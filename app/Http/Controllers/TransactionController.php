<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function create($userId, TransactionRequest $request)
    {
        $transaction = $this->transactionService->create(
            $userId,
            $request->input('subscription_id'),
            $request->input('price')
        );

        return response()->json($transaction, 201);  // 201 Created
    }
}