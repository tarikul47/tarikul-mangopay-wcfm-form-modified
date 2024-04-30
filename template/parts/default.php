<?php
$default_fields = array(
    $gateway_slug . 'user_id' => array(
        'type' => 'hidden',
        'name' => 'payment[' . $gateway_slug . '][user_id]',
        'value' => $vendor_id
    ),
    $gateway_slug . 'mp_id' => array(
        'type' => 'hidden',
        'name' => 'payment[' . $gateway_slug . '][mp_id]',
        'value' => $mp_user_id,
    ),
    // by this UBO field show 
    $gateway_slug . '_wrapper_mp_id' => array(
        'type' => 'html',
        'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        'value' => '<input type="hidden" id="mangopay_id" name="ubo_mp_id" value="' . $mp_user_id . '">',
        // 'value' => '<input type="hidden" id="mangopay_id" name="ubo_mp_id" value="user_m_01HS76N38M7HN842QQT3QRENQD">',
        // 'value' => '<input type="hidden" id="mangopay_id" name="ubo_mp_id" value="user_m_01HS76N38M7HN842QQT3QRENQD">',

    ),

    // $gateway_slug . '_wrapper_button_text' => array(
    //     'type' => 'html',
    //     'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
    //     'value' => '<input type="hidden" id="showbutton_text" value="Show Details"/><input type="hidden" id="hidebutton_text" value="Hide Details"/>',
    // )
);