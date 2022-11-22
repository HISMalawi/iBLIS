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
		//
		$max_date = '2022-09-01';
		$authorizerID = 1;
		$testIDs = Test::where('time_created','<', $max_date)->where('test_status_id', '=', Test::COMPLETED)->lists('id');
		foreach($testIDs as $testID){
			var_dump('Authorizing test ' . $testID);
			$test = Test::find($testID);
			if(!$test->panel_id) {
				$test->test_status_id = Test::VERIFIED;
				$test->time_verified = date('Y-m-d H:i:s');
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
								'time_verified' => date('Y-m-d H:i:s'),
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
