<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
	'user_post' => array(
		array('field' => 'Email', 'label' => 'email address', 'rules' => 'trim|required|valid_email'),
		array('field' => 'DisplayName', 'label' => 'Display Name', 'rules' => 'trim|required|max_length[50]'),
		array('field' => 'LastName', 'label' => 'Last name', 'rules' => 'trim|required|max_length[50]'),
		array('field' => 'FirstName', 'label' => 'First name', 'rules' => 'trim|required|max_length[50]'),
// 		array('field' => 'MiddleName', 'label' => 'Middle name', 'rules' => 'trim|required|max_length[50]'),
	    array('field' => 'Account', 'label' => 'Merchant or Branch ID', 'rules' => 'trim|required|integer'),
	    array('field' => 'UserType', 'label' => 'Type of Account', 'rules' => 'trim|required|integer'),
	    array('field' => 'ContactNo', 'label' => 'Contact No', 'rules' => 'trim|required|numeric|exact_length[11]')
	),
	'login_put' => array(
		array('field' => 'Email', 'label' => 'User ID or Email', 'rules' => 'trim|required'),
		array('field' => 'Password', 'label' => 'Password', 'rules' => 'trim|required')
	),
	'merchant_post' => array(
		array('field' => 'MerchantName', 'label' => 'Merchant Name', 'rules' => 'trim|required|min_length[4]|max_length[50]'),
		array('field' => 'ShortName', 'label' => 'Alias', 'rules' => 'trim|required|max_length[20]'),
		array('field' => 'Address', 'label' => 'Address', 'rules' => 'trim|required|max_length[100]'),
		array('field' => 'Email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|max_length[50]'),
	    array('field' => 'Lname', 'label' => 'Last Name', 'rules' => 'trim|required|max_length[50]'),
	    array('field' => 'Fname', 'label' => 'First Name', 'rules' => 'trim|required|max_length[50]'),
	    array('field' => 'Contact', 'label' => 'Contact', 'rules' => 'trim|required|numeric|exact_length[11]'),
	    array('field' => 'CreatedBy', 'label' => 'Creator Account', 'rules' => 'trim|required|exact_length[32]'),
	),
    'admin_funding' => array(
        array('field' => 'destination_token', 'label' => 'Source Wallet', 'rules' => 'trim|required|exact_length[32]'),
        array('field' => 'credits', 'label' => 'Credits', 'rules' => 'trim|required|numeric')
        
    ),
    'wallet_funding' => array(
        array('field' => 'source_token', 'label' => 'Source Wallet', 'rules' => 'trim|required|exact_length[32]'),
        array('field' => 'destination_token', 'label' => 'Destination Wallet', 'rules' => 'trim|required|exact_length[32]'),
        array('field' => 'credits', 'label' => 'Credits', 'rules' => 'trim|required|numeric')
    
    ),
    'main_post' => array(
        array('field' => 'user_token', 'label' => 'User Code', 'rules' => 'trim|required|exact_length[32]'),
    ),
    'password_post' => array(
        array('field' => 'username', 'label' => 'Email', 'rules' => 'trim|required'),
        array('field' => 'oldpassword', 'label' => 'Old Password', 'rules' => 'trim|required|min_length[8]'),
        array('field' => 'newpassword', 'label' => 'New Password', 'rules' => 'trim|required|min_length[8]'),
    ),
	'branch_post' => array(
		array('field' => 'MerchantID', 'label' => 'Merchant ID', 'rules' => 'trim|required'),
		array('field' => 'Name', 'label' => 'Branch Name', 'rules' => 'trim|required|max_length[50]'),
		array('field' => 'Area', 'label' => 'Area', 'rules' => 'trim|required|max_length[15]'),
		array('field' => 'City', 'label' => 'City', 'rules' => 'trim|required|max_length[30]'),
		array('field' => 'Address', 'label' => 'Address', 'rules' => 'trim|required|max_length[100]'),
	    array('field' => 'Email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|max_length[50]'),
	    array('field' => 'Lname', 'label' => 'Last Name', 'rules' => 'trim|required|max_length[50]'),
	    array('field' => 'Fname', 'label' => 'First Name', 'rules' => 'trim|required|max_length[50]'),
	    array('field' => 'Contact', 'label' => 'Contact', 'rules' => 'trim|required|numeric|exact_length[11]'),
	    array('field' => 'CreatedBy', 'label' => 'Creator Account', 'rules' => 'trim|required|exact_length[32]'),
	),
    'eload_post' => array(
        array('field' => 'product_id', 'label' => 'Product Code', 'rules' => 'trim|required|integer'),
        array('field' => 'account', 'label' => 'Mobile No.', 'rules' => 'trim|required|exact_length[11]|numeric'),
        array('field' => 'user_token', 'label' => 'User Code', 'rules' => 'trim|required|exact_length[32]'),
        array('field' => 'convenience_fee', 'label' => 'Convenience Fee', 'rules' => 'trim|numeric')
    ),
    'bills_post' => array(
        array('field' => 'product_id', 'label' => 'Product Code', 'rules' => 'trim|required|integer'),
        array('field' => 'account', 'label' => 'Account No.', 'rules' => 'trim|required'),
        array('field' => 'cost', 'label' => 'Amount', 'rules' => 'trim|required|max_length[15]|numeric'),
        array('field' => 'customer', 'label' => 'Customer', 'rules' => 'trim|required|max_length[30]'),
        array('field' => 'user_token', 'label' => 'User Code', 'rules' => 'trim|required|exact_length[32]'),
        array('field' => 'convenience_fee', 'label' => 'Convenience Fee', 'rules' => 'trim|numeric')
    ),
    'mobile_post' => array(
        array('field' => 'product_id', 'label' => 'Product Code', 'rules' => 'trim|required|integer'),
        array('field' => 'account', 'label' => 'Account No.', 'rules' => 'trim|required|min_length[11]|max_length[16]'),
        array('field' => 'cost', 'label' => 'Amount', 'rules' => 'trim|required|max_length[15]|numeric'),
        array('field' => 'user_token', 'label' => 'User Code', 'rules' => 'trim|required|exact_length[32]'),
        array('field' => 'convenience_fee', 'label' => 'Convenience Fee', 'rules' => 'trim|numeric')
    ),
    'email_post' => array(
        array('field' => 'recipient', 'label' => 'Recipient', 'rules' => 'trim|required|max_length[100]'),
        array('field' => 'reply_to', 'label' => 'Reply To', 'rules' => 'trim|required|max_length[50]'),
        array('field' => 'subject', 'label' => 'Subject', 'rules' => 'trim|required|max_length[100]'),
        array('field' => 'message', 'label' => 'Message', 'rules' => 'trim|required')
    )
)

?>