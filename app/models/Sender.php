<?php
class Sender
{
    /**
     * funtion for querying orders from central data repo
     * By Kenneth Kapundi
     */
    public static function search_from_remote($trackingNumber){

        $ch = curl_init( Config::get('kblis.central-repo')."/query_results/".$trackingNumber);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch));
        return $result;
    }

    /*
     *
     */
    public static function get_name($order){
        $rawNames = $order->test_types;
        $panels = array();
        $to_negate = array();

        foreach($rawNames AS $name){
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

        return array_unique(array_diff(array_merge($panels, $rawNames), $to_negate));
    }
    /**
     * Function for sending updated results to couch layer
     *
     */
    public static function send_data($patient, $specimen, $tests=[])
    {
        $order = array(
            '_id' => $specimen->tracking_number,
            'sample_status' => SpecimenStatus::find($specimen->specimen_status_id)->name,
            'results' => array()
        );

        if(sizeof($tests) == 0){
            $tests = Test::where('specimen_id', $specimen->id)->get();
        }

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
            $h['who_updated']['first_name'] = explode(' ', $who->name)[0];
            $h['who_updated']['last_name'] = explode(' ', $who->name)[1];
            $h['who_updated']['ID_number'] = $who->id;

            $r = array();
            foreach ($test->testResults AS $result){
                $measure = Measure::find($result->measure_id);
                $r[$measure->name] = $result->result." ".$measure->unit;
            }
            $h['results'] = $r;
            $order['results'][$test_name] = $h;
        }

        #$order =  urldecode(http_build_query($order));
        #dd($order);
        $data_string = json_encode($order);

        $ch = curl_init( Config::get('kblis.central-repo')."/update_order");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        curl_exec($ch);

    }
}