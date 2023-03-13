<?php
use Nlims\Service\NlimsService;
class Sender
{
    /**
     * funtion for querying orders from central data repo
     * By Kenneth Kapundi
     */
    public static function search_from_remote($trackingNumber){
        /* XLLH196N051 */
        $nlims_url =  \Config::get('nlims_connection.nlims_controller_ip');
        $nlims_user =  \Config::get('nlims_connection.nlims_custome_username');
        $nlims_pass =  \Config::get('nlims_connection.nlims_custome_password');

       
        $ch = curl_init($nlims_url."/api/v1/re_authenticate/".$nlims_user."/".$nlims_pass);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch));
       
        $token = $result->data->token;

        // $ch = curl_init("http://localhost:7070/api/v1/query_order_by_tracking_number/".$trackingNumber);

        $ch = curl_init($nlims_url."/api/v1/query_order_by_tracking_number/".$trackingNumber);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('token:'.$token));
        $result = json_decode(curl_exec($ch));
        // if(Config::get('kblis.nlims_controller') == true){
          
        // }else{
        //     $ch = curl_init( Config::get('kblis.national-repo-node')."/query_results/".$trackingNumber);
        //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     $result = json_decode(curl_exec($ch));
        // }
      
        return $result;
    }


    public static function search_results_from_remote($trackingNumber){
        /* XLLH196N051 */
        // $token = "tsg9WCiGgthO";
        $nlims_url =  \Config::get('nlims_connection.nlims_controller_ip');
        $nlims_user =  \Config::get('nlims_connection.nlims_custome_username');
        $nlims_pass =  \Config::get('nlims_connection.nlims_custome_password');
       
        $ch = curl_init($nlims_url."/api/v1/re_authenticate/".$nlims_user."/".$nlims_pass);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch));
        $token = $result->data->token;

        $ch = curl_init($nlims_url."/api/v1/query_results_by_tracking_number/".$trackingNumber);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('token:'.$token));
        $result = json_decode(curl_exec($ch));           

        // if(Config::get('kblis.nlims_controller') == true){
            
        // }else{
        //     $ch = curl_init( Config::get('kblis.national-repo-node')."/query_results/".$trackingNumber);
        //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     $result = json_decode(curl_exec($ch));
        // }
        return $result;
    }

    /*
     *
     */
    public static function get_name($order, $panels_only = false){
        $rawNames = $order->data->tests;
        $panels = array();
        $to_negate = array();
        $new_array = array();
        foreach($rawNames AS $name => $status){
            array_push($new_array,$name);
            $panel = PanelType::where('name', $name)->first();
            if($panel) {
                array_push($panels, $name);
                $to_negate = array_merge($to_negate, DB::table('panels')
                    ->join('test_types', 'test_types.id', '=', 'panels.test_type_id')
                    ->where('panel_type_id', $panel->id)
                    ->select('name')
                    ->lists('name'));
            }
        }
        if($panels_only){
            return $panels;
        }else {
            return array_unique(array_diff(array_merge($panels, $new_array), $to_negate));
        }
    }
    /**
     * Function for sending updated results to couch layer
     *
     */
    public static function send_data($patient, $specimen, $tests=[])
    {
        $nlims_url =  \Config::get('nlims_connection.nlims_controller_ip');
        $nlims_user =  \Config::get('nlims_connection.nlims_custome_username');
        $nlims_pass =  \Config::get('nlims_connection.nlims_custome_password');

        $order = array(
            '_id' => $specimen->tracking_number,
            'sample_status' => SpecimenStatus::find($specimen->specimen_status_id)->name,
            'results' => array()
        );

        if(sizeof($tests) == 0){
            $tests = Test::where('specimen_id', $specimen->id)->get();
        }
        //check token
       // var_dump($nlims_pass);exit;
        $ch = curl_init($nlims_url."/api/v1/re_authenticate/".$nlims_user."/".$nlims_pass);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch));
        $token = $result->data->token;
        Session::put('nlims_token', $token);

        foreach($tests AS $test){

            $test_name = $test->testType->name;
            $order['results'][$test_name] = array();
            $h = array();
            $h['test_status'] = $test->testStatus->name;
            $h['remarks'] = $test->interpretation;
            $h['datetime_started'] = $test->time_started;
            $h['datetime_completed'] = $test->time_completed;

            $h['who_updated'] = array();
            $who = Auth::user();
            $name = explode(' ', $who->name);
            // $h['who_updated']['first_name'] = isset($name[0]) ? $name[0]  : '';
            // $h['who_updated']['last_name'] = isset($name[1]) ? $name[1]  : '';
            // $h['who_updated']['ID_number'] = $who->id;

            $who_updated_fname = isset($name[0]) ? $name[0]  : '';
            $who_updated_lname = isset($name[1]) ? $name[1]  : '';
            $who_updated_id = $who->id;

            $r = array();
            foreach ($test->testResults AS $result){
                $measure = Measure::find($result->measure_id);
                if($result->result) {
                    $r[$measure->name] = $result->result . " " . $measure->unit;
                }else{
                    $r[$measure->name] = $result->result;
                }
            }
            /*
            $data = "{
                'tracking_number: '" + $specimen->tracking_number + "',
                'test_name: '" + $test_name + "',
                'result_date: '" + $test->time_completed + "',
                'who_updated': {
                    'id': '" + $who_updated_id + "',
                    'first_name': '" + $who_updated_fname + "',
                    'last_name': '" + $who_updated_lname + "'
                },
                'test_status': '" + $test->testStatus->name + "'
            }";
            */
            $update_test = array();
            $update_test["tracking_number"] = $specimen->tracking_number;
            $update_test["test_name"] = $test_name;
            $update_test["time_updated"] = $test->updated_at;
            $update_test["who_updated"] = array();
            $update_test["who_updated"]["id"] = Auth::user()->id;
            $update_test["who_updated"]["first_name"] = $who_updated_fname;
            $update_test["who_updated"]["last_name"] = $who_updated_lname;
            $update_test["test_status"] = $test->testStatus->name;

            if ($r && $test->testStatus->name == 'completed'){
                $update_test['results'] = $r;
                $update_test["result_date"] = $test->time_completed;
            }
            
            $test_updater = New NlimsService();
            $resp_ = $test_updater->update_test($update_test, $token);

        }

    }

    public static function merge_or_create($tracking_number){
        $nlims_url =  \Config::get('nlims_connection.nlims_controller_ip');
        $nlims_user =  \Config::get('nlims_connection.nlims_custome_username');
        $nlims_pass =  \Config::get('nlims_connection.nlims_custome_password');

        $specimenStatus = SpecimenStatus::where('name', 'specimen-accepted')->first()->id;
        $testStatus = 2;
        $specimenStatusWord = "specimen-accepted";
       
        if(count(explode("-",$tracking_number)) > 1){
            
            $statusAction = explode("-",$tracking_number)[1];
            if($statusAction == "accept"){
                $specimenStatus = SpecimenStatus::where('name', 'specimen-accepted')->first()->id;
            }else if ($statusAction == "rejected"){
                $specimenStatus = SpecimenStatus::where('name', 'specimen-rejected')->first()->id;
                $specimenStatusWord = "specimen-rejected";
                $testStatus = "8";
            }
        }

        $tracking_number = explode("-",$tracking_number)[0];       
        
        $order = Sender::search_from_remote($tracking_number);
        
        $check_sample_type = SpecimenType::where('name',$order->data->other->sample_type)->first();
       
        if($check_sample_type == NULL)
        {
            return [true,"Sample Merge Failed! sample type from nationl lims not available in iblis"];
        }
        $check_order_location = FacilityWard::where('name',$order->data->other->order_location);
        if($check_order_location == NULL)
        {
            return [true,"Sample Merge Failed! order location from nationl lims not available in iblis"];
        }
        $tstChecker = array();
        $counter = 0;
        foreach($order->data->tests AS $name => $status) {
            $tstChecker[$counter] = $name;
            $type = TestType::where('name', $name)->first();
            if($type == NULL){
                return [true,"Sample Merge Failed! test type from nationl lims not available in iblis"];
            }
            $counter++;
        }
      
        $specimen = Specimen::where('tracking_number', $tracking_number)->first();
        $patient = Patient::where('external_patient_number', $order->data->other->patient->id)->first();

        if(!$patient){
            if (in_array("Viral Load",$tstChecker)){
                if(isset($order->data->other->patient->arv_number)){
                    $patId = $order->data->other->arv_number;
                }else{
                    $patId = $order->data->other->patient->id;
                }
            }else{
                $patId = $order->data->other->patient->id;
            }

            $patient = new Patient;
            $patient->external_patient_number = $patId;
            $patient->name = $order->data->other->patient->name;
            $patient->dob = date_create($order->data->other->patient->dob);
            $patient->gender = preg_match("/m/i", $order->data->other->patient->gender) ? 0 : 1;
            $patient->phone_number = "";
            $patient->patient_number = $patId;
            $patient->save();
        }
  
        $specimenInserter = false;
        if(!$specimen){
            $specimen = new Specimen;
            $specimen->specimen_type_id = SpecimenType::where('name', $order->data->other->sample_type)->first()->id;
            $specimen->accession_number = Specimen::assignAccessionNumber();
            $specimen->tracking_number = $tracking_number;
            $specimen->drawn_by_name = $order->data->other->sample_created_by->name;
            $specimen->drawn_by_id = Auth::user()->id;
            $specimenInserter = true;           
            $sending_facility = $order->data->other->sending_lab;
            $sending_facility = DB::SELECT("SELECT * FROM facilities WHERE name='$sending_facility'");
            if(count($sending_facility) > 0){
                $sending_facility_id = $sending_facility[0]->id;
            }else{
                $sending_facility_id = $order->data->other->receiving_lab;
            }
            $specimen->sending_facility_id = $sending_facility_id;
        }
       
        $specimen->specimen_status_id = $specimenStatus;
        $specimen->accepted_by = Auth::user()->id;
        $specimen->time_accepted = time();
        $specimen->save();

        $dat = new UnsyncOrder;
		$dat->specimen_id = $specimen->id;
		$dat->data_not_synced = $specimenStatusWord;
		$dat->data_level = "specimen";
		$dat->sync_status = "not-synced";
		$dat->updated_by_name = "";
		$dat->updated_by_id = Auth::user()->id;
		$dat->save();


        if (in_array("Viral Load",$tstChecker) && $specimenInserter == true){
            $patientOnArt = new Art;
            $patientOnArt->specimen_id = $specimen->id;
            $patientOnArt->art_initiation_date = $order->data->other->art_start_date;
            $patientOnArt->art_current_regimen = $order->data->other->art_regimen;
            $patientOnArt->HTC_provider = "0";
            $patientOnArt->lasec_barcode = "";
            $patientOnArt->arv_number = $order->data->other->arv_number; 
            $patientOnArt->save();
        }

        $fname = explode(' ',$order->data->other->sample_created_by->name)[0];
        $sname = explode(' ',$order->data->other->sample_created_by->name)[1];
        /*
        $update_specimen = {
            'tracking_number':'" + $specimen->tracking_number + "',
            'who_updated': {
                'id': '" + Auth::user()->id + "',
                'first_name': '" + $fname ? $fname : '' +  "',
                'last_name': '" + $sname ? $sname : '' +  "'
            },
            'status': 'specimen_accepted'
        };
        */

        $panels_available = Sender::get_name($order, true);
        $testPanel = new TestPanel;
        $panel = array();
        $panel_type = null;

        if(count($panels_available) > 0){
            $panel_type = PanelType::where('name', $panels_available[0])->first();
            $panel = Panel::where('panel_type_id', $panel_type->id)->lists('test_type_id');
            $testPanel->panel_type_id = $panel_type->id;
        }

        foreach($order->data->tests AS $name => $status) {
            $type = TestType::where('name', $name)->first();
            if (!$type) continue;

            $test = Test::where('specimen_id', $specimen->id)->where('test_type_id', $type->id)->first();
            if (!$test) {
                $test = new Test;
                $test->test_type_id = $type->id;
                $test->specimen_id = $specimen->id;
                $test->test_status_id = $testStatus;
                $test->created_by = Auth::user()->id;
                $test->requested_by = $specimen->drawn_by_name;

                if ($panel_type && in_array($test->test_type_id, $panel)) {
                    $testPanel->save();
                    $test->panel_id = $testPanel->id;
                }
            }

            $visit = $test->visit;
            if (!$visit) {
                $visit = new Visit;
            }
            $visit->patient_id = $patient->id;
            if (!$visit->visit_type) {
                $visit->visit_type = VisitType::where('name', 'Referral')->first()->id;
            }
            $ward = $order->data->other->order_location;
            if(!isset($order->data->other->order_location)){
                $ward = "OPD";
            }          

            $visit->ward_or_location = $ward;
            $visit->save();

            $test->visit_id = $visit->id;
            $test->save();

            if($testStatus == "8"){
                $dat = new UnsyncOrder;
                $dat->specimen_id = $test->id;
                $dat->data_not_synced = "test-rejected";
                $dat->data_level = "test";
                $dat->sync_status = "not-synced";
                $dat->updated_by_name = "";
                $dat->updated_by_id = Auth::user()->id;
                $dat->save();        
            }

            if($name == "Viral Load"){
                $tracking_number = $specimen->tracking_number;
                $testID = $test->id;
                $fast = FastTrackedViralLoadTest::retrieveFastTrackedTest($tracking_number);
                if($fast[0] == true){
                    $measure_id = $fast[1];
                    $result = $fast[2];
                    $result_date = $fast[3];
                    
                    $tstResult = new TestResult();
                    $tstResult->measure_id = $measure_id;
                    $tstResult->result = $result;
                    $tstResult->time_entered = $result_date;
                    $tstResult->test_id = $testID;
                    $tstResult->save();

                    $tst = Test::find($testID);
			        $tst->worksheet_id = $fast[5];
			        $tst->save();
                    FastTrackedViralLoadTest::syncFastTrackedTest($fast[4]);
                }
            }
                
        }

        return [false,$specimen];
    }






    public static function acknowledgeRecipientNlims(){
        $nlims_url =  \Config::get('nlims_connection.nlims_controller_ip');
        $nlims_user =  \Config::get('nlims_connection.nlims_custome_username');
        $nlims_pass =  \Config::get('nlims_connection.nlims_custome_password');

       
        $ch = curl_init($nlims_url."/api/v1/re_authenticate/".$nlims_user."/".$nlims_pass);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch));
       
        $token = $result->data->token;




        $json = array (
            'tracking_number' 	 => $tracking_number,
            'status'			 => $sample_status,
            'who_updated'		 => array(
                'first_name' => $updater_f_name,
                'last_name'  => $updater_l_name,
                'id'	     => $updater_id
            )				
        );
        
        $acc = json_encode($json);
        $ch = curl_init($url."/api/v1/update_order/");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $acc);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json',
                'token: '. $token,
                'Content-Length: ' . strlen($acc))
        );
        $res = json_decode(curl_exec($ch));
    }







    public static function recieveSample($tracking_number){
        $nlims_url =  \Config::get('nlims_connection.nlims_controller_ip');
        $nlims_user =  \Config::get('nlims_connection.nlims_custome_username');
        $nlims_pass =  \Config::get('nlims_connection.nlims_custome_password');

        $specimenStatus = SpecimenStatus::where('name', 'specimen-accepted')->first()->id;
        $testStatus = 2;
        $specimenStatusWord = "specimen-accepted";
       
        if(count(explode("-",$tracking_number)) > 1){
            
            $statusAction = explode("-",$tracking_number)[1];
            if($statusAction == "accept"){
                $specimenStatus = SpecimenStatus::where('name', 'specimen-accepted')->first()->id;
            }else if ($statusAction == "rejected"){
                $specimenStatus = SpecimenStatus::where('name', 'specimen-rejected')->first()->id;
                $specimenStatusWord = "specimen-rejected";
                $testStatus = "8";
            }
        }

        $tracking_number = explode("-",$tracking_number)[0];       
        
        $order = Sender::search_from_remote($tracking_number);

        if($order->error == true){
            return [true,"Sample Receiving Not Successful, Sample Details not yet synced From HUB!!!!!"];
        }
        $check_sample_type = SpecimenType::where('name',$order->data->other->sample_type)->first();
       
        if($check_sample_type == NULL)
        {
            return [true,"Sample Merge Failed! sample type from nationl lims not available in iblis"];
        }
        $check_order_location = FacilityWard::where('name',$order->data->other->order_location);
        if($check_order_location == NULL)
        {
            return [true,"Sample Merge Failed! order location from nationl lims not available in iblis"];
        }
        $tstChecker = array();
        $counter = 0;
        foreach($order->data->tests AS $name => $status) {
            $tstChecker[$counter] = $name;
            $type = TestType::where('name', $name)->first();
            if($type == NULL){
                return [true,"Sample Merge Failed! test type from nationl lims not available in iblis"];
            }
            $counter++;
        }
      
        $specimen = Specimen::where('tracking_number', $tracking_number)->first();
        $patient = Patient::where('external_patient_number', $order->data->other->patient->id)->first();

        if(!$patient){
            if (in_array("Viral Load",$tstChecker)){
                if(isset($order->data->other->patient->arv_number)){
                    $patId = $order->data->other->arv_number;
                }else{
                    $patId = $order->data->other->patient->id;
                }
            }else{
                $patId = $order->data->other->patient->id;
            }

            $patient = new Patient;
            $patient->external_patient_number = $patId;
            $patient->name = $order->data->other->patient->name;
            $patient->dob = date_create($order->data->other->patient->dob);
            $patient->gender = preg_match("/m/i", $order->data->other->patient->gender) ? 0 : 1;
            $patient->phone_number = "";
            $patient->patient_number = $patId;
            $patient->save();
        }
  
        $specimenInserter = false;
        if(!$specimen){
            $specimen = new Specimen;
            $specimen->specimen_type_id = SpecimenType::where('name', $order->data->other->sample_type)->first()->id;
            $specimen->accession_number = Specimen::assignAccessionNumber();
            $specimen->tracking_number = $tracking_number;
            $specimen->drawn_by_name = $order->data->other->sample_created_by->name;
            $specimen->drawn_by_id = Auth::user()->id;
            $specimenInserter = true;           
            $sending_facility = $order->data->other->sending_lab;
            $sending_facility = DB::SELECT("SELECT * FROM facilities WHERE name='$sending_facility'");
            if(count($sending_facility) > 0){
                $sending_facility_id = $sending_facility[0]->id;
            }else{
                $sending_facility_id = $order->data->other->receiving_lab;
            }
            $specimen->sending_facility_id = $sending_facility_id;
      
            $specimen->specimen_status_id = $specimenStatus;
            $specimen->accepted_by = Auth::user()->id;
            $specimen->time_accepted = time();
            $specimen->save();

        }else{
            return [true,"Sample Already Received"];
        }
        $dat = new UnsyncOrder;
		$dat->specimen_id = $specimen->id;
		$dat->data_not_synced = $specimenStatusWord;
		$dat->data_level = "specimen";
		$dat->sync_status = "not-synced";
		$dat->updated_by_name = "";
		$dat->updated_by_id = Auth::user()->id;
		$dat->save();


        if (in_array("Viral Load",$tstChecker) && $specimenInserter == true){
            $patientOnArt = new Art;
            $patientOnArt->specimen_id = $specimen->id;
            $patientOnArt->art_initiation_date = $order->data->other->art_start_date;
            $patientOnArt->art_current_regimen = $order->data->other->art_regimen;
            $patientOnArt->HTC_provider = "0";
            $patientOnArt->lasec_barcode = "";
            $patientOnArt->arv_number = $order->data->other->arv_number; 
            $patientOnArt->save();
        }

        $fname = explode(' ',$order->data->other->sample_created_by->name)[0];
        $sname = explode(' ',$order->data->other->sample_created_by->name)[1];
        /*
        $update_specimen = {
            'tracking_number':'" + $specimen->tracking_number + "',
            'who_updated': {
                'id': '" + Auth::user()->id + "',
                'first_name': '" + $fname ? $fname : '' +  "',
                'last_name': '" + $sname ? $sname : '' +  "'
            },
            'status': 'specimen_accepted'
        };
        */

        $panels_available = Sender::get_name($order, true);
        $testPanel = new TestPanel;
        $panel = array();
        $panel_type = null;

        if(count($panels_available) > 0){
            $panel_type = PanelType::where('name', $panels_available[0])->first();
            $panel = Panel::where('panel_type_id', $panel_type->id)->lists('test_type_id');
            $testPanel->panel_type_id = $panel_type->id;
        }

        foreach($order->data->tests AS $name => $status) {
            $type = TestType::where('name', $name)->first();
            if (!$type) continue;

            $test = Test::where('specimen_id', $specimen->id)->where('test_type_id', $type->id)->first();
            if (!$test) {
                $test = new Test;
                $test->test_type_id = $type->id;
                $test->specimen_id = $specimen->id;
                $test->test_status_id = $testStatus;
                $test->created_by = Auth::user()->id;
                $test->requested_by = $specimen->drawn_by_name;

                if ($panel_type && in_array($test->test_type_id, $panel)) {
                    $testPanel->save();
                    $test->panel_id = $testPanel->id;
                }
            }

            $visit = $test->visit;
            if (!$visit) {
                $visit = new Visit;
            }
            $visit->patient_id = $patient->id;
            if (!$visit->visit_type) {
                $visit->visit_type = VisitType::where('name', 'Referral')->first()->id;
            }
            $ward = $order->data->other->order_location;
            if(!isset($order->data->other->order_location)){
                $ward = "OPD";
            }          

            $visit->ward_or_location = $ward;
            $visit->save();

            $test->visit_id = $visit->id;
            $test->save();

            if($testStatus == "8"){
                $dat = new UnsyncOrder;
                $dat->specimen_id = $test->id;
                $dat->data_not_synced = "test-rejected";
                $dat->data_level = "test";
                $dat->sync_status = "not-synced";
                $dat->updated_by_name = "";
                $dat->updated_by_id = Auth::user()->id;
                $dat->save();        
            }

            if($name == "Viral Load"){
                $tracking_number = $specimen->tracking_number;
                $testID = $test->id;
                $fast = FastTrackedViralLoadTest::retrieveFastTrackedTest($tracking_number);
                if($fast[0] == true){
                    $measure_id = $fast[1];
                    $result = $fast[2];
                    $result_date = $fast[3];
                    
                    $tstResult = new TestResult();
                    $tstResult->measure_id = $measure_id;
                    $tstResult->result = $result;
                    $tstResult->time_entered = $result_date;
                    $tstResult->test_id = $testID;
                    $tstResult->save();

                    $tst = Test::find($testID);
			        $tst->worksheet_id = $fast[5];
			        $tst->save();
                    FastTrackedViralLoadTest::syncFastTrackedTest($fast[4]);
                }
            }
                
        }

        return [false,$specimen];
    }






    
}
