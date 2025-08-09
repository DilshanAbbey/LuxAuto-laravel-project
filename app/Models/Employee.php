<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'nic', 'email', 'contact', 'role', 'salary'
    ];

    protected $casts = [
        'salary' => 'decimal:2'
    ];

    public function chats()
    {
        return $this->hasMany(CustomerChat::class, 'employee_id');
    }
}
