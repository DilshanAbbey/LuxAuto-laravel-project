<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'idCustomer_Vehicle',
        'customer_id', 
        'vehicleNumber', 
        'vehicleBrand', 
        'model', 
        'trim_edition', 
        'modalYear', 
        'description'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function repairs()
    {
        return $this->hasMany(VehicleRepair::class, 'vehicle_id');
    }

    public function services()
    {
        return $this->hasMany(VehicleService::class, 'vehicle_id');
    }
}
