<?php

// wrapper tab html 
$wrapper_html_fields = [];

//CREATE OPTIONS
$mangopay_tab_option_html = '<ul>';
$mangopay_tab_option_html .= '<li><a href="#" id="business_info" class="active" data-link="mangopay_wrapper_businessinfo">Account Creation</a></li>';
if ($user_mp_status == 'business' && $user_business_type == 'business')
    $mangopay_tab_option_html .= '<li><a href="#" id="business_info" data-link="mangopay_wrapper_uboinfo">UBO Information</a></li>';
$mangopay_tab_option_html .= '<li><a href="#" id="business_info" data-link="mangopay_wrapper_kyc">KYC Details</a></li>';
$mangopay_tab_option_html .= '<li><a href="#" id="business_info" data-link="mangopay_wrapper_bank_account">Bank Details</a></li>';
$mangopay_tab_option_html .= '</ul>';


$wrapper_html_fields += array(
    $gateway_slug . '_wrapper_section_options' => array(
        'type'    => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'    => $mangopay_tab_option_html
    ),
);


//common_fields

// business_fields

//headquarters_address_fields

// user_status_fields


$generate_fields = array_merge(
    $wrapper_html_fields,
    $common_fields, // First Name + Last Name + Birthday + Nationality + Country of Residence + Email 
    $business_fields, // Company Number 
    $headquarters_address_fields, // Head quarters address
    $user_status_fields, // 

    // $vendor_kyc_billing_fields,
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
