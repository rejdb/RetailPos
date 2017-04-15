<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    
    protected $_table = 'md_items';
    protected $primary_key = 'PID';
    protected $return_type = 'array';

    protected $after_get = array();
    protected $before_create = array();
    
    function getTableLinks() {
        $brands = $this->db->get('ref_item_brand')->result_array();
        $categories = $this->db->get('ref_item_category')->result_array();
        $cycles = $this->db->get('ref_item_cycle')->result_array();
        $families = $this->db->get('ref_item_family')->result_array();
        $types = $this->db->get('ref_item_type')->result_array();
        $pricelists = $this->db->get('stp_item_pricelist')->result_array();
        
        $links = array_merge(
            array('brands'=>$brands),
            array('categories'=>$categories),
            array('cycles'=>$cycles),
            array('families'=>$families),
            array('types'=>$types),
            array('pricelists'=>$pricelists)
        );
        return $links;
    }
    
    function get_all() {
        return $this->db->get('view_items')->result_array();
    }
    
    function by_filter($param) {
        $this->db->where($param);
        $response = $this->db->get('view_items')->result_array();
        if($response) {
            $message = array(
                'status' => true,
                'data'=> $response
            );
        }else{
            $message = array(
                'status' => false,
                'message' => 'No Item Found'
            );
        }
        return $message;
    }
    
    function ref_filter($param, $table) {
        $this->db->where($param);
        return $this->db->get($table)->result_array();
    }
    
    function add_reference($table, $data) {
        $this->db->insert($table, $data);
        return 'Reference has been successfully added!';
    }
    
    function insert_item_to_pricelist($table, $data) {
        $this->db->insert($table, $data);
        $lastId = $this->db->insert_id();
        
        $pid = $this->db->query('select PID,' . $lastId .' as "PLID" from md_items')->result_array();
        $this->db->insert_batch('stp_item_pricedetails', $pid);
        return 'Pricelist has been created successfully!';
    }
    
    function insert_pricelist($id,$price) {
        $this->db->trans_start();
            $plid = $this->db->query("select PLID,".$id." as PID,".$price." as Price from stp_item_pricelist")->result_array();
            if($plid) {
                $this->db->insert_batch('stp_item_pricedetails', $plid);
            }
        $this->db->trans_complete();
        
        if($this->db->trans_status()) {
            $message = array('success'=>true, 'message'=>'Item and Pricelist has been successfully created!');
        }else{
            $message = array('success'=>false, 'message'=>'Failed to create pricelist!');
        }
        return $message;
    }
    
    function updatePrice($id, $price) {
        $this->db->update('stp_item_pricedetails', $price, array('PDID'=>$id));
    }
    
    function addCampaign($title, $branches, $items) {
        $exists = $this->db->where(array('CampaignName'=>$title['CampaignName']))->get('md_campaign')->result_array();
        
        if($exists) {
            $message = array('success'=>false, 'message'=>'Campaign Name already Exists!');
        }else{
            $this->db->insert('md_campaign', $title);
            $id = $this->db->insert_id();
            
            $insertBrn = array();
            foreach($branches as $v) {
                array_push($insertBrn,array('CampaignID'=>$id,'BranchID'=>$v));}

            $insertItm = array();
            foreach($items as $k) {
                array_push($insertItm,array('CampaignID'=>$id, 'PID'=>(int)$k['PID'], 'SRP'=>$k['SRP']));}   
            
            $this->db->insert_batch('stp_campaign_branch', $insertBrn);
            $this->db->insert_batch('stp_campaign_item', $insertItm);
            
            $message = array('success'=>true, 'message'=>'Campaign has been successfully added!');
        }
        
        return $message;
    }
    
    //Gel All existing Campaign
    function getAllCampaign() {
        $data = array();
        $headers = $this->db->where('IsActive',1)->get('md_campaign')->result_object();
        
        foreach($headers as $header) {
            $stores = $this->db->where(array('CampaignID'=>$header->CampaignID))->select('BranchID')->get('stp_campaign_branch')->result_object();
            $products = $this->db->where(array('CampaignID'=>$header->CampaignID))->select('PID,SRP')->get('stp_campaign_item')->result_object();
            
            $strid = array();
            foreach($stores as $val) {
                array_push($strid, $val->BranchID);
            }
            
            array_push($data, array(
                'CampaignID' => $header->CampaignID,
                'CampaignName' => $header->CampaignName,
                'DateFrom' => $header->DateFrom,
                'DateTo' => $header->DateTo,
                'Stores' => $strid,
                'Products' => $products
            ));
        }
        return $data;
    }
    
    //Delete a campaign
    function deleteCampaign($CampaignID) {
        $this->db->trans_start();
            $this->db->update('md_campaign',array('IsActive'=>0), array('CampaignID'=>$CampaignID));
//            $this->db->delete('md_campaign', array('CampaignID'=>$CampaignID));
//            $this->db->delete('stp_campaign_branch', array('CampaignID'=>$CampaignID));
//            $this->db->delete('stp_campaign_item', array('CampaignID'=>$CampaignID));
        $this->db->trans_complete();
        
        if($this->db->trans_status() == true) {
            $message = array('success'=>true, 'message'=>'Campaign has been successfully deleted!');
        }else{
            $message = array('success'=>false, 'message'=>'Failed to delete campaign!');
        }
        return $message;
    }
}?>