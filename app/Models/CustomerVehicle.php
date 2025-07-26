<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'vehicle_number', 'vehicle_brand', 
        'model', 'trim_edition', 'modal_year', 'description'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
