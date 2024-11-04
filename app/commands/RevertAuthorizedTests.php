<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class RevertAuthorizedTests extends Command {

    protected $name = 'revert:authorized';
    protected $description = 'Reverts the authorization of completed tests using the after_authorization CSV.';

    public function __construct() {
        parent::__construct();
    }

    public function fire() {
        if (($handle = fopen('after_authorization.csv', 'r')) !== FALSE) {
            fgetcsv($handle);
            $revertedTests = [];

            while (($data = fgetcsv($handle)) !== FALSE) {
                $testID = $data[0];

                $test = Test::find($testID);
                if ($test) {
                    $test->test_status_id = Test::COMPLETED;
                    $test->time_verified = null;
                    $test->verified_by = null;
                    $test->save();

                    $this->removeUnsyncOrder($test->specimen_id);

                    $revertedTests[] = $testID;
                    echo "Reverted authorization for test ID: " . $testID . "\n";
                } else {
                    echo "Test ID: " . $testID . " not found. Skipping...\n";
                }
            }

            fclose($handle);
            $this->writeRevertSummary($revertedTests);
        } else {
            echo "Could not open after_authorization.csv for reading.\n";
        }
    }

    private function removeUnsyncOrder($specimen_id) {
        UnsyncOrder::where('specimen_id', $specimen_id)->delete();
        echo "Removed UnsyncOrder entries for specimen ID: " . $specimen_id . "\n";
    }

    private function writeRevertSummary($revertedTests) {
        $summaryFile = 'revert_summary.csv';
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
        return [];
    }

    protected function getOptions() {
        return [];
    }
}
