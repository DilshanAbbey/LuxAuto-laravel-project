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

    // Automatically sync to users table when employee is created/updated
    protected static function booted()
    {
        static::created(function ($employee) {
            User::syncFromEmployee($employee);
        });

        static::updated(function ($employee) {
            User::syncFromEmployee($employee);
        });

        static::deleted(function ($employee) {
            User::where('user_type', 'employee')
                ->where('original_id', $employee->id)
                ->delete();
        });
    }

    public function user()
    {
        return $this->hasOne(User::class, 'original_id')->where('user_type', 'employee');
    }

    public function chats()
    {
        return $this->hasMany(CustomerChat::class, 'employee_id');
    }
}
