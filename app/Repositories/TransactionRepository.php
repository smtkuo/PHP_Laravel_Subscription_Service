<?php 

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    public function create($data)
    {
        return Transaction::create($data);
    }

    public function getByUserId($userId)
    {
        return DB::table('transactions')
            ->join('subscriptions', 'transactions.subscription_id', '=', 'subscriptions.id')
            ->join('subscription_types', 'subscriptions.subscription_type_id', '=', 'subscription_types.id')
            ->where('transactions.user_id', $userId)
            ->select('transactions.*', 'subscription_types.name as subscription_type_name')
            ->get();
    }
}