<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends MY_Model {
    function __construct() {
        parent::__construct();
        $this->load->Model('api/inventory');
    }
    
    protected $_table = 'md_inventory';
    protected $primary_key = 'InvID';
    protected $return_type = 'array';

    protected $after_get = array();
    protected $before_create = array();
    
    function filter($field) {
        $params = $field['params'];
        $table = $field['table'];
        
        $this->db->where($params);
        return $this->db->get($table);
    }
    
    function MainPage($store) {
        $transfer = $this->filter(array('params'=>array('InvTo'=>$store, 'TransferType'=>0, 'Status'=>2), 'table'=>'trx_transfer'))->result_array();
        $pullout = $this->filter(array('params'=>array('Branch'=>$store, 'Status'=>2), 'table'=>'trx_pullout'))->result_array();
        $TransferApproval = $this->filter(array('params'=>array('Status'=>1), 'table'=>'trx_transfer'))->result_array();
        $PulloutApproval = $this->filter(array('params'=>array('Status'=>1), 'table'=>'trx_pullout'))->result_array();
        $Postpaid = $this->filter(array('params'=>'Status=1 and Branch = "' .$store.'" and (DepositSlip is null or DepositSlip="")', 'table'=>'trx_sales_postpaid'))->result_array();
            
        return array(
            'transfer' => count($transfer),
            'pullout' => count($pullout),
            'postpaid' => count($Postpaid),
            'approval' => array(
                'transfer' => count($TransferApproval),
                'pullout' => count($PulloutApproval),
                'total' => count($TransferApproval) + count($PulloutApproval)
            )
        );
    }
    
    function tbl_smr($data) {
        $this->db->trans_start();
            $this->db->insert_batch('trx_stocks_movement', $data);
        $this->db->trans_complete();
        if($this->db->trans_status()==true) {
            return array('status'=>true,'message'=>'Save successful!');
        }else{
            return array('status'=>false,'message'=>'Save unsuccessful!');
        }
    }
    
    function tbl_Update($field) {
        $id = $field['id'];
        $fld = $field['fields'];
        $table = $field['table'];
        
        $this->db->update($table, $fld, $id);
        return array('status'=>true,'message'=>'Update successful!');
    }

    function filter_purchase($param) {
        $this->db->where($param);
        return $this->db->get('view_purchase');
    }
    
    function filter_purchase_row($param) {
        $this->db->where($param);
        return $this->db->get('view_purchase_row');
    }
    
    function Purchase_Receipt($transid) {
        $header = $this->filter_purchase(array('TransID'=>$transid))->first_row();
        $rows = $this->filter_purchase_row(array('TransID'=>$transid))->result_array();
        
        return array('header'=>$header, 'rows'=>$rows);
    }
    
    function Purchase_Update($field) {
        $id = $field['id'];
        $fld = $field['fields'];
        $table = $field['table'];
        
        $this->db->update($table, $fld, $id);
        return array('status'=>true,'message'=>'Update successful!');
    }

    function Insert_Purchase($header, $rows) {
        $exists = $this->filter_purchase(array('TransID'=>$header['TransID']))->result_array();
        $po_number = $this->filter_purchase(array('PONumber'=>$header['PONumber'],'ShipToBranch'=>$header['ShipToBranch']))->result_array();
        if($exists) {
            $message = array('status'=>false, 'message'=>'Transaction already exists');
        }else if($po_number) {
            $message = array('status'=>false, 'message'=>'Duplicate PO Number! Check your records!');
        }else{
            $irows = array(); $smr = array();
            foreach($rows as $row => $val) {
                array_push($irows, array(
                    'TransID' => $header['TransID'],
                    'ProductID' => $val['PID'],
                    'Warehouse' => $val['Warehouse'],
                    'Cost' => $val['StdCost'],
                    'InputVat' => $val['InputVat'],
                    'Quantity' => $val['Quantity'],
                    'Total' => $val['Total'],
                    'GTotal' => $val['GTotal']
                ));
                
            }
            
            $this->db->trans_start();
                $this->db->insert('trx_purchase', $header);
                $this->db->insert_batch('trx_purchase_row', $irows);
            $this->db->trans_complete();
            if($this->db->trans_status()==true) {
                $message = array('status'=>true, 'message'=>'Purchase order has been send!');
            }else{
                $message = array('status'=>false, 'message'=>'Database error: Can\'t save your record!');
            }
        } return $message;
    }
    
    function Insert_Purchase_Serial($data) {
        $this->db->delete('trx_purchase_detail', array('PurRowID'=>$data['PurRowID']));
        if(count($data['data'])) {
            $this->db->insert_batch('trx_purchase_detail', $data['data']);
        }
    }
    
    /**** Receiving Module ******************/
    
    function Insert_Receiving($header, $rows) {
        $exists = $this->filter(array(
            'params'=>array('TransID'=>$header['TransID']),
            'table'=>'trx_receiving'))->result_array();
        $invoice_number = $this->filter(array(
            'params' => array(
                'InvoiceNo' => $header['InvoiceNo'],
                'Branch' => $header['Branch']),
            'table'=>'trx_receiving'))->result_array();
        
        if($exists) {
            $message = array('status'=>false, 'message'=>'Transaction already exists');
        }
        else if($invoice_number) {
            $message = array('status'=>false, 'message'=>'Duplicate Invoice Number! Check your records!');
        }else{
            $this->db->trans_start();
                $iser = array(); $smr = array();
                foreach($rows as $row => $val) {
                    $irows = array(
                        'TransID' => $header['TransID'],
                        'ProductID' => $val['PID'],
                        'Warehouse' => $val['Warehouse'],
                        'Cost' => $val['StdCost'],
                        'InputVat' => $val['InputVat'],
                        'Quantity' => $val['Quantity'],
                        'Total' => $val['Total'],
                        'GTotal' => $val['GTotal']
                    );
                    
                    $this->db->insert('trx_receiving_row', $irows);
                    $id = $this->db->insert_id();
                    
                    /* Add Quantity to Inventory */
                    $inventory = array(
                        'Branch' => $header['Branch'],
                        'Product' => $val['PID'],
                        'Warehouse' => $val['Warehouse'],
                        'Committed' => 0,
                        'InStocks' => $val['Quantity']
                    );
                    
                    $this->inventory->add_inventory($inventory);

                    /*** Serial Insert if available ***/
                    if((int)$val['IsSerialized'] == 1) {
                        foreach($val['Serials'] as $serial => $ser) {
                            array_push($iser, array(
                                'RcvRowID' => $id,
                                'Serial' => $ser['Serial']
                            ));
                            
                            array_push($smr, array(
                                'TransID' => $header['TransID'],
                                'Date' => $header['TransDate'],
                                'RefNo' => $header['InvoiceNo'],
                                'Module' => '/stocks',
                                'TransType' => '/receiving',
                                'Product' => $val['PID'],
                                'Warehouse' => $val['Warehouse'],
                                'Branch' => $header['Branch'],
                                'Serial' => $ser['Serial'],
                                'MoveIn' => 1,
                                'MoveOut' => 0,
                            ));
                            
                            $this->inventory->Insert_Serial(array(
                                'type' => true,
                                'datas' => array(
                                    'Product' => $val['PID'],
                                    'Warehouse' => $val['Warehouse'],
                                    'Branch' => $header['Branch'],
                                    'Serial' => $ser['Serial']
                                )
                            ));
                        }
                    }else{
                        array_push($smr, array(
                            'TransID' => $header['TransID'],
                            'Date' => $header['TransDate'],
                            'RefNo' => $header['InvoiceNo'],
                            'Module' => '/stocks',
                            'TransType' => '/receiving',
                            'Product' => $val['PID'],
                            'Warehouse' => $val['Warehouse'],
                            'Branch' => $header['Branch'],
                            'Serial' => '',
                            'MoveIn' => $val['Quantity'],
                            'MoveOut' => 0,
                        ));
                    }
                }
            
            
                $this->db->insert('trx_receiving', $header);
                if(count($iser)>0) {
                    $this->db->insert_batch('trx_receiving_detail', $iser); }
                $this->tbl_smr($smr);
            $this->db->trans_complete();
            if($this->db->trans_status()==true) {
                $message = array('status'=>true, 'message'=>'Receiving transaction has been saved!');
            }else{
                $message = array('status'=>false, 'message'=>'Database error: Can\'t save your record!');
            }
        } return $message;
    }
    
    function Receiving_Receipt($transid) {
        $header = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_receiving'))->first_row();
        $rows = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_receiving_row'))->result_array();
        
        return array('header'=>$header, 'rows'=>$rows);
    }
    
    /***** End of Receiving *****/
    
    /***** Start of Transfer *****/
    function Insert_Transfer($header, $rows) {
        $exists = $this->filter(array(
            'params'=>array('TransID'=>$header['TransID']),
            'table'=>'trx_transfer'))->result_array();
//        $exists = $this->filter_purchase(array('TransID'=>$header['TransID']))->result_array();
//        $invoice_number = $this->filter_purchase(array('PONumber'=>$header['PONumber'],'ShipToBranch'=>$header['ShipToBranch']))->result_array();
        $transfer_number = $this->filter(array(
            'params' => array(
                'TransferNo' => $header['TransferNo'],
                'Branch' => $header['Branch']),
            'table'=>'trx_transfer'))->result_array();
        
        if($exists) {
            $message = array('status'=>false, 'message'=>'Transaction already exists');
        }else if($transfer_number) {
            $message = array('status'=>false, 'message'=>'Duplicate Transfer Number! Check your records!');
        }else{
            $this->db->trans_start();
                $iser = array();
                $irows = array();
                foreach($rows as $row => $val) {
                    array_push($irows, array(
                        'TransID' => $header['TransID'],
                        'ProductID' => $val['PID'],
                        'Warehouse' => $val['Warehouse'],
                        'Cost' => $val['StdCost'],
                        'Quantity' => $val['Quantity'],
                        'Total' => $val['Total'],
                        'Serial' => $val['Serials']
                    ));
                    
                    /* Add Quantity to Inventory */
                    $inventory = array(
                        'Branch' => $header['Branch'],
                        'Product' => $val['PID'],
                        'Warehouse' => $val['Warehouse'],
                        'Committed' => $val['Quantity'],
                        'InStocks' => 0
                    );
                    
                    $inv = $this->inventory->add_inventory($inventory);

                    /*** Serial update if available ***/
                    array_push($iser, array(
                        'InvSerID' => $val['InvSerID'],
                        'IsSold' => 2
                    ));
                }
            
            
                $this->db->insert('trx_transfer', $header);
                $this->db->insert_batch('trx_transfer_row', $irows);
                $this->db->update_batch('md_inventory_serials', $iser, 'InvSerID');
            $this->db->trans_complete();
            if($this->db->trans_status()==true) {
                $message = array('status'=>true, 'message'=>'Transfer transaction has been send for approval!');
            }else{
                $message = array('status'=>false, 'message'=>'Database error: Can\'t save your record!');
            }
        } return $message;
    }
    
    function Transfer_Receipt($transid) {
        $header = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_transfer'))->first_row();
        $rows = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_transfer_row'))->result_array();
        
        return array('header'=>$header, 'rows'=>$rows);
    }
    
    function ChangeTransferStatus($data) {
        $type = $data['type'];
        $TransID = $data['TransID'];
        $NewTransID = $data['NewID'];
        $Approver = $data['Approver'];
        
        $obj = $this;
        
        $hdr = $this->filter(array('params'=>array('TransID'=>$TransID), 'table'=>'trx_transfer'))->first_row();
        $rows = $this->filter(array('params'=>array('TransID'=>$TransID), 'table'=>'trx_transfer_row'))->result_array();
        
        if($hdr && $rows) { $iser = array(); $smr = array();
                           
            if($type==4 && $hdr->Status!='4') { 
                $this->db->update('trx_transfer', array('Status'=>$type, 'Approver'=>$Approver),array('TransID'=>$TransID));
                foreach($rows as $row => $v) {
                    $r = array(
                        'Branch' => (int)$hdr->Branch,
                        'Warehouse' => (int)$v['Warehouse'],
                        'Product' => (int)$v['ProductID'],
                        'InStocks' => 0,
                        'Committed' => $v['Quantity'] * -1
                    ); $this->inventory->add_inventory($r);
                    
                    /*** Serial update if available ***/
                    if($v['Serial']) {
                        array_push($iser, array(
                            'Serial' => $v['Serial'],
                            'IsSold' => 0,
                        )); 
                    }
                }
                if(count($iser)>0) {
                    $this->db->update_batch('md_inventory_serials', $iser, 'Serial'); }
                return array('status'=>true, 'message'=>'Transfer has been successfully canceled!');
            }else if($type==2 && $hdr->Status=='1') {
                if($hdr->TransferType==1) {
                    foreach($rows as $row => $v) {
                        $r = array(
                            'Branch' => (int)$hdr->Branch,
                            'Warehouse' => (int)$v['Warehouse'],
                            'Product' => (int)$v['ProductID'],
                            'InStocks' => $v['Quantity'] * -1,
                            'Committed' => $v['Quantity'] * -1);
                        
                        $nr = array(
                            'Branch' => (int)$hdr->Branch,
                            'Warehouse' => (int)$hdr->InvTo,
                            'Product' => (int)$v['ProductID'],
                            'InStocks' => $v['Quantity'],
                            'Committed' => 0);
                        
                        /* Inventory Trasfer Out From OriginWhs - SMR */
                        array_push($smr, array(
                            'TransID' => $hdr->TransID,
                            'Date' => $hdr->TransDate,
                            'RefNo' => $hdr->TransferNo,
                            'Module' => '/stocks',
                            'TransType' => '/transfer',
                            'Product' => (int)$v['ProductID'],
                            'Warehouse' => (int)$v['Warehouse'],
                            'Branch' => $hdr->Branch,
                            'Serial' => $v['Serial'],
                            'MoveIn' => 0,
                            'MoveOut' => $v['Quantity']));
                        
                        /* Inventory Trasfer In To DestiWhs - SMR */
                        array_push($smr, array(
                            'TransID' => $hdr->TransID,
                            'Date' => $hdr->TransDate,
                            'RefNo' => $hdr->TransferNo,
                            'Module' => '/stocks',
                            'TransType' => '/transfer',
                            'Product' => (int)$v['ProductID'],
                            'Warehouse' => (int)$hdr->InvTo,
                            'Branch' => $hdr->Branch,
                            'Serial' => $v['Serial'],
                            'MoveIn' => $v['Quantity'],
                            'MoveOut' => 0));

                        $this->inventory->add_inventory($r);
                        $this->inventory->add_inventory($nr);

                        /*** Serial update if available ***/
                        if($v['Serial']) {
                            array_push($iser, array(
                                'Serial' => $v['Serial'],
                                'IsSold' => 0,
                                'Warehouse' => $hdr->InvTo
                            )); 
                        }
                    }
                    if(count($iser)>0) {
                        $this->db->update_batch('md_inventory_serials', $iser, 'Serial'); }
                    $this->db->update('trx_transfer', array('Status'=>3, 'Approver'=>$Approver,'Receiver'=>$Approver),array('TransID'=>$TransID));
                    $this->tbl_smr($smr);
                    return array('status'=>true, 'message'=>'Transfer has been approved!');
                }else{
                    $this->db->update('trx_transfer', array('Status'=>$type, 'Approver'=>$Approver),array('TransID'=>$TransID));
                    return array('status'=>true, 'message'=>'Transfer has been approved!');
                }
            }else if($type==3 && $hdr->Status=='2') {
                $new_rows = array();
                $header = array(
                    'TransID' => $NewTransID,
                    'TransferNo' => $hdr->TransferNo,
                    'TransDate' => date('Y-m-d'),
                    'Branch' => (int)$hdr->InvTo,
                    'InvFrom' => (int)$hdr->InvFrom,
                    'InvTo' => (int)$hdr->InvTo,
                    'Quantity' => (int)$hdr->Quantity,
                    'Total' => $hdr->Total,
                    'TransferType' => (int)$hdr->TransferType,
                    'Status' => 3,
                    'Comments' => $hdr->Comments,
                    'CreatedBy' => (int)$hdr->CreatedBy,
                    'Approver' => (int)$hdr->Approver,
                    'Receiver' => (int)$Approver
                );
                foreach($rows as $row => $v) {
                    $r = array(
                        'Branch' => (int)$hdr->Branch,
                        'Warehouse' => (int)$v['Warehouse'],
                        'Product' => (int)$v['ProductID'],
                        'InStocks' => $v['Quantity'] * -1,
                        'Committed' => $v['Quantity'] * -1);

                    $nr = array(
                        'Branch' => (int)$hdr->InvTo,
                        'Warehouse' => (int)$v['Warehouse'],
                        'Product' => (int)$v['ProductID'],
                        'InStocks' => $v['Quantity'],
                        'Committed' => 0);

                    /* Inventory Trasfer Out From OriginBranch - SMR */
                    array_push($smr, array(
                        'TransID' => $hdr->TransID,
                        'Date' => $hdr->TransDate,
                        'RefNo' => $hdr->TransferNo,
                        'Module' => '/stocks',
                        'TransType' => '/transfer',
                        'Product' => (int)$v['ProductID'],
                        'Warehouse' => (int)$v['Warehouse'],
                        'Branch' => $hdr->Branch,
                        'Serial' => $v['Serial'],
                        'MoveIn' => 0,
                        'MoveOut' => $v['Quantity']));

                    /* Inventory Trasfer In To DestiBranch - SMR */
                    array_push($smr, array(
                        'TransID' => $NewTransID,
                        'Date' => $hdr->TransDate,
                        'RefNo' => $hdr->TransferNo,
                        'Module' => '/stocks',
                        'TransType' => '/transfer',
                        'Product' => (int)$v['ProductID'],
                        'Warehouse' => (int)$v['Warehouse'],
                        'Branch' => (int)$hdr->InvTo,
                        'Serial' => $v['Serial'],
                        'MoveIn' => $v['Quantity'],
                        'MoveOut' => 0));
                    
                    $this->inventory->add_inventory($r);
                    $this->inventory->add_inventory($nr);

                    /*** Serial update if available ***/
                    if($v['Serial']) {
                        array_push($iser, array(
                            'Serial' => $v['Serial'],
                            'IsSold' => 0,
                            'Branch' => $hdr->InvTo
                        )); 
                    }
                    
                    //Create Row Items for Receiving Store
                    array_push($new_rows, array(
                        'TransID' => $NewTransID,
                        'ProductID' => (int) $v['ProductID'],
                        'Warehouse' => (int) $v['Warehouse'],
                        'Cost' => $v['Cost'],
                        'Quantity' => (int)$v['Quantity'],
                        'Total' => $v['Total'],
                        'Serial' => $v['Serial']
                    ));
                }
                if(count($iser)>0) {
                    $this->db->update_batch('md_inventory_serials', $iser, 'Serial'); }
                $this->db->update('trx_transfer', array('Status'=>3, 'Receiver'=>$Approver),array('TransID'=>$TransID));
                $this->db->insert('trx_transfer', $header);
                $this->db->insert_batch('trx_transfer_row', $new_rows);
                $this->tbl_smr($smr);
                return array('status'=>true, 
                             'message'=>'Transfer has been received successfully!',
                            'result'=>array_merge($header, array('rows'=>$new_rows)));
            }else{
                return array('statsu'=>false, 'message'=>'Type not found or status was changed by another user!');
            }
        }else{
            return array('status'=>false,'message'=>'Transaction does not exists!');
        }
        
    }
    
    /*** End of Transfer ****/
    
    /*** Start of Pull Out Script ***/
    function Insert_Pullout($header, $rows) {
        $exists = $this->filter(array(
            'params'=>array('TransID'=>$header['TransID']),
            'table'=>'trx_pullout'))->result_array();
        $ref_number = $this->filter(array(
            'params' => array(
                'RefNo' => $header['RefNo'],
                'Branch' => $header['Branch']),
            'table'=>'trx_pullout'))->result_array();
        
        if($exists) {
            $message = array('status'=>false, 'message'=>'Transaction already exists');
        }else if($ref_number) {
            $message = array('status'=>false, 'message'=>'Duplicate Reference Number! Check your records!');
        }else{
            $this->db->trans_start();
                $iser = array();
                $irows = array();
                foreach($rows as $row => $val) {
                    array_push($irows, array(
                        'TransID' => $header['TransID'],
                        'ProductID' => $val['PID'],
                        'Warehouse' => $val['Warehouse'],
                        'Cost' => $val['StdCost'],
                        'Quantity' => $val['Quantity'],
                        'Total' => $val['Total'],
                        'Serial' => $val['Serials']
                    ));
                    
                    /* Add Quantity to Inventory */
                    $inventory = array(
                        'Branch' => $header['Branch'],
                        'Product' => $val['PID'],
                        'Warehouse' => $val['Warehouse'],
                        'Committed' => $val['Quantity'],
                        'InStocks' => 0
                    );
                    
                    $inv = $this->inventory->add_inventory($inventory);

                    /*** Serial update if available ***/
                    if($val['Serials']) {
                        array_push($iser, array(
                            'InvSerID' => $val['InvSerID'],
                            'IsSold' => 3
                        ));
                    }
                }
            
            
                $this->db->insert('trx_pullout', $header);
                $this->db->insert_batch('trx_pullout_row', $irows);
                if(count($iser)>0) {
                    $this->db->update_batch('md_inventory_serials', $iser, 'InvSerID');}
            $this->db->trans_complete();
            if($this->db->trans_status()==true) {
                $message = array('status'=>true, 'message'=>'Pullout transaction has been send for approval!');
            }else{
                $message = array('status'=>false, 'message'=>'Database error: Can\'t save your record!');
            }
        } return $message;
    }
    
    function Pullout_Receipt($transid) {
        $header = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_pullout'))->first_row();
        $rows = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_pullout_row'))->result_array();
        
        return array('header'=>$header, 'rows'=>$rows);
    }
    
    function ChangePulloutStatus($data) {
        $type = $data['type'];
        $TransID = $data['TransID'];
        $Approver = $data['Approver'];
        
        $hdr = $this->filter(array('params'=>array('TransID'=>$TransID), 'table'=>'trx_pullout'))->first_row();
        $rows = $this->filter(array('params'=>array('TransID'=>$TransID), 'table'=>'trx_pullout_row'))->result_array();
        
        if($hdr && $rows) { $iser = array(); $smr = array();
                           
            if($type==4 && $hdr->Status!='4') { 
                $this->db->update('trx_pullout', array('Status'=>$type, 'Approver'=>$Approver),array('TransID'=>$TransID));
                foreach($rows as $row => $v) {
                    $r = array(
                        'Branch' => (int)$hdr->Branch,
                        'Warehouse' => (int)$v['Warehouse'],
                        'Product' => (int)$v['ProductID'],
                        'InStocks' => 0,
                        'Committed' => $v['Quantity'] * -1
                    ); $this->inventory->add_inventory($r);
                    
                    /*** Serial update if available ***/
                    if($v['Serial']) {
                        array_push($iser, array(
                            'Serial' => $v['Serial'],
                            'IsSold' => 0,
                        )); 
                    }
                }
                if(count($iser)>0) {
                    $this->db->update_batch('md_inventory_serials', $iser, 'Serial'); }
                return array('status'=>true, 'message'=>'Pullout has been successfully canceled!');
            }else if($type==2) {
                $this->db->update('trx_pullout', array('Status'=>$type, 'Approver'=>$Approver),array('TransID'=>$TransID));
                return array('status'=>true, 'message'=>'Pullout has been approved!');
            }else if($type==3 && $hdr->Status=='2') {
                foreach($rows as $row => $v) {
                    $r = array(
                        'Branch' => (int)$hdr->Branch,
                        'Warehouse' => (int)$v['Warehouse'],
                        'Product' => (int)$v['ProductID'],
                        'InStocks' => $v['Quantity'] * -1,
                        'Committed' => $v['Quantity'] * -1
                    );
                    
                    /* Inventory Pull Out - SMR */
                    array_push($smr, array(
                        'TransID' => $hdr->TransID,
                        'Date' => $hdr->TransDate,
                        'RefNo' => $hdr->RefNo,
                        'Module' => '/stocks',
                        'TransType' => '/pullout',
                        'Product' => (int)$v['ProductID'],
                        'Warehouse' => (int)$v['Warehouse'],
                        'Branch' => (int)$hdr->Branch,
                        'Serial' => $v['Serial'],
                        'MoveIn' => 0,
                        'MoveOut' => $v['Quantity']));

                    $this->inventory->add_inventory($r);

                    /*** Serial delete if available ***/
                    if($v['Serial']) {
                        $this->db->delete('md_inventory_serials', array('Serial'=>$v['Serial']));
                    }
                }
                $this->db->update('trx_pullout', array('Status'=>3, 'Confirmed'=>$Approver),array('TransID'=>$TransID));
                $rs = $this->tbl_smr($smr);
                return array('status'=>$rs['status'], 'message'=>'Pullout has been confirmed successfully!');
            }else{
                return array('statsu'=>false, 'message'=>'Type not found or status has been changed by another user!');
            }
        }else{
            return array('status'=>false,'message'=>'Transaction does not exists!');
        }
        
    }
    
    /*** Start of Sales Script ***/
    function Insert_Sales($header, $rows, $customer, $payments, $used) {
        $exists = $this->filter(array(
            'params'=>array('TransID'=>$header['TransID']),
            'table'=>'trx_sales'))->result_array();
        // $ref_number = $this->filter(array(
        //     'params' => array(
        //         'RefNo' => $header['RefNo'],
        //         'Branch' => $header['Branch']),
        //     'table'=>'trx_sales'))->result_array();
        
        if($exists) {
            $message = array('status'=>false, 'message'=>'Transaction already exists');
        // }else if($ref_number) {
        //     $message = array('status'=>false, 'message'=>'Duplicate Reference Number! Check your records!');
        }else{
            $series = $this->db->where('Branch',$header['Branch'])->get('ref_branch_series')->first_row();
            if(!$series) {
                $message = array('status'=>false, 'message'=>'No series found for this branch!');
            }else{
                if($series->Current==(int)$header['RefNo']) {
                    if((int)$header['RefNo'] <= $series->End) {
                        $this->db->trans_start();
                            $iser = array(); $smr = array();
                            $irows = array(); $ipayments = array();
                            foreach($rows as $row => $val) {
                                array_push($irows, array(
                                    'TransID' => $header['TransID'],
                                    'ProductID' => $val['PID'],
                                    'Warehouse' => $val['Warehouse'],
                                    'Quantity' => $val['Quantity'],
                                    'Discount' => $val['Discount'],
                                    'DiscValue' => $val['DiscValue'],
                                    'Subsidy' => $val['Subsidy'],
                                    'OutputTax' => $val['OutputVat'],
                                    'TaxAmount' => $val['TotalAfVat'] - $val['TotalAfSub'],
                                    'Cost' => $val['StdCost'],
                                    'Price' => $val['Price'],
                                    'PriceAfSub' => $val['PriceAfSub'],
                                    'PriceAfVat' => $val['PriceAfVat'],
                                    'Total' => $val['Total'],
                                    'TotalAfSub' => $val['TotalAfSub'],
                                    'TotalAfVat' => $val['TotalAfVat'],
                                    'GTotal' => $val['GTotal'],
                                    'Serial' => $val['Serials'],
                                    'Campaign' => $val['Campaign']
                                ));

                                /* Sales - SMR */
                                array_push($smr, array(
                                    'TransID' => $header['TransID'],
                                    'Date' => $header['TransDate'],
                                    'RefNo' => $header['RefNo'],
                                    'Module' => '/sales',
                                    'TransType' => '/invoice',
                                    'Product' => $val['PID'],
                                    'Warehouse' => (int)$val['Warehouse'],
                                    'Branch' => (int)$header['Branch'],
                                    'Serial' => $val['Serials'],
                                    'MoveIn' => 0,
                                    'MoveOut' => $val['Quantity']));

                                /* Add Quantity to Inventory */
                                $inventory = array(
                                    'Branch' => $header['Branch'],
                                    'Product' => $val['PID'],
                                    'Warehouse' => $val['Warehouse'],
                                    'Committed' => 0,
                                    'InStocks' => $val['Quantity'] * -1
                                );

                                $inv = $this->inventory->add_inventory($inventory);

                                /*** Serial update if available ***/
                                if($val['Serials']) {
                                    array_push($iser, array(
                                        'InvSerID' => $val['InvSerID'],
                                        'IsSold' => 1
                                    ));
                                }
                            }

                            foreach($payments as $pay => $p) {
                                array_push($ipayments, array(
                                    "TransID" => $header['TransID'],
                                    "TransDate" => $header['TransDate'],
                                    "PaymentType" => (int)$p['PaymentType'],
                                    "RefNumber" => $p['RefNumber'],
                                    "IssuingBank" => (int)$p['IssuingBank'],
                                    "Terminal" => (int)$p['Terminal'],
                                    "Installment" => (int)$p['Installment'],
                                    "Amount" => (float)$p['Amount'],
                                    "IsDeposited" => ($p['PaymentType']=='1') ? 0:1,
                                    "Branch" => (int)$p['Branch']
                                ));
                            }
                        
                            if((float)$header['ShortOver'] < 0) {
                                array_push($ipayments, array(
                                    "TransID" => $header['TransID'],
                                    "TransDate" => $header['TransDate'],
                                    "PaymentType" => 1,
                                    "RefNumber" => '',
                                    "IssuingBank" => '',
                                    "Terminal" => '',
                                    "Installment" => '',
                                    "Amount" => (float)$header['ShortOver'],
                                    "IsDeposited" => 0,
                                    "Branch" => (int)$header['Branch']
                                ));
                            }

                            if($header['IsMember']==1) {
                                $purchase = (int)$header['NetTotal'] - $header['SalesTax'];
                                $per = $this->db->select('Percent,Amount')->where('Amount<=',$purchase)->order_by('Percent','DESC')->get('ref_points')->first_row();
                                $add_points = 0;
                                if($per) { 
                                    if($used['computation']==1) {
                                        $add_points = (int)($purchase) * (intval($per->Percent) / 100);    
                                    }else{
                                        $add_points = ceil(intval($purchase)/intval($per->Amount)) * intval($per->Percent);
                                    }
                                }

                                $c = $this->db->where('CardNo', $customer['CardNo'])->get('md_customer')->first_row();
                                if($c) {
                                    $new_points = array(
                                        'CustPoints' => intval($c->CustPoints) - intval($used['points']) + $add_points,
                                        'CustCredits' => intval($c->CustCredits) - intval($used['credits']));
                                    $this->db->update('md_customer', $new_points, array('CardNo'=>$customer['CardNo']));
                                }
                            }

                            $this->db->insert('trx_sales', $header);
                            $this->db->insert('trx_sales_customer', $customer);
                            $this->db->insert_batch('trx_sales_row', $irows);
                            $this->db->insert_batch('trx_sales_payments', $ipayments);
                            if($header['Status']=='0') {
                                $this->db->update('trx_return', array('ReplacedSI'=>$header['TransID'],'Status'=>2), array('TransID'=>$header['ReturnID']));
                            }
                            if(count($iser)>0) {
                                $this->db->update_batch('md_inventory_serials', $iser, 'InvSerID'); }
                            $this->tbl_smr($smr);
                            $this->db->update('ref_branch_series', array('Current'=>$series->Current+1), array('Branch'=>(int)$header['Branch']));
                        $this->db->trans_complete();
                        if($this->db->trans_status()==true) {
                            $message = array('status'=>true, 'message'=>'Sales has been posted!');
                        }else{
                            $message = array('status'=>false, 'message'=>'Database error: Can\'t save your record!');
                        }
                    }else{
                        $message = array('status'=>false, 'message'=>'Please set next booklet, you max this out!');
                    }
                }else{
                    $message = array('status'=>false, 'message'=>'Invalid Series No.!');
                }
            }
        } return $message;
    }
    
    function Sales_Receipt($transid) {
        $header = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_sales'))->first_row();
        $rows = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_sales_row'))->result_array();
        $customer = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_sales_customer'))->first_row();
        $payments = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_sales_payments'))->result_array();
        
        return array('header'=>$header, 'rows'=>$rows, 'customer'=>$customer, 'payments'=>$payments);
    }
    
    function Get_Invoice($transid, $store) {
        $header = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_sales'))->first_row();
        
        if($header) {
            if($header->Branch==$store) {
                $days = floor((time() - strtotime($header->TransDate))/86400);
                $policy = $this->db->select('DefaultReturnPolicy')->where('BranchID',$store)->get('md_branches')->first_row();
                if($days<=$policy->DefaultReturnPolicy) {
                    $rows = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_sales_row'))->result_array();
                    $customer = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_sales_customer'))->first_row();
                    $payments = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_sales_payments'))->result_array();

                    return array(
                        'status'=>true,
                        'invoice' => array(
                            'header'=>$header, 
                            'rows'=>$rows, 
                            'customer'=>$customer, 
                            'payments'=>$payments));
                }else{
                    return array(
                        'status'=>false,
                        'timer'=>0,
                        'message'=>'Transaction does not meet return policy! Should be within ' . $policy->DefaultReturnPolicy . ' day/s.');
                }
            }else{
                return array(
                'status'=>false,
                'timer'=>1500,
                'message'=>'This transaction was not sold in this store!');
            }
        }else{
            return array(
                'status'=>false,
                'timer'=>1500,
                'message'=>'Return No. not found!');
        }
    }

    function Void_Sales($transid, $used) {
        $header = $this->filter(array('params'=>array('TransID'=>$transid,'Status'=>1),'table'=>'trx_sales'))->first_row();

        if($header) {
            $this->db->trans_start();
                $iser = array();
                $rows = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'trx_sales_row'))->result_array();
                $customer = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'trx_sales_customer'))->first_row();
                
                foreach ($rows as $row => $v) {
                    $nr = array(
                        'Branch' => (int)$header->Branch,
                        'Warehouse' => (int)$v['Warehouse'],
                        'Product' => (int)$v['ProductID'],
                        'InStocks' => (int)$v['Quantity'],
                        'Committed' => 0);

                    $this->inventory->add_inventory($nr);

                    /*** Serial update if available ***/
                    if($v['Serial']) {
                        array_push($iser, array(
                            'Serial' => $v['Serial'],
                            'IsSold' => 0,
                            'Warehouse' => (int)$v['Warehouse']
                        )); 
                    }
                }

                if($header->IsMember==1) {
                    $per = $this->db->select('Percent,Amount')->where('Amount<=',($header->TotalAfSub))->order_by('Percent','DESC')->get('ref_points')->first_row();
                    $add_points = 0;
                    if($per) { 
                        if($used['computation']==1) {
                            $add_points = (int)($header->TotalAfSub) * (intval($per->Percent) / 100);    
                        }else{
                            $add_points = ceil(intval($header->TotalAfSub)/intval($per->Amount)) * intval($per->Percent);
                        }
                    }
                    
                    $c = $this->db->select('CustPoints')->where('CardNo', $customer->CardNo)->get('md_customer')->first_row();
                    if($c) {
                        $new_points = array('CustPoints' => intval($c->CustPoints) - $add_points);
                        $this->db->update('md_customer', $new_points, array('CardNo'=>$customer->CardNo));
                    }
                }

                $this->db->delete('trx_sales', array('TransID' => $transid));
                $this->db->delete('trx_sales_row', array('TransID' => $transid));
                $this->db->delete('trx_sales_payments', array('TransID' => $transid));
                $this->db->delete('trx_sales_customer', array('TransID' => $transid));
                $this->db->delete('trx_stocks_movement', array('TransID' => $transid));
                if(count($iser)>0) {
                    $this->db->update_batch('md_inventory_serials', $iser, 'Serial'); }
            $this->db->trans_complete();
            if($this->db->trans_status()==true) {
                $message = array(
                    'status'=>true, 
                    'timer'=>1500, 
                    'message'=>'Transaction has been successfully canceled!');
            }else{
                $message = array('status'=>false, 'timer'=>1500, 'message'=>'Database error: Can\'t save your record!');
            } return $message;
        }else{
            return array(
                'status'=>false,
                'timer'=>1500,
                'message'=>'Transaction does not exists or Status is not voidable!');
        }
    }
    
    function Insert_Return($header, $rows, $customer, $payments, $used) {
        $exists = $this->filter(array(
            'params'=>array('TransID'=>$header['TransID']),
            'table'=>'trx_sales'))->result_array();
        if($exists) {
            $message = array('status'=>false, 'message'=>'Transaction already exists');
        }else{
            $this->db->trans_start();
                $iser = array(); $smr = array(); $rrows = array();
                $irows = array(); $ipayments = array();
                foreach($rows as $row => $val) {
                    array_push($irows, array(
                        'TransID' => $header['TransID'],
                        'ProductID' => $val['PID'],
                        'Warehouse' => $val['Warehouse'],
                        'Quantity' => $val['Quantity'] * -1,
                        'Discount' => $val['Discount'],
                        'DiscValue' => $val['DiscValue'] * -1,
                        'Subsidy' => $val['Subsidy'] * -1,
                        'OutputTax' => $val['OutputVat'],
                        'TaxAmount' => ($val['PriceAfVat'] - $val['Price']) * -1,
                        'Cost' => $val['StdCost'],
                        'Price' => $val['Price'],
                        'PriceAfSub' => $val['PriceAfSub'],
                        'PriceAfVat' => $val['PriceAfVat'],
                        'Total' => $val['Total'] * -1,
                        'TotalAfSub' => $val['TotalAfSub'] * -1,
                        'TotalAfVat' => $val['TotalAfVat'] * -1,
                        'GTotal' => $val['GTotal'] * -1,
                        'Serial' => $val['Serials'],
                        'Campaign' => $val['Campaign'],
                        'Rqty' => $val['Quantity'] * -1
                    ));

                    array_push($rrows, array(
                        'SalesRowID' => $val['SalesRowID'],
                        'Rqty' => $val['Rqty'] + $val['Quantity']
                    ));
                    
                    /* Return - SMR */
                    array_push($smr, array(
                        'TransID' => $header['TransID'],
                        'Date' => $header['TransDate'],
                        'RefNo' => $header['RefNo'],
                        'Module' => '/sales',
                        'TransType' => '/return',
                        'Product' => $val['PID'],
                        'Warehouse' => (int)$val['Warehouse'],
                        'Branch' => (int)$header['Branch'],
                        'Serial' => $val['Serials'],
                        'MoveIn' => $val['Quantity'],
                        'MoveOut' => 0));
                    
                    /* Add Quantity to Inventory */
                    $inventory = array(
                        'Branch' => $header['Branch'],
                        'Product' => $val['PID'],
                        'Warehouse' => $val['Warehouse'],
                        'Committed' => 0,
                        'InStocks' => $val['Quantity']
                    );
                    
                    $inv = $this->inventory->add_inventory($inventory);

                    /*** Serial update if available ***/
                    if($val['Serials']) {
                        array_push($iser, array(
                            'Serial' => $val['Serials'],
                            'IsSold' => 0
                        ));
                    }
                }
            
                if($header['IsMember']==1) {
                    $per = $this->db->select('Percent,Amount')->where('Amount<=',($header['TotalAfSub']*-1))->order_by('Percent','DESC')->get('ref_points')->first_row();
                    $add_points = 0;
                    if($per) { 
                        if($used['computation']==1) {
                            $add_points = (int)($header['TotalAfSub']) * (intval($per->Percent) / 100);    
                        }else{
                            $add_points = ceil(intval($header['TotalAfSub'])/intval($per->Amount)) * intval($per->Percent);
                        }
                    }
                    
                    $c = $this->db->select('CustPoints')->where('CardNo', $customer['CardNo'])->get('md_customer')->first_row();
                    if($c) {
                        $new_points = array(
                            'CustPoints' => intval($c->CustPoints) + $add_points);
                        $this->db->update('md_customer', $new_points, array('CardNo'=>$customer['CardNo']));
                    }
                }
                
                $this->db->insert('trx_return', $header);
                $this->db->insert('trx_sales_customer', $customer);
                $this->db->insert_batch('trx_return_row', $irows);
                $this->db->insert('trx_sales_payments', $payments);
                $this->db->update('trx_sales', array('ReturnID'=>$header['TransID'],'Status'=>2),array('TransID'=>$header['ReturnedSI']));
                $this->db->update_batch('trx_sales_row', $rrows, 'SalesRowID');
                if(count($iser)>0) {
                    $this->db->update_batch('md_inventory_serials', $iser, 'Serial'); }
                $this->tbl_smr($smr);
            $this->db->trans_complete();
            if($this->db->trans_status()==true) {
                $message = array('status'=>true, 'message'=>'Sales Return has been posted!');
            }else{
                $message = array('status'=>false, 'message'=>'Database error: Can\'t save your record!');
            }
        } return $message;
    }
    
    function Return_Receipt($transid) {
        $header = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_return'))->first_row();
        $rows = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_return_row'))->result_array();
        $customer = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_sales_customer'))->first_row();
        $payments = $this->filter(array('params'=>array('TransID'=>$transid),'table'=>'view_sales_payments'))->result_array();
        
        return array('header'=>$header, 'rows'=>$rows, 'customer'=>$customer, 'payments'=>$payments);
    }
    
    function CheckSI($invoice) {
        $exists = $this->db->where('RefNo', $invoice)->get('trx_sales')->result_array();
        if($exists) {
            return array('status'=>true, 'message'=>'SI is Valid!');
        }else{
            return array('status'=>false, 'message'=>'Invalid SI!');
        }
    }
    
    function CheckICC($invoice, $branch) {
        $exists = $this->db->where(array('Serial'=>$invoice, 'Branch'=>$branch, 'IsSold'=>0))->get('md_inventory_serials')->first_row();
        if($exists) {
            return array('status'=>true, 'message'=>'ICCID found!');
        }else{
            return array('status'=>false, 'message'=>'ICCID Not Found!');
        }
    }
    
    function addPostpaid($postpaid) {
        $serial = $this->db->where('Serial', $postpaid['ICCID'])->get('md_inventory_serials')->first_row();
        $smr = array(array(
            'TransID' => date('yHiz') . str_pad($postpaid['Branch'], 3, "0", STR_PAD_LEFT) . str_pad(rand(0, 999), 3, "0", STR_PAD_LEFT),
            'Date' => $postpaid['TransDate'],
            'RefNo' => $postpaid['RefNo'],
            'Module' => '/sales',
            'TransType' => '/postpaid',
            'Product' => $serial->Product,
            'Warehouse' => (int)$serial->Warehouse,
            'Branch' => (int)$postpaid['Branch'],
            'Serial' => $postpaid['ICCID'],
            'MoveIn' => 0,
            'MoveOut' => 1));
        
        /* Add Quantity to Inventory */
        $inventory = array(
            'Branch' => (int)$postpaid['Branch'],
            'Product' => (int)$serial->Product,
            'Warehouse' => (int)$serial->Warehouse,
            'Committed' => 0,
            'InStocks' => -1
        );
        
        $this->db->trans_start();
            $this->db->insert('trx_sales_postpaid', $postpaid);
            $lastid = $this->db->insert_id();
        
            $result = $this->db->where(array('PostpaidID'=>$lastid))->get('view_sales_postpaid')->first_row();
            $inv = $this->inventory->add_inventory($inventory);
            $this->db->update('md_inventory_serials', array('IsSold'=>1), array('InvSerID'=>(int)$serial->InvSerID));
            $this->tbl_smr($smr);
        $this->db->trans_complete();
        if($this->db->trans_status() == true) {
            return array('status'=>true, 'message'=>'Transaction has been send for activation.', 'data'=>$result);
        }else{
            return array('status'=>false, 'message'=>'Error! Unable to saved!');
        }
    }
    
    function updatePostpaid($postpaid) {
        $Activated = isset($postpaid['type']['Status']);
        
        if($Activated) {
            $d = array('ActivationDate'=>date('Y-m-d'));
            $this->db->update('trx_sales_postpaid', $d, array('PostpaidID'=>$postpaid['PostpaidID']));
        }
        
        $this->db->update('trx_sales_postpaid', $postpaid['type'], array('PostpaidID'=>$postpaid['PostpaidID']));
        return array('status'=>true, 'message'=>'Update Successful');
    }
    
    function cancelPostpaid($postpaid) {
        $serial = $this->db->where('Serial', $postpaid['IccID'])->get('md_inventory_serials')->first_row();
        $smr = array(array(
            'TransID' => date('yHiz') . str_pad($postpaid['Branch'], 3, "0", STR_PAD_LEFT) . str_pad(rand(0, 999), 3, "0", STR_PAD_LEFT),
            'Date' => $postpaid['TransDate'],
            'RefNo' => $postpaid['RefNo'],
            'Module' => '/sales',
            'TransType' => '/postpaid',
            'Product' => $serial->Product,
            'Warehouse' => (int)$serial->Warehouse,
            'Branch' => (int)$postpaid['Branch'],
            'Serial' => $postpaid['IccID'],
            'MoveIn' => 1,
            'MoveOut' => 0));
        
        /* Add Quantity to Inventory */
        $inventory = array(
            'Branch' => (int)$postpaid['Branch'],
            'Product' => (int)$serial->Product,
            'Warehouse' => (int)$serial->Warehouse,
            'Committed' => 0,
            'InStocks' => 1
        );
        
        $this->db->trans_start();
            $this->db->update('trx_sales_postpaid', array('Status'=>2), array('PostpaidID'=>$postpaid['PostpaidID']));
        
            $inv = $this->inventory->add_inventory($inventory);
            $this->db->update('md_inventory_serials', array('IsSold'=>0), array('InvSerID'=>(int)$serial->InvSerID));
            $this->tbl_smr($smr);
        $this->db->trans_complete();
        if($this->db->trans_status() == true) {
            return array('status'=>true, 'message'=>'Transaction has been cancelled.');
        }else{
            return array('status'=>false, 'message'=>'Error! Unable to saved!');
        }
    }
}?>