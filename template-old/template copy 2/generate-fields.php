<?php
// wrapper tab html 
$wrapper_html_fields = [];
$user_mp_status = 'business';
$user_business_type = 'business';

/**
 * Tab list added here 
 * Mp Notice Fields 
 * Common Fields 
 * Business_fields
 * Headquarters_address_fields
 * User status fields
 */
// 
require_once "parts/tab-list.php";
require_once "parts/mp-notice.php";
require_once "parts/kyc-fields.php";
require_once "parts/bank-fields.php";
require_once "parts/ubo-fields.php";
require_once "parts/user_information.php";



$generate_fields = array_merge(
    $mp_notice_fields,
  //  $wrapper_html_fields,

    $user_information,

  //  $vendor_kyc_billing_fields,

  //  $vendor_bank_billing_fields,
    // $vendor_iban_billing_fields,
   // $vendor_ubo_billing_fields,
    // $vendor_wrapper_bank_account_open,
    // $vendor_bank_billing_fields,
    // $vendor_iban_billing_fields,
    // $vendor_gb_billing_fields,
    // $vendor_us_billing_fields,
    // $vendor_ca_billing_fields,
    // $vendor_other_billing_fields,
    // $vendor_add_bank_account,
    // $vendor_wrapper_bank_account_close
);


/**
 * User Information
 *  1.Birthday
 *  2. Natiinality 
 *  3. User Status 
 *  4. Business type  
 * 
 * Company Number 
 *  1. Company number 
 * 
 * Headquarters Address
 *  1. Address fields 
 * 
 * Mangopay terms and Conditions 
 *   1. Checkbox 
 */















/**
 * Basic Fields List
 * -------------------------------------------------
 *8  LegalRepresentativeFirstName + 
 *9  LegalRepresentativeLastName + 
 *5  LegalRepresentativeBirthday + 
 *7  LegalRepresentativeNationality + 
 *6  LegalRepresentativeCountryOfResidence + 
 *3  Email ( By using open MP account  )
 */

/**
 *4  CompanyNumber
 */

/**
 * 1  HeadquartersAddress -
 */

/**
 * * User status
 *2 LegalPersonType -
 */
























/**
 * Basic Fields List 
    *8  LegalRepresentativeFirstName + 
    *9 LegalRepresentativeLastName + 
    *5  LegalRepresentativeBirthday + 
    *7  LegalRepresentativeNationality + 
    *6  LegalRepresentativeCountryOfResidence + 
    *3  Email ( By using open MP account  )
    *4  CompanyNumber
    
    *10  UserCategory
    *11  TermsAndConditionsAccepted
    *1  HeadquartersAddress -
        * User status
    *2 LegalPersonType -

    * Tag


 * State + 
    
   
     
    
 * LegalRepresentativeAddress
 * LegalRepresentativeEmail
    * Name (Company name ) -

 */
