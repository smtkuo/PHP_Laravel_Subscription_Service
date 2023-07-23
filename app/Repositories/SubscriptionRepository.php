<?php 

namespace App\Repositories;

use App\Models\Subscription;
use Carbon\Carbon;
class SubscriptionRepository
{
    public function userHasSubscriptionType($userId, $subscriptionTypeId)
    {
        return Subscription::where('user_id', $userId)
            ->where('subscription_type_id', $subscriptionTypeId)
            ->where('expired_at', '>', now())
            ->exists();
    }

    public function create(array $data)
    {
        return Subscription::create($data);
    }

    public function find($id)
    {
        return Subscription::find($id);
    }
    
    public function where($array)
    {
        return Subscription::where($array)->first();
    }

    public function update(Subscription $subscription, $data)
    {
        $subscription->update($data);
        return $subscription;
    }

    public function delete(Subscription $subscription)
    {
        return $subscription->delete();
    }

    public function activeSubscriptionTypeNames($userId)
    {
        return Subscription::where('user_id', $userId)
            ->where('expired_at', '>', Carbon::now())
            ->with('subscriptionType')
            ->get()
            ->pluck('subscriptionType.id')
            ->unique();
    }

    public function getSubscriptionsToRenew($date)
    {
        // Find all subscriptions where the 'expired_at' date is today or earlier
        return Subscription::where('expired_at', '<=', $date)->get();
    }
}
