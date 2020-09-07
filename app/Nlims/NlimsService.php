<?php
namespace App\Nlims;

use Illuminate\Support\Facades\Storage;
// use Storage;
use File;


class NlimsService{

    public function __construct()
    {
        $this->check_token_url = \Config::get('nlims_connection.nlims_controller_ip')."/api/".\Config::get('nlims_connection.nlims_api_version')."/check_token_validity";
        $this->re_authenticate_user_url = \Config::get('nlims_connection.nlims_controller_ip')."/api/".\Config::get('nlims_connection.nlims_api_version')."/re_authenticate/";
        $this->create_order_url = \Config::get('nlims_connection.nlims_controller_ip')."/api/".\Config::get('nlims_connection.nlims_api_version')."/create_order";
        $this->update_order = \Config::get('nlims_connection.nlims_controller_ip')."/api/".\Config::get('nlims_connection.nlims_api_version')."/update_order";
        $this->add_test = \Config::get('nlims_connection.nlims_controller_ip')."/api/".\Config::get('nlims_connection.nlims_api_version')."/add_test";
        // $this->re_authenticate_user();
        // $this->update_order = \Config::get('nlims_connection.nlims_controller_ip')."/api/".\Config::get('nlims_connection.nlims_api_version')."/update_order";
    }

    public function check_token_validity(){
        $token_ = File::get(storage_path('token/nlims_token'));

        $ch = curl_init($this->check_token_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "content_type: application/json",
            "token: ".$token_
        ));

        $response = json_decode(curl_exec($ch));
        
        if ($response['error'] == false){
            return false;
        }else{
            return true;
        }
    }

    public function re_authenticate_user(){
        $nlims_url =  \Config::get('nlims_connection.nlims_controller_ip');
		$username =  \Config::get('nlims_connection.nlims_custome_username');
        $password =  \Config::get('nlims_connection.nlims_custome_password');
        $nlims_ver = \Config::get('nlims_connection.nlims_api_version');
        $token_path = File::get(storage_path('token/nlims_token'));

        $ch = curl_init($nlims_url."/api/".$nlims_ver."/re_authenticate/".$username."/".$password);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "content_type: application/json"
        ));

        $response = json_decode(curl_exec($ch));
        // var_dump($response->data->token); exit;
        if ($response->error == false){
            $token = $response->data->token;
            Storage::put($token_path, $token);
            
            return true;
        }else{
            return $res['message'];
        }		
    }

    public function create_order($order_data){
        $token_ = File::get(storage_path('token/nlims_token'));
        $data = json_encode($order_data);

        $ch = curl_init($this->create_order_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "content_type: application/json",
            "token: ".$token_
        ));

        $response = json_decode(curl_exec($ch));
        if ($response->error == false){
            return array($response->data->tracking_number,true);
        }else{
            return  array($response->message,false);
        }
    }

    public function update_order($order_update_data, $token){
        // $token_ = File::get(storage_path('token/nlims_token'));
        //var_dump($order_update_data); exit;
        $data = json_encode($order_update_data);

        $ch = curl_init($this->update_order);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "content_type: application/json",
            "token: ".$token
        ));

        $response = json_decode(curl_exec($ch));
        //var_dump($response); exit;
        if ($response->error == false){
            return true;
        }else{
            return $response->message;
        }
    }

    public function add_test($test_data){
        $token_ = File::get(storage_path('token/nlims_token'));
        $data = json_encode($order_update_data);

        $ch = curl_init($this->add_test);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "content_type: application/json",
            "token: ".$token_
        ));

        $response = json_decode(curl_exec($ch));
        if ($response->error == true){
            return true;
        }else{
            return $response->message;
        }
    }

    public function accept($updateData, $token){
        //$token_ = File::get(storage_path('token/nlims_token'));
        $data = json_encode($updateData);

        $ch = curl_init($this->update_order);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "content_type: application/json",
            "token: ".$token
        ));

        $response = json_decode(curl_exec($ch));

        if ($response->error == true){
            return true;
        }else{
            return $response->message;
        }
    }

    public function reject($rejectData, $token){
        //$token_ = File::get(storage_path('token/nlims_token'));
        $data = json_encode($rejectData); //changed to reflect what has been passed to the function

        $ch = curl_init($this->update_order);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "content_type: application/json",
            "token: ".$token
        ));

        $response = json_decode(curl_exec($ch));
        
        if ($response->error == true){
            return true;
        }else{
            return $response->message;
        }
    }

    public function update_test($order_update_data, $token){
        // $token_ = File::get(storage_path('token/nlims_token'));
        // var_dump($order_update_data); exit;
        $data = json_encode($order_update_data);

        $nlims_url =  \Config::get('nlims_connection.nlims_controller_ip');
		$username =  \Config::get('nlims_connection.nlims_custome_username');
        $password =  \Config::get('nlims_connection.nlims_custome_password');
        $nlims_ver = \Config::get('nlims_connection.nlims_api_version');
        // $token_path = File::get(storage_path('token/nlims_token'));

        $ch = curl_init($nlims_url."/api/".$nlims_ver."/update_test");
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "content_type: application/json",
            "token: ".$token
        ));

        $response = json_decode(curl_exec($ch));
        //var_dump($response); exit;

        if ($response->error == true){
            return true;
        }else{
            return $response-> message;
        }
    }

}