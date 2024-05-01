<?php
/**
 * Generate Fields 
 */
require_once "parts/data.php"; // All variable data 
require_once "parts/default.php"; // Default data 
//require_once "parts/mp-notice.php"; // All notice data 
require_once "parts/tab-list.php"; // Tab html 
require_once "parts/user_information.php"; // MP account creation 
require_once "parts/ubo-fields.php"; // UBO functionality 
require_once "parts/kyc-fields.php"; // KYC functionality 
require_once "parts/bank-fields.php"; // Bank functionality 

$generate_fields = array_merge(
  //  $mp_notice_fields,
    $default_fields,
    $tab_fields,
    $user_information,
    $ubo_fields,
    $kyc_fields,
    $bank_fields
);