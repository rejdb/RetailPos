<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';
class Customers extends REST_Controller {

    function __construct() {
        parent:: __construct();
        date_default_timezone_set('Asia/Manila');
        $this->load->Model('api/customer');
    }
    
    function all_post() {
        $list = $this->customer->filter($this->post('params'));
        $this->response($list);
//        $this->response($this->post());
    }
    
    function status_get($status) {
         $list = $this->customer->filter(array('IsActive'=>$status));
        $this->response($list);
    }
    
    function add_post() {
        $data = (object) $this->post();
        
        $cardno = $this->customer->get_by(array('CardNo'=>$data->CardNo));
//        $exists = $this->customer->get_by(array('CustFirstName'=>$data->CustFirstName,'CustLastName'=>$data->CustLastName));
        
        if($cardno) {
            $response = array(
                'status' => false,
                'message' => 'Card No. already exists!');
        }else{
            $id = $this->customer->insert($this->post());
            $data = $this->customer->get_by(array('CustID'=>$id));    
            $response = array(
                'status' => true,
                'message' => 'Customer has been added successfully!',
                'data' => $data
            );
        }  $this->response($response);
    }
    
    function update_post() {
        $this->customer->update($this->post('CustID'), $this->post('type'));
        $this->response(array('message'=>'Record has been successfully update'));
    }
    
}