<?php 
namespace App\Services;

use App\Repositories\SubscriptionTypeRepository;

class SubscriptionTypeService
{
    protected $subscriptionTypeRepo;

    public function __construct(SubscriptionTypeRepository $subscriptionTypeRepo)
    {
        $this->subscriptionTypeRepo = $subscriptionTypeRepo;
    }

    public function getAll()
    {
        return $this->subscriptionTypeRepo->all();
    }

    public function getById($id)
    {
        return $this->subscriptionTypeRepo->find($id);
    }

    public function create($data)
    {
        return $this->subscriptionTypeRepo->create($data);
    }

    public function update($id, $data)
    {
        return $this->subscriptionTypeRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->subscriptionTypeRepo->delete($id);
    }
}