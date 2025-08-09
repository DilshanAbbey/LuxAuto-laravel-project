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
        $parts = Part::where('quantityInStock', '>', 0)->get();
        return response()->json($parts);
    }
}