<?php
class Sales extends MY_Controller {
	function __construct() {
		parent::__construct();
	}
	
	public function payment() {
        $this->load->view('errors/error-404');
	}
}
?>