<?php 

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function create($data)
    {
        return Transaction::create($data);
    }
}