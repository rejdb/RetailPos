<?php
class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        if(ceil((strtotime('05/29/2019') - time())/86400)<0) {redirect('/sales/payment');}
        if(!$this->input->cookie('profile')) { redirect('/login'); }
    }

    public function index() { 
        $this->load->view('templates/html');   
//        echo 'testing';
    }
//    public function base() { $this->load->view('/templates/html'); }
    public function dashboard() { $this->load->view('partials/dashboard'); }
    public function password() { $this->load->view('partials/change_password'); }
    
    public function purchase_order() { $this->load->view('partials/purchasing'); }
    public function purchase_receipt() { $this->load->view('partials/purchasing_receipt'); }
    public function purchase_history() { $this->load->view('partials/purchasing_history'); }
    public function purchase_received() { $this->load->view('partials/purchasing_received'); }
    public function purchase_received_receipt() { $this->load->view('partials/purchasing_received_receipt'); }
    
    public function stocks_receiving() { $this->load->view('partials/stocks_receiving'); }
    public function stocks_receiving_receipt() { $this->load->view('partials/stocks_receiving_receipt'); }
    public function stocks_receiving_history() { $this->load->view('partials/stocks_receiving_history'); }
    
    
    public function stocks_transfer() { $this->load->view('partials/stocks_transfer'); }
    public function stocks_transfer_receipt() { $this->load->view('partials/stocks_transfer_receipt'); }
    public function stocks_transfer_history() { $this->load->view('partials/stocks_transfer_history'); }
    
    public function stocks_pullout() { $this->load->view('partials/stocks_pullout'); }
    public function stocks_pullout_receipt() { $this->load->view('partials/stocks_pullout_receipt'); }
    public function stocks_pullout_history() { $this->load->view('partials/stocks_pullout_history'); }
    
    public function sales_invoice() { $this->load->view('partials/sales_invoice'); }
    public function sales_invoice_receipt() { $this->load->view('partials/sales_invoice_receipts'); }
    public function sales_invoice_history() { $this->load->view('partials/sales_invoice_history'); }
    
    
    public function sales_return() { $this->load->view('partials/sales_return'); }
    public function sales_return_receipt() { $this->load->view('partials/sales_return_receipt'); }
    public function sales_return_history() { $this->load->view('partials/sales_return_history'); }
    public function sales_postpaid() { $this->load->view('partials/sales_postpaid'); }
    
    public function cash_register() { $this->load->view('partials/cash_register'); }
    public function cash_card() { $this->load->view('partials/cash_card'); }

    //Report Management
    public function reports_sales_summary() { $this->load->view('reports/report_sales_summary'); }
    public function reports_sales_detailed() { $this->load->view('reports/report_sales_detailed'); }
    
    
    public function reports_inventory_current() { $this->load->view('reports/reports_inventory_current'); }
    public function reports_inventory_serials() { $this->load->view('reports/reports_inventory_serials'); }
    public function reports_inventory_tracking() { $this->load->view('reports/reports_inventory_tracking'); }
    public function reports_inventory_smr() { $this->load->view('reports/reports_inventory_movement'); }
    
    
    //General Settings Module
    public function store_setup() { $this->load->view('partials/general_setup'); }
    public function superuser() { $this->load->view('partials/superuser'); }

    //Branches Module
    public function branches() { $this->load->view('partials/branches'); }
    public function branchlist() { $this->load->view('partials/branch_lists'); }
    public function payment() { $this->load->view('errors/error-404'); }
    
    
    //Employee Module
    public function employee($pages) {
        switch ($pages) {
            case 'fl': $this->load->view('partials/frontliner'); break;
            case 'personnel': $this->load->view('partials/ho_personnel'); break;
            default: $this->load->view('partials/store_manager'); break;
        }
    }
    
    public function profile() { $this->load->view('partials/profile'); }

    //Inventory Module
    public function product_lists() { $this->load->view('partials/inv_product_list'); }
    public function product_discount() { $this->load->view('partials/inv_product_discount'); }
    public function product_campaign() { $this->load->view('partials/inv_product_campaign'); }
    public function inventory_warehouse() { $this->load->view('partials/inv_warehouse'); }
    public function inventory_bom() { $this->load->view('partials/inv_billofmaterial'); }

    //Suppliers
    public function suppliers() { $this->load->view('partials/supplier'); }
    
    //customers
    public function customers() { $this->load->view('partials/customer'); }
}
?>