<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'customer', 'date', 'description', 'price', 'technician'
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2'
    ];
}
