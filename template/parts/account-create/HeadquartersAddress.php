<?php
// HeadquartersAddress
 //if ($user_mp_status !== 'business') {
    $HeadquartersAddress_fields = array(
        $gateway_slug . '_header_hqaddress' => array(
            'type' => 'html',
            'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => '<h3><strong>' . __('Headquartes Address', 'wc-multivendor-marketplace') . '</strong></h3>',
        )
    );

    $HeadquartersAddress_fields += array(
        // $gateway_slug . '_header_hqaddress' => array(
        //     'type' => 'html',
        //     'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        //     'value' => '<h3><strong>' . __('Headquartes Address', 'wc-multivendor-marketplace') . '</strong></h3>',
        // ),

        $gateway_slug . '_hq_address' => array(
            'label' => __('Headquarters address', 'wc-multivendor-marketplace'),
            'type' => 'text',
            'name' => 'payment[' . $gateway_slug . '][hq_address]',
            'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => $settings['hq_address'],
            'custom_attributes' => array(
                'required' => 'required'
            ),
            'hints' => $headquarter_address_hints,
        ),

        // $gateway_slug . '_hq_address_error_msg' => array(
        //     'type' => 'html',
        //     'value' => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
        // ),

        $gateway_slug . '_hq_address2' => array(
            'label' => __('Headquarters address 2', 'wc-multivendor-marketplace'),
            'type' => 'text',
            'name' => 'payment[' . $gateway_slug . '][hq_address2]',
            'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => $settings['hq_address2'],
        ),

        $gateway_slug . '_hq_city' => array(
            'label' => __('Headquarters city', 'wc-multivendor-marketplace'),
            'type' => 'text',
            'name' => 'payment[' . $gateway_slug . '][hq_city]',
            'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => $settings['hq_city'],
            'custom_attributes' => array(
                'required' => 'required'
            ),
        ),

        // $gateway_slug . '_hq_city_error_msg' => array(
        //     'type' => 'html',
        //     'value' => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
        // ),

        $gateway_slug . '_hq_region' => array(
            'label' => __('Headquarters region', 'wc-multivendor-marketplace'),
            'type' => 'text',
            'name' => 'payment[' . $gateway_slug . '][hq_region]',
            'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => $settings['hq_region'],
            'custom_attributes' => array(
                'required' => 'required'
            ),

        ),

        // $gateway_slug . '_hq_region_error_msg' => array(
        //     'type' => 'html',
        //     'value' => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
        // ),

        $gateway_slug . '_hq_postalcode' => array(
            'label' => __('Headquarters postalcode', 'wc-multivendor-marketplace'),
            'type' => 'text',
            'name' => 'payment[' . $gateway_slug . '][hq_postalcode]',
            'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
            'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug,
            'value' => $settings['hq_postalcode'],
            'custom_attributes' => array(
                'required' => 'required'

            ),
        ),

        // $gateway_slug . '_hq_postalcode_error_msg' => array(
        //     'type' => 'html',
        //     'value' => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
        // ),

        $gateway_slug . '_hq_country' => array(
            'label' => __('Headquarters country', 'wc-multivendor-marketplace'),
            'name' => 'payment[' . $gateway_slug . '][hq_country]',
            'type' => 'select',
            'options' => WC()->countries->get_countries(),
            'class' => 'wcfm-select wcfm_ele field_type_options paymode_field paymode_' . $gateway_slug,
            'label_class' => 'wcfm_title paymode_field paymode_' . $gateway_slug,
            'value' => $settings['hq_country'],
            'custom_attributes' => array(
                'required' => 'required'
            ),
        ),

        // $gateway_slug . '_hq_country_error_msg' => array(
        //     'type' => 'html',
        //     'value' => '<p id="error-message" class="description  wcfm_page_options_desc custom-mangopay-form-error"></p>',
        // ),

        $gateway_slug . '_termsAndConditionsAccepted' => array(
            'label' => __('Agree  <a target="_blank" href="' . $site_url . '">Terms & Conditions!</a>', 'wc-multivendor-marketplace'),
            'name' => $gateway_slug . '_termsAndConditionsAccepted',
            'type' => 'checkbox',
            'class' => 'wcfm-checkbox wcfm_ele paymode_field paymode_' . $gateway_slug,
            'label_class' => 'wcfm_title paymode_field paymode_' . $gateway_slug,
            'value' => 'yes',
            'dfvalue' => $settings['termsconditions'],
            'custom_attributes' => array(
                'required' => 'required'
            ),
        ),

        // $gateway_slug . '_termsAndConditionsAccepted_error_msg' => array(
        //     'type' => 'html',
        //     'value' => '<p id="error-message" class="description custom-mangopay-form-error"></p>',
        // ),

        // $gateway_slug . '_button_businessinfo' => array(
        //     'type' => 'html',
        //     'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug,
        //     'value' => '<input type="button" id="update_business_information" value="' . __('Update', 'wc-multivendor-marketplace') . '"><img src="' . plugin_dir_url(__DIR__) . 'assets/images/ajax-loader.gif' . '" height="20" width="20" id="ajax_loader"/><span id="bi_updated">Succesfully Updated</span></div>',
        // ),
    );
//}