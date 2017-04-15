<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Inventories extends REST_Controller {

    function __construct() {
        parent:: __construct();
        date_default_timezone_set('Asia/Manila');
        $this->load->Model('api/inventory');
    }
    
    function index_post() {
//        $params = $this->post('params');
        $data = $this->post();
        
        $exists = $this->inventory->get_by(array(
            'Branch' => $data['Branch'],
            'Warehouse' => $data['Warehouse'],
            'Product' => $data['Product']
        ));
        
        $this->db->trans_start();
            if($exists) {
                $AddStocks = $exists['InStocks'] + $data['InStocks'];
                $this->inventory->update($exists['InvID'], array('InStocks'=>$AddStocks));
            }else{
                $this->inventory->insert($data);
            }
        $this->db->trans_complete();
        if($this->db->trans_status()) {
            $message = array('status'=>true, 'message'=>'Inventory has been saved!');
        }else{
            $message = array('status'=>false, 'message'=>'Cant save inventory, please check!');
        } $this->response($message);
    }
    
    function CheckInventory_post() {
        $checkQty = $this->inventory->get_by(array(
            'Branch' => $data['Branch'],
            'Warehouse' => $data['Warehouse'],
            'Product' => $data['Product']
        ));
        
        if($checkQty) {
            if($data['Quantity'] > $checkQty['Available']) {
                $message = array('status'=>false, 'message'=>'Quantity exceed Available Quantity!');
            }else{
                $message = array('status'=>true, 'message'=>'You have enough quantity!');
            }
        }else{
            $message = array('status'=>false, 'message'=>'No Inventory Found!');
        }
        
        $this->response($message);
    }
    
    //Get all Inventory Warehouse
    function warehouse_get() {
        $whs = $this->inventory->getWarehouse();
        $this->response($whs);
    }
    
    function activeWhs_get($status) {
        $whs = $this->inventory->getActiveWsh($status);
        $this->response($whs);
    }
    
    //Add new Warehouse
    function addWarehouse_post() {
        $msg = $this->inventory->addWarehouse($this->post());
        $this->response($msg);
    }
    
    function updateWarehouse_post() {
        $msg = $this->inventory->updateWarehouse($this->post());
        $this->response($msg);
    }
    
    //Get all BoM
    function allBoM_get() {
        $BoM = $this->inventory->BoM();
        $this->response($BoM);
    }
    
    //Add New BoM
    function InsertBoM_post() {
        $message = $this->inventory->InsertBoM($this->post());
        $this->response($message);
    }
    
    //Update BoM Fields
    function updateBoM_post($type) {
        $response = $this->inventory->updateBoM($type, $this->post());
        $this->response($response);
    }
    
    function CheckSerial_get($serial) {
        $check = $this->inventory->Check_Serial($serial);
        $this->response(array('status'=>$check));
    }
    
    // Add/Remove Serial to Serial Table
    function InsertRemoveSerial_post() {
        $response = $this->inventory->Insert_Serial($this->post());
//        $this->response($this->post());
        $this->response($response);
    }
    
    // Search for Inventory
    function SearchInventory_post() {
        $field = $this->post();
        $response = $this->inventory->SearchInventory($field);
        $this->response($response);
    }
    
    function smr_post() {
        $smr = $this->inventory->getSmr($this->post());
        $this->response($smr);
//        $this->response($this->post());
    }
}?>