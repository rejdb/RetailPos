<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Model {
    function __construct() {
        parent::__construct();
    }

    protected $_table = 'md_user';
    protected $primary_key = 'UID';
    protected $return_type = 'array';

    protected $after_get = array('noPassword');
    protected $before_create = array();

    public function noPassword($user) {
        unset($user['Password']);
        return $user;
    }
    
    public function getUsers($param) {
        if($param['Roles']==-1) {$param = "Roles in (2,5,6)";}
        $this->db->where($param);
        return $this->db->get('md_user')->result_array();
    }
    
    public function getFl() {
        return $this->db->get('view_frontliners')->result_array();
    }
    
    public function getBranchFl($branch) {
        return $this->db->where('BranchID', $branch)->get('view_frontliners')->result_array();
    }
    
    public function updateFl($data) {
        $target = isset($data['type']['Target']);
        $branch = isset($data['type']['BranchID']);
        
        if($target) {
            $this->db->update('ref_user_target', $data['type'], array('UsrTargetID'=>$data['UID']));
        }
        
        if($branch) {
            $this->db->update('ref_user_branch', $data['type'], array('UserBranchID'=>$data['UID']));
        }
    }
    
    public function frontliner($id, $branch, $target) {
        $this->db->insert('ref_user_target', array('UserID'=>$id,'Target'=>$target));
        $this->db->insert('ref_user_branch', array('UserID'=>$id,'BranchID'=>$branch));
    }
    
    public function branch($UserID) {
        $brnID = $this->db->where('UserID',$UserID)->get('ref_user_branch')->first_row();
        $branches = (array)$this->db->where(array('BranchID'=>$brnID->BranchID))->get('md_branches')->first_row();
        $target = (array)$this->db->where('UserID',$UserID)->select('Target')->get('ref_user_target')->first_row();
//        return $target;
        return array_merge($branches, $target);
    }
    
}


?>