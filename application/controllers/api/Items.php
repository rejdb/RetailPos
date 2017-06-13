<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Items extends REST_Controller {

    function __construct() {
        parent:: __construct();
        date_default_timezone_set('Asia/Manila');
        $this->load->Model('api/item');
    }
    
    //get all products
    function all_get() {
        $all = $this->item->get_all();
        $this->response($all);
    }
    
    //get all links to Item reference table
    function links_get(){
        $links = $this->item->getTableLinks();
        $this->response($links);
    }
    
    //get products by status
    function active_get($IsActive) {
        $all = $this->item->by_filter(array('IsActive'=>$IsActive));
        $this->response($all);
    }
    
    //search Item table by any parameter
    function search_post() {
        $search = $this->item->by_filter($this->post());
        $this->response($search);
    }
    
    //Update Item Master Data
    function update_post() {
        $this->item->update($this->post('PID'), $this->post('type'));
        $this->response(array('message'=>'Item has been successfully updated!'));
    }
    
    //add entry to Items reference table
    function addReference_post() {
        $table = $this->post('table');
        $data = $this->post('data');
        
        $exists = $this->item->ref_filter($data,$table);
        if($exists) {
            $message = 'Data already exists!';
        }else{
            if($table=='stp_item_pricelist') {
                $message = $this->item->insert_item_to_pricelist($table, $data);
            }else{
                $message = $this->item->add_reference($table, $data);
            }
        }
        $this->response(array('message'=>$message));
    }

    //update entry to Items reference table
    function updateReference_post() {
        $table = $this->post('table');
        $data = $this->post('data');
        $id = $this->post('id');
        
        $message = $this->item->update_reference($table, $data, $id);
        $this->response(array('message'=>$message));
    }
    
    //Add new product to the database
    function addNewProduct_post() {
        $data = $this->post('product');
        $price = $this->post('price');
        
        $existsBarCode = $this->item->get_by(array('BarCode'=>trim($data['BarCode'])));
        $existsDesc = $this->item->get_by(array('ProductDesc'=>trim($data['ProductDesc'])));
        
        if($existsBarCode || $existsDesc) {
            $message = array('success'=>false, 'message'=> 'Bar Code or Description already exists! Please Check.');
        }else{
            $id = $this->item->insert($data);
            $message = $this->item->insert_pricelist($id, $price);
        }
        $this->response($message);
    }
    
    //Update price detail table
    function updatePrice_post() {
        $id = $this->post('PDID');
        $data = $this->post('type');
        
        $this->item->updatePrice($id, $data);
        $this->response(array('message'=>'Price has been changed!'));
    }
    
    //Add new campaign to database
    function addCampaign_post() {
        $title = $this->post('title');
        $campaign = array(
            'CampaignName' => $title['CampaignName'],
            'DateFrom' => date('Y-m-d', strtotime(str_replace('-','/',$title['DateFrom']))),
            'DateTo' => date('Y-m-d', strtotime(str_replace('-','/',$title['DateTo'])))
        );
        $branches = $this->post('BranchID');
        $items = $this->post('products');
        
        $rsp = $this->item->addCampaign($campaign,$branches,$items);
        
        $this->response($rsp);
    }
    
    //Get all campaign List
    function getCampaign_get() {
        $list = $this->item->getAllCampaign();
        $this->response($list);
    }
    
    //Delete a campaign
    function deleteCampaign_get($CampaignID) {
        $message = $this->item->deleteCampaign($CampaignID);
        return $message;
    }

    //Upload Item Master
    function uploadItemMaster_post() {
        $filename = $_FILES['file']['name'];
	    $file = $_FILES['file']['tmp_name'];

        if($filename != 'Item_Master_Template.csv') {
            $this->response(array('error'=>false,'message'=>'Wrong filename (rename to: Item_Master_Template.csv)'));
        }else{
            $fp = file($file);
            $handle = fopen($file, "r");
            $skipRowZero = 0; $items = array(); $price = array();
            $all_items = array_column($this->item->get_all(), 'BarCode');
            $pricelist = $this->item->getTableLinks()['pricelists'];

            $newid = $this->item->getLastID();
            $id = (int)$newid[0]->Auto_increment;
            $found_key = array();

            while(($filesop = fgetcsv($handle, 1000, ",")) !== false) {
                if($skipRowZero>0) {
                    $found = array_search(trim($filesop[0]), $all_items);
                    if($found===false) {
                        // array_push($found_key, $found);
                        array_push($items, array(
                            'PID' => $id,
                            'BarCode' => trim($filesop[0]),
                            'ProductDesc' => trim($filesop[1]),
                            'SKU' => trim($filesop[2]),
                            'ItemType' => (int)trim($filesop[3]),
                            'Brand' => (int)trim($filesop[4]),
                            'Category' => (int)trim($filesop[6]),
                            'LifeCycle' => (int)trim($filesop[7]),
                            'Family' => (int)trim($filesop[5]),
                            'IsSerialized' => (int)$filesop[8],
                            'OrderLevel' => (int)trim($filesop[9]),
                            'StdCost' => (float)trim($filesop[10]),
                            // 'Price' => (float)trim($filesop[11]),
                            'PriceList' => (int)trim($filesop[12])
                        ));

                        foreach($pricelist as $srp) {
                            array_push($price, array(
                                'PLID' => (int)$srp['PLID'],
                                'PID' => $id,
                                'Price' => (float)trim($filesop[11])
                            ));
                        }
                        $id++;
                    }
                } $skipRowZero++;
            }

            $Save = array('success'=>false, 'message'=>'All Items Exists!');
            if(count($items)>0) {
                $Save = $this->item->uploadItemMaster($items,$price);
            }
            $this->response($Save);
        }
        // $this->response($this->post());
    }

    function updatePriceList_post() {
        $filename = $_FILES['file']['name'];
	    $file = $_FILES['file']['tmp_name'];

        if($filename != 'Price_Template.csv') {
            $this->response(array('error'=>false,'message'=>'Wrong filename (rename to: Price_Template.csv)'));
        }else{
            $fp = file($file);
            $handle = fopen($file, "r");
            $skipRowZero = 0; $prices = array();

            while(($filesop = fgetcsv($handle, 1000, ",")) !== false) {
                if($skipRowZero>0) {
                    $pricelist = (int)trim($filesop[1]);
                    array_push($prices, array(
                        'PID' => (int)trim($filesop[0]),
                        'PLID' => (int)trim($filesop[1]),
                        'Price' => (float)trim($filesop[2]),
                    ));
                } $skipRowZero++;
            }

            // $Save = array('success'=>false, 'message'=>'All Items Exists!');
            if(count($prices)>0) {
                $Save = $this->item->updatePriceListDet($prices,$pricelist);
            }
            $this->response($Save);
        }
    }
}?>