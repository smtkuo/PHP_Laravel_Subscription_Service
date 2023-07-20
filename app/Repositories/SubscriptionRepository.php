<?php 

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository
{
    public function create($data)
    {
        return Subscription::create($data);
    }

    public function find($id)
    {
        return Subscription::find($id);
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
}
