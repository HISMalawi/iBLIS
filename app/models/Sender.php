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

        $order = Sender::search_from_remote($tracking_number);
        $specimen = Specimen::where('tracking_number', $tracking_number)->first();
        $patient = Patient::where('external_patient_number', $order->data->other->patient->id)->first();

        if(!$patient){
            $patient = new Patient;
            $patient->external_patient_number = $order->data->other->patient->id;
            $patient->name = $order->data->other->patient->name;
            $patient->dob = date_create($order->data->other->patient->dob);
            $patient->gender = preg_match("/m/i", $order->data->other->patient->gender) ? 0 : 1;
            $patient->phone_number = "";
            $patient->patient_number = DB::table('patients')->max('id')+1;
            $patient->save();
        }

        if(!$specimen){
            $specimen = new Specimen;
            $specimen->specimen_type_id = SpecimenType::where('name', $order->data->other->sample_type)->first()->id;
            $specimen->accession_number = Specimen::assignAccessionNumber();
            $specimen->tracking_number = $tracking_number;
            $specimen->drawn_by_name = $order->data->other->sample_created_by->name;
            $specimen->drawn_by_id = Auth::user()->id;
        }

        $specimen->specimen_status_id = SpecimenStatus::where('name', 'specimen-accepted')->first()->id;
        $specimen->accepted_by = Auth::user()->id;
        $specimen->time_accepted = time();
        $specimen->save();

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
                $test->test_status_id = 2;
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
                
        }

        return $specimen;
    }
    
}
