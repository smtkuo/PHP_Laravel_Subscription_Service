<?php 
namespace App\Services;

use App\Repositories\SubscriptionRepository;
use Exception;

class SubscriptionService
{
    protected $subscriptionRepo;
    protected $transactionService;

    public function __construct(SubscriptionRepository $subscriptionRepo, TransactionService $transactionService)
    {
        $this->subscriptionRepo = $subscriptionRepo;
        $this->transactionService = $transactionService;
    }

    public function create($userId, $subscriptionTypeId, $renewedAt, $expiredAt)
    {

        // Check if the user already has a subscription of this type
        if ($this->subscriptionRepo->userHasSubscriptionType($userId, $subscriptionTypeId)) {
            throw new Exception('User already has a subscription of this type.');
        }

         // Prepare the data array
        $data = [
            'user_id' => $userId,
            'subscription_type_id' => $subscriptionTypeId,
            'renewed_at' => $renewedAt,
            'expired_at' => $expiredAt
        ];

        $subscription = $this->subscriptionRepo->create($data);

        // Load the subscriptionType relationship
        $subscription->load('subscriptionType');

        // Create a transaction
        $this->transactionService->create($userId, $subscription->id, $subscription->subscriptionType->price);


        // Load the Transaction relationship
        $subscription["activeSubscriptionTypeNames"] = $this->subscriptionRepo->activeSubscriptionTypeNames();
        

        // Create the new subscription
        return $subscription;
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
