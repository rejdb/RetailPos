<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Items extends REST_Controller {

    function __construct() {
        parent:: __construct();
        date_default_timezone_set('Asia/Manila');
        $this->load->Model('api/item');
    }
    
    //get all products
    function all_get() {
        $all = $this->item->get_all();
        $this->response($all);
    }
    
    //get all links to Item reference table
    function links_get(){
        $links = $this->item->getTableLinks();
        $this->response($links);
    }
    
    //get products by status
    function active_get($IsActive) {
        $all = $this->item->by_filter(array('IsActive'=>$IsActive));
        $this->response($all);
    }
    
    //search Item table by any parameter
    function search_post() {
        $search = $this->item->by_filter($this->post());
        $this->response($search);
    }
    
    //Update Item Master Data
    function update_post() {
        $this->item->update($this->post('PID'), $this->post('type'));
        $this->response(array('message'=>'Item has been successfully updated!'));
    }
    
    //add entry to Items reference table
    function addReference_post() {
        $table = $this->post('table');
        $data = $this->post('data');
        
        $exists = $this->item->ref_filter($data,$table);
        if($exists) {
            $message = 'Data already exists!';
        }else{
            if($table=='stp_item_pricelist') {
                $message = $this->item->insert_item_to_pricelist($table, $data);
            }else{
                $message = $this->item->add_reference($table, $data);
            }
        }
        $this->response(array('message'=>$message));
    }
    
    //Add new product to the database
    function addNewProduct_post() {
        $data = $this->post('product');
        $price = $this->post('price');
        
        $existsBarCode = $this->item->get_by(array('BarCode'=>trim($data['BarCode'])));
        $existsDesc = $this->item->get_by(array('ProductDesc'=>trim($data['ProductDesc'])));
        
        if($existsBarCode || $existsDesc) {
            $message = array('success'=>false, 'message'=> 'Bar Code or Description already exists! Please Check.');
        }else{
            $id = $this->item->insert($data);
            $message = $this->item->insert_pricelist($id, $price);
        }
        $this->response($message);
    }
    
    //Update price detail table
    function updatePrice_post() {
        $id = $this->post('PDID');
        $data = $this->post('type');
        
        $this->item->updatePrice($id, $data);
        $this->response(array('message'=>'Price has been changed!'));
    }
    
    //Add new campaign to database
    function addCampaign_post() {
        $title = $this->post('title');
        $campaign = array(
            'CampaignName' => $title['CampaignName'],
            'DateFrom' => date('Y-m-d', strtotime(str_replace('-','/',$title['DateFrom']))),
            'DateTo' => date('Y-m-d', strtotime(str_replace('-','/',$title['DateTo'])))
        );
        $branches = $this->post('BranchID');
        $items = $this->post('products');
        
        $rsp = $this->item->addCampaign($campaign,$branches,$items);
        
        $this->response($rsp);
    }
    
    //Get all campaign List
    function getCampaign_get() {
        $list = $this->item->getAllCampaign();
        $this->response($list);
    }
    
    //Delete a campaign
    function deleteCampaign_get($CampaignID) {
        $message = $this->item->deleteCampaign($CampaignID);
        return $message;
    }
}?>