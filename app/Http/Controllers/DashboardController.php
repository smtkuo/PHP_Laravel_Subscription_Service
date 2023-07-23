<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SubscriptionTypeService;
use App\Services\SubscriptionService;
use App\Services\TransactionService;


class DashboardController extends Controller
{
    protected $subscriptionTypeService;
    protected $subscriptionService;
    protected $transactionService;

    public function __construct(SubscriptionTypeService $subscriptionTypeService, SubscriptionService $subscriptionService, TransactionService $transactionService)
    {
        $this->subscriptionTypeService = $subscriptionTypeService;
        $this->subscriptionService = $subscriptionService;
        $this->transactionService = $transactionService;
    }

    /**
     * Display the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Retrieve all subscription types
        $subscriptionTypes = $this->subscriptionTypeService->getAll();
        
        // Retrieve all subscription type names
        $activeSubscriptionTypeNames = $this->subscriptionService->activeSubscriptionTypeNames($user->id);

        // Retrieve all transactions
        $transactions = $this->transactionService->getTransactionsByUser($user->id);

        // Return the dashboard view
        return view('dashboard', compact('user', 'subscriptionTypes', 'activeSubscriptionTypeNames', 'transactions'));
    }
}