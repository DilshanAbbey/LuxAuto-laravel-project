<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleService extends Model
{
    use HasFactory;

    protected $fillable = [
        'idVehicle_Service',
        'customer_id', 
        'vehicle_id', 
        'serviceDate', 
        'description', 
        'price', 
        'technician'
    ];

    protected $casts = [
        'service_date' => 'date',
        'next_service_date' => 'date',
        'price' => 'decimal:2'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(CustomerVehicle::class, 'vehicle_id');
    }

    public function employee()
    {
        return $this->belongsTo(employee::class, 'employee_id');
    }
}
