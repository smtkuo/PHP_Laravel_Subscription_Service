<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function create($userId, CreateSubscriptionRequest $request)
    {
        $subscription = $this->subscriptionService->create(
            $userId,
            $request->input('renewed_at'),
            $request->input('expired_at')
        );

        return response()->json($subscription, 201);
    }

    public function update($subscriptionId, UpdateSubscriptionRequest $request)
    {
        $subscription = $this->subscriptionService->update(
            $subscriptionId,
            $request->input('renewed_at'),
            $request->input('expired_at')
        );

        if ($subscription) {
            return response()->json($subscription, 200);
        } else {
            return response()->json(['error' => 'Subscription not found'], 404);
        }
    }

    public function delete($subscriptionId)
    {
        $deleted = $this->subscriptionService->delete($subscriptionId);

        if ($deleted) {
            return response()->json(['message' => 'Subscription deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Subscription not found'], 404);
        }
    }
}