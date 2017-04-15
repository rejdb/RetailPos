<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends MY_Model {
    function __construct() {
        parent::__construct();
    }
 
    protected $_table = 'md_branches';
    protected $primary_key = 'BranchID';
    protected $return_type = 'array';

    protected $after_get = array();
    protected $before_create = array();
    
    function getTableLinks() {
        $types = $this->db->get('ref_branch_type')->result_array();
        $categories = $this->db->get('ref_branch_category')->result_array();
        $groups = $this->db->get('ref_branch_group')->result_array();
        $channels = $this->db->get('ref_branch_channel')->result_array();
        $cities = $this->db->get('ref_branch_city')->result_array();
        $provinces = $this->db->get('ref_province')->result_array();
        
        $links = array_merge(
            array('types'=>$types),
            array('categories'=>$categories),
            array('groups'=>$groups),
            array('channels'=>$channels),
            array('cities'=>$cities),
            array('provinces'=>$provinces)
        );
        return $links;
    }
    
    //get all existing branches
    function lists() {
        $lists = $this->db->get('view_branches')->result_array();
        return $lists;
    }
    
    //get all branches by IsActive
    function IsActive($param) {
        $this->db->where($param);
        return $this->db->get('view_branches')->result_array();
    }
    
    function getTarget($param) {
        $this->db->where($param);
        $this->db->order_by('Month','desc');
        return $this->db->get('ref_branch_target')->result_array();
    }
    
    function saveTarget($data) {
        $id = $this->db->insert('ref_branch_target', $data);
        $record = $this->db->from('ref_branch_target')->where(array('TargetID'=>$id))->get();
        return $record->result_array();
    }
    
    function updateSeries($series) {
        $id = $series['Branch'];
        $data = $series['type'];                        
        
        $exists = $this->db->where('Branch',$id)->get('ref_branch_series')->result_array();
        if($exists) {
            $this->db->update('ref_branch_series', $data, array('Branch'=>$id));    
            return array('status'=>true, 'message'=>'Update successful!');
        }else{
            $data = array_merge($data, ['Branch'=>$id]);
            $this->db->insert('ref_branch_series', $data);
            return array('status'=>true, 'message'=>'Series has beed added!');
        }
        
    }
    
}?>