<?php

namespace App\Controllers;

use Yabacon\Paystack;
use App\Controllers\BaseController;
require_once APPPATH . 'ThirdParty/Paystack/src/autoload.php';

class PaystackController extends BaseController
{
    protected $paystack;
    public function __construct()
    {
        // Initialize Paystack with your secret key
        $secretKey = 'sk_test_37122620f3fa9f07f6a2be9fecbd79b635ad72f8';
        $this->paystack = new Paystack($secretKey);
    }

    public function pay()
    {
        $amount = $this->request->getVar('amount')*100;
        $email = getCurrentUser()['email'];

        try {
            $response = $this->paystack->transaction->initialize([
                'amount' => $amount,
                'email' => $email,
                'callback_url' => base_url('paystack/callback'),
            ]);

            if ($response->status) {
                return redirect()->to($response->data->authorization_url);
            } else {
                // Handle error
                echo "Error: " . $response->message;
            }
        } catch (\Exception $e) {
            echo "Exception: " . $e->getMessage();
        }
        
    }

    public function callback()
    {
        $reference = $this->request->getGet('reference');
        $depositControllerObj = New DepositeController();
        $transaction = $depositControllerObj->depositUsingPaystack($reference);
    
        $depositControllerObj->convertCurrency($transaction['currency'],$transaction['amount']);
        $deposited_amount = $transaction['amount']-$transaction['fees'];
        $deposited_amount = $deposited_amount/100;

        
        if($transaction['currency']!='USD')
        {
            $deposited_amount = $depositControllerObj->convertCurrency($transaction['currency'],$deposited_amount);
        }
        $depositControllerObj->depostAmount(3,$deposited_amount,$reference,'USD');
        return redirect()->to(site_url('wallet'))->with('message', 'Payment successful');
    }
}
