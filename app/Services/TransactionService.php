<?php 

namespace App\Services;

use App\Repositories\TransactionRepository;

class TransactionService
{
    protected $transactionRepo;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepo = $transactionRepo;
    }

    public function create($userId, $subscriptionId, $price)
    {
        return $this->transactionRepo->create([
            'user_id' => $userId,
            'subscription_id' => $subscriptionId,
            'price' => $price
        ]);
    }
}