<?php
$bank_details_hints = get_option('wcfm_bank_details_hints');
$add_bank_hints = get_option('wcfm_add_bank_hints');

/**
 * Bank wrapper 
 */
$vendor_bank_billing_fields = array(
    $gateway_slug . '_wrapper_bank_account' => array(
        'type' => 'html',
        'class' => 'mangopay_information_section wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<div>',
    ),
);

$vendor_bank_billing_fields += array(
    $gateway_slug . '_header_bank' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<div class="mangopay-headlines"><span class="img_tip wcfmfa fa-question" data-tip="' . $bank_details_hints . '" data-hasqtip="50" aria-describedby="qtip-50"></span><h3><strong>' . __('Bank Details', 'wc-multivendor-marketplace') . '</strong></h3></div>',
    ),

    $gateway_slug . '_vendor_account_type' => array(
        'label' => __('Type', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_account_type]',
        'type' => 'select',
        'options' => get_mangopay_bank_types(),
        'class' => 'mangopay-type wcfm-select wcfm_ele field_type_options paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_account_type']) ? $settings['bank_details']['vendor_account_type'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_vendor_account_name' => array(
        'label' => __('Owner name', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_account_name]',
        'type' => 'text',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_account_name']) ? $settings['bank_details']['vendor_account_name'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_vendor_account_address1' => array(
        'label' => __('Owner address line 1', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_account_address1]',
        'type' => 'text',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_account_address1']) ? $settings['bank_details']['vendor_account_address1'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),

    ),

    $gateway_slug . '_vendor_account_address2' => array(
        'label' => __('Owner address line 2', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_account_address2]',
        'type' => 'text',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_account_address2']) ? $settings['bank_details']['vendor_account_address2'] : '',
    ),

    $gateway_slug . '_vendor_account_city' => array(
        'label' => __('Owner city', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_account_city]',
        'type' => 'text',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_account_city']) ? $settings['bank_details']['vendor_account_city'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_vendor_account_region' => array(
        'label' => __('Owner region', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_account_region]',
        'type' => 'text',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_account_region']) ? $settings['bank_details']['vendor_account_region'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),

    ),

    $gateway_slug . '_vendor_account_postcode' => array(
        'label' => __('Owner postal code', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_account_postcode]',
        'type' => 'text',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_account_postcode']) ? $settings['bank_details']['vendor_account_postcode'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_vendor_account_country' => array(
        'label' => __('Owner country', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_account_country]',
        'type' => 'select',
        'options' => WC()->countries->get_countries(),
        'class' => 'wcfm-select wcfm_ele field_type_options paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_account_country']) ? $settings['bank_details']['vendor_account_country'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),
);

// IBAN fields
$vendor_bank_billing_fields += array(
    $gateway_slug . '_vendor_iban' => array(
        'label' => __('IBAN', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_iban]',
        'type' => 'text',
        'class' => 'bank-type bank-type-iban wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_iban']) ? $settings['bank_details']['vendor_iban'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_vendor_bic' => array(
        'label' => __('BIC', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_bic]',
        'type' => 'text',
        'class' => 'bank-type bank-type-iban wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_bic']) ? $settings['bank_details']['vendor_bic'] : '',
    ),
);

// GB fields
$vendor_bank_billing_fields += array(
    $gateway_slug . '_vendor_gb_accountnumber' => array(
        'label' => __('Account Number', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_gb_accountnumber]',
        'type' => 'text',
        'class' => 'bank-type bank-type-gb wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_gb_accountnumber']) ? $settings['bank_details']['vendor_gb_accountnumber'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_sort_code' => array(
        'label' => __('Sort Code', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][sort_code]',
        'type' => 'text',
        'class' => 'bank-type bank-type-gb wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['sort_code']) ? $settings['bank_details']['sort_code'] : '',
    ),

);

