<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Users extends REST_Controller {

    function __construct() {
        parent:: __construct();
        $this->load->Model('api/user');
    }
    
    public function login_post() {
        $this->load->library('form_validation');
		$data = remove_unknown_fields($this->post(), $this->form_validation->get_field_names('login_put'));
		$this->form_validation->set_data($data);
        
        if($this->form_validation->run('login_put')) {
            $userinfo = $this->user->get_by(array('Email'=> $this->post('Email'), 'Password'=>md5($this->post('Password')), 'IsActive'=>true));
            
            if($userinfo) {
                switch((int)$userinfo['Roles']) {
                    case 4:
                        $Branch = $this->user->branch((int)$userinfo['UID']); break;
//                        $Branch = array('ID'=>0,'Name'=>'Head Office', 'Avatar'=>$this->config->item('Avatar'));
                    default:
                        $Branch = array('BranchID'=>0, 'BranchCode'=>'HO','Description'=>'Head Office', 'IsActive'=>'1', 'Avatar'=>$this->config->item('Avatar')); break;
                }
                
                if($Branch['IsActive']=='1') {
                    $user = array_merge($userinfo, array('Branch'=>$Branch));
                    $this->response(array('success'=>true, 'user'=>$user));   
                }else{
                    $this->response(array('success'=>false, 'message'=>'log in to a closed store is not allowed! Contact admin to have your account transferred or check store status'));
                }
            }else{
                $this->response(array('success'=>false, 'message'=> 'User does not exists!'));
            }
        }else{
            $this->response(array('success'=>false,'result'=> $this->form_validation->get_errors_as_array()));
        }
    }
    
    function fl_get() {
        $fl = $this->user->getFl();
        $this->response(array('users'=>$fl));
    }
    
    function BranchFL_get($branch) {
        $fl = $this->user->getBranchFl($branch);
        $this->response($fl);
    }
    
    function resetPwd_post() {
        $this->user->update($this->post('UID'), $this->post('Data'));
        $this->response(array('message'=>'Password has been reset to default!'));
//        $this->response($this->post());
    }
    
    function changePassword_post() {
        $valid = $this->user->get_by(array('Email'=> $this->post('email'), 'Password'=>md5($this->post('current')), 'IsActive'=>true));
        
        if($valid) {
            $this->user->update($valid['UID'], array('Password'=>md5($this->post('new'))));
            $message = array('status'=>true, 'message'=>'Password has been changed!');
        }else{
            $message = array('status'=>false, 'message'=>'Invalid Current Password');
        }
        
        $this->response($message);
    }
    
    function update_post() {
        $this->user->update($this->post('UID'), $this->post('type'));
        $this->response(array('message'=>'User data has been successfully updated!'));
//        $this->response($this->post());
    }
    
}