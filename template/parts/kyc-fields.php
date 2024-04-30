<?php
//REMOVE KYC DOCUMENT FROM LIST
$remove_kyc_type = array('SHAREHOLDER DECLARATION', 'ADDRESS PROOF');
if ($user_mp_status == 'business') {
    if ($user_business_type == 'soletrader') {
        array_push($remove_kyc_type, 'ARTICLES OF ASSOCIATION');
    }
} else {
    array_push($remove_kyc_type, 'REGISTRATION PROOF');
    array_push($remove_kyc_type, 'ARTICLES OF ASSOCIATION');
}

// kyc fields
$kyc_fields = array(
    $gateway_slug . '_wrapper_kyc' => array(
        'type' => 'html',
        'class' => 'mangopay_information_section wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<div>',
    ),
);

$kyc_fields += array(
    $gateway_slug . '_header_kyc' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<div class="mangopay-headlines"><span class="img_tip wcfmfa fa-question" data-tip="' . $kyc_details_hints . '" data-hasqtip="50" aria-describedby="qtip-50"></span><h3><strong>' . __('KYC Details', 'wc-multivendor-marketplace') . '</strong></h3></div>',
    ),
);

if (count($kyc_options) > 0) {
    $kyc_fields += array(
        $gateway_slug . '_kyc_notice' => array(
            'type' => 'html',
            'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => sprintf(__('<span class="mangopay-kyc-notice">Please upload %s document(s) i.e. %s', 'wc-multivendor-marketplace'), count($kyc_options), implode(', ', $kyc_options)),
        ),

    );
}

$kyc_fields += array(
    $gateway_slug . '_kyc_detail' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<div>' . $kyc_documents . '</div>',
    ),

    $gateway_slug . '_kyc_details' => array(
        'name' => 'payment[' . $gateway_slug . '][kyc_details]',
        'type' => 'multiinput',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title wcfm_full_title paymode_field paymode_' . $gateway_slug,
        //'value' 		=> $settings['kyc_details'],
        'options' => array(
            "type" => array(
                'label' => __('Document Type', 'wc-multivendor-marketplace'),
                'type' => 'select',
                'options' => array_diff(get_mangopay_kyc_document_types(), $remove_kyc_type),
                'class' => 'wcfm-select wcfm_ele field_type_options paymode_field paymode_' . $gateway_slug,
                'label_class' => 'wcfm_title paymode_field paymode_' . $gateway_slug,
            ),

            'file' => array(
                'label' => __('Upload File', 'wc-multivendor-marketplace'),
                'type' => 'upload',
                'mime' => 'Uploads',
                'class' => 'wcfm_ele',
                'label_class' => 'wcfm_title',
                'hints' => $upload_files_hints,
            )
        ),
        'custom_attributes' => array(
            'limit' => count(get_mangopay_kyc_document_types()),
        ),

    ),

    $gateway_slug . '_upload_kyc' => array(
        'label' => __('Submit KYC documents', 'wc-multivendor-marketplace'),
        'name' => $gateway_slug . '_upload_kyc',
        'type' => 'checkbox',
        'class' => 'wcfm-checkbox wcfm_ele paymode_field paymode_' . $gateway_slug,
        'label_class' => 'wcfm_title paymode_field paymode_' . $gateway_slug,
        'value' => 'yes',
        'dfvalue' => 'no',
        'hints' => $submit_kyc_hints,
    ),

    $gateway_slug . '_upload_kyc_status' => array(
        'name' => $gateway_slug . '_upload_kyc_status',
        'type' => 'hidden',
        'value' => 'no',
    ),
);

$kyc_fields += array(
    $gateway_slug . '_wrapper_kyc_close' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '</div>',
    ),

);