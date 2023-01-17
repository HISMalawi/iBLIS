<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Shift31\LaravelElasticsearch\Facades\Es;

class IndexTests extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'create_index:tests';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Elastic search index tests.';

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
		$start_indexing_from = Config::get('kblis.start_indexing_from') ? Config::get('kblis.start_indexing_from') : '2021-01-01'; 
		$end_indexing = date('Y-m-d H:i:s');
		$tests = Test::where('time_created','>=', $start_indexing_from)->where('time_created','<=', $end_indexing)->orderBy('time_created', 'DESC')->get();
	
		foreach ($tests as $test) {
			try {
				ES::index([
					'id' => $test->id,
					'index' => 'tests',
					'type' => Test::class,
					'body' => [
						'test_id' => $test->id,
						'patient_name' => $test->visit->patient->name,
						'patient_number' => $test->visit->patient->patient_number,
						'accession_number' => $test->getSpecimenId(),
						'tracking_number' => $test->getTrackingNumber(),
						'test_name' => $test->testType->name,
						'location' =>$test->visit->ward_or_location,
						'test_status' =>$test->testStatus->name,
						'specimen_status' =>$test->specimen->specimenStatus->name,
						'test_time_created' => $test->time_created
					]
				]);
				echo "Indexing record---> tracking_number: {$test->getTrackingNumber()}\n";
			} catch (Exception $e) {
				$this->info($e->getMessage());
			}
		}
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
