<?php 

// 42 
process_payment();

// 141 PayOut withdrawl amount to vendor bank a/c
$mp_payout = $this->process_mangopay_payout();

/**
 * $this->vendor_id
 * $mp_account_id
 * 0 order_id 
 * $this->currency,
 * ($this->withdraw_amount + $this->withdraw_charges)
 * $this->withdraw_charges
 */
$result = $this->mp->payout();

// MP Woocommerce
class mpAccess{} 


/**
 * 2063 
 * $this->vendor_id
 * $mp_account_id
 * 0 order_id 
 * $this->currency,
 * ($this->withdraw_amount + $this->withdraw_charges)
 * $this->withdraw_charges
 */
// 2063
 payout();

  /**
   * AuthorId = $mp_vendor_id
   * DebitedWalletID = $mp_vendor_wallet_id
   * DebitedFunds = new \MangoPay\Money();
   * DebitedFunds->Currency = $currency;
   * DebitedFunds->Amount = round($amount * 100);
   * Fees = new \MangoPay\Money();
   * Fees->Currency = $currency;
   * Fees->Amount = round($fees * 100);
   * PaymentType = BANK_WIRE
   * MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
   * MeanOfPaymentDetails->BankAccountId = $mp_account_id;
   * MeanOfPaymentDetails->BankWireRef = 'ID ' . $order_id;
   * Tag = 'Commission for WC Order #' . $order_id . ' - ValidatedBy:' . wp_get_current_user()->user_login;
   */
// 2100 
$PayOut = new \MangoPay\PayOut();