<?php

/**

 * WCFM PG MangoPay plugin core
 * Plugin intiate
 * @author 		WC Lovers
 * @package 	wcfm-pg-mangopay
 * @version   1.0.0
 */

class WCFM_PG_MangoPay
{
	public $plugin_base_name;
	public $plugin_url;
	public $plugin_path;
	public $version;
	public $token;
	public $text_domain;
	public $mp;
	public $mangopayWCMain;

	public function __construct($file)
	{
		global $mngpp_o;
		$this->mangopayWCMain = $mngpp_o;
		$this->file = $file;
		$this->plugin_base_name = plugin_basename($file);
		$this->plugin_url = trailingslashit(plugins_url('', $plugin = $file));
		$this->plugin_path = trailingslashit(dirname($file));
		$this->token = WCFMpgmp_TOKEN;
		$this->text_domain = WCFMpgmp_TEXT_DOMAIN;
		$this->version = WCFMpgmp_VERSION;
		$this->mp = mpAccess::getInstance();
	//	add_action('wcfm_init', array(&$this, 'init'), 10);
	
		$this->init();

		//	var_dump($this->mangopayWCMain->options['default_vendor_status']);
		//	var_dump($this->mangopayWCMain->options['default_business_type']);
	}

	function init()
	{
		global $WCFM, $WCFMre, $mngpp_o;

		// Init Text Domain
		$this->load_plugin_textdomain();

		add_action('wp_enqueue_scripts', array(&$this, 'enqueue_styles'));

		add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));

		add_filter('wcfm_marketplace_withdrwal_payment_methods', array(&$this, 'wcfmmp_custom_pg'));

		add_filter('wcfm_marketplace_settings_fields_withdrawal_charges', array(&$this, 'wcfmmp_custom_pg_withdrawal_charges'), 50, 3);

		add_filter('wcfm_marketplace_settings_fields_billing', array(&$this, 'wcfmmp_custom_pg_vendor_setting'), 50, 2);

		add_filter('mangopay_vendor_role', array(&$this, 'set_mangopay_vendor_role'));

		add_filter('mangopay_vendors_required_class', array(&$this, 'set_mangopay_vendors_required_class'));

		add_action("wp_ajax_create_mp_account", array(&$this, "create_mp_account"));

		add_action("wp_ajax_update_mp_business_information", array(&$this, "update_mp_business_information"));

		add_action("wp_ajax_create_mp_ubo_declaration", array(&$this, "create_mp_ubo_declaration"));

		// add_action( 'wcfm_vendor_settings_update', array( &$this, 'update_mangopay_settings' ), 10, 2 );

		add_action('wcfm_wcfmmp_settings_update', array(&$this, 'update_mangopay_settings'), 10, 2);

		/**
		 * Remove extra field and validation and saving fucntionality on woocommerce registration form
		 * 
		 * 1 = Etra field remove 
		 * 2 = Validation remove for extra fields
		 * 3 = Saving functionality remove for extra fields
		 */
		remove_action('woocommerce_register_form_start',	array($mngpp_o, 'wooc_extra_register_fields'));
		remove_action('woocommerce_register_post',		array($mngpp_o, 'wooc_validate_extra_register_fields'), 10, 3);
		remove_action('woocommerce_created_customer',		array($mngpp_o, 'wooc_save_extra_register_fields'), 10, 1);

		/**
		 * Remove extra field and validation and saving fucntionality on account edit page 
		 * 1. check user mp id 
		 * 2. $mp_user_id = $this->mp->set_mp_user(get_current_user_id());
		 */

		$mp_user_id = $this->mp->get_mp_user_id(get_current_user_id());
		if (!$mp_user_id) {
			remove_action('woocommerce_edit_account_form',	array($mngpp_o, 'wooc_extra_register_fields'));
			remove_filter('woocommerce_save_account_details_required_fields',	array($mngpp_o, 'wooc_account_details_required'));
			remove_filter('woocommerce_save_account_details',	array($mngpp_o, 'wooc_save_extra_register_fields'), 10, 1);
			remove_filter('woocommerce_save_account_details_errors',	array($mngpp_o, 'wooc_validate_extra_register_fields_userfront'), 10);
		}

		// Load Gateway Class [Moved outside]
	//	require_once $this->plugin_path . 'gateway/class-wcfmmp-gateway-mangopay.php';
	}

	// create mp account 
	public function create_mp_account()
	{

		$result = array();
		$success = false;
		$msg = 'An Error Occurred!';
		$vendor_id = isset($_POST['vendor_id']) && !empty($_POST['vendor_id']) ? $_POST['vendor_id'] : 0;

		//sample data set
		//$data = $this->mangopay_acount_creation_sample_data();

		// validation process
		$errors = $this->validate_data($_POST, $vendor_id);

		if (!empty($errors)) {
			wp_send_json_error(['errors' => $errors]);
		} else {

			//	Update user meta here and send success response.
			try {
				// Set the initial status to true
				$status = true;
				$errorMessages = [];

				// Sanitize the input data
				$sanitized_data = $this->sanitize_input($_POST);

				// Save the sanitized data as user meta
				$this->save_user_meta($sanitized_data);

				$mp_user_id = $this->mp->set_mp_user($vendor_id);

				// Call dependent function 1
				if (!$mp_user_id) {
					$status = false;
					$errorMessages[] = 'Mangopay account creation failed!';
				}

				// Call dependent function 2  
				if (!$this->mp->set_mp_wallet($mp_user_id)) {
					$status = false;
					$errorMessages[] = 'Mangopay wallet creration failed!';
				}

				// Call dependent function 3
				// Note: this function need to return true in source
				// if (!$this->mangopayWCMain->on_shop_settings_saved($vendor_id)) {
				// 	$status = false;
				// 	$errorMessages[] = 'Mangopay shop settings failed!';
				// }

				// Check the status and send appropriate JSON response
				if ($status) {
					wp_send_json_success(['msg' => 'Successfully You have created Mangopay account!']);
				} else {
					//	wp_send_json_error(['msg' => 'An error occurred in one of the functions!']);
					$errorMessage = implode(' ', $errorMessages);
					wp_send_json_error(['msg' => $errorMessage]);
				}
			} catch (MangoPay\Libraries\ResponseException $e) {
				// Handle the MangoPay ResponseException
				mangopay_log($e->GetMessage(), 'error');
				wp_send_json_error(['msg' => 'An Error Occurred!']);
			} catch (MangoPay\Libraries\Exception $e) {
				// Handle the MangoPay Exception
				mangopay_log($e->GetMessage(), 'error');
				wp_send_json_error(['msg' => 'An Error Occurred!']);
			} catch (Exception $e) {
				// Handle any other exception
				wp_send_json_error(['msg' => $e->getMessage()]);
			}
		}
	}

	// UPDATE HEADQUARTS ADDRESS THROUGH API
	public function update_mp_business_information()
	{
		$result = array();
		$msg = 'An Error Occurred!';
		$vendor_id = isset($_POST['vendor_id']) && !empty($_POST['vendor_id']) ? $_POST['vendor_id'] : 0;
		$mp_user_id = $this->mp->set_mp_user($vendor_id);



		//sample data set
		//	$data = $this->mangopay_acount_update_sample_data();

		// validation process
		$errors = $this->validate_data($_POST, $vendor_id);

		if (!empty($errors)) {
			wp_send_json_error(['errors' => $errors]);
		} else {

			try {

				// Sanitize the input data
				$sanitized_data = $this->sanitize_input($_POST);

				// Save the sanitized data as user meta
				$this->save_user_meta($sanitized_data);

				// Custom vendor role set and excute if vendor role now owner catgeory 
				if ("OWNER" != $this->mp->get_user_properties($mp_user_id)->UserCategory) {
					$sanitized_data['user_roles'] = ['wcfm_vendor'];
				}

				// update data for Mangopay 
				$update = $this->mp->update_user($mp_user_id, $sanitized_data);

			//	error_log(print_r($update, true));

				$result['msg'] = 'Successfully updated!';
				wp_send_json_success($result, 200);
			} catch (MangoPay\Libraries\ResponseException $e) {

				mangopay_log($e->GetMessage(), 'error');
				$result['msg'] = $e->GetMessage();
				wp_send_json_success($result, 500);
			} catch (MangoPay\Libraries\Exception $e) {

				mangopay_log($e->GetMessage(), 'error');
				$result['msg'] = $e->GetMessage();
				wp_send_json_success($result, 500);
			}
		}
	}

	// CREATE UBO DECLARATION
	public function create_mp_ubo_declaration()
	{
		$result = array();
		$ubo = '';
		$success = false;
		$msg = 'An Error Occurred!';
		$wp_user_id = isset($_POST['vendor_id']) && !empty($_POST['vendor_id']) ? $_POST['vendor_id'] : 0;
		$mp_user_id = $this->mp->set_mp_user($wp_user_id);

		try {
			$msg = $this->mp->create_ubo_declaration($mp_user_id);
			$success = true;
		} catch (MangoPay\Libraries\ResponseException $e) {

			mangopay_log($e->GetMessage(), 'error');

			$msg = $e->GetMessage();
		} catch (MangoPay\Libraries\Exception $e) {

			mangopay_log($e->GetMessage(), 'error');

			$msg = $e->GetMessage();
		}

		$result['success'] = $success;

		$result['msg'] = $msg;

		echo json_encode($result);

		die();
	}

	public function enqueue_styles()
	{
		wp_enqueue_style($this->plugin_base_name, $this->plugin_url . 'assets/css/wcfm-pg-mangopay.css', array(), $this->version, 'all');
	}

	public function enqueue_scripts()
	{
		wp_enqueue_script('jquery-ui-datepicker');
		$this->localize_datepicker();
		wp_enqueue_script($this->plugin_base_name, $this->plugin_url . 'assets/js/wcfm-pg-mangopay.js', array('jquery'), $this->version, false);
		wp_localize_script($this->plugin_base_name, 'wecoder_mg_settings', [
			'ajaxurl' => admin_url('admin-ajax.php'),
			'states' => WC()->countries->get_states()
		]);
	}

	public function wcfmmp_custom_pg($payment_methods)
	{
		$payment_methods[WCFMpgmp_GATEWAY] = __(WCFMpgmp_GATEWAY_LABEL, 'wcfm-pg-mangopay');
		return $payment_methods;
	}

	public function localize_datepicker()
	{
		global $wp_locale;
		$aryArgs = array(
			'showButtonPanel'    => true,
			'closeText'         => __('Done', 'mangopay'),
			'currentText'       => __('Today', 'mangopay'),
			'monthNames'        => array_values($wp_locale->month),
			'monthNamesShort'   => array_values($wp_locale->month_abbrev),
			'monthStatus'       => __('Show a different month', 'mangopay'),
			'dayNames'          => array_values($wp_locale->weekday),
			'dayNamesShort'     => array_values($wp_locale->weekday_abbrev),
			'dayNamesMin'       => array_values($wp_locale->weekday_initial),

			// set the date format to match the WP general date settings
			'dateFormat'        => $this->date_format_php_to_js($this->supported_format(get_option('date_format'))),

			// get the start of week from WP general setting
			'firstDay'          => get_option('start_of_week'),

			// is Right to left language? default is false
			'isRTL'             => $wp_locale->is_rtl(),
			'changeYear'        => true,
			'yearRange'            => (date('Y') - 120) . ':' . date('Y'),
			'defaultDate'        => - (365 * 29)
		);
		wp_localize_script('jquery-ui-datepicker', 'datepickerL10n', $aryArgs);
	}

	private function date_format_php_to_js($sFormat)
	{
		switch ($sFormat) {

				//Predefined WP date formats
			case 'F j, Y':
				return ('MM dd, yy');
				break;

			case 'F js, Y':
				return ('MM dd, yy');
				break;

			case 'Y/m/d':
				return ('yy/mm/dd');
				break;

			case 'm/d/Y':
				return ('mm/dd/yy');
				break;

			case 'd/m/Y':
				return ('dd/mm/yy');
				break;

			default:

				$jsFormat = preg_replace('/F/', 'MM', $sFormat);

				$jsFormat = preg_replace('/S/', '', $sFormat);

				$jsFormat = preg_replace('/d/', 'dd', $jsFormat);

				$jsFormat = preg_replace('/j/', 'dd', $jsFormat);

				$jsFormat = preg_replace('/Y/', 'yy', $jsFormat);

				$jsFormat = preg_replace('/m/', 'mm', $jsFormat);

				$jsFormat = str_replace('  ', ' ', $jsFormat);

				return $jsFormat;
		}
	}

	public function supported_format($date_format)
	{
		if (date('Y-m-d') == $this->convertDate(date_i18n(get_option('date_format'), time()), get_option('date_format')))
			return $date_format;
		return preg_replace('/F/', 'm', $date_format);
	}
	public function convertDate($date, $format = null)
	{
		if (!$format)
			$format = $this->supported_format(get_option('date_format'));

		if (preg_match('/F/', $format) && function_exists('strptime')) {



			/** Convert date format to strftime format */

			$format = preg_replace('/j/', '%d', $format);

			$format = preg_replace('/F/', '%B', $format);

			$format = preg_replace('/Y/', '%Y', $format);

			$format = preg_replace('/,\s*/', ' ', $format);

			$date = preg_replace('/,\s*/', ' ', $date);



			setlocale(LC_TIME, get_locale());

			do_action('mwc_set_locale_date_validation', get_locale());



			$d = strptime($date, $format);

			if (false === $d)    // Fix problem with accentuated month names on some systems

				$d = strptime(utf8_decode($date), $format);



			if (!$d)

				return false;



			return

				1900 + $d['tm_year'] . '-' .

				sprintf('%02d', $d['tm_mon'] + 1) . '-' .

				sprintf('%02d', $d['tm_mday']);
		} else if (preg_match('/S/', $format) && function_exists('strptime')) {



			$formated = date_parse_from_format($format, $date);

			if (empty($formated['year']) || empty($formated['month']) || empty($formated['day'])) {

				return false;
			}

			return $formated['year'] . '-' . sprintf("%02d", $formated['month']) . '-' . sprintf("%02d", $formated['day']);
		} else {

			$d = DateTime::createFromFormat($format, $date);



			if (!$d)

				return false;



			return $d->format('Y-m-d');
		}
	}

	public function wcfmmp_custom_pg_withdrawal_charges($withdrawal_charges, $wcfm_withdrawal_options, $withdrawal_charge)
	{

		$gateway_slug  = WCFMpgmp_GATEWAY;

		$gateway_label = __(WCFMpgmp_GATEWAY_LABEL, 'wcfm-pg-mangopay') . ' ';



		$withdrawal_charge_brain_tree = isset($withdrawal_charge[$gateway_slug]) ? $withdrawal_charge[$gateway_slug] : array();

		$payment_withdrawal_charges = array("withdrawal_charge_" . $gateway_slug => array('label' => $gateway_label . __('Charge', 'wcfm-pg-mangopay'), 'type' => 'multiinput', 'name' => 'wcfm_withdrawal_options[withdrawal_charge][' . $gateway_slug . ']', 'class' => 'withdraw_charge_block withdraw_charge_' . $gateway_slug, 'label_class' => 'wcfm_title wcfm_ele wcfm_fill_ele withdraw_charge_block withdraw_charge_' . $gateway_slug, 'value' => $withdrawal_charge_brain_tree, 'custom_attributes' => array('limit' => 1), 'options' => array(

			"percent" => array('label' => __('Percent Charge(%)', 'wcfm-pg-mangopay'), 'type' => 'number', 'class' => 'wcfm-text wcfm_ele withdraw_charge_field withdraw_charge_percent withdraw_charge_percent_fixed', 'label_class' => 'wcfm_title wcfm_ele withdraw_charge_field withdraw_charge_percent withdraw_charge_percent_fixed', 'attributes' => array('min' => '0.1', 'step' => '0.1')),

			"fixed" => array('label' => __('Fixed Charge', 'wcfm-pg-mangopay'), 'type' => 'number', 'class' => 'wcfm-text wcfm_ele withdraw_charge_field withdraw_charge_fixed withdraw_charge_percent_fixed', 'label_class' => 'wcfm_title wcfm_ele withdraw_charge_field withdraw_charge_fixed withdraw_charge_percent_fixed', 'attributes' => array('min' => '0.1', 'step' => '0.1')),

			"tax" => array('label' => __('Charge Tax', 'wcfm-pg-mangopay'), 'type' => 'number', 'class' => 'wcfm-text wcfm_ele', 'label_class' => 'wcfm_title wcfm_ele', 'attributes' => array('min' => '0.1', 'step' => '0.1'), 'hints' => __('Tax for withdrawal charge, calculate in percent.', 'wcfm-pg-mangopay')),

		)));

		$withdrawal_charges = array_merge($withdrawal_charges, $payment_withdrawal_charges);

		return $withdrawal_charges;
	}

	public function mangopay_kyc_validation($mp_user_id, $user_business_type)
	{

		$validated = array();

		$kyc_options = get_mangopay_kyc_document_types();

		$required_kyc = array('IDENTITY PROOF', 'ADDRESS PROOF');

		try {

			$kyc_documents = $this->mp->get_kyc_documents($mp_user_id);

			if ($kyc_documents) {

				foreach ($kyc_documents as $kyc_document) {

					if ($kyc_document->Status == 'VALIDATED' && !in_array($kyc_options[$kyc_document->Type], $validated)) $validated[] =  $kyc_options[$kyc_document->Type];
				}
			}
		} catch (Exception $e) {

			$validated = array();
		}

		switch ($user_business_type) {

			case 'business':

				$required_kyc = array('IDENTITY PROOF', 'REGISTRATION PROOF', 'ARTICLES OF ASSOCIATION');

				break;

			case 'organisation':

				$required_kyc = array('IDENTITY PROOF', 'REGISTRATION PROOF', 'ARTICLES OF ASSOCIATION');

				break;

			case 'soletrader':

				$required_kyc = array('IDENTITY PROOF', 'REGISTRATION PROOF');

				break;

			default:

				$required_kyc = array('IDENTITY PROOF', 'ADDRESS PROOF');

				break;
		}

		if (count($validated) > 0 && count($required_kyc) > 0) {

			$diff = array_diff($required_kyc, $validated);

			if (count($diff) > 0) {

				return false;
			} else {

				return true;
			}
		} else {

			return false;
		}
	}

	public function mangopay_kyc_list($mp_user_id, $user_mp_status, $user_business_type)

	{

		$submitted = array();

		$kyc_options = get_mangopay_kyc_document_types();

		try {

			$kyc_documents = $this->mp->get_kyc_documents($mp_user_id);

			if ($kyc_documents) {

				foreach ($kyc_documents as $kyc_document) {

					if (!in_array($kyc_options[$kyc_document->Type], $submitted)) $submitted[] =  $kyc_options[$kyc_document->Type];
				}
			}
		} catch (Exception $e) {

			$submitted = array();
		}



		$remove_kyc_type = array('SHAREHOLDER DECLARATION');



		if ($user_mp_status == 'business') {

			if ($user_business_type == 'soletrader') {

				array_push($remove_kyc_type, 'ARTICLES OF ASSOCIATION');
			}

			array_push($remove_kyc_type, 'ADDRESS PROOF');
		} else {

			array_push($remove_kyc_type, 'REGISTRATION PROOF');

			array_push($remove_kyc_type, 'ARTICLES OF ASSOCIATION');
		}



		if (count($submitted) > 0) $kyc_options = array_diff($kyc_options, $submitted);

		if (count($remove_kyc_type) > 0) $kyc_options = array_diff($kyc_options, $remove_kyc_type);



		return $kyc_options;
	}

	public function mangopay_kyc_html($mp_user_id)

	{

		$html = '';

		try {

			$kyc_documents = $this->mp->get_kyc_documents($mp_user_id);

			if ($kyc_documents) {

				$kyc_options = get_mangopay_kyc_document_types();

				$html .= '<table class="kyc-detail-table">';

				$html .= '<tr class="kyc-detail-header"><th>Type</th><th>Status</th><th>Refused Reason</th><th>ID</th><th>Processed Date</th><th>Creation Date</th></tr>';

				foreach ($kyc_documents as $kyc_document) {

					$process_date = isset($kyc_document->ProcessedDate) && !empty($kyc_document->ProcessedDate) ? date("jS M Y", $kyc_document->ProcessedDate) : '';

					$creation_date = isset($kyc_document->CreationDate) && !empty($kyc_document->CreationDate) ? date("jS M Y", $kyc_document->CreationDate) : '';

					$html .= '<tr>';

					$html .= '<td>' . $kyc_options[$kyc_document->Type] . '</td>';

					$html .= '<td>' . $kyc_document->Status . '</td>';

					$html .= '<td>' . $kyc_document->RefusedReasonMessage . '</td>';

					$html .= '<td>' . $kyc_document->Id . '</td>';

					$html .= '<td class="kyc-date">' . $process_date . '</td>';

					$html .= '<td class="kyc-date">' . $creation_date . '</td>';

					$html .= '</tr>';
				}

				$html .= '</table>';
			}
		} catch (Exception $e) {

			$html = '';
		}

		return $html;
	}

	public function wcfmmp_custom_pg_vendor_setting($vendor_billing_fields, $vendor_id)
	{
		// 	// get slug
		$gateway_slug  = WCFMpgmp_GATEWAY;

		// site home url 
		$site_url = home_url('mangopay-terms-conditions');

		// vendor data check 
		$vendor_data = get_user_meta($vendor_id, 'wcfmmp_profile_settings', true);


		// if vendor isn't exist then we aren't not allow here 
		if (!$vendor_data) return;

		// check vendor exist mp account or not 
		$mp_user_id = $this->mp->get_mp_user_id($vendor_id);


		if (isset($mp_user_id) && !empty($mp_user_id)) {
			/**
			 * already Mangopay form 
			 */
			include_once(plugin_dir_path(__FILE__) . '../template/wecoder_payment_page.php');
			//echo "MP";
			return array_merge($vendor_billing_fields, $user_update_field);
		} else {
			/**
			 * Mangopay create form 
			 */
			include_once(plugin_dir_path(__FILE__) . '../template/wecoder_create_mp.php');
			//echo "NO";
			//var_dump($gateway_slug);
			return array_merge($vendor_billing_fields, $vendor_user_billing_fields);
		}


		return $vendor_billing_fields;
	}

	public function set_mangopay_vendor_role($role)
	{
		return 'wcfm_vendor';
	}

	public function set_mangopay_vendors_required_class($class_name)
	{
		return 'WCFMmp';
	}

	public function update_mangopay_settings($wp_user_id, $wcfm_settings_form)

	{
		$this->status = 'true';
		$this->message['message'] = 'Settings saved successfully - raju';
		$gateway_slug  	= WCFMpgmp_GATEWAY;
		$vendor_data 	= get_user_meta($wp_user_id, 'wcfmmp_profile_settings', true);
		$user_business_type = get_user_meta($wp_user_id, 'user_business_type', true) ? get_user_meta($wp_user_id, 'user_business_type', true) : '';

		if ('either' === $this->mp->default_vendor_status) {
			if (isset($wcfm_settings_form['payment'][$gateway_slug]['user_mp_status'])) {
				update_user_meta($wp_user_id, 'user_mp_status', $wcfm_settings_form['payment'][$gateway_slug]['user_mp_status']);
			}
		}

		if ('either' === $this->mp->default_vendor_status || 'businesses' === $this->mp->default_vendor_status) {

			if ('either' === $this->mp->default_business_type) {

				if (isset($wcfm_settings_form['payment'][$gateway_slug]['user_business_type'])) {

					update_user_meta($wp_user_id, 'user_business_type', $wcfm_settings_form['payment'][$gateway_slug]['user_business_type']);
				}
			}
		}

		if (isset($wcfm_settings_form['payment'][$gateway_slug]['birthday'])) {
			update_user_meta($wp_user_id, 'user_birthday', $wcfm_settings_form['payment'][$gateway_slug]['birthday']);
		}

		if (isset($wcfm_settings_form['payment'][$gateway_slug]['nationality'])) {
			update_user_meta($wp_user_id, 'user_nationality', $wcfm_settings_form['payment'][$gateway_slug]['nationality']);
		}

		/* if (isset($wcfm_settings_form['payment'][$gateway_slug]['compagny_number'])) {
			update_user_meta($wp_user_id, 'compagny_number', $wcfm_settings_form['payment'][$gateway_slug]['compagny_number']);
		} */

		$mp_user_id = $this->mp->set_mp_user($wp_user_id);

		if (!$mp_user_id) {
			mangopay_log(__('Can not create mangopay user, please make sure to fill up your profile & address fields such as Fisrt Name, Last Name, Email, Billing Country etc', 'wc-multivendor-marketplace'), 'error');
			return;
		}

		error_log('message stop 1');

		if (isset($wcfm_settings_form['mangopay_upload_kyc_status']) && $wcfm_settings_form['mangopay_upload_kyc_status'] == 'yes') {

			error_log('message stop 2');

			$kyc_details = isset($wcfm_settings_form['payment'][$gateway_slug]['kyc_details']) ? $wcfm_settings_form['payment'][$gateway_slug]['kyc_details'] : array();

			if (is_array($kyc_details) && !empty($kyc_details)) {

				error_log('kyc is array');

				$kyc_details 	= wp_list_pluck($kyc_details, 'file', 'type');

				foreach ($kyc_details as $type => $file) {
					$KycDocument = new \MangoPay\KycDocument();
					$KycDocument->Tag = "wp_user_id:" . $wp_user_id;
					$KycDocument->Type = $type;

					try {

						$document_created = $this->mp->create_kyc_document($mp_user_id, $KycDocument);
						$kycDocumentId = $document_created->Id;
					} catch (MangoPay\Libraries\ResponseException $e) {

						mangopay_log($e->GetMessage(), 'error');
						$this->message['message'] = $e->GetMessage();
					} catch (MangoPay\Libraries\Exception $e) {

						mangopay_log($e->GetMessage(), 'error');
						$this->message['message'] = $e->GetMessage();
					}

					if ($kycDocumentId) {
						$this->mp->create_kyc_page_from_file($mp_user_id, $kycDocumentId, get_attached_file($file));

						$the_doc = $this->mp->get_kyc_document($mp_user_id, $kycDocumentId);
						$the_doc->Status = "VALIDATION_ASKED";
						$result = $this->mp->update_kyc_document($mp_user_id, $the_doc);

						//	error_log(print_r($result, true));
					}


					// try {
					// 	$document_created = $this->mp->create_kyc_document($mp_user_id, $KycDocument);
					// 	$kycDocumentId = $document_created->Id;

					// 	error_log('kyc create = 2504');

					// 	//	if ($kycDocumentId) {
					// 	//	$uploaded = $this->mp->create_kyc_page_from_file($mp_user_id, $kycDocumentId, get_attached_file($file));

					// 	//	error_log(print_r($uploaded, true));

					// 	error_log(get_attached_file($file));
					// 	//	error_log('message stop file', $file);
					// 	//	error_log(print_r($uploaded, true));
					// 	error_log('message stop 4');

					// 	//	die();

					// 	//	if ($uploaded) {
					// 	//	$KycDocument = new \MangoPay\KycDocument();
					// 	//	$KycDocument->Id = $kycDocumentId;

					// 	$the_doc = $this->mp->get_kyc_document($mp_user_id, $kycDocumentId);

					// 	$the_doc->Status = "VALIDATION_ASKED";

					// 	//	$KycDocument->Status = \MangoPay\KycDocumentStatus::ValidationAsked;

					// 	error_log(print_r($the_doc, true));

					// 	//die(); raju

					// 	$Result = $this->mp->update_kyc_document($mp_user_id, $the_doc);

					// 	if ($Result) {
					// 		$data_meta['type'] = $type;
					// 		$data_meta['id_mp_doc'] = $kycDocumentId;
					// 		$data_meta['creation_date'] = $Result->CreationDate;
					// 		$data_meta['document_name'] = basename(get_attached_file($file));
					// 		update_user_meta($wp_user_id, 'kyc_document_' . $kycDocumentId, $data_meta);
					// 	}
					// 	//	}
					// 	//	}
					// } catch (MangoPay\Libraries\ResponseException $e) {

					// 	mangopay_log($e->GetMessage(), 'error');
					// 	$this->message['message'] = $e->GetMessage();
					// } catch (MangoPay\Libraries\Exception $e) {

					// 	mangopay_log($e->GetMessage(), 'error');
					// 	$this->message['message'] = $e->GetMessage();
					// }
				}
			}
			// we don't need this field value to be saved
			unset($wcfm_settings_form['mangopay_upload_kyc']);
		}

		$umeta_key = 'mp_account_id';
		if (!$this->mp->is_production()) {
			$umeta_key .= '_sandbox';
		}

		$existing_account_id = get_user_meta($wp_user_id, $umeta_key, true);
		$bank_details 	= $wcfm_settings_form['payment'][$gateway_slug]['bank_details'];
		$type 		= isset($bank_details['vendor_account_type']) ? $bank_details['vendor_account_type'] : '';
		$name 		= isset($bank_details['vendor_account_name']) ? $bank_details['vendor_account_name'] : '';
		$address1 	= isset($bank_details['vendor_account_address1']) ? $bank_details['vendor_account_address1'] : '';
		$address2 	= isset($bank_details['vendor_account_address2']) ? $bank_details['vendor_account_address2'] : '';
		$city 		= isset($bank_details['vendor_account_city']) ? $bank_details['vendor_account_city'] : '';
		$postcode 	= isset($bank_details['vendor_account_postcode']) ? $bank_details['vendor_account_postcode'] : '';
		$region 	= isset($bank_details['vendor_account_region']) ? $bank_details['vendor_account_region'] : '';
		$country 	= isset($bank_details['vendor_account_country']) ? $bank_details['vendor_account_country'] : '';

		$account_types 	= mangopayWCConfig::$account_types;
		$account_type 	= $account_types[$type];
		$needs_update 	= false;
		$account_data 	= array();

		/** Record redacted bank account data in vendor's usermeta **/
		foreach ($account_type as $field => $c) {
			if (isset($bank_details[$field]) && $bank_details[$field] && !preg_match('/\*\*/', $bank_details[$field])) {
				if (isset($c['redact']) && $c['redact']) {
					$needs_update = true;
					list($obf_start, $obf_end) = explode(',', $c['redact']);
					$strlen = strlen($bank_details[$field]);

					/**
					 * if its <=5 characters, lets just redact the whole thing
					 * @see: https://github.com/Mangopay/wordpress-plugin/issues/12
					 */
					if ($strlen <= 5) {
						$to_be_stored = str_repeat('*', $strlen);
					} else {
						$obf_center = $strlen - $obf_start - $obf_end;
						if ($obf_center < 2) {
							$obf_center = 2;
						}

						$to_be_stored = substr($bank_details[$field], 0, $obf_start) .
							str_repeat('*', $obf_center) .
							substr($bank_details[$field], -$obf_end, $obf_end);
					}
				} else {
					if (get_user_meta($wp_user_id, $field, true) != $bank_details[$field]) {
						$needs_update = true;
					}
					$to_be_stored = $bank_details[$field];
				}
				$wcfm_settings_form['payment'][$gateway_slug]['bank_details'][$field] = $to_be_stored;
				update_user_meta($wp_user_id, $field, $to_be_stored);
				$account_data[$field] = $bank_details[$field];
			}
		}



		/** Record clear text bank account data in vendor's usermeta **/
		$account_clear_data = array(
			'headquarters_addressline1',
			'headquarters_addressline2',
			'headquarters_city',
			'headquarters_region',
			'headquarters_postalcode',
			'headquarters_country',
			'vendor_account_type',
			'vendor_account_name',
			'vendor_account_address1',
			'vendor_account_address2',
			'vendor_account_city',
			'vendor_account_postcode',
			'vendor_account_region',
			'vendor_account_country'
		);

		foreach ($account_clear_data as $field) {
			/** update_user_meta() returns "false" if the value is unchanged **/
			if (isset($bank_details[$field]) && update_user_meta($wp_user_id, $field, $bank_details[$field])) {
				$needs_update = true;
			}
		}

		/* if ($wcfm_settings_form['payment'][$gateway_slug]['compagny_number']) :
			$this->mp->update_user($mp_user_id, array('compagny_number' => $wcfm_settings_form['payment'][$gateway_slug]['compagny_number'], 'last_name' => 'Alom'));
		endif; */

		if (isset($wcfm_settings_form['mangopay_add_bank_status']) && $wcfm_settings_form['mangopay_add_bank_status'] == 'yes') {
			if ($needs_update) {
				$this->bank_info_validation($account_data);
				try {
					$mp_account_id = $this->mp->save_bank_account(

						$mp_user_id,
						$wp_user_id,
						$existing_account_id,
						$type,
						$name,
						$address1,
						$address2,
						$city,
						$postcode,
						$region,
						$country,
						$account_data,
						$account_types
					);

					if ($mp_account_id) {
						update_user_meta($wp_user_id, $umeta_key, $mp_account_id);
						update_user_meta($wp_user_id, 'mp_bank_account', true);
					} else {
						$this->status = 'false';
						$this->message['message'] = 'Invalid Bank Account Information. Please insert all required information!';
					}
				} catch (MangoPay\Libraries\ResponseException $e) {
					mangopay_log($e->GetMessage(), 'error');
					$this->status = 'false';
					$this->message['message'] = 'Invalid Bank Account Information. Please insert all required information!';
				} catch (MangoPay\Libraries\Exception $e) {
					mangopay_log($e->GetMessage(), 'error');
					$this->status = 'false';
					$this->message['message'] = 'Invalid Bank Account Information. Please insert all required information!';
				}
			}
		}

		update_user_meta($wp_user_id, 'wcfmmp_profile_settings', $wcfm_settings_form);

		if ($this->status == 'false') {
			echo '{"status": ' . $this->status . ', "message": "' . $this->message['message']  . '"}';
			die;
		}
	}

	/**
	 * Bank Info Validation
	 * @access public
	 * @return void

	 */
	public function bank_info_validation($account_data = array())
	{
		$success = true;
		$message = 'ERROR!!!';

		$validation_info = array(
			array(
				'name' => 'Account Number',
				'key' => 'vendor_us_accountnumber',
				'validation' => '^\d+$'
			),

			array(
				'name' => 'ABA Number',
				'key' => 'vendor_us_aba',
				'validation' => '^\d{9}$'
			),

			array(
				'name' => 'IBAN',
				'key' => 'vendor_iban',
				'validation' => '^[a-zA-Z]{2}\d{2}\s*(\w{4}\s*){2,7}\w{1,4}\s*$'
			),

			array(
				'name' => 'BIC',
				'key' => 'vendor_bic',
				'validation' => '^[a-zA-Z]{6}\w{2}(\w{3})?$'
			),

			array(
				'name' => 'Account Number',
				'key' => 'vendor_gb_accountnumber',
				'validation' => '^\d{8}$'
			),

			array(
				'name' => 'ABA Number',
				'key' => 'vendor_gb_sortcode',
				'validation' => '^\d{6}$'
			),

			array(
				'name' => 'Bank Name',
				'key' => 'vendor_ca_bankname',
				'validation' => '^[\w\s]{1,50}$'
			),

			array(
				'name' => 'Institution Number',
				'key' => 'vendor_ca_instnumber',
				'validation' => '\d{3,4}'
			),

			array(
				'name' => 'Branch Code',
				'key' => 'vendor_ca_branchcode',
				'validation' => '^\d{5}$'
			),

			array(
				'name' => 'Account Number',
				'key' => 'vendor_ca_accountnumber',
				'validation' => '^\d{1,20}$'
			),

			array(
				'name' => 'Country',
				'key' => 'vendor_ot_country',
				'validation' => '^[A-Z]{2}$'
			),
			array(
				'name' => 'BIC',
				'key' => 'vendor_ot_bic',
				'validation' => '.+'
			),

			array(
				'name' => 'Account Number',
				'key' => 'vendor_ot_accountnumber',
				'validation' => '.+'
			),
		);

		foreach ($validation_info as $field) {
			if (isset($account_data[$field['key']]) && !empty($account_data[$field['key']])) {
				if (!preg_match('/' . $field['validation'] . '/', $account_data[$field['key']])) {
					$success = false;
					$message .= '</br> ' . $field['name'] . ' Does not match';
				}
			}
		}

		if (!$success) {
			echo '{"status": false, "message": "' . $message  . '"}';
			die;
		}
	}

	/**
	 * Load Localisation files.
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present
	 *
	 * @access public
	 * @return void
	 */

	public function load_plugin_textdomain()
	{
		$locale = function_exists('get_user_locale') ? get_user_locale() : get_locale();
		$locale = apply_filters('plugin_locale', $locale, 'wcfm-pg-mangopay');

		//load_plugin_textdomain( 'wcfm-tuneer-orders' );

		//load_textdomain( 'wcfm-pg-mangopay', WP_LANG_DIR . "/wcfm-pg-mangopay/wcfm-pg-mangopay-$locale.mo");

		load_textdomain('wcfm-pg-mangopay', $this->plugin_path . "lang/wcfm-pg-mangopay-$locale.mo");
		load_textdomain('wcfm-pg-mangopay', ABSPATH . "wp-content/languages/plugins/wcfm-pg-mangopay-$locale.mo");
	}

	public function load_class($class_name = '')
	{
		if ('' != $class_name && '' != $this->token) {
			require_once('class-' . esc_attr($this->token) . '-' . esc_attr($class_name) . '.php');
		} // End If Statement
	}

	public function validate_data($data, $vendor_id)
	{
		$errors = [];
		$data_type = isset($data['action']) ? $data['action'] : ''; // Assuming data_type indicates create or update

		$create_required_fields = [
			'payment_method' => 'mangopay',
			'billing_first_name' => 'First Name',
			'billing_last_name' => 'Last Name',
			'user_birthday' => 'User Birthday',
			'user_nationality' => 'User Nationality',
			'billing_country' => 'Billing Country',
			'billing_state' => 'Billing State',
			//'user_mp_status' => 'User MP Status',
			// 'user_business_type' => 'User Business Type', // Commented out since it's conditionally added
		];

		if (isset($data['user_mp_status'])) {
			$create_required_fields['user_mp_status'] = 'User MP Status';
		}

		// If 'user_mp_status' is 'individual', add 'user_business_type' to the list of required fields
		if (isset($data['user_mp_status']) && $data['user_mp_status'] === 'business') {
			$create_required_fields['user_business_type'] = 'User Business Type';
		}

		$update_required_fields = [
			'user_birthday' => 'User Birthday',
			'user_nationality' => 'User Nationality',
			'billing_country' => 'Billing Country',
			'legal_email' => 'Legal Email',
			'compagny_number' => 'Company Number',
			'headquarters_addressline1' => 'Headquarters Addressline1',
			'headquarters_city' => 'Headquarters City',
			'headquarters_region' => 'Headquarters Region',
			'headquarters_postalcode' => 'Headquarters Postalcode',
			'headquarters_country' => 'Headquarters Country',
			'termsconditions' => 'Terms Conditions',
		];

		$required_fields = ($data_type === 'update_mp_business_information') ? $update_required_fields : $create_required_fields;

		foreach ($required_fields as $field => $label) {

			// Check if the field is empty
			if (empty($data[$field])) {
				$errors[$field] = "Error: {$label} is required.";
			} else {
				// Additional validation for specific fields
				switch ($field) {
					case 'legal_email':
						// Validate email format
						if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
							$errors[$field] = "Error: {$label} is not a valid email address.";
						}
						break;
					case 'compagny_number':
						// Validate company number using a custom function
						$cn_validation = $this->mp->check_company_number_patterns($data[$field]);

						if ($cn_validation != 'found') {
							$errors[$field] = "Error: {$label} is not a valid.";
						}
						break;
						// Add more cases for other fields
					default:
						// No specific validation for other fields
						break;
				}
			}
		}
		return $errors;
	}

	// Data sanitize 
	private function sanitize_input($input_data)
	{
		$sanitized_data = array();

		foreach ($input_data as $key => $value) {
			switch ($key) {
				case 'legal_email':
					$sanitized_data[$key] = sanitize_email($value);
					break;

					// user id skip sanitize
				case 'vendor_id':
					$sanitized_data[$key] = $value;
					break;
					// Add more cases for other fields

				default:
					// For general fields, use sanitize_text_field
					$sanitized_data[$key] = sanitize_text_field($value);
					break;
			}
		}

		return $sanitized_data;
	}

	// Common function to save input data as user meta
	private function save_user_meta($data)
	{
		// Assuming $data['vendor_id'] is the user ID
		$user_id = $data['vendor_id'];

		$data_type = isset($data['action']) ? $data['action'] : '';

		$create_required_fields = [
			'payment_method', 'billing_first_name', 'billing_last_name', 'user_birthday', 'user_nationality', 'billing_country', 'billing_state',
			'user_mp_status', 'user_business_type' // Commented out since it's conditionally added
		];

		// Define create required fields
		$update_exists_fields = [
			'user_birthday', 'user_nationality', 'billing_country', 'legal_email', 'compagny_number', 'headquarters_addressline1', 'headquarters_addressline2', 'headquarters_city', 'headquarters_region', 'headquarters_postalcode',
			'headquarters_country', 'termsconditions',
		];

		$required_fields = ($data_type === 'update_mp_business_information') ? $update_exists_fields : $create_required_fields;

		// Loop through data
		foreach ($required_fields as $key) {
			// Handle specific fields using switch
			switch ($key) {

				case 'payment_method':
					$vendor_data = get_user_meta($user_id, 'wcfmmp_profile_settings', true);
					$vendor_data = is_array($vendor_data) ? $vendor_data : [];

					// Ensure the 'payment' key is an array
					$vendor_data['payment'] = $vendor_data['payment'] ?? [];

					// Update 'method' in 'payment' array
					$vendor_data['payment']['method'] = $data[$key];

					// Update user meta
					update_user_meta($user_id, 'wcfmmp_profile_settings', $vendor_data);
					break;
				case 'billing_first_name':
					update_user_meta($user_id, 'first_name', $data[$key]);
					update_user_meta($user_id, 'billing_first_name', $data[$key]);
					break;
				case 'billing_last_name':
					update_user_meta($user_id, 'last_name', $data[$key]);
					update_user_meta($user_id, 'billing_last_name', $data[$key]);
					break;
				case 'user_birthday':
					// Convert date and log the result for debugging
					$convertedDate = $this->convertDate($data[$key]);
					// Update 'user_birthday' in user meta
					update_user_meta($user_id, $key, $convertedDate);
					break;

				case 'user_mp_status':
					if (!empty($data[$key])) {
						update_user_meta($user_id, $key, $data[$key]);
					} else {
						update_user_meta($user_id, $key, $this->mangopayWCMain->options['default_vendor_status']);
					}
					break;
				case 'user_business_type':
					if (!empty($data[$key])) {
						update_user_meta($user_id, $key, $data[$key]);
					} else {
						update_user_meta($user_id, $key, $this->mangopayWCMain->options['default_business_type']);
					}
					break;
				case 'headquarters_addressline2':
					if (!empty($data[$key])) {
						update_user_meta($user_id, $key, $data[$key]);
					}
					break;
				default;
					if (($key != 'action') || $key != 'vendor_id') {
						//	error_log(print_r($key, true));
						//	error_log(print_r($data[$key], true));
						update_user_meta($user_id, $key, $data[$key]);
					}
					break;
			}
		}
	}

	public function mangopay_acount_creation_sample_data()
	{
		return [
			'action' => 'create_mp_account',
			'payment_method' => 'mangopay',
			'vendor_id' => '13',
			'billing_first_name' => 'createff',
			'billing_last_name' => 'createll',
			'user_birthday' => 'December 28, 2025',
			'user_nationality' => 'FR',
			'billing_country' => 'BD',
			'billing_state' => 'BD-06',
			'user_mp_status' => 'business',
			//'user_mp_status' => 'individual',
			'user_business_type' => 'business',
		];
	}
	public function mangopay_acount_update_sample_data()
	{
		return [
			'action' => 'update_mp_business_information',
			'vendor_id' => '14',
			'user_birthday' => 'fff',
			'user_nationality' => 'fff',
			'billing_country' => 'ffff',
			'legal_email' => 'fff@gmail.com',
			'compagny_number' => 'B12345678',
			'headquarters_addressline1' => 'ffff',
			'headquarters_addressline2' => 'fff',
			'headquarters_city' => 'ffff',
			'headquarters_region' => 'ffff',
			'headquarters_postalcode' => '56789',
			'headquarters_country' => 'ffff',
			'termsconditions' => true,
		];
	}
}
