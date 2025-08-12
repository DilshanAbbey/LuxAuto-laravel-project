<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class SyncUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users
        User::truncate();

        // Sync customers to users table
        Customer::all()->each(function ($customer) {
            User::create([
                'name' => $customer->customerName,
                'username' => $customer->username,
                'email' => $customer->email,
                'phone' => $customer->contactNumber,
                'password' => $customer->password, // Already hashed
                'role' => 'customer',
                'user_type' => 'customer',
                'original_id' => $customer->id,
                'email_verified_at' => now(),
            ]);
        });

        // Sync employees to users table
        Employee::all()->each(function ($employee) {
            User::create([
                'name' => $employee->employeeName,
                'username' => $employee->username,
                'email' => $employee->email,
                'phone' => $employee->contactNumber,
                'password' => $employee->password, // Already hashed
                'role' => $employee->role, // administrator, employee, technician
                'user_type' => 'employee',
                'original_id' => $employee->id,
                'email_verified_at' => now(),
            ]);
        });

        $this->command->info('Users table synced with customers and employees!');
    }
}