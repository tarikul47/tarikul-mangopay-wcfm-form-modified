<?php
require_once "HeadquartersAddress.php";

$user_information = array(
    $gateway_slug . '_wrapper_mp_create' => array(
        'type' => 'html',
        'class' => 'mangopay_information_section wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<div>',
    ),
);

$user_information += array(
  
    $gateway_slug . '_header_mp_create' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<div class="mangopay-headlines"><span class="img_tip wcfmfa fa-question" data-tip="' . $bank_details_hints . '" data-hasqtip="50" aria-describedby="qtip-50"></span><h3><strong>' . __('You have to create Mangopay account for your withdraw.', 'wc-multivendor-marketplace') . '</strong></h3></div>',
    ),

    $gateway_slug . '_vendor_id' => array(
        'type' => 'hidden',
        'name' => $gateway_slug . '_vendor_id',
        'class' => 'raju',
        'value' => $vendor_id
    ),

    $gateway_slug . '_firstname' => array(
        'label' => __('First Name', 'wc-multivendor-marketplace'),
        'type' => 'text',
        'name' => 'payment[' . $gateway_slug . '][firstname]',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['billing_first_name'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_lastname' => array(
        'label' => __('Last Name', 'wc-multivendor-marketplace'),
        'type' => 'text',
        'name' => 'payment[' . $gateway_slug . '][_firstname]',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['billing_last_name'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_birthday' => array(
        'label' => __('Birthday', 'wc-multivendor-marketplace'),
        'type' => 'datepicker',
        'name' => 'payment[' . $gateway_slug . '][birthday]',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['user_birthday'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_nationality' => array(
        'label' => __('Nationality', 'wc-multivendor-marketplace'),
        'type' => 'select',
        'options' => WC()->countries->get_countries(),
        'name' => 'payment[' . $gateway_slug . '][nationality]',
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

    $gateway_slug . '_billing_state' => array(
        'label' => __('State', 'wc-multivendor-marketplace'),
        'type' => 'select',
        'options' => $states,
        'name' => 'payment[' . $gateway_slug . '][billing_state]',
        'class' => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['billing_state'],
        // 'custom_attributes'     => array(
        //     'required'          => 'required'
        // ),
    ),

    /**
     * Start - User status and Business type - hiiden field
     */

    $gateway_slug . '_default_vendor_status' => array(
        'label' => __('Vendor', 'wc-multivendor-marketplace'),
        'type' => 'hidden',
        'options' => $all_mp_states,
        'name' => 'payment[' . $gateway_slug . '][default_vendor_status]',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['default_vendor_status'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_default_business_type' => array(
        'label' => __('Type', 'wc-multivendor-marketplace'),
        'type' => 'hidden',
        'options' => $all_user_business_type,
        'name' => 'payment[' . $gateway_slug . '][default_business_type]',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['default_business_type'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    /**
     * End --- User status and Business type 
     */

    $gateway_slug . '_user_mp_status' => array(
        'label' => __('User status', 'wc-multivendor-marketplace'),
        'type' => 'select',
        'options' => $all_mp_states,
        'name' => 'payment[' . $gateway_slug . '][user_mp_status]',
        'class' => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['default_vendor_status'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_user_business_type' => array(
        'label' => __('Business type', 'wc-multivendor-marketplace'),
        'type' => 'select',
        'options' => $all_user_business_type,
        'name' => 'payment[' . $gateway_slug . '][user_business_type]',
        'class' => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => $settings['default_business_type'],
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_user_business_type_wise_message' => array(
        'type' => 'html',
        'value' => '<p id="mc_message" class="description  wcfm_page_options_desc"></p>',
    ),

    // $gateway_slug . '_button_mp_submit' => array(
    //     'type' => 'html',
    //     'name' => 'payment[' . $gateway_slug . ']',
    //     'class' => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
    //     'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
    //     'value' => '<input type="button" id="submit_mp" value="' . __('Submit', 'wc-multivendor-marketplace') . '"><img src="' . plugin_dir_url(__DIR__) . 'assets/images/ajax-loader.gif' . '" height="20" width="20" id="ajax_loader"/><div id="mp_submit"></div>'
    // ),
);

$user_information = array_merge($user_information, $vendor_HeadquartersAddress_fields);

// close wrapper 
$user_information += array(
    $gateway_slug . '_wrapper_mp_create_close' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '</div>',
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
 */

