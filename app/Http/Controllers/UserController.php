<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userService->register(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        return response()->json($user, 201);  // 201 Created
    }

    public function get($id)
    {
        $user = $this->userService->get($id);
        if ($user) {
            return response()->json($user, 200);  // 200 OK
        } else {
            return response()->json(['error' => 'User not found'], 404);  // 404 Not Found
        }
    }
}
