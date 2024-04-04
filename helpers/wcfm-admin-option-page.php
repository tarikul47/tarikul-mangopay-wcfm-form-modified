<?php

add_action('admin_menu', 'wcfm_admin_option_page');

function wcfm_admin_option_page()
{

    add_options_page(
        'Mangopay Custom Settings', // page <title>Title</title>
        'Mangopay Settings', // menu link text
        'manage_options', // capability to access the page
        'mangopay-custom-settings', // page URL slug
        'wcfm_admin_custom_settigns', // callback function with content
        9 // priority
    );
}

function wcfm_admin_custom_settigns()
{
    // Save data on submit
    // NOTIFICATION
    if (isset($_POST['wcfm_company_number_notification']) && !empty($_POST['wcfm_company_number_notification'])) update_option('wcfm_company_number_notification', $_POST['wcfm_company_number_notification']); // Company Number
    if (isset($_POST['wcfm_bank_account_notification']) && !empty($_POST['wcfm_bank_account_notification'])) update_option('wcfm_bank_account_notification', $_POST['wcfm_bank_account_notification']); // Bank Account
    if (isset($_POST['wcfm_kyc_document_notification']) && !empty($_POST['wcfm_kyc_document_notification'])) update_option('wcfm_kyc_document_notification', $_POST['wcfm_kyc_document_notification']); // KYC Document
    if (isset($_POST['wcfm_kyc_validated_notification']) && !empty($_POST['wcfm_kyc_validated_notification'])) update_option('wcfm_kyc_validated_notification', $_POST['wcfm_kyc_validated_notification']); // KYC Validated
    if (isset($_POST['wcfm_ubo_document_notification']) && !empty($_POST['wcfm_ubo_document_notification'])) update_option('wcfm_ubo_document_notification', $_POST['wcfm_ubo_document_notification']); // UBO Document
    if (isset($_POST['wcfm_mangopay_notice_title']) && !empty($_POST['wcfm_mangopay_notice_title'])) update_option('wcfm_mangopay_notice_title', $_POST['wcfm_mangopay_notice_title']); // Notice Title
    if (isset($_POST['wcfm_mangopay_notice_description']) && !empty($_POST['wcfm_mangopay_notice_description'])) update_option('wcfm_mangopay_notice_description', stripslashes($_POST['wcfm_mangopay_notice_description'])); // Notice Description

    //HINTS
    if (isset($_POST['wcfm_business_information_hints']) && !empty($_POST['wcfm_business_information_hints'])) update_option('wcfm_business_information_hints', $_POST['wcfm_business_information_hints']); // Business Information
    if (isset($_POST['wcfm_company_number_hints']) && !empty($_POST['wcfm_company_number_hints'])) update_option('wcfm_company_number_hints', $_POST['wcfm_company_number_hints']); // Comapany Number
    if (isset($_POST['wcfm_legal_rep_email_hints']) && !empty($_POST['wcfm_legal_rep_email_hints'])) update_option('wcfm_legal_rep_email_hints', $_POST['wcfm_legal_rep_email_hints']); // Legal Rep Email
    if (isset($_POST['wcfm_headquarter_address_hints']) && !empty($_POST['wcfm_headquarter_address_hints'])) update_option('wcfm_headquarter_address_hints', $_POST['wcfm_headquarter_address_hints']); // Headquarter Address
    if (isset($_POST['wcfm_ubo_information_hints']) && !empty($_POST['wcfm_ubo_information_hints'])) update_option('wcfm_ubo_information_hints', $_POST['wcfm_ubo_information_hints']); // UBO Information
    if (isset($_POST['wcfm_kyc_details_hints']) && !empty($_POST['wcfm_kyc_details_hints'])) update_option('wcfm_kyc_details_hints', $_POST['wcfm_kyc_details_hints']); // KYC Details
    if (isset($_POST['wcfm_bank_details_hints']) && !empty($_POST['wcfm_bank_details_hints'])) update_option('wcfm_bank_details_hints', $_POST['wcfm_bank_details_hints']); // Bank Details
    if (isset($_POST['wcfm_add_bank_hints']) && !empty($_POST['wcfm_add_bank_hints'])) update_option('wcfm_add_bank_hints', $_POST['wcfm_add_bank_hints']); // Add Bank Account
    if (isset($_POST['wcfm_upload_files_hints']) && !empty($_POST['wcfm_upload_files_hints'])) update_option('wcfm_upload_files_hints', $_POST['wcfm_upload_files_hints']); // Upload Files
    if (isset($_POST['wcfm_submit_kyc_hints']) && !empty($_POST['wcfm_submit_kyc_hints'])) update_option('wcfm_submit_kyc_hints', $_POST['wcfm_submit_kyc_hints']); // Submit KYC Documents

    // Variable
    $rows = 3;
    $cols = 50;

?>
    <!-- Form -->
    <div>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <h1>Mangopay Custom Settings</h1>
            <p>In this page you can update your Mangopay custom settings</p>
            <h2>Custom Notifications</h2>
            <table>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_company_number_notification">Valid Company Number</label>
                    </th>
                    <td>
                        <textarea id="wcfm_company_number_notification" name="wcfm_company_number_notification" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>" placeholder="Please insert a valid company number!"><?php echo get_option('wcfm_company_number_notification'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_bank_account_notification">Bank Account</label>
                    </th>
                    <td>
                        <textarea id="wcfm_bank_account_notification" name="wcfm_bank_account_notification" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>" placeholder="Please insert a bank account!"><?php echo get_option('wcfm_bank_account_notification'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_kyc_document_notification">KYC Documents</label>
                    </th>
                    <td>
                        <textarea id="wcfm_kyc_document_notification" name="wcfm_kyc_document_notification" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>" placeholder="Please validate your KYC documents!"><?php echo get_option('wcfm_kyc_document_notification'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_kyc_validated_notification">KYC Validated</label>
                    </th>
                    <td>
                        <textarea id="wcfm_kyc_validated_notification" name="wcfm_kyc_validated_notification" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>" placeholder="Your KYC is validated!"><?php echo get_option('wcfm_kyc_validated_notification'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_ubo_document_notification">UBO Documents</label>
                    </th>
                    <td>
                        <textarea id="wcfm_ubo_document_notification" name="wcfm_ubo_document_notification" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>" placeholder="Please submit your UBO documents!"><?php echo get_option('wcfm_ubo_document_notification'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_mangopay_notice_title">Notice Title</label>
                    </th>
                    <td>
                        <textarea id="wcfm_mangopay_notice_title" name="wcfm_mangopay_notice_title" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>" placeholder="Please insert a notice title."><?php echo get_option('wcfm_mangopay_notice_title'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_mangopay_notice_description">Notice Description</label>
                    </th>
                    <td>
                        <textarea id="wcfm_mangopay_notice_description" name="wcfm_mangopay_notice_description" rows="10" cols="<?php echo $cols; ?>" placeholder="Please insert notice description."><?php echo get_option('wcfm_mangopay_notice_description'); ?></textarea>
                    </td>
                </tr>
            </Table>
            <h2>Custom Hints</h2>
            <table>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_business_information_hints">Business Information</label>
                    </th>
                    <td>
                        <textarea id="wcfm_business_information_hints" name="wcfm_business_information_hints" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>"><?php echo get_option('wcfm_business_information_hints'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_company_number_hints">Company Number</label>
                    </th>
                    <td>
                        <textarea id="wcfm_company_number_hints" name="wcfm_company_number_hints" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>"><?php echo get_option('wcfm_company_number_hints'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_legal_rep_email_hints">Legal Rep Email</label>
                    </th>
                    <td>
                        <textarea id="wcfm_legal_rep_email_hints" name="wcfm_legal_rep_email_hints" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>"><?php echo get_option('wcfm_legal_rep_email_hints'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_headquarter_address_hints">Headquarter Address</label>
                    </th>
                    <td>
                        <textarea id="wcfm_headquarter_address_hints" name="wcfm_headquarter_address_hints" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>"><?php echo get_option('wcfm_headquarter_address_hints'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_ubo_information_hints">UBO Information</label>
                    </th>
                    <td>
                        <textarea id="wcfm_ubo_information_hints" name="wcfm_ubo_information_hints" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>"><?php echo get_option('wcfm_ubo_information_hints'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_kyc_details_hints">KYC Details</label>
                    </th>
                    <td>
                        <textarea id="wcfm_kyc_details_hints" name="wcfm_kyc_details_hints" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>"><?php echo get_option('wcfm_kyc_details_hints'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_bank_details_hints">Bank Details</label>
                    </th>
                    <td>
                        <textarea id="wcfm_bank_details_hints" name="wcfm_bank_details_hints" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>"><?php echo get_option('wcfm_bank_details_hints'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_add_bank_hints">Add Bank Account</label>
                    </th>
                    <td>
                        <textarea id="wcfm_add_bank_hints" name="wcfm_add_bank_hints" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>"><?php echo get_option('wcfm_add_bank_hints'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_submit_kyc_hints">Submit KYC Documents</label>
                    </th>
                    <td>
                        <textarea id="wcfm_submit_kyc_hints" name="wcfm_submit_kyc_hints" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>"><?php echo get_option('wcfm_submit_kyc_hints'); ?></textarea>
                    </td>
                </tr>
                <tr valign="top" align="left">
                    <th scope="row">
                        <label for="wcfm_upload_files_hints">Upload Files</label>
                    </th>
                    <td>
                        <textarea id="wcfm_upload_files_hints" name="wcfm_upload_files_hints" rows="<?php echo $rows; ?>" cols="<?php echo $cols; ?>"><?php echo get_option('wcfm_upload_files_hints'); ?></textarea>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <!-- Form -->
<?php
}