// US fields
$vendor_bank_billing_fields += array(
    $gateway_slug . '_vendor_us_accountnumber' => array(
        'label' => __('Account Number', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_us_accountnumber]',
        'type' => 'text',
        'class' => 'bank-type bank-type-us wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_us_accountnumber']) ? $settings['bank_details']['vendor_us_accountnumber'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_vendor_us_aba' => array(
        'label' => __('ABA', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_us_aba]',
        'type' => 'text',
        'class' => 'bank-type bank-type-us wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_us_aba']) ? $settings['bank_details']['vendor_us_aba'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),

    ),

    $gateway_slug . '_vendor_us_datype' => array(
        'label' => __('Deposit Account Type', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_us_datype]',
        'type' => 'select',
        'options' => get_mangopay_deposit_account_types(),
        'class' => 'bank-type bank-type-us wcfm-select wcfm_ele field_type_options paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_us_datype']) ? $settings['bank_details']['vendor_us_datype'] : '',
    ),
);

// CA fields
$vendor_bank_billing_fields += array(
    $gateway_slug . '_vendor_ca_bankname' => array(
        'label' => __('Bank Name', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_ca_bankname]',
        'type' => 'text',
        'class' => 'bank-type bank-type-ca wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_ca_bankname']) ? $settings['bank_details']['vendor_ca_bankname'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_vendor_ca_instnumber' => array(
        'label' => __('Institution Number', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_ca_instnumber]',
        'type' => 'text',
        'class' => 'bank-type bank-type-ca wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_ca_instnumber']) ? $settings['bank_details']['vendor_ca_instnumber'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_vendor_ca_branchcode' => array(
        'label' => __('Branch Code', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_ca_branchcode]',
        'type' => 'text',
        'class' => 'bank-type bank-type-ca wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_ca_branchcode']) ? $settings['bank_details']['vendor_ca_branchcode'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_vendor_ca_accountnumber' => array(
        'label' => __('Account Number', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_ca_accountnumber]',
        'type' => 'text',
        'class' => 'bank-type bank-type-ca wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_ca_accountnumber']) ? $settings['bank_details']['vendor_ca_accountnumber'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),
);

// OTHER fields
$vendor_bank_billing_fields += array(
    $gateway_slug . '_vendor_ot_country' => array(
        'label' => __('Country', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_ot_country]',
        'type' => 'text',
        'class' => 'bank-type bank-type-other wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_ot_country']) ? $settings['bank_details']['vendor_ot_country'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),

    $gateway_slug . '_vendor_ot_bic' => array(
        'label' => __('BIC', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_ot_bic]',
        'type' => 'text',
        'class' => 'bank-type bank-type-other wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_ot_bic']) ? $settings['bank_details']['vendor_ot_bic'] : '',
    ),

    $gateway_slug . '_vendor_ot_accountnumber' => array(
        'label' => __('Account Number', 'wc-multivendor-marketplace'),
        'name' => 'payment[' . $gateway_slug . '][bank_details][vendor_ot_accountnumber]',
        'type' => 'text',
        'class' => 'bank-type bank-type-other wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => isset($settings['bank_details']['vendor_ot_accountnumber']) ? $settings['bank_details']['vendor_ot_accountnumber'] : '',
        'custom_attributes' => array(
            'required' => 'required'
        ),
    ),
);

// Add Bank account check
$vendor_bank_billing_fields += array(
    $gateway_slug . '_add_bank' => array(
        'label' => __('Add Bank Account', 'wc-multivendor-marketplace'),
        'name' => $gateway_slug . '_add_bank',
        'type' => 'checkbox',
        'class' => 'wcfm-checkbox wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title paymode_field paymode_' . $gateway_slug,
        'value' => 'yes',
        'dfvalue' => 'no',
        'hints' => $add_bank_hints,
    ),

    $gateway_slug . '_add_bank_status' => array(
        'label' => __('BIC', 'wc-multivendor-marketplace'),
        'name' => $gateway_slug . '_add_bank_status',
        'type' => 'hidden',
        'value' => 'no',
    ),
);

// close wrapper 
$vendor_bank_billing_fields += array(
    $gateway_slug . '_wrapper_bank_account_close' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '</div>',
    ),

);