<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Shift31\LaravelElasticsearch\Facades\Es;

class UpdateElasticIndex extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'update:tests';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update test index.';

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
		//
		$params = [
			'index'=>'tests', 
			'size'=>1,
			'sort'=>'test_id:desc'
		];
		// dd(ES::ping());
		$last_test_id = ES::search($params)['hits']['hits'][0]['sort'][0];
		$tests = Test::where('id' ,'>', $last_test_id)->get();
		foreach ($tests as $test) {
			try {
				ES::create([
					'id' => $test->id,
					'index' => 'tests',
					'type' => Test::class,
					'body' => [
						'test_id' => $test->id,
						'patient_name' => $test->visit->patient->name,
						'accession_number' => $test->getSpecimenId(),
						'tracking_number' => $test->getTrackingNumber(),
						'test_name' => $test->testType->name,
						'location' =>$test->visit->ward_or_location,
						'test_status' =>$test->testStatus->name,
						'specimen_status' =>$test->specimen->specimenStatus->name,
						'test_time_created' => $test->time_created
					]
				]);
				echo "Updating doc for tracking: {$test->getTrackingNumber()}\n";
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
