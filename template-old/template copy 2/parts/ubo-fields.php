<?php
$ubo_information_hints = get_option('wcfm_ubo_information_hints');
// UBO Information
//if ($user_business_type !== 'business') {
$vendor_ubo_billing_fields = array(
    $gateway_slug . '_wrapper_uboinfo' => array(
        'type' => 'html',
        'class' => 'mangopay_information_section wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<div class="mangopay-headlines">
            <span class="img_tip wcfmfa fa-question" data-tip="' . $ubo_information_hints . '" data-hasqtip="50" aria-describedby="qtip-50"></span>
                <h3>
                    <strong>' . __('UBO Information', 'wc-multivendor-marketplace') . '
                    </strong>
                </h3>
                </div>
                <div class="btn button" id="ubo_data"></div>',
    ),

);
//}