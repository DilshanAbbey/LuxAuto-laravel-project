<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'idEmployee',
        'employeeName', 
        'nic', 
        'email', 
        'contactNumber', 
        'role', 
        'salary',
        'username',
        'password'
    ];

    protected $casts = [
        'salary' => 'decimal:2'
    ];

    public function chats()
    {
        return $this->hasMany(CustomerChat::class, 'employee_id');
    }
}
