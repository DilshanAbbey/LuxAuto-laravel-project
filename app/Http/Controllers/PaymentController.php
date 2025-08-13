<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|array',
            'shipping_address.name' => 'required|string',
            'shipping_address.email' => 'required|email',
            'shipping_address.address' => 'required|string',
        ]);

        Stripe::setApiKey(config('payment.stripe.secret_key'));

        $cartItems = Cart::with('part')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $subtotal = $cartItems->sum('total');
        $shipping = 5.99;
        $total = $subtotal + $shipping;

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $total * 100, // Amount in cents
                'currency' => 'usd',
                'metadata' => [
                    'user_id' => auth()->id(),
                    'subtotal' => $subtotal,
                    'shipping' => $shipping
                ]
            ]);

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'amount' => $total
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'shipping_address' => 'required|array'
        ]);

        $cartItems = Cart::with('part')
            ->where('user_id', auth()->id())
            ->get();

        $subtotal = $cartItems->sum('total');
        $shipping = 5.99;
        $total = $subtotal + $shipping;

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . time(),
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'total_amount' => $total,
            'status' => 'processing',
            'shipping_address' => $request->shipping_address,
            'payment_status' => 'paid',
            'payment_gateway_id' => $request->payment_intent_id
        ]);

        // Create order items
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'part_id' => $cartItem->part_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->price,
                'total_price' => $cartItem->total
            ]);

            // Update part inventory
            $cartItem->part->decrement('quantityInStock', $cartItem->quantity);
        }

        // Clear cart
        Cart::where('user_id', auth()->id())->delete();

        return response()->json([
            'success' => true,
            'order' => $order->load('orderItems.part')
        ]);
    }
}