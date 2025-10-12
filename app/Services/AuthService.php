<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\UserRepository;
use App\Repositories\HouseholdRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $userRepository;
    protected $householdRepository;

    public function __construct(
        UserRepository $userRepository,
        HouseholdRepository $householdRepository
    ) {
        $this->userRepository = $userRepository;
        $this->householdRepository = $householdRepository;
    }

    public function register(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Check if household code is provided
            if (isset($data['household_code'])) {
                // Join existing household
                $household = $this->householdRepository->findByCode($data['household_code']);
                if (!$household) {
                    throw ValidationException::withMessages([
                        'household_code' => ['Invalid Household Code. Please check the code and try again.']
                    ]);
                }

                // Get House Member role
                $role = Role::where('name', 'House Member')->first();
                
                // Create user with existing household
                return $this->userRepository->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'household_id' => $household->id,
                    'role_id' => $role->id,
                ]);
            } else {
                // Create new household
                $household = $this->householdRepository->create([
                    'name' => $data['name'] . "'s Household"
                ]);

                // Get Admin role
                $role = Role::where('name', 'Admin')->first();

                // Create user as admin of new household
                return $this->userRepository->create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'household_id' => $household->id,
                    'role_id' => $role->id,
                ]);
            }
        });
    }

    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            return Auth::user();
        }
        
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }

    public function logout()
    {
        Auth::logout();
    }
}