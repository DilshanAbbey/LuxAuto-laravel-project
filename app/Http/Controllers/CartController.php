<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with(['part' => function($query) {
                $query->select('idPart', 'partName', 'partNumber', 'brand', 'model', 'price', 'description', 'quantityInStock');
            }])
            ->where('user_id', Auth::id())
            ->get();
        
        return response()->json($cartItems);
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_id' => 'required|exists:parts,id',
            'quantity' => 'integer|min:1'
        ]);

        $part = Part::findOrFail($request->part_id);
        
        if ($part->quantityInStock < ($request->quantity ?? 1)) {
            return response()->json(['error' => 'Insufficient stock'], 400);
        }

        $cartItem = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'part_id' => $request->part_id
            ],
            [
                'quantity' => \DB::raw('quantity + ' . ($request->quantity ?? 1)),
                'price' => $part->price
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'data' => $cartItem->load('part')
        ]);
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($cart->part->quantityInStock < $request->quantity) {
            return response()->json(['error' => 'Insufficient stock'], 400);
        }

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'data' => $cart->load('part')
        ]);
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $cart->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart'
        ]);
    }
}