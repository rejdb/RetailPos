<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    
    protected $_table = 'md_inventory';
    protected $primary_key = 'InvID';
    protected $return_type = 'array';

    protected $after_get = array();
    protected $before_create = array();
    
    function add_inventory($data) {
        $exists = $this->get_by(array(
            'Branch' => $data['Branch'],
            'Warehouse' => $data['Warehouse'],
            'Product' => $data['Product']
        ));
        
        $this->db->trans_start();
            if($exists) {
                $AddCommitted = $exists['Committed'] + $data['Committed'];
                $AddStocks = $exists['InStocks'] + $data['InStocks'];
                $this->update($exists['InvID'], array('InStocks'=>$AddStocks, 'Committed'=>$AddCommitted));
            }else{
                $this->insert($data);
            }
        $this->db->trans_complete();
        if($this->db->trans_status()) {
            $message = array('status'=>true, 'message'=>'Inventory has been saved!');
        }else{
            $message = array('status'=>false, 'message'=>'Cant save inventory, please check!');
        } return $message;
    }
    
    function getWarehouse() {
        return $this->db->get('md_warehouses')->result_array();
    }
    
    function getActiveWsh($status) {
        return $this->db->where('IsActive',$status)->get('md_warehouses')->result_array();
    }
    
    function addWarehouse($data) {
        $exists = $this->db->where($data)->get('md_warehouses')->result_array();
        if($exists) {
            $message = array('status'=>false,'message'=>'Warehouse already exists!');
        }else{
            $this->db->insert('md_warehouses', $data);
            $message = array('status'=>true,'message'=>'New Warehouse has been added!');
        }
        
        return $message;
    }
    
    function updateWarehouse($data) {
        $WhsName = isset($data['type']['WhsName']);
        $arr = (array)$data['type'];
        
        if($WhsName) {
            $exists = $this->db->where($arr)->get('md_warehouses')->result_array();
            if(!$exists) {
                $this->db->update('md_warehouses', $data['type'], array('WhsCode'=>$data['WhsCode']));
                return true;
            }else{
                return 'Already Exists!';
            }
        }else{
            $this->db->update('md_warehouses', $data['type'], array('WhsCode'=>$data['WhsCode']));
            return true;
        }
//        return $data;
    }
    
    function BoM() {
        $BoM = $this->db->where('IsActive',1)->get('md_bom')->result_object();
        
        $BoM_list = array();
        foreach($BoM as $key => $val) {
            $pids = $this->db->where(array('BoMID'=>$val->BoMID))->get('stp_bom_item')->result_object();
            array_push($BoM_list, array(
                'BoMID' => (int)$val->BoMID,
                'BoMBarCode' => $val->BoMBarCode,
                'BoMName' => $val->BoMName,
                'BoMCost' => $val->BoMCost,
                'BoMSRP' => $val->BoMSRP,
                'IsActive' => $val->IsActive,
                'BoMProducts' => $pids
            ));
        }    
        return $BoM_list;
    }
    
    function InsertBoM($data) {
        $BoM = (object) $data['bom'];
        $PrD = (object) $data['Products'];
        
        $exists = $this->db->where('BoMName', $BoM->BoMName)->get('md_bom')->result_object();
        $existsBarCode = $this->db->where('BoMBarCode', $BoM->BoMBarCode)->get('md_bom')->result_object();
        if($exists || $existsBarCode) {
            $response = array(
                'status'=>false,
                'message'=>'BoM Barcode or Name already exists! Please think of other name.'
            );
        }else{
            $this->db->insert('md_bom',$BoM);
            $id = $this->db->insert_id();
            
            $iPrD = array();
            foreach($PrD as $key => $val) {
                array_push($iPrD, array(
                    'BoMID' => $id,
                    'PID' => (int)$val['PID'],
                    'WhsCode' => (int)$val['WhsCode']
                ));
            }
            
            $this->db->insert_batch('stp_bom_item',$iPrD);  
            $response = array(
                'status'=>true,
                'message'=>'New BoM has been added successfully!'
            );
        }
        
        return $response;
    }
    
    function updateBoM($type, $data) {
        $this->db->trans_start();
        if($type=='Main') {
            $this->db->update('md_bom', $data['type'], array('BoMID'=>$data['BoMID']));
        }else{
            $this->db->update('stp_bom_item', $data['type'], array('BoMSID'=>$data['BoMSID']));
        } $this->db->trans_complete();
        
        if($this->db->trans_status() == true) {
            $message = array('status'=>true, 'message'=>'Bom has been successfully updated!');
        }else{
            $message = array('status'=>false, 'message'=>'Failed to update BoM!');
        }
        
        return $message;
    }
    
    function Check_Serial($serial) {
        $exists = $this->db->where('Serial', $serial)->get('md_inventory_serials')->result_array();
        if($exists) { return true; }else{ return false; }
    }
    
    function Insert_Serial($data) {
        $type = $data['type'];
        $field = $data['datas'];
        
        if($type=='true') {
            $check = $this->Check_Serial($field['Serial']);
            if(!$check) {
                $this->db->insert('md_inventory_serials', $field);
                $message = array('status'=>true, 'message'=>'Serial has been added Successfully!');
            }else{
                $message = array('status'=>false, 'message'=>'Serial Exists');
            }
        }else{
            $exists = $this->db->where('Serial', $field['Serial'])->get('md_inventory_serials')->first_row();
            if($exists->IsSold != 0) {
                $message = array('status'=>false, 'message'=>'Serial has been used, it cannot be removed!');
            }else{
                $this->db->delete('md_inventory_serials', array('Serial'=>$field['Serial']));
                $message = array('status'=>true, 'message'=>'Serial has been removed Successfully!');
            }
        }
        
        return $message; 
    }
    
    function SearchInventory($field) {
        $search = array('Serial' => $field['Search']);
        $serial = $this->db->where($search)->get('md_inventory_serials')->first_row();
        if($serial) {
            /*** Serial Validation Goes Here ***/
            if($serial->IsSold == 0) {
                if($serial->Branch == $field['Branch'] && $serial->Warehouse == $field['Warehouse']) {
                    $find = array('Branch'=>$field['Branch'],'Warehouse'=>$field['Warehouse'], 'Product'=>$serial->Product);
//                    $find = array('Branch'=>$field['Branch'], 'Product'=>$serial->Product);
                    $lookForCampaign = '("' . date('Y-m-d') . '" between DateFrom and DateTo) and BranchID=' . $field['Branch'] . ' and IsActive=1 and PID=' . $serial->Product;
                    $cmp = $this->db->where($lookForCampaign)->order_by('CampaignID','DESC')->get('view_campaign')->first_row();
                    $campaign = ($cmp) ? array('status'=>true, 'name'=>$cmp->CampaignName, 'price'=>$cmp->SRP) : array('status'=>false);
                    $SerialFound = (array)$this->db->where($find)->get('view_inventory')->first_row();
                    $result = array_merge($SerialFound, array('InvSerID'=>$serial->InvSerID,'Serial'=>$serial->Serial));
                    $message = array('status'=>true, 'result'=>$result, 'campaign'=>$campaign);
                }else{
                    $message = array('status'=>false, 'message'=>'Serial not found on source branch and warehouse!');
                }
            }else{
                $message = array('status'=>false, 'message'=>'Serial found but already sold!');
            }
        }else{
            $item = $this->db->where(array('BarCode'=>$field['Search']))->get('md_items')->first_row();
            if($item) {
                /*** Item Exists validation Goes Here ***/
                if($item->IsSerialized==0) {
                    $find = array('Warehouse'=>$field['Warehouse'], 'Branch'=>$field['Branch'], 'Product'=>$item->PID);
                    $lookForCampaign = '("' . date('Y-m-d') . '" between DateFrom and DateTo) and BranchID=' . $field['Branch'] . ' and IsActive=1 and PID=' . $item->PID;
                    $cmp = $this->db->where($lookForCampaign)->order_by('CampaignID','DESC')->get('view_campaign')->first_row();
                    $campaign = ($cmp) ? array('status'=>true, 'name'=>$cmp->CampaignName, 'price'=>$cmp->SRP) : array('status'=>false);
                    $ItemFound = (array)$this->db->where($find)->get('view_inventory')->first_row();
                    
                    if($ItemFound && $ItemFound['Available']>0) {
                        $result = array_merge($ItemFound, array('InvSerID'=>'','Serial'=>''));
                        $message = array('status'=>true, 'result'=>$result, 'campaign'=>$campaign);
                    }else{
                        $message = array('status'=>false, 'message'=>'No enough Inventory!');
                    }
                }else{
                    $message = array('status'=>false, 'message'=>'Item is Serialized. Check for Serial!');
                }
            }else{
                $message = array('status'=>false, 'message'=>'Item Not Found!');
            }
        } return $message;
    }
    
    function getSmr($data) {
        $dateFrom = $data['DateFrom'];
        $dateTo = $data['DateTo'];
        
        $smr = $this->db->query('call Report_SRM("' . $dateFrom . '","' .$dateTo .'")')->result_array();
        return $smr;
    }
}?>