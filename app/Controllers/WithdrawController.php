<?php

namespace App\Controllers;


use App\Models\FundingModel;
use DateTime;
use DatePeriod;
use DateInterval;
use App\Models\UserModel;
use App\Models\DepositModel;
use App\Models\WithdrawRequest;
use App\Models\TransactionModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;


class WithdrawController extends BaseController
{
    use ResponseTrait;
    private $user_id;
    private $withdraw_reuqest;
    public function __construct()
    {
        $this->user_id = getCurrentUser()['id'];
        $this->withdraw_reuqest = new WithdrawRequest();
    }
    public function create()
    {
        $rules = [
            'type' => 'required',
            'amount' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $user_id = getCurrentUser()['id'];

        if ($user_id == 1) {
            return $this->response->setJSON([
                'status' => '400',
                'message' => lang('Api.admin_withdraw_error'),
            ]);
        }

        $transactionModel = new TransactionModel();
        $total_amount = getuserwallet($user_id);
        $type = $this->request->getVar('type');
        $paypalemail = $this->request->getVar('paypal_email');
        $request_amount = $this->request->getVar('amount');

        if ($request_amount > $total_amount) {
            return $this->response->setJSON([
                'status' => '400',
                'message' => lang('Api.insufficient_balance'),
            ]);
        }

        if ($type == 'Paypal') {
            if (empty($paypalemail)) {
                return $this->response->setJSON([
                    'status' => '200',
                    'message' => lang('Api.paypal_email_required'),
                ]);
            }

            $data = [
                'type' => 'Paypal',
                'user_id' => $user_id,
                'amount' => $request_amount,
                'paypal_email' => $paypalemail,
            ];
            $this->withdraw_reuqest->save($data);
            $this->addtransaction($user_id, $request_amount);

            return $this->respond([
                'status' => '200',
                'message' => lang('Api.paypal_withdraw_success'),
            ], 200);
        } elseif ($type == 'Bank') {
            $iban = $this->request->getVar('iban');
            $address = $this->request->getVar('address');
            $country = $this->request->getVar('country');
            $swift_code = $this->request->getVar('swift_code');
            $full_name = $this->request->getVar('full_name');

            $fieldsToCheck = compact('iban', 'country', 'swift_code', 'full_name', 'address');
            $emptyFields = array_keys(array_filter($fieldsToCheck, function ($value) {
                return empty($value);
            }));

            if (!empty($emptyFields)) {
                $errorMessage = lang('Api.missing_fields') . implode(', ', $emptyFields);
                return $this->response->setJSON([
                    'status' => '200',
                    'message' => $errorMessage,
                ]);
            }

            $data = [
                'type' => 'Bank',
                'amount' => $request_amount,
                'user_id' => $user_id,
                'iban' => $iban,
                'country' => $country,
                'swift_code' => $swift_code,
                'full_name' => $full_name,
                'address' => $address,
            ];
            $this->withdraw_reuqest->save($data);
            $this->addtransaction($user_id, $request_amount);

            return $this->response->setJSON([
                'status' => '200',
                'message' => lang('Api.bank_withdraw_success'),
            ]);
        }
    }

    public function addtransaction($user_id, $amount)
    {
        $transactionModel  = new TransactionModel();
        $transactiondata = [
            'user_id' => $user_id,
            'amount' => $amount,
            'flag' => 'D',
            'action_type' => 4
        ];
        $transactionModel->save($transactiondata);
        $transactiondata = [
            'user_id' => 1,
            'amount' => $amount,
            'flag' => 'C',
            'action_type' => 4
        ];
        $transactionModel->save($transactiondata);
    }
    public function withdrawlist()
    {
        $offset = !empty($this->request->getVar('offset')) ? $this->request->getVar('offset') : 0;
        $limit = !empty($this->request->getVar('limit')) ? $this->request->getVar('limit') : 6;
        $userModel = new UserModel();

        $withdraw_requests = $this->withdraw_reuqest->where('user_id', $this->user_id)->orderBy('id', 'desc')->findAll($limit, $offset);

        if (!empty($withdraw_requests)) {
            foreach ($withdraw_requests as &$withdraw_request) {
                if ($withdraw_request['status'] == 1) {
                    $withdraw_request['status'] = lang('Api.status_pending');
                } elseif ($withdraw_request['status'] == 2) {
                    $withdraw_request['status'] = lang('Api.status_approve');
                } elseif ($withdraw_request['status'] == 3) {
                    $withdraw_request['status'] = lang('Api.status_reject');
                }
                $withdraw_request['user'] = $userModel->getUserShortInfo($withdraw_request['user_id']);
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.withdraw_requests_fetched_successfully'),
                'data' => $withdraw_requests
            ], 200);
        }
        return $this->respond([
            'code' => '400',
            'message' => lang('Api.withdraw_requests_not_found'),
        ], 200);
    }


