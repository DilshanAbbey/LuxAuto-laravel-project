<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'employee_name', 'date', 
        'description', 'technician_in_charge', 'status'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
