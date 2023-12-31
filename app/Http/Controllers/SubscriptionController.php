<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Services\SubscriptionService;
use Exception;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }
    public function create($userId, CreateSubscriptionRequest $request)
    {
        try {
            $validated = $request->validated();

            $subscription = $this->subscriptionService->create(
                $userId,
                $validated['subscription_type_id'],
                $validated['renewed_at'],
                $validated['expired_at']
            );
    
            return response()->json($subscription, 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function update($userId, $subscriptionId, UpdateSubscriptionRequest $request)
    {
        try {
            $subscription = $this->subscriptionService->update(
                $userId,
                $subscriptionId,
                $request->input('renewed_at'),
                $request->input('expired_at'),
                $request->input('subscription_type_id')
            );

            if ($subscription) {
                return response()->json($subscription, 200);
            } else {
                return response()->json(['error' => 'Subscription not found'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function delete($id)
    {
        try {
            $deleted = $this->subscriptionService->delete($id);

            if ($deleted) {
                return response()->json(['message' => 'Subscription deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Subscription not found'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
