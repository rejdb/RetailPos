<?php

class MY_Controller extends CI_Controller {
    public $Api;
    
    function __construct() {
        parent::__construct();       
        $this->Api = $this->config->item('base_url') . '/api';
    }
    
    public function get($url, $token = '3acf5c7b740d6e2538f3a7b88cf069b3') {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->Api . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 30e04afe-ba96-4515-a05b-dc1b21b7c330",
                "x-api-key: " . $token
            ),
        ));
    
        $responsed = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    
        if ($err) {
            $response = array('response_code' => false, 'message' => $this->error_message, 'error'=>$err);
        }else{
            $response = array('response_code' => true, 'results' => $responsed);
        }
        return json_encode($response);
    }
    
    public function post($url, $post_array, $token = '3acf5c7b740d6e2538f3a7b88cf069b3') {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->Api . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_array,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 30e04afe-ba96-4515-a05b-dc1b21b7c330",
                "x-api-key: " . $token
            ),
        ));
    
        $responsed = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    
        if ($err) {
            $response = array('response_code' => FALSE, 'message' => $this->error_message, 'error'=>$err);
        }else{
            $response = array('response_code' => TRUE, 'results' => $responsed);
        }
        return json_encode($response);
    }
}
?>