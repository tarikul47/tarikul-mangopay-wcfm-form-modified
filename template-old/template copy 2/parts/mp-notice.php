<?php
/**
 * Notice Html Fields 
 */

// GET ALL NOTIFICATION
$company_number_notification = get_option('wcfm_company_number_notification', 'You need to supply a valid company number to do a payout.');
$mp_account_notification = get_option('wcfm_company_number_notification', 'You have to create Mangopay account for your payout.');
$bank_account_notification = get_option('wcfm_bank_account_notification', 'You need to add a Bank Account to do a payout.');

$kyc_document_notification = get_option('wcfm_kyc_document_notification', 'You need to validate your KYC documents to do a payout.');
$kyc_validate_notification = get_option('wcfm_kyc_validated_notification', 'Your KYC is Validated!');
$ubo_document_notification = get_option('wcfm_ubo_document_notification', 'You need to submit UBO documents to do a payout.');
$mangopay_notice_title = get_option('wcfm_mangopay_notice_title');
$mangopay_notice_description = get_option('wcfm_mangopay_notice_description');

$kyc_options = $this->mangopay_kyc_list($mp_user_id, $user_mp_status, $user_business_type);
$kyc_validation = $this->mangopay_kyc_validation($mp_user_id, $user_business_type);
$ubo_result = $this->mp->test_vendor_ubo($vendor_id);
$kyc_result = $this->mp->test_vendor_kyc($vendor_id);
$kyc_documents = $this->mangopay_kyc_html($mp_user_id);

$mp_notice_fields = [];

if (empty($mp_user_id)) {
    $mp_notice_fields += array(
        $gateway_slug . '_wrapper_notice_mp_account' => array(
            'type' => 'html',
            'class' => 'mp_notice_common wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => '<div class="mp_notice_commom_text">' . $mp_account_notification . '</div>', // company number missing 
        ),
    );
}

if ($user_business_type == 'business' && empty($settings['compagny_number'])) {
    $mp_notice_fields += array(
        $gateway_slug . '_wrapper_notice_business_number' => array(
            'type' => 'html',
            'class' => 'mp_notice_common wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => '<div class="mp_notice_commom_text">' . $company_number_notification . '</div>', // company number missing 
        ),
    );
}


$mp_notice_fields += array(
    $gateway_slug . '_vendor_id' => array(
        'type' => 'hidden',
        'name' => $gateway_slug . '_vendor_id',
        'value' => $vendor_id
    ),
    // by this UBO field show 
    $gateway_slug . '_wrapper_mp_id' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<input type="hidden" id="mangopay_id" name="ubo_mp_id" value="' . $mp_user_id . '">',
        // 'value' => '<input type="hidden" id="mangopay_id" name="ubo_mp_id" value="user_m_01HS76N38M7HN842QQT3QRENQD">',
        // 'value' => '<input type="hidden" id="mangopay_id" name="ubo_mp_id" value="user_m_01HS76N38M7HN842QQT3QRENQD">',

    ),

    $gateway_slug . '_wrapper_button_text' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<input type="hidden" id="showbutton_text" value="Show Details"/><input type="hidden" id="hidebutton_text" value="Hide Details"/>',
    )
);

$bank_account = get_user_meta($vendor_id, 'mp_bank_account', true) ? get_user_meta($vendor_id, 'mp_bank_account', true) : false;

if (!$bank_account) {
    $mp_notice_fields += array(
        $gateway_slug . '_wrapper_notice_bank' => array(
            'type' => 'html',
            'class' => 'mp_notice_common wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => '<div class="mp_notice_commom_text">' . $bank_account_notification . '</div>', // Bank account missing 
        )
    );
}

if ($kyc_validation) {
    $mp_notice_fields += array(
        $gateway_slug . '_wrapper_notice_kyc' => array(
            'type' => 'html',
            'class' => 'mp_success_notice_common wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => '<div class="mp_notice_commom_text">' . $kyc_validate_notification . '</div>', // kyc is validation success
        )
    );
} else {
    $mp_notice_fields += array(
        $gateway_slug . '_wrapper_notice_kyc' => array(
            'type' => 'html',
            'class' => 'mp_notice_common wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => '<div class="mp_notice_commom_text">' . $kyc_document_notification . '</div>', // kyc missing 
        )
    );
}



if ($user_business_type == 'business' && !$ubo_result) {
    $mp_notice_fields += array(
        $gateway_slug . '_wrapper_notice_ubo' => array(
            'type' => 'html',
            'class' => 'mp_notice_common wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => '<div class="mp_notice_commom_text">' . $ubo_document_notification . '</div>', // ubo is missing 
        )
    );
}

if ($mangopay_notice_description && !empty($mangopay_notice_description)) { // custom message 
    $mp_notice_fields += array(
        $gateway_slug . '_wrapper_important_notice' => array(
            'type' => 'html',
            'class' => 'mp_imp_notice_common wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => '<div class="mp_notice_commom_text"><h6>' . $mangopay_notice_title . '</h6><p>' . $mangopay_notice_description . '</p></div>',
        ),
    );
}
