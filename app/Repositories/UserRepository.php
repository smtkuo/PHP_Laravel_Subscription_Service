<?php 

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function create($data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function update(User $user, $data)
    {
        return $user->update($data);
    }

    public function delete(User $user)
    {
        return $user->delete();
    }
}