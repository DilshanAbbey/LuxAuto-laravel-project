<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;
use App\Models\Customer;
use App\Models\Employee;

class CustomUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        return User::findById($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return null; // Not implementing remember tokens for simplicity
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Not implementing remember tokens for simplicity
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials['email']) && empty($credentials['username'])) {
            return null;
        }

        // Use email field for lookup (which can contain username or email)
        $identifier = $credentials['email'] ?? $credentials['username'];
        
        // First try customer table
        $customer = Customer::where('username', $identifier)
                           ->orWhere('email', $identifier)
                           ->first();
        
        if ($customer) {
            return new User([
                'id' => 'customer_' . $customer->id,
                'name' => $customer->customerName,
                'username' => $customer->username,
                'email' => $customer->email,
                'phone' => $customer->contactNumber,
                'password' => $customer->password,
                'role' => 'customer',
                'user_type' => 'customer',
                'original_id' => $customer->id,
            ]);
        }

        // Then try employee table
        $employee = Employee::where('username', $identifier)
                           ->orWhere('email', $identifier)
                           ->first();

        if ($employee) {
            return new User([
                'id' => 'employee_' . $employee->id,
                'name' => $employee->employeeName,
                'username' => $employee->username,
                'email' => $employee->email,
                'phone' => $employee->contactNumber,
                'password' => $employee->password,
                'role' => $employee->role, // administrator, employee, or technician
                'user_type' => 'employee',
                'original_id' => $employee->id,
            ]);
        }

        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return password_verify($credentials['password'], $user->password);
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        // For this custom implementation, we'll skip rehashing since users are virtual
        // If you want to implement this, you'd need to update the original Customer/Employee records
        return;
    }
}
