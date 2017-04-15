<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';
class Suppliers extends REST_Controller {

    function __construct() {
        parent:: __construct();
        date_default_timezone_set('Asia/Manila');
        $this->load->Model('api/supplier');
    }
    
    function all_get() {
        $list = $this->supplier->get_all();
        $this->response($list);
    }
    
    function add_post() {
        $data = (object) $this->post();
        
        $exists = $this->supplier->get_by(array('CoyName'=>$data->CoyName));
        
        if($exists) {
            $response = array(
                'status' => false,
                'message' => 'Supplier already exists!');
        }else{
            $id = $this->supplier->insert($this->post());
            $data = $this->supplier->get_by(array('SuppID'=>$id));    
            $response = array(
                'status' => true,
                'message' => 'Supplier has been added successfully!',
                'data' => $data
            );
        }  $this->response($response);
    }
    
    function update_post() {
        $this->supplier->update($this->post('SuppID'), $this->post('type'));
        $this->response(array('message'=>'Record has been successfully update'));
    }
    
}