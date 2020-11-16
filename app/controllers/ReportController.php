<?php
set_time_limit(0); //60 seconds = 1 minute
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class ReportController extends \BaseController {
	//	Begin patient report functions
	/**
	 * Display a listing of the resource.
	 * Called loadPatients because the same controller shall be used for all other reports
	 * @return Response
	 */
	public function loadPatients()
	{
		$search = Input::get('search');
		
		$patients = Patient::search($search)->orderBy('id','DESC')->paginate(Config::get('kblis.page-items'));

		if (count($patients) == 0) {
		 	Session::flash('message', trans('messages.no-match'));
		}

		// Load the view and pass the patients
		return View::make('reports.patient.index')->with('patients', $patients)->withInput(Input::all());
	}

	public function printReport($id, $visit){

		dd($id);
	}

	public function printZebraReport($id){
		$ROW_HEIGHT_DIFF = 35;
		$OFFSET_LEFT = 53;
		$RESULT_OFFSET_LEFT = 455;
		$OFFSET_TOP = 95;
		$UNDERLINE_HEIGHT = 10;

		$specimen = Specimen::find($id);
		$sample_type = $specimen->specimen_type->name;
		$patient = $specimen->test->visit->patient;
		$sample_date = date_format(date_create($specimen->test->time_created), "d/M/Y");
		$patient_name = $patient->name;
		$npid = $patient->external_patient_number;
		$accession_number = $specimen->accession_number;
		$gender = $patient->gender == 0 ? "M" : "F";
		$age = $patient->getAge();

		$result =
			'
N
q801
Q329,026
ZT
S2
A53,19,0,1,1,2,N,"'.$patient_name.' ('.$gender.','.$age.') | Pat.No: '.$npid.' | Date: '.$sample_date.'"
LO25,80,760,2
A53,56,0,1,1,2,N,"Sample Type:"
A325,56,0,1,1,2,N," Sample ID:"
A190,56,0,1,1,2,N,"'.$sample_type.'"
A450,56,0,1,1,2,N,"'.$accession_number.'"';
		
		$tests = Test::where("specimen_id", $id)->get();

		foreach($tests AS $test){

			$test_type = TestType::find($test->test_type_id);

			$result = $result.'
A'.$OFFSET_LEFT.','.$OFFSET_TOP.',0,2,1,1,N,"Test: '.$test_type->name.'"';

			$result = $result.'
LO25,'.($OFFSET_TOP-$UNDERLINE_HEIGHT).',760,1';

			$OFFSET_TOP = $OFFSET_TOP + $ROW_HEIGHT_DIFF;

			$test_measures = TestTypeMeasure::where("test_type_id", $test->test_type_id)->get();

			foreach($test_measures AS $test_measure){

				$measure = Measure::find($test_measure->measure_id);

				$results = TestResult::whereRaw(" test_id = ".$test->id." AND measure_id = ".$test_measure->measure_id)->get()->first();

				if (!empty($results)){
					$result = $result.'
A'.$OFFSET_LEFT.','.$OFFSET_TOP.',0,2,1,1,N,"'.substr($measure->name, 0, 25).':"';

					$result = $result.'
A'.$RESULT_OFFSET_LEFT.','.$OFFSET_TOP.',0,2,1,1,N,"'.$results->result.'"';

					$OFFSET_TOP = $OFFSET_TOP + $ROW_HEIGHT_DIFF;

				}

			}

		}
		$result = $result.'
LO25,'.$OFFSET_TOP.',760,1';

		$result = $result.'
P1
';

		$filename = $id.'.lbs';
		header("Content-Type: application/label; charset=utf-8");
		header('Content-Disposition: inline; filename="'.$filename.'"');
		header("Content-Length: " . strlen($result));
		header("Stream", false);
		echo $result;
		exit;
	}
	/**
	 * Display data after applying the filters on the report uses patient ID
	 *
	 * @return Response
	 */
	public function viewPatientReport($id, $visit = null){
               	
		$from = Input::get('start');
		$to = Input::get('end');
		$pending = Input::get('pending');
		$date = date('Y-m-d');
		$error = '';
		$visitId = Input::get('visit_id');
		$spe_id = "";
		$visitId = (!$visitId && $visit) ? $visit : $visitId;

		
		//	Check checkbox if checked and assign the 'checked' value
		if (Input::get('tests') === '1') {
		    $pending='checked';
		}

		//	Query to get tests of a particular patient
		if(($visit || $visitId) && $id){
			$tests = Test::where('visit_id', '=', $visit?$visit:$visitId)->orderBy("time_completed", "ASC");
		}
		else{
			$tests = Test::join('visits', 'visits.id', '=', 'tests.visit_id')
							->where('patient_id', '=', $id)->orderBy("time_completed", "ASC");

		}
		$tests_count = count($tests->get(array('tests.*')));
		
		//	Begin filters - include/exclude pending tests
		if($pending){
			$tests=$tests->where('tests.test_status_id', '!=', Test::PENDING);
		}
		else{

			$tests = $tests->whereIn('tests.test_status_id', [Test::COMPLETED, Test::VERIFIED, Test::PENDING, Test::TEST_REJECTED]);
		}
		
		
		//	Date filters
		if($from||$to){
			if(!$to) $to = $date;

			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
					$error = trans('messages.check-date-range');
			}
			else
			{
				$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
				$tests=$tests->whereBetween('time_created', array($from, $toPlusOne->format('Y-m-d H:i:s')));
			}
		}
		//	Get tests collection
		//$tests = $tests->orderBy('time_completed', 'ASC');

		$tests = $tests->get(array('tests.*'));		
		$patient_visit_checker = count($tests);
		
		$checking_status = false;
		if($tests_count==0 && $patient_visit_checker==0)
		{
			$checking_status = true;
		}
		//	Get patient details
		$patient = Patient::find($id);
		//	Check if tests are accredited
		$accredited = array();
		$verified = array();
		$print_statuses = array();
		foreach ($tests as $test) {
		
			array_push($print_statuses, $test);
			if($test->testType->isAccredited())
				array_push($accredited, $test->id);
			else
				continue;
		}
			
			
		foreach ($tests as $test) {
			if($test->isVerified())
				array_push($verified, $test->id);
			else
				continue;
		}

		$data = array();

		foreach($tests as $test){
			$specimen = Specimen::find($test->specimen_id);
			$spe_id = $specimen->id;
			
			if(empty($data[$specimen->accession_number])){
				$data[$specimen->accession_number] = array();
			}

			array_push($data[$specimen->accession_number], $test);
		}

		$obj = new PatientReportPrintStatus;
		$res = $obj->get_print_status($visitId);

		$view_url = "reports.patient.report";
	
		if(Input::has('pdf')){
			if(!Input::has('page')){
				
				$url = Request::url()."?pdf=true&page=true";

				$fileName = "patientreport".$id."_".$date.".pdf";
				$printer = Input::get("printer_name");

				$process = new Process("xvfb-run -a wkhtmltopdf --footer-font-size 10 --footer-center 'Page [page]/[toPage]' -s A4 -T 2mm -L 2mm -R 2mm '$url'  $fileName");
				$process->run();

				$process = new Process("lp -d $printer $fileName");
				$process->run();

				$process = new Process("rm $fileName && rm patientreport*.pdf");
				$process->run();
				
				if(Input::has('from_view_details')) {
					return Redirect::route('test.index',
						array('test_status' => TestStatus::where('name', 'completed')->first()->id)
					);
				}

			}else{
					$view_url = "reports.patient.export";
			}
		}
	
			$sql = "SELECT * FROM users INNER JOIN specimens ON specimens.accepted_by = users.id WHERE specimens.id='$spe_id'";
			$collected_by =  DB::select(DB::raw($sql));
	
                        $rejected = Specimen::REJECTED;
     	                $specimen = Specimen::where('id', '=', $spe_id)->first();
     	                $rej_status = DB::select(DB::raw("SELECT specimens.id FROM specimens WHERE specimen_status_id='$rejected' AND specimens.id='$spe_id'"));

			return View::make($view_url)
				->with('patient', $patient)
				->with('tests', $tests)
				->with('data', $data)
				->with('pending', $pending)
				->with('error', $error)
				->with('visit', $visitId)
				->with('accredited', $accredited)
				->with('verified', $verified)
				->with('patient_visits',$patient_visit_checker)
				->with('checking_status',$checking_status)
				->with('collected_by',$collected_by[0]->name)
				->with('date_sample_collected',$collected_by[0]->date_of_collection)
				->with('print_status', $res)
				->with('rej_status',$rej_status)
				->with('specimen_id', $spe_id )
				->with('spdetails',$specimen)
				->with('available_printers', Config::get('kblis.A4_printers'))
				->withInput(Input::all());
		

	}

	public function trackPatientReportPrint()
	{	$specimen_id = Input::get('specimen_id');

		$obj = new PatientReportPrintStatus;

		$obj->specimen_id = $specimen_id;
		$obj->printed_by =  $user_id = Auth::user()->id;;
		$obj->save();

	}

	//	End patient report functions

	/**
	*	Function to return test types of a particular test category to fill test types dropdown
	*/
	public function reportsDropdown(){
        $input = Input::get('option');
        $testCategory = TestCategory::find($input);
        $testTypes = $testCategory->testTypes();
        return Response::make($testTypes->get(['id','name']));
    }

	//	Begin Daily Log-Patient report functions
	/**
	 * Display a view of the daily patient records.
	 *
	 */
	public function dailyLog()
	{
		$from = Input::get('start');
		$to = Input::get('end');
		$pendingOrAll = Input::get('pending_or_all');
		$error = '';
		$accredited = array();
		//	Check radiobutton for pending/all tests is checked and assign the 'true' value
		if (Input::get('tests') === '1') {
		    $pending='true';
		}
		$date = date('Y-m-d');
		if(!$to){
			$to=$date;
		}
		$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
		$records = Input::get('records');
		$testCategory = Input::get('section_id');
		$testType = Input::get('test_type');
		$labSections = TestCategory::lists('name', 'id');
		if($testCategory)
			$testTypes = TestCategory::find($testCategory)->testTypes->lists('name', 'id');
		else
			$testTypes = array(""=>"");
		
		if($records=='patients'){
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
						$error = trans('messages.check-date-range');
				}
				else{
					$visits = Visit::whereBetween('created_at', array($from, $toPlusOne))->get();
				}
				if (count($visits) == 0) {
				 	Session::flash('message', trans('messages.no-match'));
				}
			}
			else{

				$visits = Visit::where('created_at', 'LIKE', $date.'%')->orderBy('patient_id')->get();
			}
			if(Input::has('word')){
				$date = date("Ymdhi");
				$fileName = "daily_visits_log_".$date.".doc";
				$headers = array(
				    "Content-type"=>"text/html",
				    "Content-Disposition"=>"attachment;Filename=".$fileName
				);
				$content = View::make('reports.daily.exportPatientLog')
								->with('visits', $visits)
								->with('accredited', $accredited)
								->withInput(Input::all());
		    	return Response::make($content,200, $headers);
			}
			else{
				return View::make('reports.daily.patient')
								->with('visits', $visits)
								->with('error', $error)
								->with('accredited', $accredited)
								->withInput(Input::all());
			}
		}
		//Begin specimen rejections
		else if($records=='rejections')
		{
			$specimens = Specimen::where('specimen_status_id', '=', Specimen::REJECTED);
			/*Filter by test category*/
			if($testCategory&&!$testType){
				$specimens = $specimens->join('tests', 'specimens.id', '=', 'tests.specimen_id')
									   ->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
									   ->where('test_types.test_category_id', '=', $testCategory);
			}
			/*Filter by test type*/
			if($testCategory&&$testType){
				$specimens = $specimens->join('tests', 'specimens.id', '=', 'tests.specimen_id')
				   					   ->where('tests.test_type_id', '=', $testType);
			}

			/*Filter by date*/
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
						$error = trans('messages.check-date-range');
				}
				else
				{
					$specimens = $specimens->whereBetween('time_rejected', 
						array($from, $toPlusOne))->get(array('specimens.*'));
				}
			}
			else
			{
				$specimens = $specimens->where('time_rejected', 'LIKE', $date.'%')->orderBy('id')
										->get(array('specimens.*'));
			}
			if(Input::has('word')){
				$date = date("Ymdhi");
				$fileName = "daily_rejected_specimen_".$date.".doc";
				$headers = array(
				    "Content-type"=>"text/html",
				    "Content-Disposition"=>"attachment;Filename=".$fileName
				);
				$content = View::make('reports.daily.exportSpecimenLog')
								->with('specimens', $specimens)
								->with('testCategory', $testCategory)
								->with('testType', $testType)
								->with('accredited', $accredited)
								->withInput(Input::all());
		    	return Response::make($content,200, $headers);
			}
			else
			{
				return View::make('reports.daily.specimen')
							->with('labSections', $labSections)
							->with('testTypes', $testTypes)
							->with('specimens', $specimens)
							->with('testCategory', $testCategory)
							->with('testType', $testType)
							->with('error', $error)
							->with('accredited', $accredited)
							->withInput(Input::all());
			}
		}
		//Begin test records
		else
		{
			$tests = Test::whereNotIn('test_status_id', [Test::NOT_RECEIVED]);
			
			/*Filter by test category*/
			if($testCategory&&!$testType){
				$tests = $tests->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
							   ->where('test_types.test_category_id', '=', $testCategory);
			}
			/*Filter by test type*/
			if($testType){
				$tests = $tests->where('test_type_id', '=', $testType);
			}
			/*Filter by all tests*/
			if($pendingOrAll=='pending'){
				$tests = $tests->whereIn('test_status_id', [Test::PENDING, Test::STARTED]);
			}
			else if($pendingOrAll=='all'){
				$tests = $tests->whereIn('test_status_id', 
					[Test::PENDING, Test::STARTED, Test::COMPLETED, Test::VERIFIED]);
			}
			//For Complete tests and the default.
			else{
				$tests = $tests->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED]);
			}
			/*Get collection of tests*/
			/*Filter by date*/
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
						$error = trans('messages.check-date-range');
				}
				else
				{
					$tests = $tests->whereBetween('time_created', array($from, $toPlusOne))->get(array('tests.*'));
				}
			}
			else
			{
				$tests = $tests->where('time_created', 'LIKE', $date.'%')->get(array('tests.*'));
			}
				
			if(Input::has('word')){
				$date = date("Ymdhi");
				$fileName = "daily_test_records_".$date.".doc";
				$headers = array(
				    "Content-type"=>"text/html",
				    "Content-Disposition"=>"attachment;Filename=".$fileName
				);
				$content = View::make('reports.daily.exportTestLog')
								->with('tests', $tests)
								->with('testCategory', $testCategory)
								->with('testType', $testType)
								->with('pendingOrAll', $pendingOrAll)
								->with('accredited', $accredited)
								->withInput(Input::all());
		    	return Response::make($content,200, $headers);
			}
			else
			{
				return View::make('reports.daily.test')
							->with('labSections', $labSections)
							->with('testTypes', $testTypes)
							->with('tests', $tests)
							->with('counts', $tests->count())
							->with('testCategory', $testCategory)
							->with('testType', $testType)
							->with('pendingOrAll', $pendingOrAll)
							->with('accredited', $accredited)
							->with('error', $error)
							->withInput(Input::all());
			}
		}
	}













	public function mohDiagnosticStats(){
		$department = Input::get("department");
		$indicator = Input::get("indicator");
		$year = Input::get("year");
		$quarter = Input::get("quarter");

		$months = array();
            if($quarter == "Quarter 1"){
                $months = ["01","02","03"];
            }else if ($quarter == "Quarter 2"){
                $months = ["04","05","06"];
            }else if ($quarter == "Quarter 3"){
                $months = ["07","08","09"];
            }else if ($quarter == "Quarter 4"){
                $months = ["10","11","12"];
			}
		
		if($department == "bio"){
			$data =  array();
			$counter = 0 ;
			foreach($months AS $month){		
				$sql = $this->extractBiochemistryMohDiagnonisticStats($indicator,$month,$year);
			
				$org = DB::select(DB::raw($sql));
				array_push($data,[$month,$org[0]->test_count]);			
			}

			return Response::json($data);
		}else if ($department == "blood"){
			$data =  array();
			$counter = 0 ;
			foreach($months AS $month){		
				$sql = $this->extractBloodBankMohDiagnonisticStats($indicator,$month,$year);
			
				$org = DB::select(DB::raw($sql));
				array_push($data,[$month,$org[0]->test_count]);			
			}

			return Response::json($data);	
		}else if ($department == "micro"){
			$data =  array();
			$counter = 0 ;
			foreach($months AS $month){		
				$sql = $this->extractMicrobiologyMohDiagnonisticStats($indicator,$month,$year);
			
				$org = DB::select(DB::raw($sql));
				array_push($data,[$month,$org[0]->test_count]);			
			}

			return Response::json($data);	
		}else if ($department == "haema"){
			$data =  array();
			$counter = 0 ;
			foreach($months AS $month){		
				$sql = $this->extracthaematologyMohDiagnonisticStats($indicator,$month,$year);
			
				$org = DB::select(DB::raw($sql));
				array_push($data,[$month,$org[0]->test_count]);			
			}

			return Response::json($data);	
		}else if ($department == "sero"){
			$data =  array();
			$counter = 0 ;
			foreach($months AS $month){		
				$sql = $this->extractserologyMohDiagnonisticStats($indicator,$month,$year);
			
				$org = DB::select(DB::raw($sql));
				array_push($data,[$month,$org[0]->test_count]);			
			}

			return Response::json($data);	
		}else if ($department == "para"){
			$data =  array();
			$counter = 0 ;
			foreach($months AS $month){		
				$sql = $this->extractparasitolgyMohDiagnonisticStats($indicator,$month,$year);
			
				$org = DB::select(DB::raw($sql));
				array_push($data,[$month,$org[0]->test_count]);			
			}

			return Response::json($data);	
		}

		
	}

	
	public function extractBloodBankMohDiagnonisticStats($indicator,$month,$year){
		$period = $year."-".$month;
		$data = array(
		"blood grouping done on Patients" => "SELECT count(*) AS test_count FROM 
								tests INNER JOIN test_results ON test_results.test_id = tests.id 
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								INNER JOIN measures ON measures.id = test_results.measure_id	
								WHERE test_types.name = 'ABO Blood Grouping' AND 
								(substr(tests.time_created,1,7) = '$period' AND (measures.name = 'Grouping' AND test_results.result IS NOT NULL ))",
		
		"Total X-matched" => "SELECT count(*) AS test_count FROM 
								tests INNER JOIN test_results ON test_results.test_id = tests.id 
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								INNER JOIN measures ON measures.id = test_results.measure_id	
								WHERE test_types.name = 'Cross-match' AND 
								(substr(tests.time_created,1,7) = '$period' AND (measures.name = 'Pack ABO Group' AND test_results.result IS NOT NULL ))",

		"X- matched for matenity" => "SELECT count(*) AS test_count FROM 
					tests INNER JOIN test_results ON test_results.test_id = tests.id 
					INNER JOIN measures ON measures.id = test_results.measure_id
					INNER JOIN test_types ON test_types.id = tests.test_type_id
					INNER JOIN visits ON visits.id = tests.visit_id	
					WHERE test_types.name = 'Cross-match' AND 
					((substr(tests.time_created,1,7) = '$period' AND (visits.ward_or_location = 'EM THEATRE' OR visits.ward_or_location = 'Labour' OR visits.ward_or_location = 'OPD' OR visits.ward_or_location ='PNW')) AND (measures.name = 'Pack ABO Group' AND test_results.result IS NOT NULL ))
                    
                    ",

		"X-macthed for peads" => "SELECT count(*) AS test_count FROM 
					tests INNER JOIN test_results ON test_results.test_id = tests.id 
					INNER JOIN measures ON measures.id = test_results.measure_id
					INNER JOIN test_types ON test_types.id = tests.test_type_id
					INNER JOIN visits ON visits.id = tests.visit_id	
					WHERE test_types.name = 'Cross-match' AND 
					((substr(tests.time_created,1,7) = '$period' AND (visits.ward_or_location = 'CWA' OR visits.ward_or_location = 'CWB' OR visits.ward_or_location = 'CWC' OR visits.ward_or_location ='EM Nursery' OR visits.ward_or_location ='Under 5 Clinic')) AND (measures.name = 'Pack ABO Group' AND test_results.result IS NOT NULL ))
                    ",

		
		"X-matched for others" => "SELECT count(*) AS test_count FROM 
					tests INNER JOIN test_results ON test_results.test_id = tests.id 
					INNER JOIN measures ON measures.id = test_results.measure_id
					INNER JOIN test_types ON test_types.id = tests.test_type_id
					INNER JOIN visits ON visits.id = tests.visit_id	
					WHERE test_types.name = 'Cross-match' AND 
					((substr(tests.time_created,1,7) = '$period' AND (visits.ward_or_location = 'Other')) AND (measures.name = 'Pack ABO Group' AND test_results.result IS NOT NULL ))
                    ",

		
		"X-matches done on patients with Hb ≤ 6.0g/dl" => "SELECT count(*) AS test_count FROM 
										tests INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN measures ON measures.id = test_results.measure_id	
										INNER JOIN visits ON visits.id = tests.visit_id	
										WHERE test_types.name = 'Cross-match' AND 
										(substr(tests.time_created,1,7) = '$period' AND (measures.name = 'Pack ABO Group' AND test_results.result IS NOT NULL ) 
										) AND visits.patient_id  IN (SELECT distinct visits.patient_id FROM tests INNER JOIN test_results ON test_results.test_id = tests.id 
											INNER JOIN visits ON visits.id = tests.visit_id 
											WHERE test_results.measure_id = 148 AND test_results.result <= 6)",


		"X-matches done on patients with Hb > 6.0g/dl" => "SELECT count(*) AS test_count FROM 
										tests INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN measures ON measures.id = test_results.measure_id	
										INNER JOIN visits ON visits.id = tests.visit_id	
										WHERE test_types.name = 'Cross-match' AND 
										(substr(tests.time_created,1,7) = '$period' AND (measures.name = 'Pack ABO Group' AND test_results.result IS NOT NULL ) 
										) AND visits.patient_id  IN (SELECT distinct visits.patient_id FROM tests INNER JOIN test_results ON test_results.test_id = tests.id 
											INNER JOIN visits ON visits.id = tests.visit_id 
											WHERE test_results.measure_id = 148 AND test_results.result > 6)"
								
		);
	

		return $data[$indicator];

	}

	public function extractBiochemistryMohDiagnonisticStats($indicator,$month,$year){
		$period = $year."-".$month;
		$data = array(
		"Blood glucose" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								INNER JOIN specimens ON specimens.id = tests.specimen_id
								WHERE (test_types.name = 'Glucose' AND specimens.specimen_type_id ='3' )AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result IS NOT NULL)",
		
		"CSF glucose" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								INNER JOIN specimens ON specimens.id = tests.specimen_id
								WHERE (test_types.name = 'Glucose' AND specimens.specimen_type_id ='2' )AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result IS NOT NULL)",

		"Total Protein" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'Microprotein' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result IS NOT NULL)",

		"Albumin" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'Microalbumin' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		
		"Alkaline Phosphatase(ALP)" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		"Alanine aminotransferase (ALT)" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		"Amylase" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",
								
	    "Antistreptolysin O (ASO)" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",
		
		"Aspartate aminotransferase(AST)" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		"Bilirubin Total" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		"Bilirubin Direct" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		
		"Calcium" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		"Chloride" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		"Cholesterol Total" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",



		"Cholesterol LDL" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",
		
		"Cholesterol HDL" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		"Cholinesterase" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		"C Reactive Protein (CRP)" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		
		"Creatinine" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		"Creatine Kinase NAC" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result ='Purulent' OR test_results.result = 'MTB DETECTED'))",

		"Creatine Kinase MB" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",


		"Haemoglobin A1c" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",


		"Iron" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",

		"Lipase" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",

		"Lactate Dehydrogenase (LDH)" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",


		"Magnesium" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",

		"Micro-protein" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",

		"Micro-albumin" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",


		"Phosphorus" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",

		"Potassium" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",

		"Rheumatoid Factor" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",


		"Sodium" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",

		"Triglycerides" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",

		
		"Urea" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",

		"Uric acid" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'MTB NOT DETECTED')",

		);

		return $data[$indicator];

	}


	public function extractMicrobiologyMohDiagnonisticStats($indicator,$month,$year){
		$period = $year."-".$month;
		$data = array(
				"Number of AFB sputum examined" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										WHERE test_types.name = 'TB Microscopic Exam' AND 
										(substr(time_created,1,7) = '$period')",


				"Number of  new TB cases examined" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result = 'MTB DETECTED' OR test_results.result = 'MTB DETECTED LOW' OR test_results.result = 'MTB DETECTED HIGH' OR test_results.result = 'MTB DETECTED MEDIUM' OR test_results.result = 'MTB DETECTED VERY LOW'))",
				
				"New cases with positive smear" => "SELECT count(*) AS test_count FROM 
										test_results 
										INNER JOIN measures ON measures.id = test_results.measure_id
                                        INNER JOIN tests ON tests.id = test_results.test_id
										WHERE measures.name= 'Smear microscopy result' AND
										(substr(tests.time_created,1,7) = '$period' AND (test_results.result = '++' OR test_results.result = '+++' OR test_results.result = '+' OR test_results.result = 'positive' OR test_results.result LIKE '%scanty%'))
										",

				"MTB Not Detected" => "SELECT count(*) AS test_count FROM 
										test_results 
										INNER JOIN measures ON measures.id = test_results.measure_id
                                        INNER JOIN tests ON tests.id = test_results.test_id
										WHERE measures.name= 'Gene Xpert MTB' AND
										(substr(tests.time_created,1,7) = '$period' AND (test_results.result = 'MTB NOT DETECTED'))",

				"RIF Resistant Detected" => "SELECT count(*) AS test_count FROM 
										test_results 
										INNER JOIN measures ON measures.id = test_results.measure_id
                                        INNER JOIN tests ON tests.id = test_results.test_id
										WHERE measures.name= 'Gene Xpert RIF Resistance' AND
										(substr(tests.time_created,1,7) = '$period' AND (test_results.result = 'Rif Resistance DETECTED'))",
				

				"RIF Resistant Not Detected" => "SELECT count(*) AS test_count FROM 
										test_results 
										INNER JOIN measures ON measures.id = test_results.measure_id
                                        INNER JOIN tests ON tests.id = test_results.test_id
										WHERE measures.name= 'Gene Xpert RIF Resistance' AND
										(substr(tests.time_created,1,7) = '$period' AND (test_results.result = 'RIF Resistant not detected'))",


				"RIF Resistant Indeterminate" => "SELECT count(*) AS test_count FROM 
										test_results 
										INNER JOIN measures ON measures.id = test_results.measure_id
                                        INNER JOIN tests ON tests.id = test_results.test_id
										WHERE measures.name= 'Gene Xpert RIF Resistance' AND
										(substr(tests.time_created,1,7) = '$period' AND (test_results.result = 'indeterminate' OR test_results.result = 'RIF Indeterminant' OR test_results.result = 'INDETERMINATE' ))",
				
				"Invalid" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result = 'INVALID' OR test_results.result = 'invalid'))",

				"No results" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'TB Tests' AND 
								(substr(tests.time_created,1,7) = '$period' AND tests.test_status_id =3)",

				"Number of CSF samples analysed" => "SELECT count(*) AS test_count FROM 
								specimens 
								INNER JOIN specimen_types ON specimens.specimen_type_id = specimen_types.id
								WHERE specimen_types.name = 'CSF' AND 
								(substr(specimens.time_accepted,1,7) = '$period' )",

				"Number of CSF samples analysed for AFB" => "SELECT count(*) AS test_count FROM 
								specimens 
								INNER JOIN specimen_types ON specimens.specimen_type_id = specimen_types.id
								WHERE specimen_types.name = 'CSFF' AND 
								(substr(specimens.time_accepted,1,7) = '$period' )",
				
				"Number of CSF samples with Organism" => "SELECT count(*) AS test_count FROM 
								specimens 
								INNER JOIN specimen_types ON specimens.specimen_type_id = specimen_types.id
								INNER JOIN tests ON tests.specimen_id = specimens.id
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id  = tests.test_type_id
								WHERE (specimen_types.name = 'CSF' AND test_types.name = 'Culture & Sensitivity') AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'Growth' )",
				

				"HVS analysed" => "SELECT count(*) AS test_count FROM 
								specimens 
								INNER JOIN specimen_types ON specimens.specimen_type_id = specimen_types.id
								WHERE specimen_types.name = 'HVS' AND 
								(substr(specimens.time_accepted,1,7) = '$period' )",

				
				"Number of Blood Cultures done" => "SELECT count(*) AS test_count FROM 
								specimens 
								INNER JOIN specimen_types ON specimens.specimen_type_id = specimen_types.id
								INNER JOIN tests ON tests.specimen_id = specimens.id
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id  = tests.test_type_id
								WHERE (specimen_types.name = 'Blood' AND test_types.name = 'Culture & Sensitivity') AND 
								(substr(tests.time_created,1,7) = '$period' )",

				"Positive blood Cultures" => "SELECT count(*) AS test_count FROM 
								specimens 
								INNER JOIN specimen_types ON specimens.specimen_type_id = specimen_types.id
								INNER JOIN tests ON tests.specimen_id = specimens.id
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id  = tests.test_type_id
								WHERE (specimen_types.name = 'Blood' AND test_types.name = 'Culture & Sensitivity') AND 
								(substr(tests.time_created,1,7) = '$period' AND test_results.result = 'Growth' )",


				"Number of tests on microscopy" => "SELECT count(*) AS test_count FROM 
                                                                                test_results 
                                                                                INNER JOIN measures ON measures.id = test_results.measure_id
                                        INNER JOIN tests ON tests.id = test_results.test_id
                                                                                WHERE (measures.name= 'Smear microscopy result') AND
                                                                                (substr(tests.time_created,1,7) = '$period' AND (test_results.result IS NOT NULL))",

				"Number of tests on GeneXpert" => "SELECT count(*) AS test_count FROM 
                                                                                test_results 
                                                                                INNER JOIN measures ON measures.id = test_results.measure_id
                                        INNER JOIN tests ON tests.id = test_results.test_id
                                                                                WHERE (measures.name= 'Gene Xpert MTB' OR measures.name = 'Gene Xpert RIF Resistance') AND
                                                                                (substr(tests.time_created,1,7) = '$period' AND (test_results.result IS NOT NULL))",

				"MTB Detected" => "SELECT count(*) AS test_count FROM 
										test_results 
										INNER JOIN measures ON measures.id = test_results.measure_id
                                        INNER JOIN tests ON tests.id = test_results.test_id
										WHERE measures.name= 'Gene Xpert MTB' AND
										(substr(tests.time_created,1,7) = '$period' AND (test_results.result = 'MTB DETECTED' OR test_results.result = 'MTB DETECTED LOW' OR test_results.result = 'MTB DETECTED HIGH' OR test_results.result = 'MTB DETECTED MEDIUM' OR test_results.result = 'MTB DETECTED VERY LOW'))",
				
				"India ink positive" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'India Ink' AND 
								(substr(tests.time_created,1,7) = '$period' AND (test_results.result = 'POSITIVE' OR test_results.result = 'positive'))",
				
				
				"Gram stain positive" => "SELECT count(*) AS test_count FROM 
								tests 
								INNER JOIN test_results ON tests.id = test_results.test_id
								INNER JOIN test_types ON test_types.id = tests.test_type_id
								WHERE test_types.name = 'Gram Stain' AND 
								(substr(tests.time_created,1,7) = '$period' AND ((test_results.result = 'yes' OR test_results.result = 'organism seen') AND test_results.result IS NOT NULL))",
				
		);

		
		return $data[$indicator];
				
	}
	
	public function microbiologyMohReport(){

		$quarter = ['Quarter 1','QNumber of CSF samples analysed for AFBuarter 2','Quarter 3','Quarter 4'];	
		$currentYear = date("Y");
		$years = array();
		for($i = $currentYear; $i >= "2016"; $i = $i - 1){
			array_push($years,$i);
		}

		$indicators = array(
			"Number of AFB sputum examined",
			"Number of  new TB cases examined",
			"New cases with positive smear",
			"MTB Not Detected",
			"RIF Resistant Detected",
			"RIF Resistant Not Detected",
			"RIF Resistant Indeterminate",
			"Invalid",
			"No results",
			"Number of CSF samples analysed",
			"Number of CSF samples analysed for AFB",
			"Number of CSF samples with Organism",
			"HVS analysed",
			"Number of Blood Cultures done",
			"Positive blood Cultures",
			"Number of tests on microscopy",
			"Number of tests on GeneXpert",
			"MTB Detected",
			"India ink positive",
			"Gram stain positive");

		return View::make('reports.moh.microbiologyReport')
						->with('quarterPeriod',$quarter)
						->with('years',$years)
						->with('heading','MoH Diagonistic Report (Microbiology Department)')
						->with('indicators',$indicators);
	}



	public function biochemistryMohReport(){

		$quarter = ['Quarter 1','Quarter 2','Quarter 3','Quarter 4'];	
		$currentYear = date("Y");
		$years = array();
		for($i = $currentYear; $i >= "2016"; $i = $i - 1){
			array_push($years,$i);
		}


		$indicators = array(
			"Blood glucose",
			"CSF glucose",
			"Total Protein",
			"Albumin",
			"Alkaline Phosphatase(ALP)",
			"Alanine aminotransferase (ALT)",
			"Amylase",
			"Antistreptolysin O (ASO)",
			"Aspartate aminotransferase(AST)",
			"Bilirubin Total",
			"Bilirubin Direct",
			"Calcium",
			"Chloride",
			"Cholesterol Total",
			"Cholesterol LDL",
			"Cholesterol HDL",
			"Cholinesterase",
			"C Reactive Protein (CRP)",
			"Creatinine",
			"Creatine Kinase NAC",
			"Creatine Kinase MB",
			"Haemoglobin A1c",
			"Iron",
			"Lipase",
			"Lactate Dehydrogenase (LDH)",
			"Magnesium",
			"Micro-protein",
			"Micro-albumin",
			"Phosphorus",
			"Potassium",
			"Rheumatoid Factor",
			"Sodium",
			"Triglycerides",
			"Urea",
			"Uric acid");
	
		return View::make('reports.moh.biochemistryReport')
						->with('quarterPeriod',$quarter)
						->with('years',$years)
						->with('heading','MoH Diagonistic Report (Biochemistry Department)')
						->with('indicators',$indicators);
	}





	public function haematologyMohReport(){

		$quarter = ['Quarter 1','Quarter 2','Quarter 3','Quarter 4'];	
		$currentYear = date("Y");
		$years = array();
		for($i = $currentYear; $i >= "2016"; $i = $i - 1){
			array_push($years,$i);
		}


		$indicators = array(			
			"Full Blood Count",
			"Heamoglobin only (blood donors excluded)",
			"Patients with Hb <= 6.0g/dl",
			"Patients with Hb <= 6.0g/dl who were transfused",
			"Patients with Hb > 6.0g/dl",
			"Patients with Hb >6.0g/dl who were transfused",
			"WBC manual count",
			"WBC differential",
			"Erythrocyte Sedimentation Rate (ESR)",
			"Sickling Test",
			"Reticulocyte count",
			"Prothrombin time (PT)",
			"Activated Partial Thromboplastin Time (APTT)",
			"International Normalized Ratio (INR)",
			"Bleeding/ cloting time",
			"CD4 absolute count",
			"CD4 percentage",
			"Blood film for red cell morphology",
			"Bleeding/clotting time");
	
		return View::make('reports.moh.haematologyReport')
						->with('quarterPeriod',$quarter)
						->with('years',$years)
						->with('heading','MoH Diagonistic Report (Haematology Department)')
						->with('indicators',$indicators);
	}

	public function extracthaematologyMohDiagnonisticStats($indicator,$month,$year){
		$period = $year."-".$month;
		$data = array(
				"Full Blood Count" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'FBC' AND (test_statuses.name ='verified' OR test_statuses.name ='completed') ) AND 
										(substr(time_created,1,7) = '$period')",

				"Heamoglobin only (blood donors excluded)" => "SELECT count(*) AS test_count FROM 
										test_results 
										INNER JOIN measures ON measures.id = test_results.measure_id
										INNER JOIN tests ON tests.id = test_results.test_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id                                        
										WHERE (measures.name= 'HGB' AND (test_statuses.name ='verified' OR test_statuses.name ='completed') ) AND
										(substr(tests.time_created,1,7) = '$period' )
										",

				"Patients with Hb <= 6.0g/dl" => "SELECT distinct  count(*) AS test_count FROM tests INNER JOIN test_results ON test_results.test_id = tests.id 
											INNER JOIN visits ON visits.id = tests.visit_id 
											WHERE (test_results.measure_id = 148 AND test_results.result <= 6) AND (substr(tests.time_created,1,7) = '$period')",

				"Patients with Hb <= 6.0g/dl who were transfused" => "SELECT count(*) AS test_count FROM 
										tests INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN measures ON measures.id = test_results.measure_id	
										INNER JOIN visits ON visits.id = tests.visit_id	
										WHERE test_types.name = 'Cross-match' AND 
										(substr(tests.time_created,1,7) = '$period' AND (measures.name = 'Pack ABO Group' AND test_results.result IS NOT NULL ) 
										) AND visits.patient_id  IN (SELECT distinct visits.patient_id FROM tests INNER JOIN test_results ON test_results.test_id = tests.id 
											INNER JOIN visits ON visits.id = tests.visit_id 
											WHERE test_results.measure_id = 148 AND test_results.result <= 6)",
				
				"Patients with Hb > 6.0g/dl" => "SELECT distinct  count(*) AS test_count FROM tests INNER JOIN test_results ON test_results.test_id = tests.id 
											INNER JOIN visits ON visits.id = tests.visit_id 
											WHERE (test_results.measure_id = 148 AND test_results.result > 6) AND (substr(tests.time_created,1,7) = '$period')",


				"Patients with Hb >6.0g/dl who were transfused" => "SELECT count(*) AS test_count FROM 
										tests INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN measures ON measures.id = test_results.measure_id	
										INNER JOIN visits ON visits.id = tests.visit_id	
										WHERE test_types.name = 'Cross-match' AND 
										(substr(tests.time_created,1,7) = '$period' AND (measures.name = 'Pack ABO Group' AND test_results.result IS NOT NULL ) 
										) AND visits.patient_id  IN (SELECT distinct visits.patient_id FROM tests INNER JOIN test_results ON test_results.test_id = tests.id 
											INNER JOIN visits ON visits.id = tests.visit_id 
											WHERE test_results.measure_id = 148 AND test_results.result > 6)",


				"WBC manual count" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										WHERE test_types.name = 'Manual Differential & Cell Morphology' AND 
										(substr(time_created,1,7) = '$period')",



				"WBC differential" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										WHERE test_types.name = 'Manual Differential & Cell Morphology' AND 
										(substr(time_created,1,7) = '$period')",


				"Erythrocyte Sedimentation Rate (ESR)" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										WHERE test_types.name = 'ESR' AND 
										(substr(time_created,1,7) = '$period')",



				"Sickling Test" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Sickling Test' AND (test_statuses.name ='verified' OR test_statuses.name ='completed') ) AND
										(substr(time_created,1,7) = '$period')",

				"Reticulocyte count" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										WHERE test_types.name = 'Reticulocyte count' AND 
										(substr(time_created,1,7) = '$period')",


				"Prothrombin time (PT)" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Prothrombin Time' AND (test_statuses.name ='verified' OR test_statuses.name ='completed') ) AND										
										(substr(time_created,1,7) = '$period')",


				"Activated Partial Thromboplastin Time (APTT)" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'APTT' AND (test_statuses.name ='verified' OR test_statuses.name ='completed') ) AND
										(substr(time_created,1,7) = '$period')",


				"International Normalized Ratio (INR)" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'INR' AND (test_statuses.name ='verified' OR test_statuses.name ='completed') ) AND
										(substr(time_created,1,7) = '$period')",



				"Bleeding/ cloting time" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										WHERE test_types.name = 'Bleeding/ cloting time' AND 
										(substr(time_created,1,7) = '$period')",

				"CD4 absolute count" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										WHERE test_types.name = 'CD4 absolute count' AND 
										(substr(time_created,1,7) = '$period')",

				"CD4 percentage" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										WHERE test_types.name = 'CD4 percentage' AND 
										(substr(time_created,1,7) = '$period')",
				

				"Blood film for red cell morphology" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										WHERE test_types.name = 'Manual Differential & Cell Morphology' AND 
										(substr(time_created,1,7) = '$period')",

				
				"Bleeding/clotting time" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										WHERE test_types.name = 'Bleeding/clotting time' AND 
										(substr(time_created,1,7) = '$period')",

				
		);

		
		return $data[$indicator];
				
	}

	public function bloodBankMohReport(){

		$quarter = ['Quarter 1','Quarter 2','Quarter 3','Quarter 4'];	
		$currentYear = date("Y");
		$years = array();
		for($i = $currentYear; $i >= "2016"; $i = $i - 1){
			array_push($years,$i);
		}


		$indicators = array(
				"blood grouping done on Patients",
				"Total X-matched","X- matched for matenity",
				"X-macthed for peads",
				"X-matched for others",
				"X-matches done on patients with Hb ≤ 6.0g/dl",
				"X-matches done on patients with Hb > 6.0g/dl"
			);
	
		return View::make('reports.moh.bloodBankReport')
						->with('quarterPeriod',$quarter)
						->with('years',$years)
						->with('heading','MoH Diagonistic Report (Blood Bank Department)')
						->with('indicators',$indicators);
	}




	public function serologyMohReport(){

		$quarter = ['Quarter 1','Quarter 2','Quarter 3','Quarter 4'];	
		$currentYear = date("Y");
		$years = array();
		for($i = $currentYear; $i >= "2016"; $i = $i - 1){
			array_push($years,$i);
		}


		$indicators = array(
				"Syphilis Test",
				"Syphilis screening on patients (by depart_option)",
				"Positive tests^",
				"Syphilis screening on antenatal mothers",
				"Positive tests ^",
				"HepBs test done on patients",
				"Positive_tests  ^",
				"HepC test done on patients",
				"Positive tests  ^",
				"Hcg  Pregnacy tests done",
				"Positive tests   ^",
				"HIV tests on PEP",
				"positives tests    ^",
			);
	
		return View::make('reports.moh.serologyReport')
						->with('quarterPeriod',$quarter)
						->with('years',$years)
						->with('heading','MoH Diagonistic Report (Serology Department)')
						->with('indicators',$indicators);
	}

	public function extractserologyMohDiagnonisticStats($indicator,$month,$year){
		$period = $year."-".$month;
		$data = array(
				"Syphilis Test" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Syphilis Test' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND 
										(substr(time_created,1,7) = '$period')",

				"Syphilis screening on patients (by depart_option)" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Syphilis Test' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND 
										(substr(time_created,1,7) = '$period')",

				"Positive tests^" => "SELECT distinct  count(*) AS test_count FROM tests INNER JOIN test_results ON test_results.test_id = tests.id 
											INNER JOIN visits ON visits.id = tests.visit_id 
											INNER JOIN measures ON measures.id = test_results.measure_id
											INNER JOIN test_types ON test_types.id = tests.test_type_id
											WHERE (test_results.measure_id = 112 OR test_results.measure_id = 113 OR test_results.measure_id = 114) AND (test_results.result = 'REACTIVE')
											AND (substr(tests.time_created,1,7) = '$period' AND test_types.name = 'Syphilis Test')",

				
				"Syphilis screening on antenatal mothers" => "SELECT count(*) AS test_count FROM 
							tests INNER JOIN test_results ON test_results.test_id = tests.id 
							INNER JOIN measures ON measures.id = test_results.measure_id
							INNER JOIN test_types ON test_types.id = tests.test_type_id
							INNER JOIN visits ON visits.id = tests.visit_id	
							WHERE test_types.name = 'Syphilis Test' AND 
							((substr(tests.time_created,1,7) = '$period' AND (visits.ward_or_location = 'EM THEATRE' OR visits.ward_or_location = 'Labour' OR visits.ward_or_location = 'OPD' OR visits.ward_or_location ='PNW')) )
							",

				"Positive tests ^" => "SELECT distinct  count(*) AS test_count FROM tests INNER JOIN test_results ON test_results.test_id = tests.id 
											INNER JOIN visits ON visits.id = tests.visit_id 
											INNER JOIN measures ON measures.id = test_results.measure_id
											INNER JOIN test_types ON test_types.id = tests.test_type_id
											WHERE ((test_results.measure_id = 112 OR test_results.measure_id = 113 OR test_results.measure_id = 114) AND test_results.result = 'REACTIVE')
											AND ((substr(tests.time_created,1,7) = '$period' AND test_types.name = 'Syphilis Test') AND (visits.ward_or_location = 'EM THEATRE' OR visits.ward_or_location = 'Labour' OR visits.ward_or_location = 'OPD' OR visits.ward_or_location ='PNW'))",

				"HepBs test done on patients" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Hepatitis B Test' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND 
										(substr(time_created,1,7) = '$period')",

				"Positive_tests  ^" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Hepatitis B Test' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND 
										((substr(time_created,1,7) = '$period') AND (test_results.result ='positive'))",

				"HepC test done on patients" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Hepatitis C Test' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND 
										(substr(time_created,1,7) = '$period')",

				"Positive tests  ^" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Hepatitis C Test' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND 
										((substr(time_created,1,7) = '$period') AND (test_results.result ='positive'))",
				

				"Hcg  Pregnacy tests done" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Pregnancy Test' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND 
										(substr(time_created,1,7) = '$period')",

				"Positive tests   ^" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Pregnancy Test' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND 
										((substr(time_created,1,7) = '$period') AND (test_results.result ='positive'))",

				"HIV tests on PEP" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'HIV' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND 
										(substr(time_created,1,7) = '$period')",

				"positives tests    ^" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'HIV' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND 
										((substr(time_created,1,7) = '$period') AND (test_results.result ='positive'))"

	
		);
		
		return $data[$indicator];
				
	}



	public function parasitologyMohReport(){

		$quarter = ['Quarter 1','Quarter 2','Quarter 3','Quarter 4'];	
		$currentYear = date("Y");
		$years = array();
		for($i = $currentYear; $i >= "2016"; $i = $i - 1){
			array_push($years,$i);
		}


		$indicators = array(
				"Total malaria microscopy tests done",
				"Malaria microscopy in <= 5yrs (by species)?",
				"Positive malaria slides in < 5yrs",
				"Malaria microscopy in unknown age",
				"Positive malaria slides in unknown age",
				"Total MRDTs Done",
				"MRDTs Positives",
				"MRDTs in <=  5yrs",
				"MRDT Positives in < 5yrs",
				"MRDTs in >= 5yrs",
				"MRDT Positives in > 5yrs",
				"Total invalid MRDTs tests",
				"Trypanosome tests",
				"Positive tests",
				"Urine microscopy total",
				"Schistosome Haematobium",
				"Other urine parasites",
				"urine chemistry (count)",
				"Semen analysis (count)",
				"Blood Parasites (count)",
				"Blood Parasites seen",
				"Stool Microscopy (count)",
				"Stool Microscopy Parasites seen"
			);
	
		return View::make('reports.moh.parasitologyReport')
						->with('quarterPeriod',$quarter)
						->with('years',$years)
						->with('heading','MoH Diagonistic Report (Parasitology Department)')
						->with('indicators',$indicators);
	}


	public function extractparasitolgyMohDiagnonisticStats($indicator,$month,$year){
		$period = $year."-".$month;
		$data = array(
				"Total malaria microscopy tests done" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE (test_types.name = 'Malaria Screening' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.id = 96 ) AND (test_results.result = '++++ (>10 parasites/field)' OR test_results.result = '+ (1-10 parasites/100 fields)' OR test_results.result = '++ (11-99 parasites/100 field)' OR test_results.result = '+++ (1-10 parasites /field)' OR test_results.result = 'No parasite seen'))",

					"Malaria microscopy in <= 5yrs (by species)?" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN visits ON visits.id = tests.visit_id	
										INNER JOIN patients ON patients.id = visits.patient_id
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE ((test_types.name = 'Malaria Screening' AND (substr(tests.time_created,1,4) - substr(patients.dob,1,4) <= 5)) AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'Blood film') AND (test_results.result = '++++ (>10 parasites/field)' OR test_results.result = '+ (1-10 parasites/100 fields)' OR test_results.result = '++ (11-99 parasites/100 field)' OR test_results.result = '+++ (1-10 parasites /field)' OR test_results.result = 'No parasite seen'))",

					"Positive malaria slides in < 5yrs" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN visits ON visits.id = tests.visit_id	
										INNER JOIN patients ON patients.id = visits.patient_id
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE ((test_types.name = 'Malaria Screening' AND (substr(tests.time_created,1,4) - substr(patients.dob,1,4) < 5)) AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'Blood film') AND (test_results.result = '++++ (>10 parasites/field)' OR test_results.result = '+ (1-10 parasites/100 fields)' OR test_results.result = '++ (11-99 parasites/100 field)' OR test_results.result = '+++ (1-10 parasites /field)'))",


					"Malaria microscopy in unknown age" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN visits ON visits.id = tests.visit_id	
										INNER JOIN patients ON patients.id = visits.patient_id
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE ((test_types.name = 'Malaria Screening' AND patients.dob IS NULL) AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'Blood film') AND (test_results.result = '++++ (>10 parasites/field)' OR test_results.result = '+ (1-10 parasites/100 fields)' OR test_results.result = '++ (11-99 parasites/100 field)' OR test_results.result = '+++ (1-10 parasites /field)' OR test_results.result = 'No parasite seen'))",


					"Positive malaria slides in unknown age" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN visits ON visits.id = tests.visit_id	
										INNER JOIN patients ON patients.id = visits.patient_id
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE ((test_types.name = 'Malaria Screening' AND patients.dob IS NULL) AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'Blood film') AND (test_results.result = '++++ (>10 parasites/field)' OR test_results.result = '+ (1-10 parasites/100 fields)' OR test_results.result = '++ (11-99 parasites/100 field)' OR test_results.result = '+++ (1-10 parasites /field)'))",

				"Total MRDTs Done" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE (test_types.name = 'Malaria Screening' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT'))",

				
				"MRDTs Positives" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE (test_types.name = 'Malaria Screening' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT') AND (test_results.result = 'positive'))",

				"MRDTs in <=  5yrs" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN visits ON visits.id = tests.visit_id	
										INNER JOIN patients ON patients.id = visits.patient_id
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE ((test_types.name = 'Malaria Screening' AND (substr(tests.time_created,1,4) - substr(patients.dob,1,4) <= 5)) AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT'))",

			"MRDT Positives in < 5yrs" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN visits ON visits.id = tests.visit_id	
										INNER JOIN patients ON patients.id = visits.patient_id
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE ((test_types.name = 'Malaria Screening' AND (substr(tests.time_created,1,4) - substr(patients.dob,1,4) < 5)) AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT') AND (test_results.result = 'positive'))",

			"MRDTs in >= 5yrs" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN visits ON visits.id = tests.visit_id	
										INNER JOIN patients ON patients.id = visits.patient_id
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE ((test_types.name = 'Malaria Screening' AND (substr(tests.time_created,1,4) - substr(patients.dob,1,4) >= 5)) AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT'))",


			"MRDT Positives in > 5yrs" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN visits ON visits.id = tests.visit_id	
										INNER JOIN patients ON patients.id = visits.patient_id
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE ((test_types.name = 'Malaria Screening' AND (substr(tests.time_created,1,4) - substr(patients.dob,1,4) > 5)) AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT') AND (test_results.result = 'positive'))",


			"Total invalid MRDTs tests" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE (test_types.name = 'Malaria Screening' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT') AND (test_results.result = 'invalid' OR test_results.result IS NULL))",

				"Trypanosome tests" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE (test_types.name = 'Trypanosome tests' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT') AND (test_results.result = 'positive' OR test_results.result = 'negative' OR test_results.result = 'invalid'))",

					"Positive tests" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE (test_types.name = 'Trypanosome tests' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT') AND (test_results.result = 'positive' OR test_results.result = 'negative' OR test_results.result = 'invalid'))",


					"Urine microscopy total" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Urine Microscopy' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' ))",

					"Schistosome Haematobium" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE (test_types.name = 'Schistosome Haematobiums' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT') AND (test_results.result = 'positive' OR test_results.result = 'negative' OR test_results.result = 'invalid'))",

					"Other urine parasites" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE (test_types.name = 'Other urine parasites' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT') AND (test_results.result = 'positive' OR test_results.result = 'negative' OR test_results.result = 'invalid'))",
			"urine chemistry (count)" => "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										INNER JOIN test_results ON test_results.test_id = tests.id 
										INNER JOIN measures ON measures.id = test_results.measure_id
										WHERE (test_types.name = 'urine chemistry (count)' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' AND measures.name = 'MRDT') AND (test_results.result = 'positive' OR test_results.result = 'negative' OR test_results.result = 'invalid'))",

					"Semen analysis (count)" =>  "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Semen Analysis' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' ))",


			"Blood Parasites (count)" =>  "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Blood Parasites seen' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' ))",

			"Blood Parasites seen" =>  "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Blood Parasites seen' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' ))",

			"Stool Microscopy (count)" =>  "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Stool Analysis' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' ))",

			"Stool Microscopy Parasites seen" =>  "SELECT count(*) AS test_count FROM 
										tests 
										INNER JOIN test_types ON test_types.id = tests.test_type_id
										INNER JOIN test_statuses ON test_statuses.id = tests.test_status_id
										WHERE (test_types.name = 'Stool Microscopy Parasites seen' AND (test_statuses.name ='verified' OR test_statuses.name ='completed'))AND  
										((substr(tests.time_created,1,7) = '$period' ))",

		);
	
		return $data[$indicator];
				
	}

	//	End Daily Log-Patient report functions

	/*	Begin Aggregate reports functions	*/
	//	Begin prevalence rates reports functions
	/**
	 * Display a both chart and table on load.
	 *
	 * @return Response
	 */
	public function prevalenceRates()
	{
		$from = Input::get('start');
		$to = Input::get('end');
		$today = date('Y-m-d');
		$year = date('Y');
		$testTypeID = Input::get('test_type');

		//	Apply filters if any
		if(Input::has('filter')){

			if(!$to) $to=$today;

			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($today)||strtotime($to)>strtotime($today)){
				Session::flash('message', trans('messages.check-date-range'));
			}

			$months = json_decode(self::getMonths($from, $to));
			$data = TestType::getPrevalenceCounts($from, $to, $testTypeID);
			$chart = self::getPrevalenceRatesChart($testTypeID);
		}
		else
		{
			// Get all tests for the current year
			$test = Test::where('time_created', 'LIKE', date('Y').'%');
			$periodStart = $test->min('time_created'); //Get the minimum date
			$periodEnd = $test->max('time_created'); //Get the maximum date
			$data = TestType::getPrevalenceCounts($periodStart, $periodEnd);
			$chart = self::getPrevalenceRatesChart();
		}

		return View::make('reports.prevalence.index')
						->with('data', $data)
						->with('chart', $chart)
						->withInput(Input::all());
	}

	/**
	* Get months: return months for time_created column when filter dates are set
	*/	
	public static function getMonths($from, $to){
		$today = "'".date("Y-m-d")."'";
		$year = date('Y');
		$tests = Test::select('time_created')->distinct();

		if(strtotime($from)===strtotime($today)){
			$tests = $tests->where('time_created', 'LIKE', $year.'%');
		}
		else
		{
			$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
			$tests = $tests->whereBetween('time_created', array($from, $toPlusOne));
		}

		$allDates = $tests->lists('time_created');
		asort($allDates);
		$yearMonth = function($value){return strtotime(substr($value, 0, 7));};
		$allDates = array_map($yearMonth, $allDates);
		$allMonths = array_unique($allDates);
		$dates = array();

		foreach ($allMonths as $date) {
			$dateInfo = getdate($date);
			$dates[] = array('months' => $dateInfo['mon'], 'label' => substr($dateInfo['month'], 0, 3),
				'annum' => $dateInfo['year']);
		}

		return json_encode($dates);
	}
	/**
	 * Display prevalence rates chart
	 *
	 * @return Response
	 */
	public static function getPrevalenceRatesChart($testTypeID = 0){
		$from = Input::get('start');
		$to = Input::get('end');
		$months = json_decode(self::getMonths($from, $to));
		$testTypes = new Illuminate\Database\Eloquent\Collection();

		if($testTypeID == 0){
			
			$testTypes = TestType::supportPrevalenceCounts();
		}else{
			$testTypes->add(TestType::find($testTypeID));
		}

		$options = '{
		    "chart": {
		        "type": "spline"
		    },
		    "title": {
		        "text":"'.trans('messages.prevalence-rates').'"
		    },
		    "subtitle": {
		        "text":'; 
		        if($from==$to)
		        	$options.='"'.trans('messages.for-the-year').' '.date('Y').'"';
		        else
		        	$options.='"'.trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to.'"';
		    $options.='},
		    "credits": {
		        "enabled": false
		    },
		    "navigation": {
		        "buttonOptions": {
		            "align": "right"
		        }
		    },
		    "series": [';
		    	$counts = count($testTypes);

			    	foreach ($testTypes as $testType) {
		        		$options.= '{
		        			"name": "'.$testType->name.'","data": [';
		        				$counter = count($months);
		            			foreach ($months as $month) {
		            			$data = $testType->getPrevalenceCount($month->annum, $month->months);
		            				if($data->isEmpty()){
		            					$options.= '0.00';
		            					if($counter==1)
			            					$options.='';
			            				else
			            					$options.=',';
		            				}
		            				else{
		            					foreach ($data as $datum) {
				            				$options.= $datum->rate;

				            				if($counter==1)
				            					$options.='';
				            				else
				            					$options.=',';
					            		}
		            				}
		            			$counter--;
				    		}
				    		$options.=']';
				    	if($counts==1)
							$options.='}';
						else
							$options.='},';
						$counts--;
					}
			$options.='],
		    "xAxis": {
		        "categories": [';
		        $count = count($months);
	            	foreach ($months as $month) {
	    				$options.= '"'.$month->label." ".$month->annum;
	    				if($count==1)
	    					$options.='" ';
	    				else
	    					$options.='" ,';
	    				$count--;
	    			}
	            $options.=']
		    },
		    "yAxis": {
		        "title": {
		            "text": "'.trans('messages.prevalence-rates-label').'"
		        },
	            "min": "0",
	            "max": "100"
		    }
		}';
	return $options;
	}
	//	Begin count reports functions
	/**
	 * Display a test((un)grouped) and specimen((un)grouped) counts.
	 *
	 */
	public function countReports(){
		$date = date('Y-m-d');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');
		$to = Input::get('end');
		if(!$to) $to = $date;
		$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
		$counts = Input::get('counts');
		$accredited = array();
		//	Begin grouped test counts
		if($counts==trans('messages.grouped-test-counts'))
		{
			$testCategories = TestCategory::all();
			$testTypes = TestType::all();
			$ageRanges = array('0-5', '5-15', '15-120');	//	Age ranges - will definitely change in configurations
			$gender = array(Patient::MALE, Patient::FEMALE); 	//	Array for gender - male/female

			$perAgeRange = array();	// array for counts data for each test type and age range
			$perTestType = array();	//	array for counts data per testype
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
				Session::flash('message', trans('messages.check-date-range'));
			}
			foreach ($testTypes as $testType) {
				$countAll = $testType->groupedTestCount(null, null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countMale = $testType->groupedTestCount([Patient::MALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countFemale = $testType->groupedTestCount([Patient::FEMALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$perTestType[$testType->id] = ['countAll'=>$countAll, 'countMale'=>$countMale, 'countFemale'=>$countFemale];
				foreach ($ageRanges as $ageRange) {
					$maleCount = $testType->groupedTestCount([Patient::MALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$femaleCount = $testType->groupedTestCount([Patient::FEMALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$perAgeRange[$testType->id][$ageRange] = ['male'=>$maleCount, 'female'=>$femaleCount];
				}
			}
			return View::make('reports.counts.groupedTestCount')
						->with('testCategories', $testCategories)
						->with('ageRanges', $ageRanges)
						->with('gender', $gender)
						->with('perTestType', $perTestType)
						->with('perAgeRange', $perAgeRange)
						->with('accredited', $accredited)
						->withInput(Input::all());
		}
		else if($counts==trans('messages.ungrouped-specimen-counts')){
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
				Session::flash('message', trans('messages.check-date-range'));
			}

			$ungroupedSpecimen = array();
			foreach (SpecimenType::all() as $specimenType) {
				$rejected = $specimenType->countPerStatus([Specimen::REJECTED], $from, $toPlusOne->format('Y-m-d H:i:s'));
				$accepted = $specimenType->countPerStatus([Specimen::ACCEPTED], $from, $toPlusOne->format('Y-m-d H:i:s'));
				$total = $rejected+$accepted;
				$ungroupedSpecimen[$specimenType->id] = ["total"=>$total, "rejected"=>$rejected, "accepted"=>$accepted];
			}

			// $data = $data->groupBy('test_type_id')->paginate(Config::get('kblis.page-items'));
			return View::make('reports.counts.ungroupedSpecimenCount')
							->with('ungroupedSpecimen', $ungroupedSpecimen)
							->with('accredited', $accredited)
							->withInput(Input::all());

		}
		else if($counts==trans('messages.grouped-specimen-counts')){
			$ageRanges = array('0-5', '5-15', '15-120');	//	Age ranges - will definitely change in configurations
			$gender = array(Patient::MALE, Patient::FEMALE); 	//	Array for gender - male/female

			$perAgeRange = array();	// array for counts data for each test type and age range
			$perSpecimenType = array();	//	array for counts data per testype
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
				Session::flash('message', trans('messages.check-date-range'));
			}
			$specimenTypes = SpecimenType::all();
			foreach ($specimenTypes as $specimenType) {
				$countAll = $specimenType->groupedSpecimenCount([Patient::MALE, Patient::FEMALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countMale = $specimenType->groupedSpecimenCount([Patient::MALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countFemale = $specimenType->groupedSpecimenCount([Patient::FEMALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$perSpecimenType[$specimenType->id] = ['countAll'=>$countAll, 'countMale'=>$countMale, 'countFemale'=>$countFemale];
				foreach ($ageRanges as $ageRange) {
					$maleCount = $specimenType->groupedSpecimenCount([Patient::MALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$femaleCount = $specimenType->groupedSpecimenCount([Patient::FEMALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$perAgeRange[$specimenType->id][$ageRange] = ['male'=>$maleCount, 'female'=>$femaleCount];
				}
			}
			return View::make('reports.counts.groupedSpecimenCount')
						->with('specimenTypes', $specimenTypes)
						->with('ageRanges', $ageRanges)
						->with('gender', $gender)
						->with('perSpecimenType', $perSpecimenType)
						->with('perAgeRange', $perAgeRange)
						->with('accredited', $accredited)
						->withInput(Input::all());
		}
		else{
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
				Session::flash('message', trans('messages.check-date-range'));
			}

			$ungroupedTests = array();
			foreach (TestType::all() as $testType) {
				$pending = $testType->countPerStatus([Test::PENDING, Test::STARTED], $from, $toPlusOne->format('Y-m-d H:i:s'));
				$complete = $testType->countPerStatus([Test::COMPLETED, Test::VERIFIED], $from, $toPlusOne->format('Y-m-d H:i:s'));
				$ungroupedTests[$testType->id] = ["complete"=>$complete, "pending"=>$pending];
			}

			// $data = $data->groupBy('test_type_id')->paginate(Config::get('kblis.page-items'));
			return View::make('reports.counts.ungroupedTestCount')
							->with('ungroupedTests', $ungroupedTests)
							->with('accredited', $accredited)
							->withInput(Input::all());
		}
	}

	/*
	*	Begin turnaround time functions - functions related to the turnaround time report
	*	Most have been borrowed from the original BLIS by C4G
	*/
	/*
	* 	getPercentile() returns the percentile value from the given list
	*/
	public static function getPercentile($list, $ile_value)
	{
		$num_values = count($list);
		sort($list);
		$mark = ceil(round($ile_value/100, 2) * $num_values);
		return $list[$mark-1];
	}
	/*
	* 	week_to_date() returns timestamp for the first day of the week (Monday)
	*	@var $week_num and $year
	*/
	public static function week_to_date($week_num, $year)
	{
		# Returns timestamp for the first day of the week (Monday)
		$week = $week_num;
		$Jan1 = mktime (0, 0, 0, 1, 1, $year); //Midnight
		$iYearFirstWeekNum = (int) strftime("%W", $Jan1);
		if ($iYearFirstWeekNum == 1)
		{
			$week = $week - 1;
		}
		$weekdayJan1 = date ('w', $Jan1);
		$FirstMonday = strtotime(((4-$weekdayJan1)%7-3) . ' days', $Jan1);
		$CurrentMondayTS = strtotime(($week) . ' weeks', $FirstMonday);
		return ($CurrentMondayTS);
	}
	/*
	* 	rawTaT() returns list of timestamps for tests that were registered and handled between date_from and date_to
	*	optional @var $from, $to, $labSection, $testType
	*/
	public static function rawTaT($from, $to, $labSection, $testType){
		$rawTat = DB::table('tests')->select(DB::raw('UNIX_TIMESTAMP(time_created) as timeCreated, UNIX_TIMESTAMP(time_started) as timeStarted, UNIX_TIMESTAMP(time_completed) as timeCompleted, targetTAT'))
						->join('test_types', 'test_types.id', '=', 'tests.test_type_id')
						->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED]);
						if($from && $to){
							$rawTat = $rawTat->whereBetween('time_created', [$from, $to]);
						}
						else{
							$rawTat = $rawTat->where('time_created', 'LIKE', '%'.date("Y").'%');
						}
						if($labSection){
							$rawTat = $rawTat->where('test_category_id', $labSection);
						}
						if($testType){
							$rawTat = $rawTat->where('test_type_id', $testType);
						}
		return $rawTat->get();
	}
	/*
	* 	getTatStats() calculates Weekly progression of TAT values for a given test type and time period
	*	optional @var $from, $to, $labSection, $testType, $interval
	*/
	public static function getTatStats($from, $to, $labSection, $testType, $interval){
		# Calculates Weekly progression of TAT values for a given test type and time period

		$resultset = self::rawTaT($from, $to, $labSection, $testType);
		# {resultentry_ts, specimen_id, date_collected_ts, ...}

		$progression_val = array();
		$progression_count = array();
		$percentile_tofind = 90;
		$percentile_count = array();
		$goal_val = array();
		# Return {month=>[avg tat, percentile tat, goal tat, [overdue specimen_ids], [pending specimen_ids]]}

		if($interval == 'M'){
			foreach($resultset as $record)
			{
				$timeCreated = $record->timeCreated;
				$timeCreated_parsed = date("Y-m-d", $timeCreated);
				$timeCreated_parts = explode("-", $timeCreated_parsed);
				$month_ts = mktime(0, 0, 0, $timeCreated_parts[1], 0, $timeCreated_parts[0]);
				$month_ts_datetime = date("Y-m-d H:i:s", $month_ts);
				$wait_diff = ($record->timeStarted - $record->timeCreated); //Waiting time
				$date_diff = ($record->timeCompleted - $record->timeStarted); //Turnaround time

				if(!isset($progression_val[$month_ts]))
				{
					$progression_val[$month_ts] = array();
					$progression_val[$month_ts][0] = $date_diff;
					$progression_val[$month_ts][1] = $wait_diff;
					$progression_val[$month_ts][4] = array();
					$progression_val[$month_ts][4][] = $record;

					$percentile_count[$month_ts] = array();
					$percentile_count[$month_ts][] = $date_diff;

					$progression_count[$month_ts] = 1;

					if(!$record->targetTAT==null)
						$goal_tat[$month_ts] = $record->targetTAT; //Hours
					else
						$goal_tat[$month_ts] = 0.00; //Hours			
				}
				else
				{
					$progression_val[$month_ts][0] += $date_diff;
					$progression_val[$month_ts][1] += $wait_diff;
					$progression_val[$month_ts][4][] = $record;

					$percentile_count[$month_ts][] = $date_diff;

					$progression_count[$month_ts] += 1;
				}
			}

			foreach($progression_val as $key=>$value)
			{
				# Find average TAT
				$progression_val[$key][0] = $value[0]/$progression_count[$key];

				# Determine percentile value
				$progression_val[$key][3] = self::getPercentile($percentile_count[$key], $percentile_tofind);

				# Convert from sec timestamp to Hours
				$progression_val[$key][0] = ($value[0]/$progression_count[$key])/(60*60);//average TAT
				$progression_val[$key][1] = ($value[1]/$progression_count[$key])/(60*60);//average WT
				$progression_val[$key][3] = $progression_val[$key][3]/(60*60);// Percentile ???

				$progression_val[$key][2] = $goal_tat[$key];

			}
		}
		else if($interval == 'D'){
			foreach($resultset as $record)
			{
				$date_collected = $record->timeCreated;
				$day_ts = $date_collected; 
				$wait_diff = ($record->timeStarted - $record->timeCreated); //Waiting time
				$date_diff = ($record->timeCompleted - $record->timeStarted); //Turnaround time
				if(!isset($progression_val[$day_ts]))
				{
					$progression_val[$day_ts] = array();
					$progression_val[$day_ts][0] = $date_diff;
					$progression_val[$day_ts][1] = $wait_diff;
					$progression_val[$day_ts][4] = array();
					$progression_val[$day_ts][4][] = $record;

					$percentile_count[$day_ts] = array();
					$percentile_count[$day_ts][] = $date_diff;

					$progression_count[$day_ts] = 1;

					$goal_tat[$day_ts] = $record->targetTAT; //Hours
				}
				else
				{
					$progression_val[$day_ts][0] += $date_diff;
					$progression_val[$day_ts][1] += $wait_diff;
					$progression_val[$day_ts][4][] = $record;

					$percentile_count[$day_ts][] = $date_diff;

					$progression_count[$day_ts] += 1;
				}
			}

			foreach($progression_val as $key=>$value)
			{
				# Find average TAT
				$progression_val[$key][0] = $value[0]/$progression_count[$key];

				# Determine percentile value
				$progression_val[$key][3] = self::getPercentile($percentile_count[$key], $percentile_tofind);

				# Convert from sec timestamp to Hours
				$progression_val[$key][0] = ($value[0]/$progression_count[$key])/(60*60);//average TAT
				$progression_val[$key][1] = ($value[1]/$progression_count[$key])/(60*60);//average WT
				$progression_val[$key][3] = $progression_val[$key][3]/(60*60);// Percentile ???

				$progression_val[$key][2] = $goal_tat[$key];

			}
		}
		else{
			foreach($resultset as $record)
			{
				$date_collected = $record->timeCreated;
				$week_collected = date("W", $date_collected);
				$year_collected = date("Y", $date_collected);
				$week_ts = self::week_to_date($week_collected, $year_collected);
				$wait_diff = ($record->timeStarted - $record->timeCreated); //Waiting time
				$date_diff = ($record->timeCompleted - $record->timeStarted); //Turnaround time

				if(!isset($progression_val[$week_ts]))
				{
					$progression_val[$week_ts] = array();
					$progression_val[$week_ts][0] = $date_diff;
					$progression_val[$week_ts][1] = $wait_diff;
					$progression_val[$week_ts][4] = array();
					$progression_val[$week_ts][4][] = $record;

					$percentile_count[$week_ts] = array();
					$percentile_count[$week_ts][] = $date_diff;

					$progression_count[$week_ts] = 1;

					if(!$record->targetTAT==null)
						$goal_tat[$week_ts] = $record->targetTAT; //Hours
					else
						$goal_tat[$week_ts] = 0.00; //Hours				
				}
				else
				{
					$progression_val[$week_ts][0] += $date_diff;
					$progression_val[$week_ts][1] += $wait_diff;
					$progression_val[$week_ts][4][] = $record;

					$percentile_count[$week_ts][] = $date_diff;

					$progression_count[$week_ts] += 1;
				}
			}

			foreach($progression_val as $key=>$value)
			{
				# Find average TAT
				$progression_val[$key][0] = $value[0]/$progression_count[$key];

				# Determine percentile value
				$progression_val[$key][3] = self::getPercentile($percentile_count[$key], $percentile_tofind);

				# Convert from sec timestamp to Hours
				$progression_val[$key][0] = ($value[0]/$progression_count[$key])/(60*60);//average TAT
				$progression_val[$key][1] = ($value[1]/$progression_count[$key])/(60*60);//average WT
				$progression_val[$key][3] = $progression_val[$key][3]/(60*60);// Percentile ???

				$progression_val[$key][2] = $goal_tat[$key];

			}
		}
		# Return {month=>[avg tat, percentile tat, goal tat, [overdue specimen_ids], [pending specimen_ids], avg wait time]}
		return $progression_val;
	}

	/**
	 * turnaroundTime() function returns the turnaround time blade with necessary contents
	 *
	 * @return Response
	 */
	public function turnaroundTime()
	{
		$today = date('Y-m-d');
		$from = Input::get('start');
		$to = Input::get('end');
		if(!$to){
			$to=$today;
		}
		$testCategory = Input::get('section_id');
		$testType = Input::get('test_type');
		$labSections = TestCategory::lists('name', 'id');
		$interval = Input::get('period');
		$error = null;
		$accredited = array();

		if($testCategory)
			$testTypes = TestCategory::find($testCategory)->testTypes->lists('name', 'id');
		else
			$testTypes = array(""=>"");

		if($from||$to){
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($today)||strtotime($to)>strtotime($today)){
					$error = trans('messages.check-date-range');
			}
			else
			{
				$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
				Session::flash('fine', '');
			}
		}
		$resultset = self::getTatStats($from, $to, $testCategory, $testType, $interval);
		return View::make('reports.tat.index')
					->with('labSections', $labSections)
					->with('testTypes', $testTypes)
					->with('resultset', $resultset)
					->with('testCategory', $testCategory)
					->with('testType', $testType)
					->with('interval', $interval)
					->with('error', $error)
					->with('accredited', $accredited)
					->withInput(Input::all());
	}

	//	Begin infection reports functions
	/**
	 * Display a table containing all infection statistics.
	 *
	 */
	public function infectionReport(){

	 	$ageRanges = array('0-5'=>'Under 5 years', 
	 					'5-14'=>'5 years and over but under 14 years', 
	 					'14-120'=>'14 years and above');	//	Age ranges - will definitely change in configurations
		$gender = array(Patient::MALE, Patient::FEMALE); 	//	Array for gender - male/female
		$ranges = array('Low', 'Normal', 'High');
		$accredited = array();

		//	Fetch form filters
		$date = date('Y-m-d');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');
		$to = Input::get('end');
		if(!$to) $to = $date;
		
		$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));

		$testCategory = Input::get('test_category');

		$infectionData = Test::getInfectionData($from, $toPlusOne, $testCategory);	// array for counts data for each test type and age range
		
		return View::make('reports.infection.index')
					->with('gender', $gender)
					->with('ageRanges', $ageRanges)
					->with('ranges', $ranges)
					->with('infectionData', $infectionData)
					->with('accredited', $accredited)
					->withInput(Input::all());
	}

	/**
	 * Displays summary statistics on users application usage.
	 *
	 */
	public function userStatistics(){

		//	Fetch form filters
		$date = date('Y-m-d');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');

		$to = Input::get('end');
		if(!$to) $to = $date;
		
		$selectedUser = Input::get('user');
		if(!$selectedUser)$selectedUser = "";
		else $selectedUser = " USER: ".User::find($selectedUser)->name;

		$reportTypes = array('Summary', 'Patient Registry', 'Specimen Registry', 'Tests Registry', 'Tests Performed');

		$selectedReport = Input::get('report_type');
		if(!$selectedReport)$selectedReport = 0;

		switch ($selectedReport) {
			case '1':
				$reportData = User::getPatientsRegistered($from, $to.' 23:59:59', Input::get('user'));
				$reportTitle = Lang::choice('messages.user-statistics-patients-register-report-title',1);
				break;
			case '2':
				$reportData = User::getSpecimensRegistered($from, $to.' 23:59:59', Input::get('user'));
				$reportTitle = Lang::choice('messages.user-statistics-specimens-register-report-title',1);
				break;
			case '3':
				$reportData = User::getTestsRegistered($from, $to.' 23:59:59', Input::get('user'));
				$reportTitle = Lang::choice('messages.user-statistics-tests-register-report-title',1);
				break;
			case '4':
				$reportData = User::getTestsPerformed($from, $to.' 23:59:59', Input::get('user'));
				$reportTitle = Lang::choice('messages.user-statistics-tests-performed-report-title',1);
				break;
			default:
				$reportData = User::getSummaryUserStatistics($from, $to.' 23:59:59', Input::get('user'));
				$reportTitle = Lang::choice('messages.user-statistics-summary-report-title',1);
				break;
		}

		$reportTitle = str_replace("[FROM]", $from, $reportTitle);
		$reportTitle = str_replace("[TO]", $to, $reportTitle);
		$reportTitle = str_replace("[USER]", $selectedUser, $reportTitle);
		
		return View::make('reports.userstatistics.index')
					->with('reportTypes', $reportTypes)
					->with('reportData', $reportData)
					->with('reportTitle', $reportTitle)
					->with('selectedReport', $selectedReport)
					->withInput(Input::all());
	}

	/**
	* Returns qc index page
	*
	* @return view
	*/
	public function qualityControl()
	{
		$accredited = array();
		$controls = Control::all()->lists('name', 'id');
		return View::make('reports.qualitycontrol.index')->with('controls', $controls)->with('accredited', $accredited);
	}

	/**
	* Returns qc results for a specific control page
	*
	* @param Input - controlId, date range
	* @return view
	*/
	public function qualityControlResults()
	{
		$rules = array('start_date' => 'date|required',
					'end_date' => 'date|required',
					'control' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		}
		else {
			$controlId = Input::get('control');
			$endDatePlusOne = date_add(new DateTime(Input::get('end_date')), date_interval_create_from_date_string('1 day'));
			$dates= array(Input::get('start_date'), $endDatePlusOne);
			$control = Control::find($controlId);
			$controlTests = ControlTest::where('control_id', '=', $controlId)
										->whereBetween('created_at', $dates)->get();
			$leveyJennings = $this->leveyJennings($control, $dates);
			return View::make('reports.qualitycontrol.results')
				->with('control', $control)
				->with('controlTests', $controlTests)
				->with('leveyJennings', $leveyJennings)
				->withInput(Input::all());
		}
	}

	/**
	 * Displays Surveillance
	 * @param string $from, string $to, array() $testTypeIds
	 * As of now surveillance works only with alphanumeric measures
	 */
	public function surveillance(){
		/*surveillance diseases*/
		//	Fetch form filters
		$date = date('Y-m-d');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');
		$to = Input::get('end');
		if(!$to) $to = $date;
		$accredited = array();

		$surveillance = Test::getSurveillanceData($from, $to.' 23:59:59');


		if(Input::has('word')){
			$fileName = "surveillance_".$date.".doc";
			$headers = array(
			    "Content-type"=>"text/html",
			    "Content-Disposition"=>"attachment;Filename=".$fileName
			);
			$content = View::make('reports.surveillance.exportSurveillance')
							->with('surveillance', $surveillance)
							->with('accredited', $accredited)
							->withInput(Input::all());
			return Response::make($content,200, $headers);
		}else{
			return View::make('reports.surveillance.index')
					->with('surveillance', $surveillance)
					->with('accredited', $accredited)
					->withInput(Input::all());
		}
	}

	/**
	 * Manage Surveillance Configurations
	 * @param
	 */
	public function surveillanceConfig(){
		
        $allSurveillanceIds = array();
		
		//edit or leave surveillance entries as is
		if (Input::get('surveillance')) {
			$diseases = Input::get('surveillance');

			foreach ($diseases as $id => $disease) {
                $allSurveillanceIds[] = $id;
				$surveillance = ReportDisease::find($id);
				$surveillance->test_type_id = $disease['test-type'];
				$surveillance->disease_id = $disease['disease'];
				$surveillance->save();
			}
		}
		
		//save new surveillance entries
		if (Input::get('new-surveillance')) {
			$diseases = Input::get('new-surveillance');

			foreach ($diseases as $id => $disease) {
				$surveillance = new ReportDisease;
				$surveillance->test_type_id = $disease['test-type'];
				$surveillance->disease_id = $disease['disease'];
				$surveillance->save();
                $allSurveillanceIds[] = $surveillance->id;
				
			}
		}

        //check if action is from a form submission
        if (Input::get('from-form')) {
	     	// Delete any pre-existing surveillance entries
	     	//that were not captured in any of the above save loops
	        $allSurveillances = ReportDisease::all(array('id'));

	        $deleteSurveillances = array();

	        //Identify survillance entries to be deleted by Ids
	        foreach ($allSurveillances as $key => $value) {
	            if (!in_array($value->id, $allSurveillanceIds)) {
	                $deleteSurveillances[] = $value->id;
	            }
	        }
	        //Delete Surveillance entry if any
	        if(count($deleteSurveillances)>0)ReportDisease::destroy($deleteSurveillances);
        }

		$diseaseTests = ReportDisease::all();

		return View::make('reportconfig.surveillance')
					->with('diseaseTests', $diseaseTests);
	}
	/**
	 * MOH 706
	 *
	 */
	public function moh706(){
		//	Variables definition
		$date = date('Y-m-d');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');
		$end = Input::get('end');
		if(!$end) $end = $date;
		$toPlusOne = date_add(new DateTime($end), date_interval_create_from_date_string('1 day'));
		$to = date_add(new DateTime($end), date_interval_create_from_date_string('1 day'))->format('Y-m-d');
		$ageRanges = array('0-5', '5-14', '14-120');
		$sex = array(Patient::MALE, Patient::FEMALE);
		$ranges = array('Low', 'Normal', 'High');
		$specimen_types = array('Urine', 'Pus', 'HVS', 'Throat', 'Stool', 'Blood', 'CSF', 'Water', 'Food', 'Other fluids');
		$isolates = array('Naisseria', 'Klebsiella', 'Staphylococci', 'Streptoccoci'. 'Proteus', 'Shigella', 'Salmonella', 'V. cholera', 
						  'E. coli', 'C. neoformans', 'Cardinella vaginalis', 'Haemophilus', 'Bordotella pertusis', 'Pseudomonas', 
						  'Coliforms', 'Faecal coliforms', 'Enterococcus faecalis', 'Total viable counts-22C', 'Total viable counts-37C', 
						  'Clostridium', 'Others');

		//	Get specimen_types for microbiology
		$labSecId = TestCategory::getTestCatIdByName('microbiology');
		$specTypeIds = DB::select(DB::raw("select distinct(specimen_types.id) as spec_id from testtype_specimentypes".
										  " join test_types on test_types.id=testtype_specimentypes.test_type_id".
										  " join specimen_types on testtype_specimentypes.specimen_type_id=specimen_types.id".
										  "  where test_types.test_category_id=?"), array($labSecId));

		//	Referred out specimen
		$referredSpecimens = DB::select(DB::raw("SELECT specimen_type_id, specimen_types.name as spec, count(specimens.id) as tot,".
												" facility_id, facilities.name as facility FROM iblis.specimens".
												" join referrals on specimens.referral_id=referrals.id".
												" join specimen_types on specimen_type_id=specimen_types.id".
												" join facilities on referrals.facility_id=facilities.id".
												" where referral_id is not null and status=1".
												" and time_accepted between ? and ?".
												" group by facility_id;"), array($from, $toPlusOne));
		$table = '<!-- URINALYSIS -->
			<div class="col-sm-12">
				<strong>URINE ANALYSIS</strong>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th rowspan="2">Urine Chemistry</th>
							<th colspan="2">No. Exam</th>
							<th colspan="4"> Number positive</th>
						</tr>
						<tr>
							<th>M</th>
							<th>F</th>
							<th>Total</th>
							<th>&lt;5yrs</th>
							<th>5-14yrs</th>
							<th>&gt;14yrs</th>
						</tr>
					</thead>';
				$urinaId = TestType::getTestTypeIdByTestName('Urinalysis');
				$urinalysis = TestType::find($urinaId);
				$urineChem = TestType::getTestTypeIdByTestName('Urine Chemistry');
				$urineChemistry = TestType::find($urineChem);
				$measures = TestTypeMeasure::where('test_type_id', $urinaId)->orderBy('measure_id', 'DESC')->get();
				$table.='<tbody>
						<tr>
							<td>Totals</td>';
						foreach ($sex as $gender) {
							$table.='<td>'.$urinalysis->groupedTestCount([$gender], null, $from, $toPlusOne).'</td>';
						}
						$table.='<td>'.$urinalysis->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
						foreach ($ageRanges as $ageRange) {
							$table.='<td>'.$urinalysis->groupedTestCount([Patient::MALE, Patient::FEMALE], $ageRange, $from, $toPlusOne).'</td>';
						}	
					$table.='</tr>';
				
				foreach ($measures as $measure) {
					$tMeasure = Measure::find($measure->measure_id);
					if(in_array($tMeasure->name, ['ph', 'Epithelial cells', 'Pus cells', 'S. haematobium', 'T. vaginalis', 'Yeast cells', 'Red blood cells', 'Bacteria', 'Spermatozoa'])){continue;}
					$table.='<tr>
								<td>'.$tMeasure->name.'</td>';
							foreach ($sex as $gender) {
								$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne, null, null).'</td>';
							}
							$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne, null, 1).'</td>';
							foreach ($ageRanges as $ageRange) {
								$table.='<td>'.$tMeasure->totalTestResults(null, $ageRange, $from, $toPlusOne, null, 1).'</td>';
							}
							$table.='</tr>';
				}

				$table.='<tr>
							<td>Others</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th rowspan="2">Urine Microscopy</th>
							<th colspan="2">No. Exam</th>
							<th colspan="4"> Number positive</th>
						</tr>
						<tr>
							<th>M</th>
							<th>F</th>
							<th>Total</th>
							<th>&lt;5yrs</th>
							<th>5-14yrs</th>
							<th>&gt;14yrs</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>Totals</td>';
				$urineMic = TestType::getTestTypeIdByTestName('Urine Microscopy');
				$urineMicroscopy = TestType::find($urineMic);
				$measures = TestTypeMeasure::where('test_type_id', $urinaId)->orderBy('measure_id', 'DESC')->get();
						foreach ($sex as $gender) {
							$table.='<td>'.$urinalysis->groupedTestCount([$gender], null, $from, $toPlusOne).'</td>';
						}
						$table.='<td>'.$urinalysis->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
						foreach ($ageRanges as $ageRange) {
							$table.='<td>'.$urinalysis->groupedTestCount([Patient::MALE, Patient::FEMALE], $ageRange, $from, $toPlusOne).'</td>';
						}	
					$table.='</tr>';
				
				foreach ($measures as $measure) {
					$tMeasure = Measure::find($measure->measure_id);
					if(in_array($tMeasure->name, ['Leucocytes', 'Nitrites', 'Glucose', 'pH', 'Bilirubin', 'Ketones', 'Proteins', 'Blood', 'Urobilinogen Phenlpyruvic acid'])){continue;}
					$table.='<tr>
								<td>'.$tMeasure->name.'</td>';
							foreach ($sex as $gender) {
								$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne, null, null).'</td>';
							}
							$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne, null, 1).'</td>';
							foreach ($ageRanges as $ageRange) {
								$table.='<td>'.$tMeasure->totalTestResults(null, $ageRange, $from, $toPlusOne, null, 1).'</td>';
							}
							$table.='</tr>';
				}
				$table.='<tr>
							<td>Others</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th rowspan="2">Blood Chemistry</th>
							<th colspan="2">No. Exam</th>
							<th colspan="4"> Number positive</th>
						</tr>
						<tr>
							<th>M</th>
							<th>F</th>
							<th>Total</th>
							<th>Low</th>
							<th>Normal</th>
							<th>High</th>
						</tr>
					</thead>
					<tbody>';
				$bloodChem = TestType::getTestTypeIdByTestName('Blood Sugar');
				$bloodChemistry = TestType::find($bloodChem);
				$measures = TestTypeMeasure::where('test_type_id', $bloodChem)->orderBy('measure_id', 'DESC')->get();
					$table.='<tr>
							<td>Totals</td>';
					foreach ($sex as $gender) {
						$table.='<td>'.$bloodChemistry->groupedTestCount([$gender], null, $from, $toPlusOne).'</td>';
					}
					$table.='<td>'.$bloodChemistry->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
					foreach ($ageRanges as $ageRange) {
						$table.='<td>'.$bloodChemistry->groupedTestCount([Patient::MALE, Patient::FEMALE], $ageRange, $from, $toPlusOne).'</td>';
					}
					foreach ($measures as $measure) {
						$tMeasure = Measure::find($measure->measure_id);	
						$table.='<tr>
								<td>'.$tMeasure->name.'</td>';
							foreach ($sex as $gender) {
								$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne, null, null).'</td>';
							}
							$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne, ['Low', 'Normal', 'High'], null).'</td>';
							foreach ($ranges as $range) {
								$table.='<td>'.$tMeasure->totalTestResults(null, null, $from, $toPlusOne, [$range], 1).'</td>';
							}
							$table.='</tr>';
					}
					$table.='<tr>
							<td>OGTT</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th rowspan="2">Renal function tests</th>
							<th colspan="2">No. Exam</th>
							<th colspan="4"> Number positive</th>
						</tr>
						<tr>
							<th>M</th>
							<th>F</th>
							<th>Total</th>
							<th>Low</th>
							<th>Normal</th>
							<th>High</th>
						</tr>
					</thead>
					<tbody>';
				$rfts = TestType::getTestTypeIdByTestName('RFTS');
				$rft = TestType::find($rfts);
				$measures = TestTypeMeasure::where('test_type_id', $rfts)->orderBy('measure_id', 'DESC')->get();
				$table.='<tr>
						<td>Totals</td>';
	        		foreach ($sex as $gender) {
						$table.='<td>'.$rft->groupedTestCount([$gender], null, $from, $toPlusOne).'</td>';
					}
					$table.='<td>'.$rft->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
					foreach ($ageRanges as $ageRange) {
						$table.='<td>'.$rft->groupedTestCount([Patient::MALE, Patient::FEMALE], $ageRange, $from, $toPlusOne).'</td>';
					}	
				$table.='</tr>';
				foreach ($measures as $measure) {
					$name = Measure::find($measure->measure_id)->name;
					if($name == 'Electrolytes'){
						continue;
					}
					$tMeasure = Measure::find($measure->measure_id);
					$table.='<tr>
								<td>'.$tMeasure->name.'</td>';
							foreach ($sex as $gender) {
								$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne, null, null).'</td>';
							}
							$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne, null, 1).'</td>';
							foreach ($ranges as $range) {
								$table.='<td>'.$tMeasure->totalTestResults(null, null, $from, $toPlusOne, [$range], 1).'</td>';
							}
							$table.='</tr>';
				}
				$table.='</tbody>
				</table>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th rowspan="2">Liver Function Tests</th>
							<th colspan="2">No. Exam</th>
							<th colspan="4"> Number positive</th>
						</tr>
						<tr>
							<th>M</th>
							<th>F</th>
							<th>Total</th>
							<th>Low</th>
							<th>Normal</th>
							<th>High</th>
						</tr>
					</thead>
					<tbody>';
				$lfts = TestType::getTestTypeIdByTestName('LFTS');
				$lft = TestType::find($lfts);
				$measures = TestTypeMeasure::where('test_type_id', $lfts)->orderBy('measure_id', 'DESC')->get();
				$table.='<tr>
						<td>Totals</td>';
		        		foreach ($sex as $gender) {
							$table.='<td>'.$lft->groupedTestCount([$gender], null, $from, $toPlusOne).'</td>';
						}
						$table.='<td>'.$lft->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
						foreach ($ageRanges as $ageRange) {
							$table.='<td>'.$lft->groupedTestCount([Patient::MALE, Patient::FEMALE], $ageRange, $from, $toPlusOne).'</td>';
						}	
					$table.='</tr>';
				foreach ($measures as $measure) {
					$name = Measure::find($measure->measure_id)->name;
					if($name == 'SGOT'){
						$name = 'ASAT (SGOT)';
					}
					if($name == 'ALAT'){
						$name = 'ASAT (SGPT)';
					}
					if($name == 'Total Proteins'){
						$name = 'Serum Protein';
					}
					$tMeasure = Measure::find($measure->measure_id);
					$table.='<tr>
								<td>'.$tMeasure->name.'</td>';
							foreach ($sex as $gender) {
								$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne, null, null).'</td>';
							}
							$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne, null, 1).'</td>';
							foreach ($ranges as $range) {
								$table.='<td>'.$tMeasure->totalTestResults(null, null, $from, $toPlusOne, [$range], 1).'</td>';
							}
							$table.='</tr>';
				}
				$table.='<tr>
							<td>Gamma GT</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th rowspan="2">Lipid Profile</th>
							<th colspan="2">No. Exam</th>
							<th colspan="4"> Number positive</th>
						</tr>
						<tr>
							<th>M</th>
							<th>F</th>
							<th>Total</th>
							<th>Low</th>
							<th>Normal</th>
							<th>High</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Totals</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr><tr>
							<td>Amylase</td>';
							$tMeasure = Measure::find(Measure::getMeasureIdByName('Serum Amylase'));
							foreach ($sex as $gender) {
								$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne, null, null).'</td>';
							}
							$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne, null, 1).'</td>';
							foreach ($ranges as $range) {
								$table.='<td>'.$tMeasure->totalTestResults(null, $ageRange, $from, $toPlusOne, [$range], 1).'</td>';
							}
						$table.='</tr><tr>
							<td>Total cholestrol</td>';
							$tMeasure = Measure::find(Measure::getMeasureIdByName('cholestrol'));
							foreach ($sex as $gender) {
								$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne, null, null).'</td>';
							}
							$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne, null, 1).'</td>';
							foreach ($ranges as $range) {
								$table.='<td>'.$tMeasure->totalTestResults(null, null, $from, $toPlusOne, [$range], 1).'</td>';
							}
						$table.='</tr>
						<tr>
							<td>Trigycerides</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>HDL</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>LDE</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>PSA</td>';
							$tMeasure = Measure::find(Measure::getMeasureIdByName('PSA'));
							foreach ($sex as $gender) {
								$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne, null, null).'</td>';
							}
							$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne, null, 1).'</td>';
							foreach ($ranges as $range) {
								$table.='<td>'.$tMeasure->totalTestResults(null, null, $from, $toPlusOne, [$range], 1).'</td>';
							}
						$table.='</tr>
					</tbody>
				</table>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th rowspan="2">CSF Chemistry</th>
							<th colspan="2">No. Exam</th>
							<th colspan="4"> Number positive</th>
						</tr>
						<tr>
							<th>M</th>
							<th>F</th>
							<th>Total</th>
							<th>Low</th>
							<th>Normal</th>
							<th>High</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Totals</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>';
				$csf = TestType::getTestTypeIdByTestName('CSF for biochemistry');
				$measures = TestTypeMeasure::where('test_type_id', $csf)->orderBy('measure_id', 'DESC')->get();
				foreach ($measures as $measure) {
					$name = Measure::find($measure->measure_id)->name;
					$table.='<tr>
							<td>'.$name.'</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>';
				}
				$table.='</tbody>
				</table>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th rowspan="2">Body Fluids</th>
							<th colspan="2">No. Exam</th>
							<th colspan="4"> Number positive</th>
						</tr>
						<tr>
							<th>M</th>
							<th>F</th>
							<th>Total</th>
							<th>Low</th>
							<th>Normal</th>
							<th>High</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Totals</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>
						<tr>
							<td>Proteins</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Glucose</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Acid phosphatase</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Bence jones protein</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th rowspan="2">Thyroid Function Tests</th>
							<th colspan="2">No. Exam</th>
							<th colspan="4"> Number positive</th>
						</tr>
						<tr>
							<th>M</th>
							<th>F</th>
							<th>Total</th>
							<th>Low</th>
							<th>Normal</th>
							<th>High</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Totals</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
						</tr>';
				$tfts = TestType::getTestTypeIdByTestName('TFT');
				$measures = TestTypeMeasure::where('test_type_id', $tfts)->orderBy('measure_id', 'ASC')->get();
				foreach ($measures as $measure) {
					$tMeasure = Measure::find($measure->measure_id);
					if($tMeasure->name == 'FT3'){
						$name = 'T3';
					}
					if($tMeasure->name == 'FT4'){
						$name = 'T4';
					}
					
					$table.='<tr>
							<td>'.$tMeasure->name.'</td>';
						foreach ($sex as $gender) {
							$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne, null, null).'</td>';
						}
						$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne, null, 1).'</td>';
						foreach ($ranges as $range) {
							$table.='<td>'.$tMeasure->totalTestResults(null, null, $from, $toPlusOne, [$range], 1).'</td>';
						}
						$table.='</tr>';
				}
				$table.='<tr>
							<td>Others</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- URINALYSIS -->
			<!-- PARASITOLOGY -->
			<div class="col-sm-12">
				<strong>PARASITOLOGY</strong>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th colspan="5">Blood Smears</th>
						</tr>
						<tr>
							<th rowspan="2">Malaria</th>
							<th colspan="4">Positive</th>
						</tr>
						<tr>
							<th>Total Done</th>
							<th>&lt;5yrs</th>
							<th>5-14yrs</th>
							<th>&gt;14yrs</th>
						</tr>
					</thead>';
				$bs = TestType::getTestTypeIdByTestName('Bs for mps');
				$bs4mps = TestType::find($bs);
				$table.='<tbody>
						<tr>
							<td></td>
							<td>'.$bs4mps->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
					foreach($measures = TestTypeMeasure::where('test_type_id', $bs)->orderBy('measure_id', 'ASC')->get() as $measure)
					{
						$tMeasure = Measure::find($measure->measure_id);
						foreach ($ageRanges as $ageRange) {
							$table.='<td>'.$tMeasure->totalTestResults(null, $ageRange, $from, $toPlusOne, ['+', '++', '+++', '++++']).'</td>';
						}
					}
					$table.='</tr>
						<tr style="text-align:right;">
							<td>Falciparum</td>
							<td style="background-color: #CCCCCC;"></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr style="text-align:right;">
							<td>Ovale</td>
							<td style="background-color: #CCCCCC;"></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr style="text-align:right;">
							<td>Malariae</td>
							<td style="background-color: #CCCCCC;"></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr style="text-align:right;">
							<td>Vivax</td>
							<td style="background-color: #CCCCCC;"></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><strong>Borrelia</strong></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><strong>Microfilariae</strong></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><strong>Trypanosomes</strong></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="5"><strong>Genital Smears</strong></td>
						</tr>
						<tr>
							<td>Total</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>T. vaginalis</td>
							<td style="background-color: #CCCCCC;"></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>S. haematobium</td>
							<td style="background-color: #CCCCCC;"></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Yeast cells</td>
							<td style="background-color: #CCCCCC;"></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Others</td>
							<td style="background-color: #CCCCCC;"></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="5"><strong>Spleen/bone marrow</strong></td>
						</tr>
						<tr>
							<td>Total</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>L. donovani</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>';
				$stool = TestType::getTestTypeIdByTestName('Stool for O/C');
				$stoolForOc = TestType::find($stool);
				$measures = TestTypeMeasure::where('test_type_id', $stool)->orderBy('measure_id', 'DESC')->get();
				$table.='<td colspan="5"><strong>Stool</strong></td>
						</tr>
						<tr>
							<td>Total</td>
							<td>'.$stoolForOc->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
							foreach ($ageRanges as $ageRange) {
								$table.='<td>'.$stoolForOc->groupedTestCount(null, $ageRange, $from, $toPlusOne).'</td>';
							}
						$table.='</tr>';
						foreach ($measures as $measure) {
							$tMeasure = Measure::find($measure->measure_id);
							foreach ($tMeasure->measureRanges as $range) {
								if($range->alphanumeric=='O#C not seen'){ continue; }
							$table.='<tr>
									<td>'.$range->alphanumeric.'</td>';
								$table.='<td style="background-color: #CCCCCC;"></td>';
								foreach ($ageRanges as $ageRange) {
									$table.='<td>'.$tMeasure->totalTestResults(null, $ageRange, $from, $toPlusOne, [$range->alphanumeric]).'</td>';
								}
								$table.='</tr>';
							}
						}
						$table.='<tr>
							<td colspan="5"><strong>Lavages</strong></td>
						</tr>
						<tr>
							<td>Total</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- PARASITOLOGY -->
			<!-- BACTERIOLOGY -->
			<div class="col-sm-12">
				<strong>BACTERIOLOGY</strong>
				<div class="row">
					<div class="col-sm-4">
						<table class="table table-condensed report-table-border" style="padding-right:5px;">
							<tbody style="text-align:right;">
								<tr>
									<td>Total examinations done</td>
									<td></td>
								</tr>';
						foreach ($specTypeIds as $key) {
							if(in_array(SpecimenType::find($key->spec_id)->name, ['Aspirate', 'Pleural Tap', 'Synovial Fluid', 'Sputum', 'Ascitic Tap', 'Semen', 'Skin'])){
								continue;
							}
							$totalCount = DB::select(DB::raw("select count(specimen_id) as per_spec_count from tests".
															 " join specimens on tests.specimen_id=specimens.id".
															 " join test_types on tests.test_type_id=test_types.id".
															 " where specimens.specimen_type_id=?".
															 " and test_types.test_category_id=?".
															 " and test_status_id in(?,?)".
															 " and tests.time_created BETWEEN ? and ?;"), 
															[$key->spec_id, $labSecId, Test::COMPLETED, Test::VERIFIED, $from, $toPlusOne]);
							$table.='<tr>
									<td>'.SpecimenType::find($key->spec_id)->name.'</td>
									<td>'.$totalCount[0]->per_spec_count.'</td>
								</tr>';
						}
						$table.='</tr>
									<td>Rectal swab</td>
									<td>0</td>
								</tr>
								</tr>
									<td>Water</td>
									<td>0</td>
								</tr>
								</tr>
									<td>Food</td>
									<td>0</td>
								</tr>
								</tr>
									<td>Other (specify)....</td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-sm-8">
						<table class="table table-condensed report-table-border">
							<tbody>
								<tr>
									<td colspan="3">Drugs</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="3">Sensitivity (Total done)</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="3">Resistance per drug</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td rowspan="3">KOH Preparations</td>
									<td>Fungi</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td colspan="2">Others (specify)</td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>...</td>
									<td></td>
								</tr>
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td>...</td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p>SPUTUM</p>
						<table class="table table-condensed report-table-border">
							<tbody>
								<tr>
									<td></td>
									<td>Total</td>
									<td>Positive</td>
								</tr>
								<tr>
									<td>TB new suspects</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Followup</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>TB smears</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>MDR</td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<table class="table table-condensed report-table-border">
					<tbody>
						<tr><td></td>';
					foreach ($specimen_types as $spec) {
						$table.='<td>'.$spec.'</td>';
					}	
					$table.='</tr>';
					foreach ($isolates as $isolate) {
						$table.='<tr>
							<td>'.$isolate.'</td>';
							foreach ($specimen_types as $spec) {
								$table.='<td>'.TestResult::microCounts($isolate,$spec, $from, $toPlusOne)[0]->total.'</td>';
							}
						$table.='</tr>';
					}
					$table.='<tr>
							<td colspan="11">Specify species of each isolate</td>
						</tr>
					</tbody>
				</table>
				<div class="row">
					<div class="col-sm-12">
						<strong>HEMATOLOGY REPORT</strong>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="2">Type of examination</th>
									<th>No. of Tests</th>
									<th>Controls</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="2">Full blood count</td>
									<td>'.TestType::find(TestType::getTestTypeIdByTestName('Full haemogram'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2">Manual WBC counts</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2">Peripheral blood films</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2">Erythrocyte Sedimentation rate</td>
									<td>'.TestType::find(TestType::getTestTypeIdByTestName('ESR'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2">Sickling test</td>
									<td>'.TestType::find(TestType::getTestTypeIdByTestName('Sickling test'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2">HB electrophoresis</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2">G6PD screening</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2">Bleeding time</td>
									<td>'.TestType::find(TestType::getTestTypeIdByTestName('Bleeding time test'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2">Clotting time</td>
									<td>'.TestType::find(TestType::getTestTypeIdByTestName('Clotting time test'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2">Prothrombin test</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2">Partial prothrombin time</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="2">Bone Marrow Aspirates</td>
									<td></td>
									<td style="background-color: #CCCCCC;"></td>
								</tr>
								<tr>
									<td colspan="2">Reticulocyte counts</td>
									<td></td>
									<td style="background-color: #CCCCCC;"></td>
								</tr>
								<tr>
									<td colspan="2">Others</td>
									<td></td>
									<td style="background-color: #CCCCCC;"></td>
								</tr>
								<tr>
									<td rowspan="2">Haemoglobin</td>
									<td>No. Tests</td>
									<td>&lt;5</td>
									<td>5&lt;Hb&lt;10</td>
								</tr>
								<tr>
									<td>'.TestType::find(TestType::getTestTypeIdByTestName('HB'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td rowspan="2">CD4/CD8</td>
									<td>No. Tests</td>
									<td>&lt;200</td>
									<td>200-350</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td rowspan="2">CD4%</td>
									<td>No. Tests</td>
									<td>&lt;25%</td>
									<td>&gt;25%</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td rowspan="2">Peripheral Blood Films</td>
									<td>Parasites</td>
									<td colspan="2">No. smears with inclusions</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td colspan="2"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-sm-12">
						<strong>BLOOD GROUPING AND CROSSMATCH REPORT</strong>
						<div class="row">
							<div class="col-sm-6">
								<table class="table table-condensed report-table-border">
									<tbody>
										<tr>
											<td>Total groupings done</td>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('GXM'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
										</tr>
										<tr>
											<td>Blood units grouped</td>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('Blood Grouping'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
										</tr>
										<tr>
											<td>Total transfusion reactions</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood cross matches</td>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('Cross Match'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-6">
								<strong>Blood safety</strong>
								<table class="table table-condensed report-table-border">
									<tbody>
										<tr>
											<td>Measure</td>
											<td>Number</td>
										</tr>
										<tr>
											<td>A. Blood units collected from regional blood transfusion centres</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood units collected from other centres and screened at health facility</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood units screened at health facility that are HIV positive</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood units screened at health facility that are Hepatitis positive</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood units positive for other infections</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood units transfered</td>
											<td></td>
										</tr>
										<tr>
											<td rowspan="2">General remarks .............................</td>
											<td rowspan="2"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- BACTERIOLOGY -->
			<!-- HISTOLOGY AND CYTOLOGY -->
			<div class="col-sm-12">
				<strong>HISTOLOGY AND CYTOLOGY REPORT</strong>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th rowspan="2"></th>
							<th rowspan="2">Total</th>
							<th rowspan="2">Normal</th>
							<th rowspan="2">Infective</th>
							<th colspan="2">Non-infective</th>
							<th colspan="3">Positive findings</th>
						</tr>
						<tr>
							<th>Benign</th>
							<th>Malignant</th>
							<th>&lt;5 yrs</th>
							<th>5-14 yrs</th>
							<th>&gt;14 yrs</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="9">SMEARS</td>
						</tr>
						<tr>
							<td>Pap Smear</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>Tissue Impressions</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td colspan="9">TISSUE ASPIRATES (FNA)</td>
						</tr>
						<tr>
							<td></td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td colspan="9">FLUID CYTOLOGY</td>
						</tr>
						<tr>
							<td>Ascitic fluid</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>CSF</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>Pleural fluid</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>Others</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="9">TISSUE HISTOLOGY</td>
						</tr>
						<tr>
							<td>Cervix</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>Prostrate</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>Breast</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>Ovarian cyst</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>Fibroids</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>Lymph nodes</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>Others</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<strong>SEROLOGY REPORT</strong>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th rowspan="2">Serological test</th>
							<th colspan="2">Total</th>
							<th colspan="2">&lt;5 yrs</th>
							<th colspan="2">5-14 yrs</th>
							<th colspan="2">&gt;14 yrs</th>
						</tr>
						<tr>
							<th>Tested</th>
							<th>No. +ve</th>
							<th>Tested</th>
							<th>No. +ve</th>
							<th>Tested</th>
							<th>No. +ve</th>
							<th>Tested</th>
							<th>No. +ve</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Rapid Plasma Region</td>';
							if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('VDRL')))==0)
							{
								$table.='<td>0</td>
									<td>0</td>';
							}
							else{
								foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('VDRL')) as $count){
									if(count($count)==0)
										{
											$count->total=0;
											$count->positive=0;
										}
									$table.='<td>'.$count->total.'</td>
									<td>'.$count->positive.'</td>';
								}
							}
							foreach ($ageRanges as $ageRange) {
								if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('VDRL'), $ageRange))==0)
								{
									$table.='<td>0</td>
									<td>0</td>';
								}
								else{
									foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('VDRL'), $ageRange) as $count){
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
								}
							}
							$table.='</tr>
						<tr>
							<td>TPHA</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>ASO Test</td>';
							if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Asot')))==0)
							{
								$table.='<td>0</td>
									<td>0</td>';
							}
							else{
								foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Asot')) as $count){
									if(count($count)==0)
										{
											$count->total=0;
											$count->positive=0;
										}
									$table.='<td>'.$count->total.'</td>
									<td>'.$count->positive.'</td>';
								}
							}
							foreach ($ageRanges as $ageRange) {
								$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Asot'), $ageRange);
								if(count($data)==0)
								{
									$table.='<td>0</td>
									<td>0</td>';
								}
								else{
									foreach($data as $count){
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
								}
							}
							$table.='</tr>
						<tr>
							<td>HIV Test</td>';
							if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Rapid HIV test')))==0)
							{
								$table.='<td>0</td>
									<td>0</td>';
							}
							else{
								foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Rapid HIV test')) as $count){
									if(count($count)==0)
										{
											$count->total=0;
											$count->positive=0;
										}
									$table.='<td>'.$count->total.'</td>
									<td>'.$count->positive.'</td>';
								}
							}
							foreach ($ageRanges as $ageRange) {
								$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Rapid HIV test'), $ageRange);
								if(count($data)==0)
								{
									$table.='<td>0</td>
									<td>0</td>';
								}
								else{
									foreach($data as $count){
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
								}
							}
							$table.='</tr>
						<tr>
							<td>Widal Test</td>';
							if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Widal')))==0)
							{
								$table.='<td>0</td>
									<td>0</td>';
							}
							else{
								foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Widal')) as $count){
									if(count($count)==0)
										{
											$count->total=0;
											$count->positive=0;
										}
									$table.='<td>'.$count->total.'</td>
									<td>'.$count->positive.'</td>';
								}
							}
							foreach ($ageRanges as $ageRange) {
								$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Widal'), $ageRange);
								if(count($data)==0)
								{
									$table.='<td>0</td>
									<td>0</td>';
								}
								else{
									foreach($data as $count){
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
								}
							}
							$table.='</tr>
						<tr>
							<td>Brucella Test</td>';
							if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Brucella')))==0)
							{
								$table.='<td>0</td>
									<td>0</td>';
							}
							else{
								foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Brucella')) as $count){
									if(count($count)==0)
										{
											$count->total=0;
											$count->positive=0;
										}
									$table.='<td>'.$count->total.'</td>
									<td>'.$count->positive.'</td>';
								}
							}
							foreach ($ageRanges as $ageRange) {
								$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Brucella'), $ageRange);
								if(count($data)==0)
								{
									$table.='<td>0</td>
									<td>0</td>';
								}
								else{
									foreach($data as $count){
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
								}
							}
							$table.='</tr>
						<tr>
							<td>Rheumatoid Factor Tests</td>';
							if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('RF')))==0)
							{
								$table.='<td>0</td>
									<td>0</td>';
							}
							else{
								foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('RF')) as $count){
									if(count($count)==0)
										{
											$count->total=0;
											$count->positive=0;
										}
									$table.='<td>'.$count->total.'</td>
									<td>'.$count->positive.'</td>';
								}
							}
							foreach ($ageRanges as $ageRange) {
								$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('RF'), $ageRange);
								if(count($data)==0)
								{
									$table.='<td>0</td>
									<td>0</td>';
								}
								else{
									foreach($data as $count){
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
								}
							}
							$table.='</tr>
						<tr>
							<td>Cryptococcal Antigen</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Helicobacter pylori test</td>';
							if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('H pylori')))==0)
							{
								$table.='<td>0</td>
									<td>0</td>';
							}
							else{
								foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('H pylori')) as $count){
									if(count($count)==0)
										{
											$count->total=0;
											$count->positive=0;
										}
									$table.='<td>'.$count->total.'</td>
									<td>'.$count->positive.'</td>';
								}
							}
							foreach ($ageRanges as $ageRange) {
								$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('H pylori'), $ageRange);
								if(count($data)==0)
								{
									$table.='<td>0</td>
									<td>0</td>';
								}
								else{
									foreach($data as $count){
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
								}
							}
							$table.='</tr>
						<tr>
							<td>Hepatitis A test</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>';
							$table.='</tr>
						<tr>
							<td>Hepatitis B test</td>';
							if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Hepatitis B')))==0)
							{
								$table.='<td>0</td>
									<td>0</td>';
							}
							else{
								foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Hepatitis B')) as $count){
									if(count($count)==0)
										{
											$count->total=0;
											$count->positive=0;
										}
									$table.='<td>'.$count->total.'</td>
									<td>'.$count->positive.'</td>';
								}
							}
							foreach ($ageRanges as $ageRange) {
								$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Hepatitis B'), $ageRange);
								if(count($data)==0)
								{
									$table.='<td>0</td>
									<td>0</td>';
								}
								else{
									foreach($data as $count){
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
								}
							}
							$table.='</tr>
						<tr>
							<td>Hepatitis C test</td>';
							if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Hepatitis C')))==0)
							{
								$table.='<td>0</td>
									<td>0</td>';
							}
							else{
								foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Hepatitis C')) as $count){
									if(count($count)==0)
										{
											$count->total=0;
											$count->positive=0;
										}
									$table.='<td>'.$count->total.'</td>
									<td>'.$count->positive.'</td>';
								}
							}
							foreach ($ageRanges as $ageRange) {
								$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Hepatitis C'), $ageRange);
								if(count($data)==0)
								{
									$table.='<td>0</td>
									<td>0</td>';
								}
								else{
									foreach($data as $count){
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
								}
							}
							$table.='</tr>
						<tr>
							<td>Viral Load</td>';
							if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Viral load')))==0)
							{
								$table.='<td>0</td>
									<td style="background-color: #CCCCCC;"></td>';
							}
							else{
								foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Viral load')) as $count){
									if(count($count)==0)
										{
											$count->total=0;
											$count->positive=0;
										}
									$table.='<td>'.$count->total.'</td>
									<td style="background-color: #CCCCCC;"></td>';
								}
							}
							foreach ($ageRanges as $ageRange) {
								$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Viral load'), $ageRange);
								if(count($data)==0)
								{
									$table.='<td>0</td>
									<td style="background-color: #CCCCCC;"></td>';
								}
								else{
									foreach($data as $count){
										$table.='<td>'.$count->total.'</td>
										<td style="background-color: #CCCCCC;"></td>';
									}
								}
							}
							$table.='</tr>
						<tr>
							<td>Formal Gel Test</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
							<td>N/S</td>
						</tr>
						<tr>
							<td>Other Tests</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<br />
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th>Dried Blood Spots</th>
							<th>Tested</th>
							<th># +ve</th>
							<th>Discrepant</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Early Infant Diagnosis of HIV</td>';
							if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('eid of hiv')))==0)
							{
								$table.='<td>0</td>
									<td>0</td>';
							}
							else{
								foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('eid of hiv')) as $count){
									if(count($count)==0)
										{
											$count->total=0;
											$count->positive=0;
										}
									$table.='<td>'.$count->total.'</td>
									<td>'.$count->positive.'</td>';
								}
							}
							$table.='<td></td>
						</tr>
						<tr>
							<td>Quality Assurance</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Discordant couples</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Others</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<p><strong>Specimen referral to higher levels</strong></p>
				<table class="table table-condensed report-table-border">
					<thead>
						<tr>
							<th>Specimen</th>
							<th>No</th>
							<th>Sent to</th>
							<th>No. of Reports/results received</th>
						</tr>
					</thead>
					<tbody>';
				if($referredSpecimens){
					foreach ($referredSpecimens as $referredSpecimen) {
						$table.='<tr>
								<td>'.$referredSpecimen->spec.'</td>
								<td>'.$referredSpecimen->tot.'</td>
								<td>'.$referredSpecimen->facility.'</td>
								<td></td>
							</tr>';
					}
				}else{
					$table.='<tr>
								<td colspan="4">'.trans('messages.no-records-found').'</td>
							</tr>';
				}
				$table.='</tbody>
				</table>
			</div>
			<!-- HISTOLOGY AND CYTOLOGY -->';
		if(Input::has('excel')){
			$date = date("Ymdhi");
			$fileName = "MOH706_".$date.".xls";
			$headers = array(
			    "Content-type"=>"text/html",
			    "Content-Disposition"=>"attachment;Filename=".$fileName
			);
			$content = $table;
	    	return Response::make($content,200, $headers);
		}
		else{
			//return View::make('reports.moh.706');
			return View::make('reports.moh.index')->with('table', $table)->with('from', $from)->with('end', $end);
		}
	}
	/**
	 * Manage Diseases reported on
	 * @param
	 */
	public function disease(){
		if (Input::all()) {
			$rules = array();
			$newDiseases = Input::get('new-diseases');

			if (Input::get('new-diseases')) {
				// create an array that form the rules array
				foreach ($newDiseases as $key => $value) {
					
					//Ensure no duplicate disease
					$rules['new-diseases.'.$key.'.disease'] = 'unique:diseases,name';
				}
			}

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails()) {
				return Redirect::route('reportconfig.disease')->withErrors($validator);
			} else {

		        $allDiseaseIds = array();
				
				//edit or leave disease entries as is
				if (Input::get('diseases')) {
					$diseases = Input::get('diseases');

					foreach ($diseases as $id => $disease) {
		                $allDiseaseIds[] = $id;
						$diseases = Disease::find($id);
						$diseases->name = $disease['disease'];
						$diseases->save();
					}
				}
				
				//save new disease entries
				if (Input::get('new-diseases')) {
					$diseases = Input::get('new-diseases');

					foreach ($diseases as $id => $disease) {
						$diseases = new Disease;
						$diseases->name = $disease['disease'];
						$diseases->save();
		                $allDiseaseIds[] = $diseases->id;
					}
				}

		        //check if action is from a form submission
		        if (Input::get('from-form')) {
			     	// Delete any pre-existing disease entries
			     	//that were not captured in any of the above save loops
			        $allDiseases = Disease::all(array('id'));

			        $deleteDiseases = array();

			        //Identify disease entries to be deleted by Ids
			        foreach ($allDiseases as $key => $value) {
			            if (!in_array($value->id, $allDiseaseIds)) {

							//Allow delete if not in use
							$inUseByReports = Disease::find($value->id)->reportDiseases->toArray();
							if (empty($inUseByReports)) {
							    
							    // The disease is not in use
			                	$deleteDiseases[] = $value->id;
							}
			            }
			        }
			        //Delete disease entry if any
			        if(count($deleteDiseases)>0){

			        	Disease::destroy($deleteDiseases);
			        }
		        }
			}
		}
		$diseases = Disease::all();

		return View::make('reportconfig.disease')
					->with('diseases', $diseases);
	}

	public function stockLevel(){
		
		//	Fetch form filters
		$date = date('Y-m-d');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');

		$to = Input::get('end');
		if(!$to) $to = $date;
		
		$reportTypes = array('Monthly', 'Quarterly');
		

		$selectedReport = Input::get('report_type');	
		if(!$selectedReport)$selectedReport = 0;

		switch ($selectedReport) {
			case '0':
			
				$reportData = Receipt::getIssuedCommodities($from, $to.' 23:59:59');
				$reportTitle = Lang::choice('messages.monthly-stock-level-report-title',1);
				break;
			case '1':
				$reportData = Receipt::getIssuedCommodities($from, $to.' 23:59:59');
				$reportTitle = Lang::choice('messages.quarterly-stock-level-report-title',1);
				break;
				default:
				$reportData = Receipt::getIssuedCommodities($from, $to.' 23:59:59');
				$reportTitle = Lang::choice('messages.monthly-stock-level-report-title',1);
				break;
		}

		$reportTitle = str_replace("[FROM]", $from, $reportTitle);
		$reportTitle = str_replace("[TO]", $to, $reportTitle);
		
		return View::make('reports.inventory.index')
					->with('reportTypes', $reportTypes)
					->with('reportData', $reportData)
					->with('reportTitle', $reportTitle)
					->with('selectedReport', $selectedReport)
					->withInput(Input::all());
	}
	/**
	* Function to calculate the mean, SD, and UCL, LCL
	* for a given control measure.
	*
	* @param control_measure_id
	* @return json string
	* 
	*/
	public function leveyJennings($control, $dates)
	{
		foreach ($control->controlMeasures as $key => $controlMeasure) {
			if(!$controlMeasure->isNumeric())
			{
				//We ignore non-numeric results
				continue;
			}

			$results = $controlMeasure->results()->whereBetween('created_at', $dates)->lists('results');

			$count = count($results);

			if($count < 6)
			{
				$response[] = array('success' => false,
					'error' => "Too few results to create LJ for ".$controlMeasure->name);
				continue;
			}

			//Convert string results to float 
			foreach ($results as &$result) {
				$result = (double) $result;
			}

			$total = 0;
			foreach ($results as $res) {
				$total += $res;
			}

			$average = round($total / $count, 2);

			$standardDeviation = $this->stat_standard_deviation($results);
			$standardDeviation  = round($standardDeviation, 2);

			$response[] = array('success' => true,
							'total' => $total,
							'average' => $average,
							'standardDeviation' => $standardDeviation,
							'plusonesd' => $average + $standardDeviation,
							'plustwosd' => $average + ($standardDeviation * 2),
							'plusthreesd' => $average + ($standardDeviation * 3),
							'minusonesd' => $average - ($standardDeviation),
							'minustwosd' => $average - ($standardDeviation * 2),
							'minusthreesd' => $average - ($standardDeviation * 3),
							'dates' => $controlMeasure->results()->lists('created_at'),
							'controlName' => $controlMeasure->name,
							'controlUnit' => $controlMeasure->unit,
							'results' => $results);
		}
		return json_encode($response);
	}

    /**
     * This user-land implementation follows the implementation quite strictly;
     * it does not attempt to improve the code or algorithm in any way. It will
     * raise a warning if you have fewer than 2 values in your array, just like
     * the extension does (although as an E_USER_WARNING, not E_WARNING).
     * 
     * @param array $a 
     * @param bool $sample [optional] Defaults to false
     * @return float|bool The standard deviation or false on error.
     */
    function stat_standard_deviation(array $a, $sample = false) {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has zero elements", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((double) $val) - $mean;
            $carry += $d * $d;
        };
        if ($sample) {
           --$n;
        }
        return sqrt($carry / $n);
    }

	/**
	 * Display data after applying the filters on the report uses patient ID
	 *
	 * @return Response
	 */
	public function cd4(){
		//	check if accredited
		$accredited = array();
		$from = Input::get('start');
		$to = Input::get('end');
		$pending = Input::get('pending');
		$date = date('Y-m-d');
		$error = '';
		//	Check dates
		if(!$from)
			$from = date('Y-m-01');
		if(!$to)
			$to = $date;
		//	Get columns
		$columns = array(Lang::choice('messages.cd4-less', 1), Lang::choice('messages.cd4-greater', 1));
		$rows = array(Lang::choice('messages.baseline', 1), Lang::choice('messages.follow-up', 1));
		//	Get test
		$test = TestType::find(TestType::getTestTypeIdByTestName('cd4'));
		$counts = array();
		foreach ($columns as $column)
		{
			foreach ($rows as $row)
			{
				$counts[$column][$row] = $test->cd4($from, $to, $column, $row);
			}
		}
		
		return View::make('reports.cd4.index')
					->with('columns', $columns)
					->with('rows', $rows)
					->with('accredited', $accredited)
					->with('test', $test)
					->with('counts', $counts)
					->withInput(Input::all());
	}

	public function departments_summary()
	{
				$date = date('Y-m-d');
		$start_date = Input::get('start', $date);
		$end_date = Input::get('end', $date);
		$lab_section_id = Input::get('lab_section', 'All');

		$start    = (new DateTime($start_date))->modify('first day of this month');
		$end      = (new DateTime($end_date))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);

		$category_names = array();
		$category_names['All'] = 'All';
		$categories;
		if($lab_section_id == 'All')
		{
			$categories = TestCategory::orderBy('name')->get();
		}
		else
		{
			$categories = TestCategory::find($lab_section_id);
		}
	
		$select_categories = TestCategory::orderBy('name')->get();
		foreach($select_categories as $cat)
		{
			if(strtoupper($cat->name) != 'LAB RECEPTION')
			{
				$category_names[$cat->id] = $cat->name;
			}
		}

		$data = array();
		foreach ($categories as $category) 
		{
			$category_name;
			$test_category_id;
			if(count($categories) == 1)
			{
				$category_name = $categories->name;
				$test_category_id = $categories->id;
				$category = $categories;
			}
			else
			{
				$category_name = $category->name;
				$test_category_id = $category->id;
			}	

			foreach ($category->testTypes as $test_type) 
			{
				$test_type_name = $test_type->name;
				$test_type_id = $test_type->id;

				$count = 1;
				$ranges = count(iterator_to_array($period, false));
				
	            foreach ($period as $dt) 
	            {
	            	$number = 0;
    				$month_name = $dt->format('M');
    				$first_date = ($count == 1)?$start_date:$dt->format('Y-m-d');
					$last_date = ($count == $ranges)?$end_date:$a_date = date("Y-m-t", strtotime($dt->format('Y-m-d')));

    				$dt = $dt->format('Y-m');
    				$query = "SELECT count(*) as tests_per_month FROM tests join test_types on tests.test_type_id = test_types.id WHERE test_type_id = '$test_type_id' AND test_category_id = '$test_category_id' AND tests.time_created BETWEEN '$first_date' AND '$last_date' AND tests.test_status_id = (SELECT id FROM test_statuses WHERE name = 'verified') GROUP BY test_types.id;";
    				
    				$test_per_month = DB::select(DB::raw($query)); 
    				if(count($test_per_month) > 0)
    				{ 
    					$number = $test_per_month[0]->tests_per_month;
    				}
	            	$data[$category_name][$test_type_name][$dt] = $number;

	            	$count++;
				}
            }
        }

        $view_url = "reports.departments.bymonth";

        if(Input::has('pdf'))
        {
        	if(!Input::has('page'))
        	{
				$url = Request::url()."?pdf=true&page=true&start=$start_date&end=$end_date";

				$fileName = "labstatreport_".$date.".pdf";
				$printer = Input::get("printer_name");

				$process = new Process("xvfb-run -a wkhtmltopdf -s A4 -B 0mm -T 2mm -L 2mm -R 2mm  '$url'  $fileName");
				$process->run();

				$process = new Process("lp -d $printer $fileName");
				$process->run();

				//$process = new Process("rm $fileName && rm labstatreport*.pdf");
				//$process->run();
			}
			else
			{
				$view_url = "reports.departments.exportbymonth";
			}

		}


        return View::make($view_url)
        	->with('data', $data)
        	->with('categories', $categories)
        	->with('category', $category)
        	->with('category_names', $category_names)
        	->with('period', $period)
        	->with('available_printers', Config::get('kblis.A4_printers'))
        	->withInput(Input::except('pdf', 'printer_name'));

	}


	public function department_report()
	{


		$default_lab_section = TestCategory::select('id')->orderBy('name')->first();
		$default_lab_section_id = $default_lab_section->id;
		$lab_section_id = Input::get('lab_section', $default_lab_section_id);

		$date = date('Y-m-d');
		$start_date = Input::get('start', $date);
		$end_date = Input::get('end', $date);


		$product_wards = array();
		$product_ranges = array();
		$product_age_ranges = array();
		$product_data = array();

		//get blood products
		if($lab_section_id == TestCategory::getTestCatIdByName('Blood Bank'))
		{
			$blood_products = $this->getBloodProductTypes($start_date, $end_date);
			$product_wards = $blood_products['wards'];
			$product_ranges = $blood_products['ranges'];
			$product_age_ranges = $blood_products['age_ranges'];
			$product_data = $blood_products['data'];
		}

		//get critical values
		$critical_with_wards = $this->critical_values($lab_section_id, $start_date, $end_date);
		$critical_values = $critical_with_wards['critical_values'];
		$critical_measures = $critical_with_wards['critical_measures'];
		$critical_wards = $critical_with_wards['wards'];


		$start    = (new DateTime($start_date))->modify('first day of this month');
		$end      = (new DateTime($end_date))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);
		
		$data = array();
		$category = TestCategory::find($lab_section_id);
		$test_category_id = $category->id;

		$category_names = array();
		$categories = TestCategory::orderBy('name')->get();
		foreach($categories as $cat)
		{
			$category_names[$cat->id] = $cat->name;
		}

		$wards = array();
		$query_wards = "SELECT DISTINCT(ward_or_location) as ward, visits.visit_type as visit_type FROM visits join tests	ON visits.id = tests.visit_id join test_types on test_types.id = tests.test_type_id WHERE test_types.test_category_id = '$test_category_id' AND tests.time_created BETWEEN '$start_date' AND '$end_date' AND tests.test_status_id = (SELECT id FROM test_statuses WHERE name = 'verified');";
		$distinct_wards = DB::select(DB::raw($query_wards));
	
		//$distinct_wards = DB::select(DB::raw("SELECT name FROM wards;"));

		foreach ($distinct_wards as $ward) 
		{
			//$location = $ward->name;
			$location = $ward->ward;
			$visit_type = $ward->visit_type;
			 if($visit_type == 'Referral')
			 {
			 	$location = 'Referral';
			 }

			array_push($wards, $location);
		}


		$test_types = $category->testTypes;
		foreach ($test_types as $test_type) 
		{
			$test_type_name = $test_type->name;
			$test_type_id = $test_type->id;
			$test_ids = array();
            
            $counter = 1;
			$ranges = count(iterator_to_array($period, false));
			foreach ($period as $dt) 
        	{
        	
            	$month_name = $dt->format('M');
            	$first_date = ($counter == 1)?$start_date:$dt->format('Y-m-d');
				$last_date = ($counter == $ranges)?$end_date: date("Y-m-t", strtotime($dt->format('Y-m-d')));

			

            	$number_of_tests = 0;

            	foreach($wards as $ward)
            	{
            		if($ward != 'Referral')
            		{
						$query = "SELECT tests.id as test_id, visits.ward_or_location as ward, visits.visit_type as visit_type FROM tests join test_types on tests.test_type_id = test_types.id join visits on tests.visit_id = visits.id WHERE tests.test_type_id = '$test_type_id' AND test_types.test_category_id = '$test_category_id' AND tests.time_created BETWEEN '$first_date' AND '$last_date' AND visits.ward_or_location = '$ward' AND tests.test_status_id = (SELECT id FROM test_statuses WHERE name = 'verified');";
					}
					else
					{
						$query = "SELECT tests.id as test_id, visits.ward_or_location as ward, visits.visit_type as visit_type FROM tests join test_types on tests.test_type_id = test_types.id join visits on tests.visit_id = visits.id WHERE tests.test_type_id = '$test_type_id' AND test_types.test_category_id = '$test_category_id' AND tests.time_created BETWEEN '$first_date' AND '$last_date' AND visits.visit_type = '$ward' AND tests.test_status_id = (SELECT id FROM test_statuses WHERE name = 'verified');";	
					}
					$test_per_ward = DB::select(DB::raw($query)); 
					
					$count = count($test_per_ward);
	            	$data[$test_type_name][$month_name][$ward] = $count;
	            	
        		}
        		$counter++;
			}
		
		}



		$view_url = "reports.departments.byward";

		if(Input::has('pdf'))
        {
        	if(!Input::has('page'))
        	{
				$url = Request::url()."?pdf=true&page=true&lab_section=$lab_section_id";

				$fileName = "departmentreport_".$date.".pdf";
				$printer = Input::get("printer_name");


				$process = new Process("xvfb-run -a wkhtmltopdf -s A4 -B 0mm -T 2mm -L 2mm -R 2mm  '$url'  $fileName");
				$process->run();

				$process = new Process("lp -d $printer $fileName");
				$process->run();

				$process = new Process("rm $fileName && rm departmentreport*.pdf");
				$process->run();
			}
			else
			{
				$view_url = "reports.departments.exportbyward";
			}
		}

        return View::make($view_url)
        	->with('data', $data)
        	->with('category', $category)
        	->with('category_names', $category_names)
        	->with('period', $period)
        	->with('wards', $wards)
        	->with('product_wards', $product_wards)
        	->with('product_ranges', $product_ranges)
        	->with('product_age_ranges', $product_age_ranges)
        	->with('product_data', $product_data)
        	->with('critical_wards', $critical_wards)
        	->with('critical_measures', $critical_measures)
        	->with('critical_values', $critical_values)
        	->with('available_printers', Config::get('kblis.A4_printers'))
        	->withInput(Input::all());
	}

	public function tb_report()
	{
		$date = date('Y-m-d');
		$year = date('Y');

		$lab_section_id = TestCategory::where('name', 'Microbiology')->first()->id;

		$start_date = Input::get('start', $date);
		$end_date = Input::get('end', $date);

		$start    = (new DateTime($start_date))->modify('first day of this month');
		$end      = (new DateTime($end_date))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);

		$data = array();
		$result_names = array();

		$test_type = TestType::where('name', '=', 'TB Tests')->first();
		$measures = $test_type->measures;

		$results_per_measure = array();

		foreach($measures as $measure)
		{
			$measure_name = $measure->name;
			$measure_results = array();
			//count for each month

			$count = 1;
			$ranges = count(iterator_to_array($period, false));

			foreach($period as $dt)
			{
				$month_name = $dt->format('F');

				$first_date = ($count === 1)?$start_date:$dt->format('Y-m-d');
				$last_date = ($count == $ranges)?$end_date:$a_date = date("Y-m-t", strtotime($dt->format('Y-m-d')));

				$query = "SELECT count(*) as count, test_results.result as result_name FROM tests JOIN test_results ON tests.id = test_results.test_id JOIN measures  ON test_results.measure_id = measures.id WHERE tests.test_type_id = (SELECT id FROM test_types WHERE name = 'TB Tests') AND tests.test_status_id = (SELECT id FROM test_statuses WHERE name = 'verified') AND tests.time_created BETWEEN '$first_date' AND '$last_date' AND measures.name = '$measure_name' GROUP BY result;";

				$results = DB::select(DB::raw($query));
				foreach($results as $result)
				{
			
					$data[$measure_name][$month_name][$result->result_name] = $result->count;	
					
					if(!in_array($result->result_name, $result_names))
					{
						array_push($result_names, $result->result_name);
					}

					if(!in_array($result->result_name, $measure_results))
					{
						array_push($measure_results, $result->result_name);
					}
				}

				$count++;
			}
			$results_per_measure[$measure_name] = $measure_results;

		}

		$view_url = "reports.tb.index";
		if(Input::has('pdf'))
        {

			if(!Input::has('page'))
        	{

				$url = Request::url()."?pdf=true&page=true&year=$year&lab_section=$lab_section_id&start=$start_date&end=$end_date";

				$fileName = "tbreport_".$date.".pdf";
				$printer = Input::get("printer_name");


				$process = new Process("xvfb-run -a wkhtmltopdf -s A4 -B 0mm -T 2mm -L 2mm -R 2mm  '$url'  $fileName");
				$process->run();

				$process = new Process("lp -d $printer $fileName");
				$process->run();

				$process = new Process("rm $fileName && rm tbreport*.pdf");
				$process->run();
			}
			else
			{
				$view_url = "reports.tb.export";
			}
		}
		

		return View::make($view_url)
        	->with('data', $data)
        	->with('measures', $measures)
        	->with('measure_results', $results_per_measure)
        	->with('result_names', $result_names)
			->with('available_printers', Config::get('kblis.A4_printers'))
        	->with('period', $period)
        	->withInput(Input::all());
	}

	public function rejected_specimens()
	{
		$date = date('Y-m-d');
		$default_test_type_id = TestType::select('id')->orderBy('name')->first()->id;
		$default_lab_section_id = TestCategory::select('id')->orderBy('name')->first()->id;

		$test_type_id = Input::get('test_type', $default_test_type_id);
		$category_id = Input::get('lab_section', $default_lab_section_id);

		$lab_section_name = TestCategory::find($category_id)->name;
		$test_type_name = TestType::find($test_type_id)->name;
		

		$startdate = Input::get('start', date('Y-m-d'));
		$enddate = Input::get('end', date('Y-m-d'));

		$sections = TestCategory::orderBy('name')->get();
		$categories  = array();
		foreach($sections as $cat)
		{
			$categories[$cat->id] = $cat->name;
		}
	
		$test_type_objs = TestType::orderBy('name')->get();
		$test_type_names = array();
		foreach($test_type_objs as $test_type_obj)
		{
			$test_type_names[$test_type_obj->id] = $test_type_obj->name;
		}

		$rejected_counts = array();
		$wards = array();
		$test_types = array();
		$checked = array();
		$reasons = array();
		
		//get all rejected specimen of a category
		$query = "SELECT specimens.* FROM specimens JOIN tests ON specimens.id = tests.specimen_id JOIN test_types ON tests.test_type_id = test_types.id JOIN test_categories ON test_types.test_category_id = test_categories.id WHERE test_categories.id = '$category_id' AND specimens.time_rejected IS NOT NULL AND tests.time_created	BETWEEN '$startdate' AND '$enddate';";

		$rejected_specimens = DB::select(DB::raw($query));
		foreach ($rejected_specimens as $rejected_specimen) 
		{
  
         	$test = Specimen::find($rejected_specimen->id)->test;
         	$test_type_name = $test->testType->name;
         	$ward = $test->visit->ward_or_location;


       		$reason_name = RejectionReason::find($rejected_specimen->rejection_reason_id)->reason;

     		if(!in_array($rejected_specimen->id, $checked))
     		{
         		if(!isset($rejected_counts[$reason_name][$ward][$test_type_name]))
         		{
         			$rejected_counts[$reason_name][$ward][$test_type_name] = 1;
         			array_push($wards, $ward);
         			array_push($reasons, $reason_name);
         			array_push($test_types, $test_type_name);
         		}
         		else
         		{
         			$rejected_counts[$reason_name][$ward][$test_type_name] += 1;
         			array_push($wards, $ward);
         			array_push($reasons, $reason_name);
         			array_push($test_types, $test_type_name);
         		}
     		}
     		array_push($checked, $rejected_specimen->id);
		}
		$wards = array_unique($wards);

		$reasons = array_unique($reasons);
		$test_types = array_unique($test_types);



		$view_url = "reports.rejected.index";

		if(Input::has('pdf'))
        {
        	if(!Input::has('page'))
        	{
				$url = Request::url()."?pdf=true&page=true";

				$fileName = "rejectedsamples_".$date.".pdf";
				$printer = Input::get("printer_name");


				$process = new Process("xvfb-run -a wkhtmltopdf -s A4 -B 0mm -T 2mm -L 2mm -R 2mm  '$url'  $fileName");
				$process->run();

				$process = new Process("lp -d $printer $fileName");
				$process->run();

				$process = new Process("rm $fileName && rm rejectedsamples*.pdf");
				$process->run();
			}
			else
			{
				$view_url = "reports.rejected.export";
			}
		}


		return View::make($view_url)
			->with( 'rejected_specimens', $rejected_counts)
			->with('rejected_wards', $wards)
			->with('rejection_reasons', $reasons)
			->with('test_types', $test_types)
			->with('categories', $categories)
			->with('category', $lab_section_name)
			->with('test_type_names', $test_type_names)
			->with('test_type_name', $test_type_name)
			->withInput(Input::all())
			->with('available_printers', Config::get('kblis.A4_printers'));
	}


	public function critical_values($category_id, $start_date, $end_date)
	{
		$critical_values = array();
		$critical_measures = array();
		$critical_wards = array();

		//get all test results of a category
		$query = "SELECT test_results.* FROM test_results JOIN tests ON test_results.test_id = tests.id JOIN test_types ON tests.test_type_id = test_types.id JOIN test_categories ON test_types.test_category_id = test_categories.id WHERE test_categories.id = '$category_id' AND tests.time_created BETWEEN '$start_date' AND '$end_date';";

		$results = DB::select(DB::raw($query));

		foreach($results as $result)
		{
			$measure_id = $result->measure_id;
			
			$measure = Measure::find($measure_id);
			if($measure->isNumeric())
			{
				$test = Test::find($result->test_id);
				if($test)
				{
					$test_result = $result->result;
					$ward = $test->visit->ward_or_location;
					$patient = $test->visit->patient;


					$range_string = $measure->getRange($patient, $measure->id);
					$position = strpos($range_string, '-');
					$lower_limit = substr($range_string, 1, ($position - 2));
					$upper_limit = substr($range_string, ($position + 2));
					$upper_limit = substr($upper_limit, 0, strlen($upper_limit) - 1);

					list($numeric, $alpha) = sscanf($test_result, "%[0-9]%[A-Za-z]");
					if(is_numeric($numeric))
					{
						if($numeric < $lower_limit)
						{
							if(isset($critical_values[$measure->name][$ward]['low']))
							{
								$critical_values[$measure->name][$ward]['low'] += 1;
								if(!isset($critical_values[$measure->name][$ward]['high']))
								{
									$critical_values[$measure->name][$ward]['high'] = 0;
								}
							}
							else
							{
								$critical_values[$measure->name][$ward]['low'] = 1;
								if(!isset($critical_values[$measure->name][$ward]['high']))
								{
									$critical_values[$measure->name][$ward]['high'] = 0;
								}
								if(!in_array($ward, $critical_wards))
								{
									array_push($critical_wards, $ward);
								}
								if(!in_array($measure->name, $critical_measures))
								{
									array_push($critical_measures, $measure->name);
								}
							}
						}
						elseif($numeric > $upper_limit)
						{
							if(isset($critical_values[$measure->name][$ward]['high']))
							{
								$critical_values[$measure->name][$ward]['high'] += 1;
								if(!isset($critical_values[$measure->name][$ward]['low']))
								{
									$critical_values[$measure->name][$ward]['low'] = 0;
								}
								
							}
							else
							{
								$critical_values[$measure->name][$ward]['high'] = 1;
								if(!isset($critical_values[$measure->name][$ward]['low']))
								{
									$critical_values[$measure->name][$ward]['low'] = 0;
								}
								if(!in_array($ward, $critical_wards))
								{
									array_push($critical_wards, $ward);
								}
								if(!in_array($measure->name, $critical_measures))
								{
									array_push($critical_measures, $measure->name);
								}
							}
						}
					}
				}
			}

		}
		return ['critical_values' => $critical_values, 'critical_measures' => $critical_measures, 'wards' =>$critical_wards];	
	}

	

	 
  	

  	public function getBloodProductTypes($start_date, $end_date)
  	{
  		$date = date('Y-m-d');
  		$data = array();
  		$cross_match_test = TestType::find(TestType::getTestTypeIdByTestName('Cross-Match'));
  		$measure = Measure::find(Measure::getMeasureIdByName('Product Type'));
  		$ranges = $measure->measureRanges;
  		$wards =array();
  		$ageRanges = array('0-5'=>'Under 5 years', 
	 					'6-14'=>'5 years and over but under 14 years', 
	 					'15-120'=>'14 years and above');
  		foreach($ranges as $range)
  		{
  			$result = $range->alphanumeric;
  			foreach($ageRanges as $key => $value)
  			{
  				$limits = explode('-', $key);
  				$lower = $limits[0];
  				$upper = $limits[1];

	  			$query = "SELECT test_results.result AS result, patients.gender as gender, visits.ward_or_location as ward FROM test_results JOIN tests ON test_results.test_id = tests.id JOIN visits ON tests.visit_id = visits.id JOIN patients ON visits.patient_id = patients.id WHERE tests.test_status_id = (SELECT id FROM test_statuses WHERE name = 'verified') AND tests.time_created BETWEEN '$start_date' AND '$end_date' AND test_results.result = '$result' AND YEAR('$date') - YEAR(patients.dob) BETWEEN '$lower' AND '$upper';";


	  			$range_results = DB::select(DB::raw($query));

	  			foreach($range_results as $range_result)
	  			{
	  				$ward = $range_result->ward;
	  				if(!in_array($ward, $wards))
	  				{
	  					array_push($wards, $ward);
	  				}
	  				$gender = $range_result->gender;
	  				if($gender)
	  				{
	  					$gender = 'FEMALE';
	  				}
	  				else
	  				{
	  					$gender = 'MALE';
	  				}

	  				if(isset($data[$result][$ward][$gender][$key]))
	  				{
	  					$data[$result][$ward][$gender][$key] += 1;
	  				}
	  				else
	  				{
	  					$data[$result][$ward][$gender][$key] = 1;
	  				}
	  			}
  			}
  	
  		}

  		return array('data' => $data, 'wards' => $wards, 'ranges' => $ranges, 'age_ranges' => $ageRanges);

  	}


  	public function getTat()
  	{
  		$data = array();
  		//parameters
  		$test_category_id = Input::get('lab_section', TestCategory::orderBy('name')->first()->id);
  		$start_date = Input::get('start', date('Y-m-d'));
  		$end_date = Input::get('end', date('Y-m-d'));
  		$time_format = Input::get('time_format', 'hours');

  		$category = TestCategory::find($test_category_id);
  		$categories = TestCategory::orderBy('name')->get();
  		$category_name = array();
  		$test_types = TestCategory::find($test_category_id)->testTypes;
  		$test_type_list = TestCategory::find($test_category_id)->testTypes->lists('name');
  		$time_formats = ['minutes' => 'minutes', 'hours' => 'hours', 'days' => 'days', 'weeks' =>'weeks'];



  		foreach($categories as $cat)
  		{
  			$category_names[$cat->id] = $cat->name;
  		}

  		foreach($test_types as $test_type)
  		{
  			$tat = 0;
  			$count = 0;
  			$avgtat = 0;
  			$tests = Test::where('test_type_id', '=', $test_type->id)
  							->where('test_status_id', '=', Test::VERIFIED)
  							->whereBetween('time_created', array($start_date, $end_date))
  							->get();
  			$targetTAT = $test_type->targetTAT;
  			$targetTAT = $test_type->formatTime($targetTAT, $time_format);
			if(is_numeric($targetTAT[0]))
			{
  			$targetTAT = number_format($targetTAT[0], 3, '.', '');
			}
			else
			{
			$targetTAT = 0;
			}

  			foreach($tests as $test)
  			{
  				$turnaroundtime = $test->getTurnaroundTime();
  				$tat += $turnaroundtime;
  				$count++;
  			}

  			if($count != 0)
  			{

  				$avgtat = ceil($tat/$count);
  				$avgtat = ceil($avgtat/(60*60));
  			}
  			$avgtat .= ' hrs';
  			$avgtat = $test_type->formatTime($avgtat, $time_format);

			

  			$avgtat = number_format($avgtat[0], 3, '.', '');

  			$data[$test_type->name] = array('tat' => $avgtat, 'target' => $targetTAT);	
  			
  			 
  		}
		
		$view_url = "reports.departments.turnaroundtime";

		if(Input::has('pdf'))
        {
        	if(!Input::has('page'))
        	{
				$url = Request::url()."?pdf=true&page=true";

				$fileName = "turnaroundtime_".$date.".pdf";
				$printer = Input::get("printer_name");


				$process = new Process("xvfb-run -a wkhtmltopdf -s A4 -B 0mm -T 2mm -L 2mm -R 2mm  '$url'  $fileName");
				$process->run();

				$process = new Process("lp -d $printer $fileName");
				$process->run();

				$process = new Process("rm $fileName && rm turnaroundtime*.pdf");
				$process->run();
			}
			else
			{
				$view_url = "reports.departments.exportturnaround";
			}
		}

  		return View::make($view_url)
			->with('data', $data)
			->with('test_type_list', $test_type_list)
			->with('categories', $categories)
			->with('category', $category)
			->with('time_formats', $time_formats)
			->with('category_names', $category_names)
			->withInput(Input::all())
			->with('available_printers', Config::get('kblis.A4_printers'));
		
  	}


  	public function testsResultsCounts()
  	{   //	Fetch form filters
		$date = date('Y-m-d');
		$date = explode("-",$date);		
		$year = Input::get('year');
		$month = Input::get('month');
		if (strlen(Input::get('month'))==1) $month ="0".Input::get('month');
		if (strlen(Input::get('month'))==2) $month =Input::get('month');
		if (!$year) $year = $date[0];
		if (!$month) $month = $date[1];
		
		$option = Input::get('test_category');
		if(!$option) $option = "-- All --";
  		$testCategories = new TestCategory();  		
  		$categories =  $testCategories->getCategories($option);
  		$data = array();  		
  		$ck = 0; 
  		$control = count($categories);  		
 		
  		for ($count=0;$count<$control;$count++)
  		{  	$id =  $categories[$count]->id;
  			$cat_name = $categories[$count]->name;
  			$checkDate = $year.'-'.$month;
  			$sql = "SELECT count(tests.test_type_id) as Count, test_types.id, test_types.name,tests.time_created FROM test_types inner join tests on tests.test_type_id = test_types.id  WHERE test_types.test_category_id='$id' AND SUBSTRING(tests.time_created,1,7) = '$checkDate' GROUP BY test_types.name";
  			$test_type = DB::select(DB::raw($sql));  	
  			$da = array();
  			foreach ($test_type as $test_types){   
					$test_type_id = $test_types->id;										
					$sql = "SELECT test_results.measure_id,test_results.result,measure_types.name, measure_ranges.range_lower,measure_ranges.range_upper,measure_ranges.alphanumeric, measure_ranges.interpretation FROM test_results inner join tests on test_results.test_id = tests.id inner join measures on measures.id = test_results.measure_id inner join measure_types on measure_types.id = measures.measure_type_id inner join measure_ranges on measure_ranges.measure_id = measures.id WHERE tests.test_type_id='$test_type_id' AND SUBSTRING(tests.time_created,1,7) = '$checkDate' ";

					$test_data = DB::select(DB::raw($sql)); 
					$positive_counter =0;
					$negative_counter =0;		
					foreach ($test_data as $test_id)
					{	 	$measure_id = $test_id->measure_id;
							$result_value = $test_id->result;
												
							if (($test_id->name=="Numeric Range") AND ($test_id->range_lower<=$result_value AND $test_id->range_upper>=$result_value)){  
									if ($test_id->interpretation=="POSITIVE"){
	 										$positive_counter ++;
									}
									elseif ($test_id->interpretation=="NEGATIVE"){
											$negative_counter++;
									}
							}
							else if (($test_id->name=="Alphanumeric Values") AND ($test_id->alphanumeric==$result_value)){   
									if ($test_id->interpretation=="POSITIVE"){
	 										$positive_counter ++;
									}
									elseif ($test_id->interpretation=="NEGATIVE"){
											$negative_counter++;
									}								
							}											
					}								
					$name =  $test_types->name;
					$test_names = array($name => array( 'count' => $test_types->Count,
										  	            'positive' => $positive_counter,
												        'negative' => $negative_counter));	
					$da[$ck] = $test_names;
					$ck++;		
			}			
			$ck =0;	
			$data[$count] =  array($cat_name => array($da));	 						
  		}	
		return View::make('reports.testsCounts.index')
					->with('testTypes', $data)
					->withInput(Input::all());
  	}


  	function positiveNegativeCounts()
  	{
  		$ward_date = date('Y-m-d');
  		$ward_month = Input::get('ward_month');
  		$ward_year = Input::get('ward_year');
  		if (!$ward_year){$ward_year= date('Y');}
  		if (!$ward_month){$ward_month = date('m');}
  		if (strlen($ward_month)==1) $ward_month ="0".$ward_month;				  		
  		
  		$ward_check_date = $ward_year."-".$ward_month;
  		$sql ="SELECT count(*) as count,visits.ward_or_location  as ward_name, visits.visit_type as ward_type FROM tests 
  			INNER JOIN visits ON tests.visit_id = visits.id 
  			INNER JOIN test_types on test_types.id = tests.test_type_id
  			WHERE visits.ward_or_location 
  			IN (SELECT wards.name FROM wards) 
  			AND test_types.name='Culture & Sensitivity' 
  			AND (SUBSTRING(tests.time_created,1,7) ='$ward_check_date') 
  			GROUP BY iblis.visits.ward_or_location 
  			Order By visits.visit_type ";

  		$ward_counts = DB::select(DB::raw($sql));

  		return $ward_counts;
  	}

  	function get_culture_sensitivity_counts_for_wards()
  	{
  			//for ward section
  		$ward_date = date('Y-m-d');
  		$ward_month = Input::get('ward_month');
  		$ward_year = Input::get('ward_year');
  		if (!$ward_year){$ward_year= date('Y');}
  		if (!$ward_month){$ward_month = date('m');}
  		if (strlen($ward_month)==1) $ward_month ="0".$ward_month;				  		
  		
  		$ward_check_date = $ward_year."-".$ward_month;
  		$sql ="SELECT count(*) as count,visits.ward_or_location  as ward_name, visits.visit_type as ward_type FROM tests 
  			INNER JOIN visits ON tests.visit_id = visits.id 
  			INNER JOIN test_types on test_types.id = tests.test_type_id
  			WHERE visits.ward_or_location 
  			IN (SELECT wards.name FROM wards) 
  			AND test_types.name='Culture & Sensitivity' 
  			AND (SUBSTRING(tests.time_created,1,7) ='$ward_check_date') 
  			GROUP BY iblis.visits.ward_or_location 
  			Order By visits.visit_type ";

  		$ward_counts = DB::select(DB::raw($sql));

 		return View::make('reports.culturesensitivity.wardscounts.index')
  					->with('ward_counts',$ward_counts)
  					->withInput(Input::all());
  		
  	}

  	function get_organisms_counts()
  	{ 
  			//for ward section
  		$date = date('Y-m-d');
  		$month = Input::get('month');
  		$year = Input::get('year');
  		if (!$year){$year= date('Y');}
  		if (!$month){$month = date('m');}
  		if (strlen($month)==1) $month ="0".$month;				  		
  		
  		$check_date = $year."-".$month;
  		$sql = "SELECT count(*) as total FROM tests INNER JOIN test_types ON test_types.id = tests.test_type_id WHERE (test_types.name='Culture & Sensitivity') AND (SUBSTRING(tests.time_created,1,7) ='$check_date')";
  		$count = DB::select(DB::raw($sql));

  		$sql = "SELECT count(*) as total_growth FROM tests INNER JOIN test_results ON test_results.test_id = tests.id WHERE test_results.result ='Growth'
  			AND (SUBSTRING(tests.time_created,1,7) ='$check_date')";
  		$total_growth = DB::select(DB::raw($sql));

  		$sql = "SELECT count(*) AS organismCount, organisms.name AS organismName FROM tests INNER JOIN test_organisms ON test_organisms.test_id = tests.id INNER JOIN organisms ON organisms.id = test_organisms.organism_id INNER JOIN test_results ON test_results.test_id = tests.id WHERE (SUBSTRING(tests.time_created,1,7) = '$check_date') AND test_results.result='Growth' GROUP BY organisms.name ORDER BY organismCount DESC"; 

  		$counts = DB::select(DB::raw($sql));
  		
 		return View::make('reports.culturesensitivity.organismcounts.index')
 					->with('total_count',$count[0]->total)
 					->with('total_growth',$total_growth[0]->total_growth)
  					->with('organism_details',$counts)
  					->withInput(Input::all());  		
  	}

  	function getOrganismInWards()
  	{
  		$date = date('Y-m-d');
  		$month = Input::get('month');
  		$year = Input::get('year');
  		if (!$year){$year= date('Y');}
  		if (!$month){$month = date('m');}
  		if (strlen($month)==1) $month ="0".$month;				  		
  		
  		$check_date = $year."-".$month;
  		$sql = "SELECT wards.name AS wardName, visit_types.name AS visitType FROM wards INNER JOIN visittype_wards ON visittype_wards.ward_id = wards.id 
  			INNER JOIN visit_types ON visit_types.id = visittype_wards.visit_type_id";

  		$wards = DB::select(DB::raw($sql));
  		$data = array();
  		$counter =0;
  		$count = 0;


  		foreach ($wards as $wardDetails) 
  		{
  			$organs = array();
  			$sql = "SELECT count(*) AS organismCount, organisms.name AS organismName  FROM visits INNER JOIN tests ON tests.visit_id = visits.id INNER JOIN test_organisms ON test_organisms.test_id = tests.id INNER JOIN organisms ON organisms.id = test_organisms.organism_id INNER JOIN test_results ON
  			test_results.test_id = tests.id 
  			WHERE (SUBSTRING(tests.time_created,1,7) = '$check_date') 
  			AND test_results.result='Growth' AND 
  				visits.ward_or_location = '$wardDetails->wardName' GROUP BY organisms.name 
  			ORDER BY organismCount DESC";

  			$rs = DB::select(DB::raw($sql));
  			$data[$counter][0] =$wardDetails->wardName;
  			$data[$counter][1] =$wardDetails->visitType;

			if(count($rs)>0)
			{	foreach ($rs as $value) 
				{	$organs[$count][0] = $value->organismName;
					$organs[$count][1] = $value->organismCount;
					$count ++;
				}
			}
			else
			{	$organs[$count][0] = '-';
				$organs[$count][1] = 0;
				$count++;
			}
			$data[$counter][2] = $organs;
			$count = 0;
			$counter++;
		}
		
  		return View::make('reports.culturesensitivity.organisminwards.index')
  					->with('info',$data)
  					->withInput(Input::all());  		
  	}  

  	function cultureSensitivityCounts()
  	{
  		//for general counts section
  		$date = date('Y-m-d');
  		$month = Input::get('month');
  		$year = Input::get('year');
  		if (!$year){$year= date('Y');;}
  		if (!$month){$month = date('m');}
  		if (strlen($month)==1) $month ="0".$month;				  		
  		$check_date = $year."-".$month;
  			$values = array('Mixed growth; no predominant organism',
  						'Growth of normal flora; no pathogens isolated',
  						'No growth','Growth','Growth of contaminants');
  		$data = array();
  		$counter=0;
  		$sql = "SELECT count(*) as total FROM tests INNER JOIN test_types ON test_types.id = tests.test_type_id WHERE (test_types.name='Culture & Sensitivity') AND (SUBSTRING(tests.time_created,1,7) ='$check_date')";
  		$totalCount = DB::select(DB::raw($sql));

  		foreach($values AS $measure)
  		{
  			$sql = "SELECT count(*) AS count FROM tests INNER JOIN test_results ON test_results.test_id = tests.id WHERE (SUBSTRING(tests.time_created,1,7) ='$check_date') AND test_results.result='$measure'";

  			$count = DB::select(DB::raw($sql));

  			if (count($count)>0)
  			{
  					$data[$counter][0] = $measure;
  					$data[$counter][1] = $count[0]->count;  					
  			}
  			else
  			{
  					$data[$counter][0] = $measure;
  					$data[$counter][1] = 0;
  			}

  			$counter++;  			
  		}
  		return View::make('reports.culturesensitivity.generalcount.index')
  						->with('data',$data)
  						->with('total',$totalCount[0]->total)
  						->withInput(Input::all());
  	}


  	function getsusceptibilitycount()
  	{	$date = date('Y-m-d');
  		$month = Input::get('month');
  		$year = Input::get('year');
  		if (!$year){$year= date('Y');}
  		if (!$month){$month = date('m');}
  		if (strlen($month)==1) $month ="0".$month;				  		
  		
  		$check_date = $year."-".$month;

  		$organismObject = new  Organism;
  		$drugObject = new Drug;
  		$susceptibilityObject = new Susceptibility;
  		$testObject = new Test;

  		$i = 0;
  		$s = 0;
  		$r = 0;
  		
  		$details = array();
  		$count =0;
  		$counter=0;

		$organism = $organismObject->getOrganisms();

		foreach($organism AS $organismDetails)
		{ 
			$drugs = $drugObject->getOrganismDrugs($organismDetails->organismName);
			$inter = array();
			foreach($drugs AS $drug)
			{ 
			  $Susceptibility = $susceptibilityObject->getOrganismSusceptibility($organismDetails->organismsId,$drug->drugId);			  

			  	if(count($Susceptibility)>0)
			  	{ 
				  	foreach($Susceptibility AS $sus)
				  	{	
				 	  if(($testObject->checkTest($check_date,$sus->testId))==true)
				 	  {
				 	  	 if ($sus->inter=='I')
				 	  	 {
				 	  	 	$i+=1;
				 	  	 }
				 	  	 elseif($sus->inter=='R')
				 	  	 {
				 	  	 	$r+=1;
				 	  	 }
				 	  	 elseif($sus->inter=='S')
				 	  	 {	
				 	  	 	$s+=1;
				 	  	 }
				 	  }	
				 	}		 	 
			  	}		
			  	$inter[$count][0] = $drug->drugName;
			  	$inter[$count][1] = $i;
			  	$inter[$count][2] = $r;
			  	$inter[$count][3] = $s;
			  	$count++;	
			  	$i=0;
			  	$r=0;
			  	$s=0; 

			}
			$details[$counter][0]=$organismDetails->organismName;
			$details[$counter][1]=$inter;
			$counter++;		
		}

  		return View::make('reports.culturesensitivity.susceptibility.index')
  					->with('info',$details)
  					->withInput(Input::all()); 

  	}

}
