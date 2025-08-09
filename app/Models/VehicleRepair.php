<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleRepair extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'vehicle_number', 'repair_date', 
        'description', 'price', 'technician_in_charge'
    ];

    protected $casts = [
        'repair_date' => 'date',
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
