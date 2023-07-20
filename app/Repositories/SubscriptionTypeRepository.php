<?php 

namespace App\Repositories;

use App\Models\SubscriptionType;

class SubscriptionTypeRepository
{
    protected $model;

    public function __construct(SubscriptionType $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $subscriptionType = $this->model->find($id);
        
        if ($subscriptionType) {
            $subscriptionType->update($data);
            return $subscriptionType;
        }

        return null;
    }

    public function delete($id)
    {
        $subscriptionType = $this->model->find($id);
        
        if ($subscriptionType) {
            return $subscriptionType->delete();
        }

        return false;
    }
}