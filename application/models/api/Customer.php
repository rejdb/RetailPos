<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    
    protected $_table = 'md_customer';
    protected $primary_key = 'CustID';
    protected $return_type = 'array';

    protected $after_get = array();
    protected $before_create = array();
    
    function filter($param) {
        $this->db->where($param);
        return $this->db->get('view_customer')->result_array();
    }
    
    function get_all() {
        return $this->db->get('view_customer')->result_array();
    }
    
}