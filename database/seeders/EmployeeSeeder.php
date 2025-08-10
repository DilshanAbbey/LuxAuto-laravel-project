<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // Administrator
        Employee::create([
            'idEmployee' => 'EMP0001',
            'employeeName' => 'Administrator',
            'nic' => '123456789V',
            'email' => 'admin@luxauto.com',
            'contactNumber' => '1234567890',
            'role' => 'administrator',
            'salary' => 80000.00,
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Employee
        Employee::create([
            'idEmployee' => 'EMP0002',
            'employeeName' => 'John Employee',
            'nic' => '987654321V',
            'email' => 'employee@luxauto.com',
            'contactNumber' => '1234567891',
            'role' => 'employee',
            'salary' => 50000.00,
            'username' => 'employee1',
            'password' => Hash::make('password'),
        ]);

        // Technician
        Employee::create([
            'idEmployee' => 'EMP0003',
            'employeeName' => 'Mike Technician',
            'nic' => '456789123V',
            'email' => 'technician@luxauto.com',
            'contactNumber' => '1234567892',
            'role' => 'technician',
            'salary' => 45000.00,
            'username' => 'tech1',
            'password' => Hash::make('password'),
        ]);
    }
}