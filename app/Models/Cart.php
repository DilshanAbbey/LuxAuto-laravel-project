<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'part_id',
        'quantity',
        'price'
    ];

    protected $appends = ['total'];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function getTotalAttribute()
    {
        return $this->quantity * $this->price;
    }
}