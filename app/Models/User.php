<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'role',
        'user_type',
        'original_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Role checking methods
    public function isAdministrator()
    {
        return $this->role === 'administrator';
    }

    public function isEmployee()
    {
        return $this->role === 'employee';
    }

    public function isTechnician()
    {
        return $this->role === 'technician';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function canAccessDashboard()
    {
        return in_array($this->role, ['administrator', 'employee', 'technician']);
    }

    // Relationships
    public function customerProfile()
    {
        return $this->belongsTo(Customer::class, 'original_id')->where('user_type', 'customer');
    }

    public function employeeProfile()
    {
        return $this->belongsTo(Employee::class, 'original_id')->where('user_type', 'employee');
    }

    // Get the original model (Customer or Employee)
    public function getOriginalModel()
    {
        if ($this->user_type === 'customer') {
            return Customer::find($this->original_id);
        } else {
            return Employee::find($this->original_id);
        }
    }

    // Static method to sync from Customer
    public static function syncFromCustomer(Customer $customer)
    {
        return self::updateOrCreate(
            [
                'user_type' => 'customer',
                'original_id' => $customer->id
            ],
            [
                'name' => $customer->customerName,
                'username' => $customer->username,
                'email' => $customer->email,
                'phone' => $customer->contactNumber,
                'password' => $customer->password,
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );
    }

    // Static method to sync from Employee
    public static function syncFromEmployee(Employee $employee)
    {
        return self::updateOrCreate(
            [
                'user_type' => 'employee',
                'original_id' => $employee->id
            ],
            [
                'name' => $employee->employeeName,
                'username' => $employee->username,
                'email' => $employee->email,
                'phone' => $employee->contactNumber,
                'password' => $employee->password,
                'role' => $employee->role,
                'email_verified_at' => now(),
            ]
        );
    }
}
