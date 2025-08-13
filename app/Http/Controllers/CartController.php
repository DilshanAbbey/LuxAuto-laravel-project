<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Part;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('part')
            ->where('user_id', auth()->id())
            ->get();
        
        return response()->json($cartItems);
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_id' => 'required|exists:parts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $part = Part::findOrFail($request->part_id);
        
        $cartItem = Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'part_id' => $request->part_id
            ],
            [
                'quantity' => $request->quantity,
                'price' => $part->price
            ]
        );

        return response()->json($cartItem->load('part'));
    }

    public function update(Request $request, Cart $cart)
    {
        $this->authorize('update', $cart);
        
        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json($cart->load('part'));
    }

    public function destroy(Cart $cart)
    {
        $this->authorize('delete', $cart);
        $cart->delete();
        
        return response()->json(['message' => 'Item removed from cart']);
    }
}