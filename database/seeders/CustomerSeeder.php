<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        Customer::create([
            'idCustomer' => 'CUST0001',
            'customerName' => 'Jane Customer',
            'email' => 'customer@luxauto.com',
            'contactNumber' => '1234567893',
            'username' => 'customer1',
            'password' => Hash::make('password'),
        ]);

        Customer::create([
            'idCustomer' => 'CUST0002',
            'customerName' => 'John Smith',
            'email' => 'john.smith@email.com',
            'contactNumber' => '1234567894',
            'username' => 'johnsmith',
            'password' => Hash::make('password'),
        ]);
    }
}