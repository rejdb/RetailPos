<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    
    protected $_table = 'md_supplier';
    protected $primary_key = 'SuppID';
    protected $return_type = 'array';

    protected $after_get = array();
    protected $before_create = array();
    
    
    
}