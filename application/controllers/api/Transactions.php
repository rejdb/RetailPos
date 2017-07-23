<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Transactions extends REST_Controller {

    function __construct() {
        parent:: __construct();
        date_default_timezone_set('Asia/Manila');
        $this->load->Model('api/transaction');
        $this->load->Model('api/item');
        $this->load->Model('api/branch');
        $this->load->Model('api/supplier');
    }
    
    function MainPage_get($store) {
        $response = $this->transaction->MainPage($store);
        $this->response($response);
    }
    
    function InsertSMR_post() {
        $response = $this->transaction->tbl_smr($this->post());
        $this->response($response);
    }
    
    function Update_post() {
        $response = $this->transaction->tbl_Update($this->post());
        $this->response($response);
    }
    
    function History_post() {
        $response = $this->transaction->filter($this->post())->result_array();
        $this->response($response);
    }
    
    function SubmitPurchase_post() {
        $header = $this->post('header');
        $rows = $this->post('rows');
        
        $response = $this->transaction->Insert_Purchase($header,$rows);
        $this->response($response);
    }
    
    function PurchaseReceipt_get($transid) {
        $response = $this->transaction->Purchase_Receipt($transid);
        $this->response($response);
    }
    
    function PurchaseHistory_post() {
        $response = $this->transaction->filter_purchase($this->post())->result_array();
        $this->response($response);
    }
    
    function PurchaseUpdate_post() {
        $response = $this->transaction->Purchase_Update($this->post());
        $this->response($response);
    }
    
    function InsertPurchaseSerial_post() {
        $this->transaction->Insert_Purchase_Serial($this->post());
        $this->response(array('message'=>'Purchase serial has been added!'));
        // $this->response($m);
    }
    
    function SubmitReceiving_post() {
        $header = $this->post('header');
        $rows = $this->post('rows');
        
        $response = $this->transaction->Insert_Receiving($header,$rows);
        $this->response($response);
//        $this->response($header);
    }
    
    /**** Receiving Receipts ****/
    function ReceivingReceipt_get($transid) {
        $response = $this->transaction->Receiving_Receipt($transid);
        $this->response($response);
    }
    
    function SubmitTransfer_post() {
        $header = $this->post('header');
        $rows = $this->post('rows');
        
        $response = $this->transaction->Insert_Transfer($header,$rows);
        $this->response($response);
    }
    
    function TransferReceipt_get($transid) {
        $response = $this->transaction->Transfer_Receipt($transid);
        $this->response($response);
    }
    
    function ChangeTransferStatus_post() {
        $response = $this->transaction->ChangeTransferStatus($this->post());
        $this->response($response);
    }
    
    function SubmitPullout_post() {
        $header = $this->post('header');
        $rows = $this->post('rows');
        
        $response = $this->transaction->Insert_Pullout($header,$rows);
        $this->response($response);
    }
    
    function PulloutReceipt_get($transid) {
        $response = $this->transaction->Pullout_Receipt($transid);
        $this->response($response);
    }
    
    function ChangePulloutStatus_post() {
        $response = $this->transaction->ChangePulloutStatus($this->post());
        $this->response($response);
    }
    
    function SubmitSales_post() {
        $header = $this->post('header');
        $rows = $this->post('rows');
        $customer = $this->post('customer');
        $payments = $this->post('payments');
        $used = $this->post('used');
        
        $response = $this->transaction->Insert_Sales($header,$rows, $customer, $payments,$used);
        $this->response($response);
//        $this->response($this->post());
    }
    
    function SalesReceipt_get($transid) {
        $response = $this->transaction->Sales_Receipt($transid);
        $this->response($response);
    }
    
    function GetSalesInvoice_get($transid, $store) {
        $response = $this->transaction->Get_Invoice($transid, $store);
        $this->response($response);
    }

    function VoidSales_post() {
        $transid = $this->post('TransID');
        $used = $this->post('used');
        $response = $this->transaction->Void_Sales($transid, $used);
        $this->response($response);
        // $this->response($this->post('used'));
    }
    
    function SubmitReturn_post() {
        $header = $this->post('header');
        $rows = $this->post('rows');
        $customer = $this->post('customer');
        $payments = $this->post('payments');
        $used = $this->post('used');
        
        $response = $this->transaction->Insert_Return($header,$rows, $customer, $payments,$used);
        $this->response($response);
//        $this->response($this->post());
    }
    
    function ReturnReceipt_get($transid) {
        $response = $this->transaction->Return_Receipt($transid);
        $this->response($response);
    }
    
    function CheckSI_get($invoice) {
        $result = $this->transaction->CheckSI($invoice);
        $this->response($result);
    }
    
    function CheckICC_get($invoice, $branch) {
        $result = $this->transaction->CheckICC($invoice, $branch);
        $this->response($result);
    }
    
    function addPostpaid_post() {
        $postpaid = $this->transaction->addPostpaid($this->post());
        $this->response($postpaid);
    }
    
    function updatePostpaid_post() {
        $up = $this->transaction->updatePostpaid($this->post());
        $this->response($up);
    }
    
    function cancelPostpaid_post() {
        $cancel = $this->transaction->cancelPostpaid($this->post());
        $this->response($cancel);
    }
    
}