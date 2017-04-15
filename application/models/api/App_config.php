<?php defined('BASEPATH') OR exit('No direct script access allowed');

class App_config extends MY_Model {
    function __construct() {
        parent::__construct();
    }

    protected $_table = 'stp_config';
    protected $primary_key = 'Id';
    protected $return_type = 'array';

    protected $after_get = array();
    protected $before_create = array();

    public function payments() {
        return $this->db->get('ref_payment_type');
    }

    public function setPayments($payments) {
        $this->db->update_batch('ref_payment_type', $payments, 'PaymentId');
    }
    
    public function installment($status) {
        if($status != 'all') {
            $this->db->where('IsActive',$status);}
        return $this->db->get('ref_installment')->result_object();
    }
    
    public function add_installment($installment) {
        $exists = $this->db->where('InstDesc', $installment['InstDesc'])->get('ref_installment')->result_array();
        if($exists) {
            return array('status'=>false, 'message'=>'Data already exists!');
        }else{
            $this->db->insert('ref_installment', $installment);
            $data = $this->installment('all');
            return array('status'=>true, 'message'=>'Save successfull!', 'data'=>$data);
        }
    }
    
    function updateInstallment($data) {
        $Amount = isset($data['type']['InstDesc']);
        $arr = (array)$data['type'];
        
        if($Amount) {
            $exists = $this->db->where($arr)->get('ref_installment')->result_array();
            if(!$exists) {
                $this->db->update('ref_installment', $data['type'], array('InsId'=>$data['InsId']));
                return true;
            }else{
                return 'Already Exists!';
            }
        }else{
            $this->db->update('ref_installment', $data['type'], array('InsId'=>$data['InsId']));
            return true;
        }
//        return $data;
    }
    
    public function terminal($status) {
        if($status != 'all') {
            $this->db->where('IsActive',$status);}
        return $this->db->get('ref_terminal')->result_object();
    }
    
    public function add_terminal($terminal) {
        $exists = $this->db->where('BankName', $terminal['BankName'])->get('ref_terminal')->result_array();
        if($exists) {
            return array('status'=>false, 'message'=>'Data already exists!');
        }else{
            $this->db->insert('ref_terminal', $terminal);
            $data = $this->terminal('all');
            return array('status'=>true, 'message'=>'Save successfull!', 'data'=>$data);
        }
    }
    
    function updateBank($data) {
        $Amount = isset($data['type']['BankName']);
        $arr = (array)$data['type'];
        
        if($Amount) {
            $exists = $this->db->where($arr)->get('ref_terminal')->result_array();
            if(!$exists) {
                $this->db->update('ref_terminal', $data['type'], array('BankID'=>$data['BankID']));
                return true;
            }else{
                return 'Already Exists!';
            }
        }else{
            $this->db->update('ref_terminal', $data['type'], array('BankID'=>$data['BankID']));
            return true;
        }
    }
    
    public function points() {
        return $this->db->order_by('Amount','DESC')->get('ref_points')->result_array();
    }
    
    public function add_points($points) {
        $exists = $this->db->where('Amount', $points['Amount'])->get('ref_points')->result_array();
        if($exists) {
            return array('status'=>false, 'message'=>'Data already exists!');
        }else{
            $this->db->insert('ref_points', $points);
            return array('status'=>true, 'message'=>'Save successfull!');
        }
    }
    
    public function remove_point($id) {
        $this->db->delete('ref_points',array('PointID'=>$id));
    }
    
    function updatePoint($data) {
        $Amount = isset($data['type']['Amount']);
        $arr = (array)$data['type'];
        
        if($Amount) {
            $exists = $this->db->where($arr)->get('ref_points')->result_array();
            if(!$exists) {
                $this->db->update('ref_points', $data['type'], array('PointID'=>$data['PointID']));
                return true;
            }else{
                return 'Already Exists!';
            }
        }else{
            $this->db->update('ref_points', $data['type'], array('PointID'=>$data['PointID']));
            return true;
        }
//        return $data;
    }
    
    public function update_deposit_slip($deposit) {
        $u = array('TransDate'=>$deposit['TransDate'],'Branch'=>$deposit['Branch'], 'IsDeposited'=>0);
        $this->db->trans_start();
            $this->db->update('trx_sales_payments', $deposit, $u);
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return array('status'=>false, 'message'=>'Unable to update all records!');
        }else{
            return array('status'=>true, 'message'=>'Deposit slip has been saved!');
        }
    }
    
    public function addPaymentType($payment) {
        $exists = $this->db->where('PaymentName', $payment['PaymentName'])->get('ref_payment_type')->result_array();
        if($exists) {
            return array('status'=>false, 'message'=>'Payment already exists!');
        }else{
            $this->db->insert('ref_payment_type', $payment);
            $data = $this->payments()->result_array();
            return array('status'=>true, 'message'=>'Save successfull!', 'data'=>$data);
        }
    }
}


?>