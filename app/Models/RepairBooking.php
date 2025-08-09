<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'idRepair_booking',
        'customer_id',
        'vehicle_id',
        'slotNumber',
        'date',
        'time',
        'technician_in_charge'
    ];

    protected $casts = [
        'date' => 'date'
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
