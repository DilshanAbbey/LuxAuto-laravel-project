<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'idPart',
        'partName', 
        'partNumber', 
        'brand', 
        'model', 
        'price', 
        'description', 
        'quantityInStock'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'part_id');
    }
}
