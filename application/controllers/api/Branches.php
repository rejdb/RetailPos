<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Branches extends REST_Controller {

    function __construct() {
        parent:: __construct();
        $this->load->Model('api/branch');
        $this->load->Model('api/user');
    }
    
    function links_get(){
        $managers = $this->user->getUsers(array('Roles'=>3,'IsActive'=>true));
        $links = array_merge($this->branch->getTableLinks(), array('managers'=>$managers));
        $this->response($links);
    }
    
    function addbranch_post() {
        $BranchCode = $this->post('BranchCode');
        $Description = $this->post('Description');
        $BranchEmail = $this->post('BranchEmail');
        
        $codeExists = $this->branch->get_by(array('BranchCode'=>$BranchCode));
        $descExists = $this->branch->get_by(array('Description'=>$Description));
        $emailExists = $this->branch->get_by(array('BranchEmail'=>$BranchEmail));
        
        if(!$codeExists && !$descExists && !$emailExists) {
            $this->branch->insert($this->post());
            $this->response(array(
                'success'=>true,
                'message'=>'Branch has been successfully created!'
            ));   
        }else{
            $this->response(array(
                'success'=>false,
                'message'=>'Branch Code, Name or email already exists! Please check.'
            ));
        }
    }
    
    //get all branches
    function lists_get() {
        $lists = $this->branch->lists();
        $this->response($lists);
    }
    
    //get all branches by IsActive
    function status_get($id) {
        $lists = $this->branch->IsActive(array('IsActive'=>$id));
        $this->response($lists);
    }
    
    function setVal_post() {
        $BrnCode = isset($this->post('type')['BranchCode']);
        $BrnName = isset($this->post('type')['Description']);
        $arr = (array)$this->post('type');
        
        if($BrnCode || $BrnName) {
            $exists = $this->branch->get_by($arr);
            if(!$exists) {
                $this->branch->update($this->post('BranchID'), $this->post('type'));
            }
        }else{
            $this->branch->update($this->post('BranchID'), $this->post('type'));
        }
        
        $this->response('Updated successfully!');
    }
    
    function getTarget_get($param) {
        $target = $this->branch->getTarget(array('BranchID'=>$param));
        $this->response($target);
    }
    
    function saveTarget_post() {
        $record = $this->branch->saveTarget($this->post());
        $this->response($record);
    }
    
    function updateSeries_post() {
        $series = $this->branch->updateSeries($this->post());
        $this->response($series);
    }
}?>