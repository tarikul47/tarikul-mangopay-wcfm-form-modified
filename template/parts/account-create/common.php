<?php

// common fields added here 
$common_information = array(

    $gateway_slug . '_header_user_info' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<h3><strong>' . __('User Information', 'wc-multivendor-marketplace') . '</strong></h3>',
    ),

    /**
     * Our custom field set here on Mangopay payment page - raju
     */
    $gateway_slug . '_user_birthday' => array(
        'label' => __('Birthday', 'wc-multivendor-marketplace'),
        'type' => 'datepicker',
        'name' => 'payment[' . $gateway_slug . '][user_birthday]',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['user_birthday'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),
    $gateway_slug . '_user_nationality' => array(
        'label' => __('Nationality', 'wc-multivendor-marketplace'),
        'type' => 'select',
        'options' => WC()->countries->get_countries(),
        'name' => 'payment[' . $gateway_slug . '][user_nationality]',
        'class' => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['user_nationality'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),
    $gateway_slug . '_billing_country' => array(
        'label' => __('Country of Residence', 'wc-multivendor-marketplace'),
        'type' => 'select',
        'options' => WC()->countries->get_countries(),
        'name' => 'payment[' . $gateway_slug . '][billing_country]',
        'class' => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['billing_country'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),
    $gateway_slug . '_compnay_name' => array(
        'label' => __('Registered Compnay Name', 'wc-multivendor-marketplace'),
        'type' => 'text',
        'name' => 'payment[' . $gateway_slug . '][compnay_name]',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['compnay_name'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    // $gateway_slug . '_legal_email' => array(
    //     'label' => __('Legal Representative Email', 'wc-multivendor-marketplace'),
    //     'type' => 'text',
    //     'name' => 'payment[' . $gateway_slug . '][legal_email]',
    //     'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
    //     'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
    //     'value' => $settings['legal_email'],
    //     'custom_attributes' => array(
    //         'required' => 'required'
    //     ),
    //     'hints' => $legal_rep_email_hints,
    // ),
);

