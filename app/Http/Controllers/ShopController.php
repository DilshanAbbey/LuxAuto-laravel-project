<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index()
    {
        // Ensure user is authenticated and is a customer
        if (!Auth::check() || !Auth::user()->isCustomer()) {
            return redirect('/loginregister')->with('error', 'Please login as a customer to access the shop');
        }
        
        $parts = Part::where('quantityInStock', '>', 0)->get();
        return view('shop', compact('parts'));
    }

    public function getProducts()
    {
        // Ensure user is authenticated and is a customer
        if (!Auth::check() || !Auth::user()->isCustomer()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
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