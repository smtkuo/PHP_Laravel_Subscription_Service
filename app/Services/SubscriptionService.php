<?php 
namespace App\Services;

use App\Repositories\SubscriptionRepository;

class SubscriptionService
{
    protected $subscriptionRepo;

    public function __construct(SubscriptionRepository $subscriptionRepo)
    {
        $this->subscriptionRepo = $subscriptionRepo;
    }

    public function create($userId, $subscriptionTypeId, $renewedAt, $expiredAt)
    {
        return $this->subscriptionRepo->create([
            'user_id' => $userId,
            'subscription_type_id' => $subscriptionTypeId,
            'renewed_at' => $renewedAt,
            'expired_at' => $expiredAt
        ]);
    }

    public function update($subscriptionId, $subscriptionTypeId, $renewedAt, $expiredAt)
    {
        $subscription = $this->subscriptionRepo->find($subscriptionId);
        if ($subscription) {
            return $this->subscriptionRepo->update($subscription, [
                'subscription_type_id' => $subscriptionTypeId,
                'renewed_at' => $renewedAt,
                'expired_at' => $expiredAt
            ]);
        }
        return null;
    }

    public function delete($subscriptionId)
    {
        $subscription = $this->subscriptionRepo->find($subscriptionId);
        if ($subscription) {
            return $this->subscriptionRepo->delete($subscription);
        }
        return null;
    }
}
