<?php
//print_r($this->mp->default_business_type);
$company_number_information = [];
//if ('businesses' == $this->mp->default_business_type) {
$company_number_information = array(
    $gateway_slug . '_header_company_number' => array(
        'type' => 'html',
        'class' => 'company_number_box paymode_field paymode_' . $gateway_slug,
        'value' => '<div>',
    ),
    $gateway_slug . '_header_company_number_heading' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<h3><strong>' . __('Company Number', 'wc-multivendor-marketplace') . '</strong></h3>',
    ),
    $gateway_slug . '_compagny_number' => array(
        'label' => __('Company Number', 'wc-multivendor-marketplace'),
        'type' => 'text',
        'name' => 'payment[' . $gateway_slug . '][compagny_number]',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['compagny_number'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
        'hints' => $company_number_hints,
    ),
    $gateway_slug . '_header_company_number_close' => array(
        'type' => 'html',
        'class' => 'paymode_field paymode_' . $gateway_slug,
        'value' => '</div>',
    ),
);
//}