<?php

/**
 * Data retrive 
 */
$settings['billing_first_name'] = get_user_meta($vendor_id, 'first_name', true);
$settings['billing_last_name'] = get_user_meta($vendor_id, 'last_name', true);
$settings['user_birthday'] = get_user_meta($vendor_id, 'user_birthday', true) ? date('F j, Y', strtotime(get_user_meta($vendor_id, 'user_birthday', true))) : '';
$settings['user_nationality'] = get_user_meta($vendor_id, 'user_nationality', true);
$settings['billing_country'] = get_user_meta($vendor_id, 'billing_country', true);
$settings['billing_state'] = get_user_meta($vendor_id, 'billing_state', true);
$countries = WC()->countries->get_countries();

/**
 * Mangopay options data 
 */

//$settings['default_buyer_status'] = $this->mangopayWCMain->options['default_buyer_status'];
//$settings['default_vendor_status'] = $this->mangopayWCMain->options['default_vendor_status'];

$settings['default_vendor_status'] = "";

if ("businesses" === $this->mangopayWCMain->options['default_vendor_status']) {
    $settings['default_vendor_status'] = "business";
} else if ("individuals" === $this->mangopayWCMain->options['default_vendor_status']) {
    $settings['default_vendor_status'] = "individual";
} else {
    $settings['default_vendor_status'] = "either";
}


$settings['default_business_type'] = $this->mangopayWCMain->options['default_business_type'];

//var_dump($this->mangopayWCMain->options['default_vendor_status']);
//var_dump($settings['default_vendor_status']);
//var_dump($settings['default_business_type']);

// option for mangopay user status and business type field
$all_mp_states = [
    "" => "Select an option...",
    "individual" => "Individual",
    "business" => "Business user"
];

$all_user_business_type = [
    "" => "Select an option...",
    "organisations" => "Organisation",
    "soletrader" => "Soletrader",
    "business" => "Business",
];

$states = array();

if (isset($settings['billing_country'])) {
    $states = WC()->countries->get_states($settings['billing_country']);
}

$vendor_user_billing_fields = array();
//print_r($states);


