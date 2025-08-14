<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'idCustomer_Chat',
        'customer_id',
        'employee_id',
        'date',
        'description',
        'status'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
