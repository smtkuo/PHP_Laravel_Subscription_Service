<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use App\Services\AuthService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $userService;
    protected $authService;

    public function __construct(UserService $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;

        // Apply the 'web' middleware to the controller methods
        $this->middleware('web');
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->userService->register(
                $request->input('name'),
                $request->input('email'),
                $request->input('password')
            );
    
            return response()->json([
                'success' => 1,
                'message' => 'Your registration has been created',
                'data' => $user,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 1], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            // Create a token for the user
            $request->session()->regenerate();

            return response()->json([
                'success' => 1,
                'message' => 'Login successful',
                'data' => Auth::user(),
            ], Response::HTTP_OK);
        } else {
            // Authentication failed, return error
            return response()->json([
                'success' => 0,
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function showLoginForm()
    {
        $user = Auth::user(); // Access the authenticated user
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }
}