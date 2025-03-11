<?php

namespace App\Controllers;
use Exception;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use App\Controllers\BaseController;
use App\Controllers\DepositeController ;
use Paystack\Paystack as PaystackClient;
use App\Config\Paystack as PaystackConfig;

class PayPalController extends BaseController
{
    
    protected $paystack;
    protected $config = [];

    public function createPayment()
    {
        
        // dd(get_setting('paypal_public_key'));

        $amount = $this->request->getVar('amount');
        $approvalLink = createPayPalPayment($amount);
        if ($approvalLink) {
            return redirect()->to($approvalLink);  // Redirect user to PayPal for payment
        } else {
            return redirect()->back()->with('error', 'Payment creation failed');
        }
    }

    public function paymentSuccess()
    {
        $paymentId = $this->request->getGet('paymentId');
        $payerId = $this->request->getGet('PayerID');

        if (!$paymentId || !$payerId) {
            return redirect()->back()->with('error', 'Payment failed or canceled');
        }

        $payment = Payment::get($paymentId, getPayPalApiContext());

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {

            // Execute the payment
            $result = $payment->execute($execution, getPayPalApiContext());
            
            $paymentArray = $result->toArray();


            $depositControllerObj = New DepositeController();
            $transaction  = $depositControllerObj->getPyapalTransactioDetails($paymentArray['id']);
            $transactionFee = $transaction['transactions'][0]['related_resources'][0]['sale']['transaction_fee']['value'];
            $amount = $transaction['transactions'][0]['amount']['total'];
            $deposited_amount = $amount-$transactionFee;
            $depositControllerObj->depostAmount(1,$deposited_amount,$paymentArray['id'],'USD');
             
            // Payment successful, process deposit here
            return redirect()->to(site_url('wallet'))->with('message', 'Payment successful');
        } catch (Exception $ex) {
            // Handle payment failure
            return redirect()->to('/fail')->with('error', 'Payment execution failed');
        }
    }

    public function paymentCancel()
    {
        return redirect()->to('/cancel')->with('error', 'Payment canceled');
    }
    

}
