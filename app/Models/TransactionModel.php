<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];



    function get_user_balance($user_id)
    {

        $transactionModel = new TransactionModel();

        $creditAmount = $transactionModel->selectSum('amount', 'total')
            ->where('user_id', $user_id)
            ->where('flag', 'C')
            ->get()
            ->getRow()
            ->total;

        $debitAmount = $transactionModel->selectSum('amount', 'total')
            ->where('user_id', $user_id)
            ->where('flag', 'D')
            ->get()
            ->getRow()
            ->total;

        return  $creditAmount - $debitAmount;
    }

    public function get_breakdown($user_id)
    {
        $db = db_connect();
        $dbPrefix = $db->DBPrefix;
        $user_balance=base_urls();
        // Query to fetch earnings for each transaction type
        $query = "
            SELECT
                SUM(CASE WHEN action_type = 1 AND flag='C' THEN amount ELSE 0 END) AS like_earnings,
                SUM(CASE WHEN action_type = 2 AND flag='C' THEN amount ELSE 0 END) AS comment_earnings,
                SUM(CASE WHEN action_type = 3 AND flag='C' THEN amount ELSE 0 END) AS share_earnings,
                SUM(CASE WHEN action_type = 4 AND flag='C' THEN amount ELSE 0 END) AS withdraw_earnings,
                SUM(CASE WHEN action_type = 5 AND flag='C' THEN amount ELSE 0 END) AS deposit_earnings,
                SUM(CASE WHEN action_type = 1 AND flag='D' THEN amount ELSE 0 END) AS like_debit,
                SUM(CASE WHEN action_type = 2 AND flag='D' THEN amount ELSE 0 END) AS comment_debit,
                SUM(CASE WHEN action_type = 3 AND flag='D' THEN amount ELSE 0 END) AS share_debit,
                SUM(CASE WHEN action_type = 4 AND flag='D' THEN amount ELSE 0 END) AS withdraw_debit,
                SUM(CASE WHEN action_type = 5 AND flag='D' THEN amount ELSE 0 END) AS deposit_debit
            FROM
                {$dbPrefix}transactions
            WHERE
                user_id = ?";

        // Execute the query
        $queryResult = $db->query($query, [$user_id]);

        // Fetch the result
        $result = $queryResult->getRow();

        // Calculate total earnings
        $totalEarnings = $result->like_earnings + $result->comment_earnings + $result->share_earnings + $result->withdraw_earnings + $result->deposit_earnings- ($result->like_debit + $result->comment_debit + $result->share_debit + $result->withdraw_debit + $result->deposit_debit);

        return [
            'like_earnings' => (string)($result->like_earnings- $result->like_debit),
            'comment_earnings' => (string)($result->comment_earnings-$result->comment_debit),
            'share_earnings' => (string)($result->share_earnings-$result->share_debit),
            'withdraw_earnings' => (string)($result->withdraw_earnings-$result->withdraw_debit),
            'deposit_earnings' => (string)($result->deposit_earnings-$result->deposit_debit),
            'total_earnings' => (string)$totalEarnings,
        ];
    }

}
