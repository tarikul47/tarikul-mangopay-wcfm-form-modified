<?php
/**
 * Tab List
 */

//CREATE OPTIONS
$mangopay_tab_option_html = '<ul>';
$mangopay_tab_option_html .= '<li><a href="#" id="business_info" class="active" data-link="mangopay_wrapper_mp_create">Account Creation</a></li>';
if ($user_mp_status == 'business' && $user_business_type == 'business')
    $mangopay_tab_option_html .= '<li><a href="#" id="business_info" data-link="mangopay_wrapper_uboinfo">UBO Information</a></li>';
$mangopay_tab_option_html .= '<li><a href="#" id="business_info" data-link="mangopay_wrapper_kyc">KYC Details</a></li>';
$mangopay_tab_option_html .= '<li><a href="#" id="business_info" data-link="mangopay_wrapper_bank_account">Bank Details</a></li>';
$mangopay_tab_option_html .= '</ul>';


$tab_fields = array(
    $gateway_slug . '_wrapper_section_options' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $mangopay_tab_option_html
    ),
);


// tab content 1 
// $wrapper_html_fields += array(
//     $gateway_slug . '_wrapper_mp_create' => array(  // start tag 
//         'type' => 'html',
//         'class' => 'mangopay_information_section wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
//         'value' => '<div>'
//     ),
//     $gateway_slug . '_wrapper_mp_create_text' => array(
//         'type' => 'html',
//         'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
//         'value' => '<h1>Account Creation</h1>'
//     ),
//     $gateway_slug . '_wrapper_mp_create_close' => array( // end tag 
//         'type' => 'html',
//         'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
//         'value' => '</div>'
//     ),
// );

// tab content 2
// $wrapper_html_fields += array(
//     $gateway_slug . '_wrapper_uboinfo' => array( // start tag 
//         'type' => 'html',
//         'class' => 'mangopay_information_section wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
//         'value' => '<div>'
//     ),
//     $gateway_slug . '_wrapper_uboinfo_text' => array( // start tag 
//         'type' => 'html',
//         'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
//         'value' => 'UBO text'
//     ),
//     $gateway_slug . '_wrapper_uboinfo_close' => array( // end tag 
//         'type' => 'html',
//         'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
//         'value' => '</div>'
//     ),
// );

// tab content 3
// $wrapper_html_fields += array(
//     $gateway_slug . '_wrapper_bank_account' => array(
//         'type' => 'html',
//         'class' => 'mangopay_information_section wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
//         'value' => '<h2>Bank Account'
//     ),
//     $gateway_slug . '_wrapper_bank_account_price' => array(
//         'type' => 'html',
//         'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
//         'value' => '</h2>'
//     ),
// );

// tab content 4
// $wrapper_html_fields += array(
//     $gateway_slug . '_wrapper_kyc' => array(
//         'type' => 'html',
//         'class' => 'mangopay_information_section wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
//         'value' => '<div>'
//     ),
//     $gateway_slug . '_wrapper_kyc_text' => array(
//         'type' => 'html',
//         'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
//         'value' => 'Hello World kyc'
//     ),
//     $gateway_slug . '_wrapper_kyc_close' => array(
//         'type' => 'html',
//         'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
//         'value' => '</div>'
//     ),
// );
