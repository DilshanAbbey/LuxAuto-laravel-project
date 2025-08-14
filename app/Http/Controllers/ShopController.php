<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class ShopController extends Controller
{
    public function index()
    {
        $parts = Part::where('quantityInStock', '>', 0)->get();
        return view('shop', compact('parts'));
    }

    public function getProducts()
    {
        $parts = Part::where('quantityInStock', '>', 0)
                    ->select('id', 'partName', 'partNumber', 'brand', 'model', 'price', 'description', 'quantityInStock')
                    ->get();
        
        // Transform the data to include proper id field
        $transformedParts = $parts->map(function($part) {
            return [
                'id' => $part->id,
                'partName' => $part->partName,
                'partNumber' => $part->partNumber,
                'brand' => $part->brand,
                'model' => $part->model,
                'price' => $part->price,
                'description' => $part->description,
                'quantityInStock' => $part->quantityInStock
            ];
        });
        
        return response()->json($transformedParts);
    }
}