<?php
//print_r('businesses' === $this->mp->default_vendor_status ? 'hidden' : 'select');
//print_r($this->mp->default_vendor_status);
//print_r($this->mp->default_vendor_status);

if ($user_mp_status) {
    if ('either' === $this->mp->default_vendor_status) {
        $user_type_fields += array(
            $gateway_slug . '_user_mp_status' => array(
                'label' => __('User Type', 'wc-multivendor-marketplace'),
                'type' => 'businesses' === $this->mp->default_vendor_status ? 'hidden' : 'select',
                'options' => array(
                    'individual' => __('NATURAL', 'wc-multivendor-marketplace'),
                    'business' => __('BUSINESS', 'wc-multivendor-marketplace'),
                ),
                'name' => 'payment[' . $gateway_slug . '][user_mp_status]',
                'class' => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
                'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
                'value' => $settings['user_mp_status'],
                'custom_attributes' => array(
                    'required' => 'required'
                ),
            ),
        );
    }

    if ('either' === $this->mp->default_vendor_status || 'businesses' === $this->mp->default_vendor_status) {
        if ('either' == $this->mp->default_business_type) {
            $user_type_fields += array(
                $gateway_slug . '_user_business_type' => array(
                    'label' => __('Business Type', 'wc-multivendor-marketplace'),
                    'type' => 'select',
                    'options' => array(
                        'business' => __('BUSINESS', 'wc-multivendor-marketplace'),
                        'organisation' => __('ORGANIZATION', 'wc-multivendor-marketplace'),
                        'soletrader' => __('SOLETRADER', 'wc-multivendor-marketplace'),
                    ),
                    'name' => 'payment[' . $gateway_slug . '][user_business_type]',
                    'class' => 'wcfm-select wcfm_ele paymode_field paymode_' . $gateway_slug,
                    'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
                    'value' => $settings['user_business_type'],
                    'custom_attributes' => array(
                        'required' => 'required'
                    ),
                ),
            );
        }
    }
}