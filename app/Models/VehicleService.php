<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleService extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'vehicle_number', 'service_date', 
        'description', 'price', 'next_service_date', 'technician_in_charge'
    ];

    protected $casts = [
        'service_date' => 'date',
        'next_service_date' => 'date',
        'price' => 'decimal:2'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
