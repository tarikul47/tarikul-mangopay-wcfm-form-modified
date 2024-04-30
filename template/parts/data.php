<?php
$settings = [];
$user_type_fields = [];
$user_mp_status = 'business';
$user_business_type = 'business';

//$user_mp_status = get_user_meta($vendor_id, 'user_mp_status', true) ? get_user_meta($vendor_id, 'user_mp_status', true) : '';
//$user_business_type = get_user_meta($vendor_id, 'user_business_type', true) ? get_user_meta($vendor_id, 'user_business_type', true) : '';


$settings['user_mp_status']     = isset($vendor_data['payment'][$gateway_slug]['user_mp_status']) ? $vendor_data['payment'][$gateway_slug]['user_mp_status'] : '';
$settings['user_business_type'] = isset($vendor_data['payment'][$gateway_slug]['user_business_type']) ? $vendor_data['payment'][$gateway_slug]['user_business_type'] : '';


/**
 * GET ALL HINTS
 */

$business_information_hints = get_option('wcfm_business_information_hints');
$company_number_hints = get_option('wcfm_company_number_hints');
$legal_rep_email_hints = get_option('wcfm_legal_rep_email_hints');
$headquarter_address_hints = get_option('wcfm_headquarter_address_hints');
$ubo_information_hints = get_option('wcfm_ubo_information_hints');
$kyc_details_hints = get_option('wcfm_kyc_details_hints');
$bank_details_hints = get_option('wcfm_bank_details_hints');
$add_bank_hints = get_option('wcfm_add_bank_hints');
$upload_files_hints = get_option('wcfm_upload_files_hints');
$submit_kyc_hints = get_option('wcfm_submit_kyc_hints');


/**
 * Account Creation tab data 
 */

// birtdate rerive from user meta with format 
$settings['user_birthday'] = date('F j, Y', strtotime(get_user_meta($vendor_id, 'user_birthday', true)));

// nationality rerive from user meta with format
$settings['user_nationality'] = get_user_meta($vendor_id, 'user_nationality', true);

// company number rerive from user meta with format
$settings['compagny_number'] = get_user_meta($vendor_id, 'compagny_number', true) ? get_user_meta($vendor_id, 'compagny_number', true) : '';

// Legal Representative Country Of Residence rerive from user meta with format
$settings['billing_country'] = get_user_meta($vendor_id, 'billing_country', true);

// Representative Compnay Name rerive from user meta with format
$settings['compnay_name'] = get_user_meta($vendor_id, 'compnay_name', true);

// Legal email rerive from user meta with format
$settings['legal_email'] = get_user_meta($vendor_id, 'legal_email', true) ? get_user_meta($vendor_id, 'legal_email', true) : '';


// HeadquartersAddress Data
$settings['hq_address'] = get_user_meta($vendor_id, 'headquarters_addressline1', true) ? get_user_meta($vendor_id, 'headquarters_addressline1', true) : '';
$settings['hq_address2'] = get_user_meta($vendor_id, 'headquarters_addressline2', true) ? get_user_meta($vendor_id, 'headquarters_addressline2', true) : '';
$settings['hq_region'] = get_user_meta($vendor_id, 'headquarters_region', true) ? get_user_meta($vendor_id, 'headquarters_region', true) : '';
$settings['hq_city'] = get_user_meta($vendor_id, 'headquarters_city', true) ? get_user_meta($vendor_id, 'headquarters_city', true) : '';
$settings['hq_postalcode'] = get_user_meta($vendor_id, 'headquarters_postalcode', true) ? get_user_meta($vendor_id, 'headquarters_postalcode', true) : '';
$settings['hq_country'] = get_user_meta($vendor_id, 'headquarters_country', true) ? get_user_meta($vendor_id, 'headquarters_country', true) : '';

// termsconditions data 
$settings['termsconditions'] = get_user_meta($vendor_id, 'termsconditions', true) ? 'yes' : 'no';

/**
 * KYC data 
 */
$kyc_options = $this->mangopay_kyc_list($mp_user_id, $user_mp_status, $user_business_type);
$kyc_validation = $this->mangopay_kyc_validation($mp_user_id, $user_business_type);
$kyc_documents = $this->mangopay_kyc_html($mp_user_id);

/**
 * Bank data 
 */
$bank_details_hints = get_option('wcfm_bank_details_hints');
$add_bank_hints = get_option('wcfm_add_bank_hints');