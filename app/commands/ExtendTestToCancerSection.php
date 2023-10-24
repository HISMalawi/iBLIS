<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\DB;
class ExtendTestToCancerSection extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'tests-extend:cancer-section';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Creates new tests for cancer center.';

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
		try {
			DB::beginTransaction();
			$department_id = 0;
			$cancer__min_lab = TestCategory::where('name', 'Cancer Center Lab')->first();
			if(!$cancer__min_lab){
				$test_category = new TestCategory;
				$test_category->name = 'Cancer Center Lab';
				$test_category->description = 'Min Lab';
				$test_category->save();
				$department_id = $test_category->id;
			}else{
				$department_id = $cancer__min_lab->id;
			}
			$test_types = DB::select(DB::raw("
					SELECT 
					tt.id,
						tt.name AS test_name,
						tt.short_name,
						tt.description,
						tt.test_category_id AS department_id,
						tt.targetTAT AS tat,
						tt.orderable_test,
						tt.prevalence_threshold,
						tt.accredited,
						tt.hl7_coding_system,
						tt.hl7_identifier,
						tt.hl7_text,
						tt.print_device
				FROM
						test_types tt
				WHERE
						tt.deleted_at IS NULL
								AND tt.name NOT LIKE '%Paeds%'
								AND tt.name NOT LIKE '%CancerCenter%'
			"));
			$cxc_tests = TestType::where('name', 'LIKE', '%CancerCenter%')->get()->lists('name');
			foreach($test_types as $test_type){
				if(!(in_array($test_type->test_name.'(CancerCenter)', $cxc_tests))){
					$new_test_type = new TestType;
					$new_test_type->name = $test_type->test_name.'(CancerCenter)';
					if(!empty($new_test_type->short_name)){
						$new_test_type->short_name = $test_type->short_name.'(CxC)';
					}else{
						$new_test_type->short_name = $test_type->short_name;
					}
					$new_test_type->description = $test_type->description;
					$new_test_type->test_category_id =$department_id;
					$new_test_type->targetTAT = $test_type->tat;
					$new_test_type->orderable_test = $test_type->orderable_test;
					$new_test_type->prevalence_threshold = $test_type->prevalence_threshold;
					$new_test_type->accredited = $test_type->accredited;
					$new_test_type->hl7_coding_system = $test_type->hl7_coding_system;
					$new_test_type->hl7_text = $test_type->hl7_text;
					$new_test_type->hl7_identifier = $test_type->hl7_identifier;
					$new_test_type->print_device = $test_type->print_device;
					$new_test_type->save();
					$new_test_type_id = $new_test_type->id;
					echo "Created test type: ".$new_test_type->name."\n";
					$test_type_measures = TestTypeMeasure::where('test_type_id', '=', $test_type->id)->get();
					foreach($test_type_measures as $test_type_measure){
						$new_tt_measure = new TestTypeMeasure;
						$new_tt_measure->test_type_id = $new_test_type_id;
						$new_tt_measure->measure_id = $test_type_measure->measure_id;
						$new_tt_measure->save();
						echo "Created test type measure for: ".$new_test_type->name."\n";
					}
					$test_type_specimens = DB::select(DB::raw("
						SELECT 
								*
						FROM
								testtype_specimentypes tts
						WHERE 
								tts.test_type_id = $test_type->id
					"));
					foreach($test_type_specimens as $test_type_specimen){
						$ttsp = [
							'test_type_id' => $new_test_type_id,
							'specimen_type_id' => $test_type_specimen->specimen_type_id
						];
						DB::table('testtype_specimentypes')->insert($ttsp);
						echo "Created test type specimen for: ".$new_test_type->name."\n";
					}
					$test_organims = DB::select(DB::raw("
						SELECT 
								*
						FROM
						testtype_organisms tto
						WHERE 
								tto.test_type_id = $test_type->id
								AND tto.deleted_at IS NULL"
					));

					foreach($test_organims as $test_organim){
						$ttog = [
							'test_type_id' => $new_test_type_id,
							'organism_id' => $test_organim->organism_id
						];
						DB::table('testtype_organisms')->insert($ttog);
						echo "Created test type organism for: ".$new_test_type->name."\n";
					}
				}else{
					echo "Test type: ".$test_type->test_name."(CancerCenter) already exists\n";
				}
			}
			DB::commit();
		}catch (\Exception $e) {
			DB::rollBack();
		}
		try {
			DB::beginTransaction();
			$panel_types = DB::select(DB::raw("
				SELECT 
						*
				FROM
						panel_types pt
				WHERE
						pt.name NOT LIKE '%Paeds%'
						AND pt.name NOT LIKE '%CancerCenter%'
								AND pt.deleted_at IS NULL"
			));
			$test_panels = PanelType::where('name', 'LIKE', '%CancerCenter%')->get()->lists('name');
			foreach($panel_types as $panel_type){
				if(!(in_array($panel_type->name.'(CancerCenter)', $test_panels))){
					$new_panel_type = new PanelType;
					$new_panel_type->name = $panel_type->name.'(CancerCenter)';
					if(!empty($new_panel_type->short_name)){
						$new_panel_type->short_name =	$panel_type->short_name.'(CxC)';
					}else{
						$new_panel_type->short_name =	$panel_type->short_name;
					}
					$new_panel_type->save();
					$panel_type_id = $new_panel_type->id;
					$panel_type_name = $new_panel_type->name;
					echo 'Created panel type: '.$panel_type_name."\n";
					$panels = Panel::where('panel_type_id', '=', $panel_type->id)->get();
					foreach($panels as $panel){
						$test_type = TestType::where('id', $panel->test_type_id)->first();
						$test_type = TestType::where('name', $test_type->name.'(CancerCenter)')->first();
						$np = [
							'test_type_id' => $test_type->id,
							'panel_type_id' => $panel_type_id
						];
						DB::table('panels')->insert($np);
						echo 'Created panel for panel type: '.$panel_type_name."\n";
					}
				}else{
					echo 'Panel type: '.$panel_type->name.'(CancerCenter) already exists'."\n";
				}
			}
			DB::commit();
		}catch (\Exception $e) {
			DB::rollBack();
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
