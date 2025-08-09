<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Customer;
use App\Models\Employee;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'username',
        'email',
        'phone',
        'password',
        'role',
        'user_type', // 'customer' or 'employee'
        'original_id', // ID from customer or employee table
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     
    */

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // This model doesn't use database table
    public $timestamps = false;
    protected $table = null;


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

    // Get the original model (Customer or Employee)
    public function getOriginalModel()
    {
        if ($this->user_type === 'customer') {
            return Customer::find($this->original_id);
        } else {
            return Employee::find($this->original_id);
        }
    }

    // Static method to find user by credentials
    public static function findByCredentials($username, $password)
    {
        // First try customer table
        $customer = Customer::where('username', $username)
                           ->orWhere('email', $username)
                           ->first();
        
        if ($customer && password_verify($password, $customer->password)) {
            return new self([
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
        $employee = Employee::where('username', $username)
                           ->orWhere('email', $username)
                           ->first();

        if ($employee && password_verify($password, $employee->password)) {
            return new self([
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

    // Static method to find user by ID
    public static function findById($id)
    {
        if (str_starts_with($id, 'customer_')) {
            $customerId = str_replace('customer_', '', $id);
            $customer = Customer::find($customerId);
            
            if ($customer) {
                return new self([
                    'id' => $id,
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
        } elseif (str_starts_with($id, 'employee_')) {
            $employeeId = str_replace('employee_', '', $id);
            $employee = Employee::find($employeeId);
            
            if ($employee) {
                return new self([
                    'id' => $id,
                    'name' => $employee->employeeName,
                    'username' => $employee->username,
                    'email' => $employee->email,
                    'phone' => $employee->contactNumber,
                    'password' => $employee->password,
                    'role' => $employee->role,
                    'user_type' => 'employee',
                    'original_id' => $employee->id,
                ]);
            }
        }

        return null;
    }
}
