<?php
require_once "account-create/common.php";
require_once "account-create/company-number.php";
require_once "account-create/HeadquartersAddress.php";
require_once "account-create/user-type.php";

// Account Creation Tab Content

$user_information = array( // start tag
    $gateway_slug . '_wrapper_mp_create' => array(
        'type' => 'html',
        'class' => 'mangopay_information_section wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<div>',
    ),
);

// Merge common information
$user_information = array_merge($user_information, $common_information);

// user type 
$user_information = array_merge($user_information, $user_type_fields);

// company number fields added here
$user_information = array_merge($user_information, $company_number_information);

// HeadquartersAddress fields added here 
$user_information = array_merge($user_information, $HeadquartersAddress_fields);


$user_information += array(
    $gateway_slug . '_wrapper_mp_create_close' => array( // end tag 
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '</div>'
    ),
);

/**
 * MP account creation fields 
 * 1. HeadquartersAddress
 * 2. Name (Company Number )
 * 3. LegalPersonType
 * 5. LegalRepresentativeFirstName
 * 6. LegalRepresentativeLastName
 * 7. LegalRepresentativeBirthday
 * 8. LegalRepresentativeNationality
 * 9. LegalRepresentativeCountryOfResidence
 * 9. CompanyNumber
 * 10. Email 
 * 11. TermsAndConditionsAccepted
 * 12. UserCategory
 * 
 * 
 * 
 * 
 *//**
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


