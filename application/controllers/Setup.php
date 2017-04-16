<?php
class Setup extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->view('pages/general_setup');
    }
}
?>