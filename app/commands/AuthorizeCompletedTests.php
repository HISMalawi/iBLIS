<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class AuthorizeCompletedTests extends Command
{

	protected $name = 'authorize:completed';
	protected $description = 'Authorizes completed tests starting from a specified date.';

	protected $users = [];

	public function __construct()
	{
		parent::__construct();
		$this->users = $this->readUsersFromJSON();
	}

	private function readUsersFromJSON()
	{
		$users = [];
		$jsonFilePath = 'authorize_users.json';

		if (file_exists($jsonFilePath)) {
			$jsonData = file_get_contents($jsonFilePath);
			$users = json_decode($jsonData, true);
		} else {
			echo "Could not find users.json file.\n";
		}

		return $users;
	}

	protected function create_dir($start_date, $end_date)
	{
		$dirName = 'public/exports/' . $start_date . '-' . $end_date;
		if (!file_exists($dirName)) {
			mkdir($dirName, 0777, true);
		}
		return $dirName;
	}

	public function fire()
	{
		$startDate = $this->argument('start_date');;
		$endDate = $this->argument('end_date');
		$currentDate = date('Y-m-d H:i:s');
		$dir = $this->create_dir($startDate, $endDate);
		$testIDs = Test::where('time_created', '>', $startDate)
			->where('time_created', '<', $endDate)
			->where('test_status_id', '=', Test::COMPLETED)
			->lists('id');
		$total_test_affected_arr = [];

		if (sizeof($testIDs) > 0) {
			$file_headers = ['Test ID', 'Test Status', 'Test Date Create', 'Test Date Complete', 'Authorized By', 'Test Date Authorized', 'Test Accession Number'];
			$before = fopen($dir . '/before_authorization.csv', 'w');
			fputcsv($before, $file_headers);
			fclose($before);
			$after = fopen($dir . '/after_authorization.csv', 'w');
			fputcsv($after, $file_headers);
			fclose($after);
		}

		foreach ($testIDs as $testID) {
			$test = Test::find($testID);
			if ($test && $test->testStatus->name != 'verified') {
				$total_test_affected_arr[] = $testID;
				$authorizerID = $this->getRandomAuthorizer($test->testType->testCategory->name);

				if ($authorizerID !== NULL) {
					$timeCompleted = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $test->time_completed);
					$timeCompleted->addMinutes(20);
					$this->writeToCSV($dir . '/before_authorization.csv', $test);
					$date_of_authorization = $timeCompleted ?? $currentDate;
					if ($test->test_status_id = Test::COMPLETED && $test->time_verified == null) {
						if (!$test->panel_id) {
							$this->authorizeSingleTest($test, $authorizerID, $date_of_authorization);
						} else {
							$this->authorizePanelTests($test, $authorizerID, $date_of_authorization);
						}
					}
					$new_test = Test::find($testID);
					$this->writeToCSV($dir . '/after_authorization.csv', $new_test);
					echo "Authorized test with id: " . $testID . "\n";
				} else {
					echo "Could not find an authorizer for test with id: " . $testID . "\n Skipping...";
				}
			}
		}

		$this->writeSummary($startDate, $endDate, sizeof($total_test_affected_arr));
	}

	private function authorizeSingleTest($test, $authorizerID, $date_of_authorization)
	{
		$test->test_status_id = Test::VERIFIED;
		$test->time_verified = $date_of_authorization;
		$test->verified_by = $authorizerID;
		$test->save();

		$this->createUnsyncOrder($test->id, "test");

		$count = DB::select(DB::raw("SELECT tests.specimen_id AS specimen_id FROM tests WHERE tests.id=$test->id"));
		if (isset($count[0]->specimen_id)) {
			$id = $count[0]->specimen_id;
			$co = DB::select(DB::raw("SELECT * FROM tests WHERE specimen_id='$id'"));
			if (count($co) > 1) {
				$ver = Test::VERIFIED;
				DB::update(DB::raw("UPDATE tests SET tests.test_status_id ='$ver' WHERE tests.specimen_id='$id' AND (tests.test_type_id = '29' OR tests.test_type_id = '30')"));
				$this->createUnsyncOrder($id, "specimen");
			}
		}

		Event::fire('test.verified', [$test->id]);
	}

	private function getRandomAuthorizer($department)
	{

		$users = $this->users[$department] ?? null;
		if ($users && count($users) > 0) {
			$userName = array_rand($users);
			return User::where('username', $users[$userName])->where('deleted_at', NULL)->pluck('id');
		}
		return null;
	}

	private function authorizePanelTests($test, $authorizerID, $date_of_authorization)
	{
		Test::where('panel_id', $test->panel_id)->update([
			'test_status_id' => Test::VERIFIED,
			'time_verified' => $date_of_authorization,
			'verified_by' => $authorizerID
		]);

		$testIds = Test::where('panel_id', $test->panel_id)->lists('id');
		foreach ($testIds as $id) {
			Event::fire('test.verified', [$id]);
			$this->createUnsyncOrder($id, "test");
		}
	}

	private function createUnsyncOrder($specimen_id, $data_level)
	{
		$dat = new UnsyncOrder;
		$dat->specimen_id = $specimen_id;
		$dat->data_not_synced = "verified";
		$dat->data_level = $data_level;
		$dat->sync_status = "not-synced";
		$dat->updated_by_name = "";
		$dat->updated_by_id = "";
		$dat->save();
	}

	private function writeToCSV($filename, $test)
	{
		$file = fopen($filename, 'a');
		$file_arr = [
			$test->id,
			$test->testStatus->name,
			$test->time_created,
			$test->time_completed,
			$test->verifiedBy["username"],
			$test->time_verified,
			$test->specimen->accession_number
		];
		fputcsv($file, $file_arr);
		fclose($file);
	}

	private function writeSummary($currentDate, $endDate, $total_count)
	{
		$dir = $this->create_dir($currentDate, $endDate);
		$sum_data = [
			Config::get('kblis.facility_name'),
			$currentDate,
			$total_count,
			"All completed tests created between " . $currentDate . " and " . $endDate,
			"All tests to have authorized status",
			"Date authorized equal date completed plus 20 minutes"
		];
		$headers = ['Facility Name ', 'Date Script Run', 'Total Tests Affected', 'Criteria Before Auth Status', 'Criteria After Auth Status', 'Criteria Auth Time'];
		$d = fopen($dir . '/summary_from_script.csv', 'w');
		fputcsv($d, $headers);
		fputcsv($d, $sum_data);
		fclose($d);
	}

	protected function getArguments()
	{
		return [
			['start_date', InputArgument::REQUIRED, 'The start date in format YYYY-MM-DD.'],
			['end_date', InputArgument::REQUIRED, 'The end date in format YYYY-MM-DD.'],
		];
	}

	protected function getOptions()
	{
		return [];
	}
}
