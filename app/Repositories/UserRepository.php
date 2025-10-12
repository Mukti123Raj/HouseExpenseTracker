<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements BaseRepository
{
    public function create(array $attributes)
    {
        return User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
            'household_id' => $attributes['household_id'] ?? null,
            'role_id' => $attributes['role_id'] ?? null,
        ]);
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function update($id, array $attributes)
    {
        $user = $this->find($id);
        if ($user) {
            $user->update($attributes);
            return $user;
        }
        return null;
    }

    public function delete($id)
    {
        $user = $this->find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}