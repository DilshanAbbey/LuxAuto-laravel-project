<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CustomerDelivery;
use App\Models\Customer;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
        ]);

        Stripe::setApiKey(config('payment.stripe.secret_key'));

        $cartItems = Cart::with('part')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
        $shipping = $subtotal > 100 ? 0 : 5.99; // Free shipping over $100
        $total = $subtotal + $shipping;

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => round($total * 100), // Amount in cents
                'currency' => 'usd',
                'metadata' => [
                    'user_id' => auth()->id(),
                    'subtotal' => $subtotal,
                    'shipping' => $shipping
                ]
            ]);

            return response()->json([
                'client_secret' => $paymentIntent->client_secret,
                'amount' => $total,
                'subtotal' => $subtotal,
                'shipping' => $shipping
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
        ]);

        return DB::transaction(function () use ($request) {
            $user = auth()->user();
            $cartItems = Cart::with('part')
                ->where('user_id', $user->id)
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }

            // Get customer ID
            $customer = Customer::where('id', $user->original_id)->first();
            if (!$customer) {
                return response()->json(['error' => 'Customer not found'], 404);
            }

            // Create or update customer delivery address
            $customerDelivery = CustomerDelivery::updateOrCreate(
                [
                    'customer_id' => $customer->id,
                    'address' => $request->address,
                    'city' => $request->city,
                    'zip_code' => $request->zip_code
                ],
                [
                    'customer_id' => $customer->id,
                    'address' => $request->address,
                    'city' => $request->city,
                    'zip_code' => $request->zip_code
                ]
            );

            // Calculate totals
            $subtotal = $cartItems->sum(function($item) {
                return $item->quantity * $item->price;
            });
            $shipping = $subtotal > 100 ? 0 : 5.99;
            $total = $subtotal + $shipping;

            // Prepare shipping address for order
            $shippingAddress = [
                'address' => $request->address,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
                'customer_name' => $customer->customerName,
                'customer_email' => $customer->email,
                'delivery_id' => $customerDelivery->id
            ];

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . time() . '-' . $user->id,
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'total_amount' => $total,
                'status' => 'processing',
                'shipping_address' => $shippingAddress,
                'payment_status' => 'paid',
                'payment_gateway_id' => $request->payment_intent_id
            ]);

            // Create order items and update inventory
            foreach ($cartItems as $cartItem) {
                // Check stock availability
                if ($cartItem->part->quantityInStock < $cartItem->quantity) {
                    throw new \Exception("Insufficient stock for {$cartItem->part->partName}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'part_id' => $cartItem->part_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->price,
                    'total_price' => $cartItem->quantity * $cartItem->price
                ]);

                // Update part inventory
                $cartItem->part->decrement('quantityInStock', $cartItem->quantity);
            }

            // Clear cart
            Cart::where('user_id', $user->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order' => $order->load('orderItems.part'),
                'delivery_address' => $customerDelivery
            ]);
        });
    }
}