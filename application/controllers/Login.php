<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends My_Controller {

    function __construct() {
        parent::__construct();
//        if(ceil((strtotime('04/06/2017') - time())/86400)<=6) {redirect('/sales/payment');}
    }
    
	public function index()
	{
		$this->load->view('/templates/login');
	}
}
