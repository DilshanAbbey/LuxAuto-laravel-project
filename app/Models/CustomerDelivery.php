<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'address', 'city', 'zip_code'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