$vendor_user_billing_fields += array(
    $gateway_slug . '_wrapper_mg_payment' => array(
        'type'    => 'html',
        'class' => 'mangopay_information_section wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'    => '<h3 class="business_information_header mangopay-headlines">You have to create Mangopay account for your withdraw.</h3>',
    ),
    $gateway_slug . '_vendor_id' => array(
        'type'            => 'hidden',
        'name'             => $gateway_slug . '_vendor_id',
        'class' => 'raju',
        'value'         => $vendor_id
    ),
    $gateway_slug . '_firstname' => array(
        'label'         => __('First Name', 'wc-multivendor-marketplace'),
        'type'            => 'text',
        'name'             => 'payment[' . $gateway_slug . '][firstname]',
        'class'         => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'     => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'         => $settings['billing_first_name'],
        'custom_attributes'    => array(
            'required'    => 'required'
        ),
    ),

    $gateway_slug . '_firstname_error_msg' => array(
        'type'    => 'html',
        'value'    => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
    ),

    $gateway_slug . '_lastname' => array(
        'label'         => __('Last Name', 'wc-multivendor-marketplace'),
        'type'            => 'text',
        'name'             => 'payment[' . $gateway_slug . '][_firstname]',
        'class'         => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'     => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'         => $settings['billing_last_name'],
        'custom_attributes'    => array(
            'required'    => 'required'
        ),
    ),

    $gateway_slug . '_laststname_error_msg' => array(
        'type'    => 'html',
        'value'    => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
    ),

    $gateway_slug . '_birthday' => array(
        'label'         => __('Birthday', 'wc-multivendor-marketplace'),
        'type'            => 'datepicker',
        'name'             => 'payment[' . $gateway_slug . '][birthday]',
        'class'         => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'     => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'         => $settings['user_birthday'],
        'custom_attributes'    => array(
            'required'    => 'required'
        ),
    ),

    $gateway_slug . '_birthday_error_msg' => array(
        'type'    => 'html',
        'value'    => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
    ),
    $gateway_slug . '_nationality' => array(
        'label'         => __('Nationality', 'wc-multivendor-marketplace'),
        'type'             => 'select',
        'options'         => WC()->countries->get_countries(),
        'name'             => 'payment[' . $gateway_slug . '][nationality]',
        'class'         => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'     => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'         => $settings['user_nationality'],
        'custom_attributes'    => array(
            'required'    => 'required'
        ),
    ),
    $gateway_slug . '__nationality_error_msg' => array(
        'type'    => 'html',
        'value'    => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
    ),

    $gateway_slug . '_billing_country' => array(
        'label'                 => __('Country of Residence', 'wc-multivendor-marketplace'),
        'type'                  => 'select',
        'options'               => WC()->countries->get_countries(),
        'name'                  => 'payment[' . $gateway_slug . '][billing_country]',
        'class'                 => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'           => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'         => $settings['billing_country'],
        'custom_attributes'     => array(
            'required'          => 'required'
        ),
    ),

    $gateway_slug . '_billing_country_error_msg' => array(
        'type'    => 'html',
        'value'    => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
    ),

    $gateway_slug . '_billing_state' => array(
        'label'                 => __('State', 'wc-multivendor-marketplace'),
        'type'                  => 'select',
        'options'               => $states,
        'name'                  => 'payment[' . $gateway_slug . '][billing_state]',
        'class'                 => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'           => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'         => $settings['billing_state'],
        // 'custom_attributes'     => array(
        //     'required'          => 'required'
        // ),
    ),

    // $gateway_slug . '_billing_state_error_msg' => array(
    //     'type'    => 'html',
    //     'value'    => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
    // ),

    /**
     * Start - User status and Business type - hiiden field
     */

    $gateway_slug . '_default_vendor_status' => array(
        'label'                 => __('Vendor', 'wc-multivendor-marketplace'),
        'type'                  => 'hidden',
        'options'               => $all_mp_states,
        'name'                  => 'payment[' . $gateway_slug . '][default_vendor_status]',
        'class'                 => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'           => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'                 => $settings['default_vendor_status'],
        'custom_attributes'     => array(
            'required'          => 'required'
        ),
    ),

    $gateway_slug . '_default_business_type' => array(
        'label'                 => __('Type', 'wc-multivendor-marketplace'),
        'type'                  => 'hidden',
        'options'               => $all_user_business_type,
        'name'                  => 'payment[' . $gateway_slug . '][default_business_type]',
        'class'                 => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'           => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'                 => $settings['default_business_type'],
        'custom_attributes'     => array(
            'required'          => 'required'
        ),
    ),

    /**
     * End --- User status and Business type 
     */


    $gateway_slug . '_user_mp_status' => array(
        'label'                 => __('User status', 'wc-multivendor-marketplace'),
        'type'                  => 'select',
        'options'               => $all_mp_states,
        'name'                  => 'payment[' . $gateway_slug . '][user_mp_status]',
        'class'                 => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'           => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'                 => $settings['default_vendor_status'],
        'custom_attributes'     => array(
            'required'          => 'required'
        ),
    ),

    $gateway_slug . '_user_mp_status_error_msg' => array(
        'type'    => 'html',
        'value'    => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
    ),

    $gateway_slug . '_user_business_type' => array(
        'label'                 => __('Business type', 'wc-multivendor-marketplace'),
        'type'                  => 'select',
        'options'               => $all_user_business_type,
        'name'                  => 'payment[' . $gateway_slug . '][user_business_type]',
        'class'                 => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'           => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'                 => $settings['default_business_type'],
        'custom_attributes'     => array(
            'required'          => 'required'
        ),
    ),

    $gateway_slug . '_user_business_type_error_msg' => array(
        'type'    => 'html',
        'value'    => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
    ),

    $gateway_slug . '_user_business_type_wise_message' => array(
        'type'    => 'html',
        'value'    => '<p id="mc_message" class="description  wcfm_page_options_desc"></p>',
    ),


    $gateway_slug . '_button_mp_submit' => array(
        'type'                  => 'html',
        'name'                  => 'payment[' . $gateway_slug . ']',
        'class'                 => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'           => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value'                  => '<input type="button" id="submit_mp" value="' . __('Submit', 'wc-multivendor-marketplace') . '"><img src="' . plugin_dir_url(__DIR__) . 'assets/images/ajax-loader.gif' . '" height="20" width="20" id="ajax_loader"/><div id="mp_submit"></div>'
    ),

    $gateway_slug . '_error_messages' => array(
        'type'                  => 'html',
        'name'                  => 'payment[' . $gateway_slug . ']',
        'class'                 => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class'           => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        // 'value'                  => '<div id="error-messages"></div>'
    ),
);


//echo "<pre>";
//var_dump($vendor_user_billing_fields);

//$user_mp_register_fields = array_merge($bank_fileds, $user_fileds_1);

/**
 * first name 
 * last name 
 * birthday 
 * Nationality 
 * Country / Region
 * State / County
 * Business type 

 */
