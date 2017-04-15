<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Setup extends REST_Controller {

    function __construct() {
        parent:: __construct();
        $this->load->Model('api/app_config');
        $this->load->Model('api/user');
    }


    public function config_get() {
        $payments = $this->app_config->payments();
        $config = array_merge($this->app_config->get_by(array('Id'=>1)), array('payments' => $payments->result()));
        $this->response(array('config' => $config));
    }

    public function config_post() {
        $this->app_config->update(1, $this->post('setup'));
        $this->app_config->setPayments($this->post('payments'));

        $payments = $this->app_config->payments();
        $config = array_merge($this->app_config->get_by(array('Id'=>1)), array('payments' => $payments->result()));
        $this->response(array('config' => $config));

        // $this->response(array('config' => $this->post('setup')));
    }
    
    public function Installment_get($status) {
        $installment = $this->app_config->installment($status);
        $this->response($installment);
    }
    
    public function AddInstallment_post() {
        $response = $this->app_config->add_installment($this->post());
        $this->response($response);
    }
    
    public function updateInstallment_post() {
        $msg = $this->app_config->updateInstallment($this->post());
        $this->response($msg);
    }
    
    public function Terminal_get($status) {
        $installment = $this->app_config->terminal($status);
        $this->response($installment);
    }
    
    public function AddTerminal_post() {
        $response = $this->app_config->add_terminal($this->post());
        $this->response($response);
    }
    
    public function updateBank_post() {
        $msg = $this->app_config->updateBank($this->post());
        $this->response($msg);
    }
    
    public function Points_get() {
        $points = $this->app_config->points();
        $this->response($points);
    }
    
    public function addPoints_post() {
        $response = $this->app_config->add_points($this->post());
        $this->response($response);
    }
    
    public function RemovePoint_get($id) {
        $this->app_config->remove_point($id);
    }
    
    public function updatePoint_post() {
        $msg = $this->app_config->updatePoint($this->post());
        $this->response($msg);
    }
    
    public function users_get($param) {
//        $this->db->where(array('Roles' => $param));
        $users = $this->user->getUsers(array('Roles'=>$param));
        $this->response(array('users' => $users));
    }
    
    public function useractivate_get($id) {
        $user = (object) $this->user->get_by(array('UID'=>$id));
        $status = !((int)$user->IsActive === 1) ? true: false;
        
        $this->user->update($id,array('IsActive'=> $status));
        
        $this->response($status);
    }
    
    public function superuser_post() {
        //check email duplicate
        $checkEmail = $this->user->get_by(array('Email'=>$this->post('Email')));
        
        if(!$checkEmail) {
            $rsp = $this->user->insert($this->post());
            $user = $this->user->get_by(array('UID'=>$rsp));
            $this->response(array('userinfo' => $user));
        }else{
            $this->response(array(
                'error'=> true,
                'message'=> 'Email already exists!'
            ));
        }  
    }
    
    public function frontliner_post() {
        $user = (object) $this->post('user');
        $fl = (object) $this->post('fl');
        
//        $this->response($user->Email);
        //check duplicate email
        $emailExists = $this->user->get_by(array('Email'=>$user->Email));
        if(!$emailExists) {
            $id = $this->user->insert($user);
            if($id) {
                $this->user->frontliner($id,$fl->BranchID,$fl->Target);
                $this->response(array('success'=>true, 'message'=>'Account has been created successfully!'));
            }else{
                $this->response(array('success'=>false, 'message'=>'Unable to save record, please check your form fields!'));
            }
        }else{
            $this->response(array(
                'success'=> false,
                'message'=> 'Email already exists!'
            ));
        }
    }
    
    public function updateFl_post() {
        $uid = $this->post('UID');
        $datas = $this->post('type');
        
        $target = isset($this->post('type')['Target']);
        $BrnCode = isset($this->post('type')['BranchID']);
        
        if($target || $BrnCode) {
            $data = $this->user->updateFl($this->post());
        }else{
            $this->user->update($uid,$datas);   
        }
        $this->response('Update successful!');
//        $this->response($data);
    }
    
    public function updateDepositSlip_post() {
        $deposit = $this->app_config->update_deposit_slip($this->post());
        $this->response($deposit);
    }
    
    public function addPaymentType_post() {
        $payment = $this->app_config->addPaymentType($this->post());
        $this->response($payment);
    }
    
    
}
?>