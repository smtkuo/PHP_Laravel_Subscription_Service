<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SubscriptionTypeService;

class DashboardController extends Controller
{
    protected $subscriptionTypeService;

    public function __construct(SubscriptionTypeService $subscriptionTypeService)
    {
        $this->subscriptionTypeService = $subscriptionTypeService;
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

        // Return the dashboard view
        return view('dashboard', ['user' => $user, 'subscriptionTypes' => $subscriptionTypes]);
    }
}