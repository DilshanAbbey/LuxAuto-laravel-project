<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'username', 'password'
    ];

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