    public function userwallet()
    {
        $user_id = getCurrentUser()['id'];
        $amount = getuserwallet($user_id);
     
        $transactionModel = New TransactionModel;
        $earnings = $transactionModel->get_breakdown($user_id);
      
        $dateFrom = date('Y-m-d', strtotime('-6 days'));
        $dateTo = date('Y-m-d');
        $totalSum = 0;
        // Generate list of dates within the range
        $interval = new DateInterval('P1D'); // 1 day interval
        $startDate = new DateTime($dateFrom);
        $endDate = new DateTime($dateTo);
        $endDate->add($interval); // Add 1 day to include the end date
        $period = new DatePeriod($startDate, $interval, $endDate);
        $sevendayearning = [];

        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');

            $credit = $transactionModel
                    ->selectSum('amount', 'total_amount')
                    ->where('flag', 'C')
                    ->where('DATE(created_at)', $dateString)
                    ->where('user_id', $user_id)
                    ->whereIn('action_type', [1, 2, 3])
                ->first();
                $debit = $transactionModel
                    ->selectSum('amount', 'total_amount')
                    ->where('flag', 'D')
                    ->where('DATE(created_at)', $dateString)
                    ->where('user_id', $user_id)
                    ->whereIn('action_type', [1, 2, 3])
                ->first();

                $credit_amount = !empty($credit['total_amount'])?$credit['total_amount']:0;
                $debit_amount = !empty($debit['total_amount'])?$debit['total_amount']:0;
                

                $total = $credit_amount-$debit_amount;                
               
                $totalSum += $total;
             
            
            $today = [
                'day' => $dateString,
                'total_earnings' => (!empty($total)) ? (string)$total : '0',
            ];

            $sevendayearning[] = $today;
        }
      
        $earnings['seven_day_earning'] =(string)$totalSum;

        return $this->response->setJSON([
            'status' => '200',
            'message' => 'Total Available balance',
            'amount'  => (string)$amount,
            'earning'=>$earnings,
            'seven_day_earning'=>array_reverse($sevendayearning),
            
        ]);
    }
    public function transaferAmount()
    {
    }
    public function transferFund()
    {
        $rules = [
            'user_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required'),
                ],
            ],
            'amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.amount_required'),
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $userModel = new UserModel;
        $user_id = $this->request->getVar('user_id');
        $loggedInUser = getCurrentUser();
        $user = $userModel->find($user_id);
        if ($user_id == $loggedInUser['id']) {
            return $this->response->setJSON([
                'status' => '400',
                'message' => lang('Api.cannot_transfer_to_self'),
            ]);
        }
        if (empty($user)) {
            return $this->response->setJSON([
                'status' => '404',
                'message' => lang('Api.user_not_found'),
            ]);
        }
        $amount = (float)$this->request->getVar('amount');
        $userwallet_balance = (float)getuserwallet($loggedInUser['id']);

        if ($amount > $userwallet_balance) {
            return $this->response->setJSON([
                'status' => '400',
                'message' => lang('Api.insufficient_balance'),
            ]);
        }
        $db = \Config\Database::connect();
        $db->transStart();
        try {
            $transactionModel = new TransactionModel;
            $deductionData = [
                'user_id' => $loggedInUser['id'],
                'amount' => $amount,
                'flag' => 'D',
                'action_type' => 11
            ];
            $transactionModel->save($deductionData);
            $creditEntry = [
                'user_id' => $user_id,
                'amount' => $amount,
                'flag' => 'C',
                'action_type' => 12
            ];
            $transactionModel->save($creditEntry);
            $db->transCommit();
            return $this->response->setJSON([
                'status' => '200',
                'message' => lang('Api.amount_transferred_successfully'),
            ]);
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction
            $db->transRollback();
            return $this->response->setJSON([
                'status' => '200',
                'message' => lang('Api.transfer_failed_due_to') . $e->getMessage(),
            ]);
        }
    }
    public function donate()
    {
        $rules = [
            'fund_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.fund_id_required'),
                ],
            ],
            'amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.amount_required'),
                ],
            ],
        ];
    
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $fund_id = $this->request->getVar('fund_id');
        $amount = $this->request->getVar('amount');

        $fundModel = New FundingModel;
        $fund = $fundModel->find($fund_id);
        if(empty($fund))
        {
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.donation_not_found'),
                
            ]);
        }
        $loggedin_user_id = getCurrentUser()['id'];
        $userwallet_amount = getuserwallet($loggedin_user_id);
        
        if($userwallet_amount<$amount)
        {
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.insufficient_balance'),
                
            ]);
        }
        $db = \Config\Database::connect();
        $db->transStart();
        try {
            $transactionModel = new TransactionModel;
            $deductionData = [
                'user_id' => $loggedin_user_id,
                'amount' => $amount,
                'flag' => 'D',
                'action_type' => 14
            ];
            
            $transactionModel->save($deductionData);
            $creditEntry = [
                'user_id' => $fund['user_id'],
                'amount' => $amount,
                'flag' => 'C',
                'action_type' => 14
            ];
            $transactionModel->save($creditEntry);
            $data = [
                'fund_id' => $fund['id'], // Replace with the actual fund_id value
                'user_id' => $loggedin_user_id, // Replace with the actual user_id value
                'amount' =>$amount, // Replace with the actual amount value
                // Current timestamp for updated_at
            ];
        
            $db->table('raise_fund')->insert($data);
           
            $db->transCommit();
            return $this->response->setJSON([
                'code' => '200',
                'message' => lang('Api.donation_successful'),
            ]);
        } catch (\Exception $e) {
            // If an error occurs, rollback the transaction
            $db->transRollback();
            return $this->response->setJSON([
                'code' => '200',
                'message' => lang('Api.donation_failed_due_to') . $e->getMessage(),
            ]);
        }

    }
}
