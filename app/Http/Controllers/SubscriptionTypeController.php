<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubscriptionTypeRequest;
use App\Http\Requests\UpdateSubscriptionTypeRequest;
use App\Services\SubscriptionTypeService;

class SubscriptionTypeController extends Controller
{
    protected $subscriptionTypeService;

    public function __construct(SubscriptionTypeService $subscriptionTypeService)
    {
        $this->subscriptionTypeService = $subscriptionTypeService;
    }

    public function index()
    {
        $subscriptionTypes = $this->subscriptionTypeService->getAll();

        return response()->json($subscriptionTypes, 200);
    }

    public function store(CreateSubscriptionTypeRequest $request)
    {
        $subscriptionType = $this->subscriptionTypeService->create($request->validated());

        return response()->json($subscriptionType, 201);
    }

    public function show($id)
    {
        $subscriptionType = $this->subscriptionTypeService->getById($id);

        if ($subscriptionType) {
            return response()->json($subscriptionType, 200);
        } else {
            return response()->json(['error' => 'Subscription Type not found'], 404);
        }
    }

    public function update($id, UpdateSubscriptionTypeRequest $request)
    {
        $updated = $this->subscriptionTypeService->update($id, $request->validated());

        if ($updated) {
            return response()->json(['message' => 'Subscription Type updated successfully'], 200);
        } else {
            return response()->json(['error' => 'Subscription Type not found'], 404);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->subscriptionTypeService->delete($id);

        if ($deleted) {
            return response()->json(['message' => 'Subscription Type deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Subscription Type not found'], 404);
        }
    }
}