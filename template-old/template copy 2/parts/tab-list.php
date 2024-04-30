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


$wrapper_html_fields += array(
    $gateway_slug . '_wrapper_section_options' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $mangopay_tab_option_html
    ),
);
