<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AuthorizeCompletedTests extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'authorize:completed';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Authorizes completed tests start from specified date.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//Date authorized == date test completed
		// keep a log of all test authorized
		$max_date = '2022-09-01';
		$date_now = date('Y-m-d H:i:s');
		$authorizerID = 1;
		$testIDs = Test::where('time_created','<', $max_date)->where('test_status_id', '=', Test::COMPLETED)->lists('id');
		$total_test_affected_arr = [];

		//CSV file
		if(sizeof($testIDs)>0){
			$file_headers = array('Test ID', 'Test Status', 'Test Date Create', 'Test Date Complete','Test Date Authorized', 'Test Accession Number');
			$before = fopen('before_authorization.csv', 'w');
			fputcsv($before, $file_headers);
			fclose($before);
			$after = fopen('after_authorization.csv', 'w');
			fputcsv($after, $file_headers);
			fclose($after);
		}

		foreach($testIDs as $testID){
			$test = Test::find($testID);
			if($test->testStatus->name != 'verified'){
				array_push($total_test_affected_arr, $testID);
				// Keep track of tests before authorization
				$before_auth_csv = fopen('before_authorization.csv', 'a');
				$file_arr = [
					$test->id, $test->testStatus->name, $test->time_created, $test->time_completed, $test->time_verified, $test->specimen->accession_number
				];
				fputcsv($before_auth_csv, $file_arr);
				fclose($before_auth_csv);

				$date_of_authorization = $test->time_completed;
				if(!$test->panel_id) {
					$test->test_status_id = Test::VERIFIED;
					$test->time_verified = $date_of_authorization;
					$test->verified_by = $authorizerID;
					$test->save();

						$dat = new UnsyncOrder;
						$dat->specimen_id = $testID;
						$dat->data_not_synced = "verified";
						$dat->data_level = "test";
						$dat->sync_status = "not-synced";
						$dat->updated_by_name = "";
						$dat->updated_by_id = "" ;
						$dat->save();

					$testIds = array($testID);
				
					$count = DB::select(DB::raw("SELECT tests.specimen_id AS specimen_id FROM tests WHERE tests.id=$testID"));

					if($count[0]->specimen_id)
					{   $id =$count[0]->specimen_id;				
						$co = DB::select(DB::raw("SELECT * FROM tests WHERE specimen_id='$id'"));
						if(count($co)>1)
						{
							$ver = Test::VERIFIED;
							DB::update(DB::raw("UPDATE tests SET tests.test_status_id ='$ver'
												WHERE tests.specimen_id='$id'
												AND
												(tests.test_type_id ='29'AND tests.test_type_id ='30')"));
								$dat = new UnsyncOrder;
								$dat->specimen_id = $id;
								$dat->data_not_synced = "verified";
								$dat->data_level = "specimen";
								$dat->sync_status = "not-synced";
								$dat->updated_by_name = "";
								$dat->updated_by_id = "" ;
								$dat->save();
						}				
					}			
				}else{
					Test::where('panel_id', $test->panel_id)
							->update(
								array(
									'test_status_id' => Test::VERIFIED,
									'time_verified' => $date_of_authorization,
									'verified_by' => $authorizerID
									)
							);
					$testIds = Test::where('panel_id', $test->panel_id)->lists('id');
				}
				//Fire of entry verified event
				foreach($testIds As $id) {
					Event::fire('test.verified', array($id));
						$dat = new UnsyncOrder;
						$dat->specimen_id = $id;
						$dat->data_not_synced = "verified";
						$dat->data_level = "test";
						$dat->sync_status = "not-synced";
						$dat->updated_by_name = "";
						$dat->updated_by_id = "" ;
						$dat->save();
				}

				// Keep track of tests after authorization
				$test = Test::find($testID);
				$after_auth_csv = fopen('after_authorization.csv', 'a');
				$file_arr = [
					$test->id, $test->testStatus->name, $test->time_created, $test->time_completed, $test->time_verified, $test->specimen->accession_number
				];
				fputcsv($after_auth_csv, $file_arr);
				fclose($after_auth_csv);
				echo "Authorizing test with id: ".$testID."\n";
			}
			
		}

		// Summary of data from the script
		$sum_data = [
			Config::get('kblis.facility_name'),
			$date_now,
			sizeof($total_test_affected_arr),
			"All completed tests created before ".$max_date,
			"All tests to have authorized status",
			"Date authorized equal date completed"
		];
		$headers = array('Facility Name ', 'Date Script Run', 'Total Tests Affected', 'Criteria Before Auth Status','Criteria After Auth Status', 'Criteria Auth Time');
		$d = fopen('summary_from_script.csv', 'w');
		fputcsv($d, $headers);
		fputcsv($d, $sum_data);
		fclose($d);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
