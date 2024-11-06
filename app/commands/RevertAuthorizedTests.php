<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class RevertAuthorizedTests extends Command {

    protected $name = 'revert:authorized';
    protected $description = 'Reverts the authorization of completed tests using the after_authorization CSV.';

    public function __construct() {
        parent::__construct();
    }

    protected function create_dir($start_date, $end_date) {
		$dirName = 'public/exports/'.$start_date.'-'.$end_date;
		if (!file_exists($dirName)) {
			mkdir($dirName, 0777, true);
		}
		return $dirName;
	}

    public function  index_unsync_orders(){
        $indexName = 'idx_specimen_id';
        $tableName = 'unsync_orders';
        $indexExists = DB::select("SHOW INDEX FROM $tableName WHERE Key_name = ?", [$indexName]);
        if (empty($indexExists)) {
            DB::statement("CREATE INDEX $indexName ON $tableName (specimen_id)");
        }
    }

    public function fire() {
        $this->index_unsync_orders();

        $startDate = $this->argument('start_date');;
		$endDate = $this->argument('end_date');
		$dir = $this->create_dir($startDate, $endDate);

        if (($handle = fopen($dir.'/after_authorization.csv', 'r')) !== FALSE) {
            fgetcsv($handle);
            $revertedTests = [];

            while (($data = fgetcsv($handle)) !== FALSE) {
                $testID = $data[0];
                array_push($revertedTests, $testID);
            }
            fclose($handle);

            if (sizeof($revertedTests) > 0) {
                $file_headers = ['Test ID', 'Test Status', 'Test Date Create', 'Test Date Complete', 'Authorized By', 'Test Date Authorized', 'Test Accession Number'];
                $before = fopen($dir.'/before_reverting.csv', 'w');
                fputcsv($before, $file_headers);
                fclose($before);
                $after = fopen($dir.'/after_reverting.csv', 'w');
                fputcsv($after, $file_headers);
                fclose($after);
            }

            foreach ($revertedTests as $testID) {
                $test = Test::find($testID);
                if ($test) {
                    if($test->test_status_id == Test::VERIFIED && $test->time_verified !== null) {
                        $this->writeToCSV($dir.'/before_reverting.csv', $test);
                        $test->test_status_id = Test::COMPLETED;
                        $test->time_verified = null;
                        $test->verified_by = null;
                        $test->save();
                        $new_test = Test::find($testID);
                        $this->removeUnsyncOrder($test->specimen_id);
                        $this->writeToCSV($dir.'/after_reverting.csv', $new_test);
                        echo "Reverted authorization for test ID: " . $testID . "\n";
                    } else {
                        echo "Test ID: " . $testID . " not found. Skipping...\n";
                    }
                } else {
                    echo "Test ID: " . $testID . " not found. Skipping...\n";
                }
            }
            $this->writeRevertSummary($revertedTests);
        } else {
            echo "Could not open after_authorization.csv for reading.\n";
        }
    }

    private function removeUnsyncOrder($specimen_id) {
        UnsyncOrder::where('specimen_id', $specimen_id)->delete();
        echo "Removed UnsyncOrder entries for specimen ID: " . $specimen_id . "\n";
    }

    private function writeToCSV($filename, $test) {
		$file = fopen($filename, 'a');
		$file_arr = [
			$test->id,
			$test->testStatus->name,
			$test->time_created,
			$test->time_completed,
            $test->verifiedBy["username"] ?? "",
			$test->time_verified,
			$test->specimen->accession_number
		];
		fputcsv($file, $file_arr);
		fclose($file);
	}

    private function writeRevertSummary($revertedTests) {
        $startDate = $this->argument('start_date');;
		$endDate = $this->argument('end_date');
		$dir = $this->create_dir($startDate, $endDate);
        $summaryFile = $dir.'/revert_summary.csv';
        $summaryData = [
            'Total Tests Reverted',
            count($revertedTests),
            'Test IDs Reverted: ' . implode(', ', $revertedTests)
        ];
        $headers = ['Summary Data', 'Count', 'Details'];
        
        $file = fopen($summaryFile, 'w');
        fputcsv($file, $headers);
        fputcsv($file, $summaryData);
        fclose($file);

        echo "Reversion summary written to revert_summary.csv\n";
    }

    protected function getArguments() {
		return [
            ['start_date', InputArgument::REQUIRED, 'The start date in format YYYY-MM-DD.'],
            ['end_date', InputArgument::REQUIRED, 'The end date in format YYYY-MM-DD.'],
        ];
	}

	protected function getOptions() {
		return [];
	}
}
