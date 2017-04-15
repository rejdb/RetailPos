<?php
class Reports extends MY_Controller {

    function __construct() {
        parent::__construct();
        if(!$this->input->cookie('profile')) { redirect('/login'); }
    }
    
    function current_inventory() {
        $this->load->view('reports/current_inventory');
    }
}?>