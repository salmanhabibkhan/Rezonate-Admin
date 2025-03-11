<?php

namespace App\Controllers;

use Exception;
use Stripe\Charge;
use Stripe\Stripe;

use Stripe\StripeClient;
use App\Models\DepositModel;
use App\Models\TransactionModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class DepositeController extends BaseController
{
    use ResponseTrait;

    public function create()
    {
        $rules = [
            'gateway_id' => [
                'label' => 'Payment Gateway',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.gateway_id_required'),
                ]
            ],
            'transaction_id' => [
                'label' => 'Transaction ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.transaction_id_required'),
                ]
            ]
        ];
    
        // Validate input
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond(
                [
                    'status' => '400',
                    'message' => lang('Api.validation_error'),
                    'data' => $validationErrors,
                ],
                400
            );
        }
        $gateway_id = esc($this->request->getVar('gateway_id'));
        $transaction_id = esc($this->request->getVar('transaction_id'));
        
        if($gateway_id==1)
        {
            $transaction  = $this->getPyapalTransactioDetails($transaction_id);
            $transactionFee = $transaction['transactions'][0]['related_resources'][0]['sale']['transaction_fee']['value'];


            $amount = $transaction['transactions'][0]['amount']['total'];
            $deposited_amount = $amount-$transactionFee;
            
           
            
            $this->depostAmount($gateway_id,$deposited_amount,$transaction_id,'USD');
            return $this->respond(
                [
                    'status' => '200',
                    'message' => lang('Api.paypal_deposit_success'),
                ],
                200
            );
        }
        if($gateway_id==2)
        {
            $transaction  = $this->depositUSingStripe($transaction_id);
            $appfee = $transaction['application_fee_amount']??0;
            $deposited_amount  = ($transaction['amount']-$appfee)/100;
            $this->depostAmount($gateway_id,$deposited_amount,$transaction_id,'USD');
            return $this->respond(
                [
                    'status' => '200',
                    'message' => lang('Api.stripe_deposit_success'),
                ],
                200
            );
        }
        elseif($gateway_id==3)
        {
            $transaction  =  $this->depositUsingPaystack($transaction_id);
            
            $deposited_amount = $transaction['amount']-$transaction['fees'];
            $deposited_amount = $deposited_amount/100;
            if($transaction['currency']!='USD')
            {
                $deposited_amount = $this->convertCurrency($transaction['currency'],$deposited_amount);
            }
            $this->depostAmount($gateway_id,$deposited_amount,$transaction_id,'USD');
            return $this->respond(
                [
                    'status' => '200',
                    'message' => lang('Api.paystack_deposit_success'),
                ],
                200
            );
        }
        elseif($gateway_id==4)
        {
            $transaction = $this->depositUsingFlutterwave($transaction_id);
            $deposited_amount = $transaction['amount']-$transaction['app_fee']-$transaction['merchant_fee'];
            if($transaction['currency']!='USD')
            {
                $deposited_amount = $this->convertCurrency($transaction['currency'],$deposited_amount);
            }
            $this->depostAmount($gateway_id,$deposited_amount,$transaction_id,'USD');
            return $this->respond(
                [
                    'status' => '200',
                    'message' => lang('Api.flutterwave_deposit_success'),
                ],
                200
            );
        }

    }
    public function getPyapalTransactioDetails($transactionId)
    {
        $clientId = get_setting('paypal_public_key');
        $secret = get_setting('paypal_secret_key');        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials&scope=https://uri.paypal.com/services/payments/realtimepayment");


        // Setting the headers
        $headers = [];
        $headers[] = "Accept: application/json";
        $headers[] = "Accept-Language: en_US";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $accessToken = json_decode($response)->access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v1/payments/payment/" . $transactionId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Set the headers, including the Bearer token
        $headers = [];
        $headers[] = "Content-Type: application/json";
        $headers[] = "Authorization: Bearer " . $accessToken;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute cURL request and store the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            // Decode and display the transaction details
            $transactionDetails = json_decode($response, true);
            
            // Check if the transaction details were successfully retrieved
            if (isset($transactionDetails['id'])) {
                return $transactionDetails;
            }
        }

        curl_close($ch);
    }
    protected function depositUsingFlutterwave($transaction_id)
    {
        $secret_key = get_setting('flutterwave_secret_key');
        $url = "https://api.flutterwave.com/v3/transactions/$transaction_id/verify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $secret_key",
            "Content-Type: application/json"
        ]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            $result = json_decode($response, true);
            if ($result['status'] === 'success') {
                return $result['data'];
            } else {
                echo "Error: " . $result['message'];
            }
        }

        // Close cURL session
        curl_close($ch);
    }   
    public function depostAmount($gateway_id,$amount,$transaction_id,$currency)
    {
        $depositModel = new DepositModel();
        $depositdata = [
            'user_id' => getCurrentUser()['id'],
            'gateway_id' => $gateway_id,
            'amount' => $amount,
            'transaction_id' => $transaction_id,
            'currency' => strtoupper($currency),
            'status'=>'approved'
        ];
        $depositModel->save($depositdata);
        //credit entry
        $transactionModel = New TransactionModel();
        $transaction = [
            'user_id'=>getCurrentUser()['id'],
            'flag'=>'C',
            'action_type'=>5,
            'amount'=>$amount,
        ];
        $transactionModel->save($transaction);
        
    }
    protected function depositUSingStripe($tranactionId)
    {
        require_once APPPATH . 'ThirdParty/stripe/stripe-php/init.php';
        Stripe::setApiKey(get_setting('paypal_secret_key'));
        $stripe = new Stripe();
        $stripe = new StripeClient(get_setting('stripe_secret_key'));
        $data = $stripe->paymentIntents->retrieve($tranactionId);
        return $data;
    }
    public function depositUsingPaystack($transactionId)
    {
        $secret_key =get_setting('paystack_secret_key');
        $url = "https://api.paystack.co/transaction/verify/$transactionId";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $secret_key"
        ]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            $result = json_decode($response, true);
            if ($result['status']) {
                return $result['data'];

            } else {
                // Error occurred
                echo "Error: " . $result['message'];
            }
        }

        // Close cURL session
        curl_close($ch);
    }
    public function convertCurrency($fromCurrency,$amount)
    {
        $apiKey = '801a81b7c0f943322a0c920e';
        $toCurrency = 'USD';
        $url = "https://v6.exchangerate-api.com/v6/$apiKey/pair/$fromCurrency/$toCurrency";

        // Initialize cURL session
        $curl = curl_init();

        // Set the options for the cURL session
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);

        // Execute the request and store the response
        $response = curl_exec($curl);

        // Close the cURL session
        curl_close($curl);

        // Decode the response
        $data = json_decode($response, true);

        // Check if the request was successful
        if (isset($data['conversion_rate'])) {
            // Get the conversion rate
            $conversionRate = $data['conversion_rate'];
          
            // Calculate the converted amount
            $convertedAmount = $amount * $conversionRate;
            
            return $convertedAmount;
        } else {
            echo "Error retrieving conversion rate.\n";
        }
    }
    public function depositAmount()
    {
        $user_id = getCurrentUser()['id'];
        $trancationModel = New TransactionModel;
        $this->data['user_balance'] = $trancationModel->get_user_balance($user_id);
        $this->data['css_files'] = ['css/wallet.css'];
        echo load_view('pages/wallet/deposit', $this->data);
    
    }
    public function depositAmountViaPaypal()
    {
        $user_id = getCurrentUser()['id'];
        $trancationModel = New TransactionModel;
        $this->data['user_balance'] = $trancationModel->get_user_balance($user_id);
        $this->data['css_files'] = ['css/wallet.css'];
        echo load_view('pages/wallet/depositviapaypal', $this->data);
    
    }
    public function depositAmountViaPaystack()
    {
        $user_id = getCurrentUser()['id'];
        $trancationModel = New TransactionModel;
        $this->data['user_balance'] = $trancationModel->get_user_balance($user_id);
        $this->data['css_files'] = ['css/wallet.css'];
        echo load_view('pages/wallet/depositviapaystack', $this->data);
    
    }
    public function paymentCheckout()
    {
        $user = getCurrentUser();
        require_once APPPATH . 'ThirdParty/stripe/stripe-php/init.php';
        Stripe::setApiKey(get_setting('stripe_secret_key'));
        try {
            
            $charge = Charge::create ([
                "amount" =>$this->request->getVar('amount'),
                "currency" => "usd",
                "source" => $this->request->getVar('stripeToken'),
                "description" => "Test payment from tutsmake.com."
            ]);
            $transaction_id = $charge->id;
            $charge = Charge::retrieve($charge->id);
            if ($charge->status === 'succeeded' && $charge->paid === true) {
                $depositModel = new DepositModel;
                
                $depositdata = [
                    'user_id' => $user['id'],
                    'gateway_id' => 2,
                    'amount' => $charge->amount,
                    'transaction_id' => $transaction_id,
                    'currency' => strtoupper($charge->currency),
                    'status' => 'approved',
                ];
                $depositModel->save($depositdata);
                $transactionModel = New TransactionModel();
                $transaction = [
                    'user_id'=>$user['id'],
                    'flag'=>'C',
                    'action_type'=>5,
                    'amount'=>$charge->amount,
                ];
                $transactionModel->save($transaction);
                return redirect()->to(site_url('wallet'));
            } else {
                return 'Payment not confirmed!';
            }
        } catch (Exception $e) {
            // Redirect with error message if charge fails
            echo $e->getMessage();
        }

    }
}
