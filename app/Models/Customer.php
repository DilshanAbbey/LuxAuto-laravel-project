<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'idCustomer',
        'customerName', 
        'email', 
        'contactNumber', 
        'username', 
        'password'
    ];

    // Automatically sync to users table when customer is created/updated
    protected static function booted()
    {
        static::created(function ($customer) {
            User::syncFromCustomer($customer);
        });

        static::updated(function ($customer) {
            User::syncFromCustomer($customer);
        });

        static::deleted(function ($customer) {
            User::where('user_type', 'customer')
                ->where('original_id', $customer->id)
                ->delete();
        });
    }

    public function user()
    {
        return $this->hasOne(User::class, 'original_id')->where('user_type', 'customer');
    }

    public function deliveries()
    {
        return $this->hasMany(CustomerDelivery::class);
    }

    public function vehicles()
    {
        return $this->hasMany(CustomerVehicle::class);
    }

    public function repairs()
    {
        return $this->hasMany(VehicleRepair::class);
    }

    public function services()
    {
        return $this->hasMany(VehicleService::class);
    }

    public function chats()
    {
        return $this->hasMany(CustomerChat::class);
    }
}
