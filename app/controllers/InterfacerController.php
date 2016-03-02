<?php

class InterfacerController extends \BaseController
{

    public function receiveLabRequest()
    {
        //authenticate() connection

        $labRequest = Request::getContent();
        $labRequest = str_replace(['labRequest', '='], ['', ''], $labRequest);

        //Validate::ifValid()

        //Fire event with the received data
        Event::fire('api.receivedLabRequest', json_decode($labRequest));
    }


    /* -------------------------------------------------
    * proposed to do in future, for a full api we need to connect to blis and
    * get a variety of data, for analysis and such.
    * --------------------------------------------------
    */
    public function authenticate()
    {
    }

    public function connect()
    {
    }

    public function disconnect()
    {
    }

    public function searchPatients()
    {
    }

    public function searchResults()
    {
    }

    public function getTestTypes()
    {

        $username = null;
        $password = null;

// mod_php
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];

// most other servers
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {

            if (strpos(strtolower($_SERVER['HTTP_AUTHORIZATION']), 'basic') === 0)
                list($username, $password) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));

        }

        if (is_null($username)) {

            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Text to send if user hits Cancel button';

            die();

        } else {

            $credentials = array(
                "username" => $username,
                "password" => $password
            );

            if (!Auth::attempt($credentials)) {

                header('WWW-Authenticate: Basic realm="My Realm"');
                header('HTTP/1.0 401 Unauthorized');
                echo 'Text to send if user hits Cancel button';

                die();

            }
        }

        $specimen_type = $_REQUEST['specimenfilter'];
        $specimenType = SpecimenType::where("name", "=", $specimen_type)->first();
        $testTypes = [];
        $testPanels = [];

        if ($specimenType) {
            $testTypes = DB::table('testtype_specimentypes')
                ->join('test_types', 'test_types.id', '=', 'testtype_specimentypes.test_type_id')
                ->select('test_types.*')
                ->where('testtype_specimentypes.specimen_type_id', '=', $specimenType->id)
                ->whereNull('test_types.deleted_at');

            $testTypes = $testTypes->get();

            $testPanels = DB::table('panel_types')
                ->join('panels', 'panel_types.id', '=', 'panels.panel_type_id')
                ->join('test_types', 'test_types.id', '=', 'panels.test_type_id')
                ->join('testtype_specimentypes', 'test_types.id', '=', 'testtype_specimentypes.test_type_id')
                ->select('panel_types.*')
                ->where('testtype_specimentypes.specimen_type_id', '=', $specimenType->id);

            $testPanels = $testPanels->get();

        }

        $result = array_merge($testTypes, $testPanels);

        return json_encode($result);

    }

    public function getSpecimen()
    {

        echo("get specimen");

    }

    public function updateResult()
    {

        $username = null;
        $password = null;

// mod_php
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];

// most other servers
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {

            if (strpos(strtolower($_SERVER['HTTP_AUTHORIZATION']), 'basic') === 0)
                list($username, $password) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));

        }

        if (is_null($username)) {

            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Text to send if user hits Cancel button';

            die();

        } else {

            $credentials = array(
                "username" => $username,
                "password" => $password
            );

            if (!Auth::attempt($credentials)) {

                header('WWW-Authenticate: Basic realm="My Realm"');
                header('HTTP/1.0 401 Unauthorized');
                echo 'Text to send if user hits Cancel button';

                die();

            }
        }

        $json = array();

        $base = realpath(".");

        if (!file_exists($base . "/data")) {
            mkdir($base . "/data", 0777, true);
        }

        $specimen_id = $this::trimZeros($_REQUEST["specimen_id"]);

        $measure_id = $_REQUEST["measure_id"];

        $result = $_REQUEST["result"];

        $remote_ip = '';    // $_SERVER["REMOTE_ADDR"] . "/";

        if (!file_exists($base . "/data/$remote_ip")) {
            mkdir($base . "/data/$remote_ip", 0777, true);
        }

        if (file_exists("$base/data/$remote_ip$specimen_id.json")) {

            $json = json_decode(file_get_contents("$base/data/$remote_ip$specimen_id.json"), true);

        }

        if(isset($specimen_id) && isset($measure_id) && isset($result)) {

            if(!isset($json[$specimen_id])) {

                $json[$specimen_id] = array(
                    $measure_id => $result
                );

            } else {

                $json[$specimen_id][$measure_id] = $result;

            }

            file_put_contents("$base/data/$remote_ip$specimen_id.json", json_encode($json, true));

            return "1";

        } else {

            return "-1";

        }

    }

    public function trimZeros($id)
    {

        $i = 0;

        $len = strlen($id);

        $result = $id;

        while($i < $len) {

            if(substr($id, $i, 1) != "0") {

                $result = substr($id, $i, ($len - $i));

                break;

            } else {

                $i += 1;

            }

        }

        return $result;

    }

}