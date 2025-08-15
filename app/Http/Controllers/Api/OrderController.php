<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isCustomer()) {
            // Customers only see their own orders
            $orders = Order::where('user_id', $user->id)->with('orderItems.part')->get();
        } elseif ($user->isAdministrator() || $user->isEmployee()) {
            // Admin and employees see all orders
            $orders = Order::with(['user', 'orderItems.part'])->get();
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($orders);
    }

    public function show(Order $order)
    {
        $user = auth()->user();
        
        if ($user->isCustomer() && $order->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        } elseif (!$user->canAccessDashboard() && !$user->isCustomer()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($order->load(['orderItems.part', 'user']));
    }

    public function update(Request $request, Order $order)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'sometimes|in:pending,paid,failed,refunded'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $order->update($request->only(['status', 'payment_status']));

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'data' => $order
        ]);
    }

    public function items(Order $order)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $orderItems = $order->orderItems()->with('part')->get();
        return response()->json($orderItems);
    }
}