<?php 

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register($name, $email, $password)
    {
        return $this->userRepo->create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
    }

    public function get($id)
    {
        $user =  $this->userRepo->find($id);

        // Load the subscriptionType relationship
        $user->load('subscriptions');

        // Load the subscriptionType relationship
        $user->load('transactions');

        return $user;
    }
}
