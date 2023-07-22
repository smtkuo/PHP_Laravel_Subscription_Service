<?php 

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($email, $password)
    {
        $user = $this->userRepository->findByEmail($email);
        
        if ($user && Hash::check($password, $user->password)) {
            // Here we should return a JWT or API token, depending on the authentication method used.
            // For instance, if you are using Laravel Sanctum, you would do:
            return $user->createToken('API Token')->plainTextToken;
        }

        return null;
    }
}