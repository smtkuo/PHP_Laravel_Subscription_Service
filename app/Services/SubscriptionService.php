<?php 
namespace App\Services;

use App\Repositories\SubscriptionRepository;
use Illuminate\Support\Facades\Auth;
use Exception;
use Carbon\Carbon;

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

        // Create the new subscription
        return $subscription;
    }

    public function update($subscriptionId, $renewedAt, $expiredAt, $subscriptionTypeId=0)
    {
        $subscription = $this->subscriptionRepo->find($subscriptionId);
        $userId = $subscription->user_id;

        if ($subscription) {
            // Create a transaction
            $this->transactionService->create($userId, $subscription->id, $subscription->subscriptionType->price);

            if($subscriptionTypeId){
                return $this->subscriptionRepo->update($subscription, [
                    'subscription_type_id' => $subscriptionTypeId,
                    'renewed_at' => $renewedAt,
                    'expired_at' => $expiredAt
                ]);
            }

            return $this->subscriptionRepo->update($subscription, [
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
    
    public function activeSubscriptionTypeNames($userId)
    {
        return $this->subscriptionRepo->activeSubscriptionTypeNames($userId)->toArray();
    }

    /**
     * Get all subscriptions that need to be renewed.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSubscriptionsDueForRenewal()
    {
        // Get the current date
        $today = Carbon::now();

        // Use the subscription repository to get the subscriptions that need to be renewed
        $subscriptions = $this->subscriptionRepo->getSubscriptionsToRenew($today);

        return $subscriptions;
    }

}
