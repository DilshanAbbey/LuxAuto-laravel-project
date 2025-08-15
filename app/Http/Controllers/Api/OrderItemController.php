<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdministrator() && !auth()->user()->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $orderItems = OrderItem::with(['order.user', 'part'])->get();
        return response()->json($orderItems);
    }

    public function show(OrderItem $orderItem)
    {
        if (!auth()->user()->isAdministrator() && !auth()->user()->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($orderItem->load(['order.user', 'part']));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'part_id' => 'required|exists:parts,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $totalPrice = $request->quantity * $request->unit_price;

        $orderItem = OrderItem::create([
            'order_id' => $request->order_id,
            'part_id' => $request->part_id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $totalPrice
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order item created successfully',
            'data' => $orderItem->load(['order', 'part'])
        ]);
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        if (!auth()->user()->isAdministrator() && !auth()->user()->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $totalPrice = $request->quantity * $request->unit_price;

        $orderItem->update([
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $totalPrice
        ]);

        // Update the order's total amount
        $order = $orderItem->order;
        $newSubtotal = $order->orderItems->sum('total_price');
        $order->update([
            'subtotal' => $newSubtotal,
            'total_amount' => $newSubtotal + $order->shipping_cost
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order item updated successfully',
            'data' => $orderItem->load(['order.user', 'part'])
        ]);
    }

    public function destroy(OrderItem $orderItem)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $orderItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order item deleted successfully'
        ]);
    }

    // Get order items by order ID
    public function getByOrder($orderId)
    {
        if (!auth()->user()->isAdministrator() && !auth()->user()->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order = Order::findOrFail($orderId);
        $orderItems = OrderItem::where('order_id', $orderId)->with('part')->get();
        
        return response()->json($orderItems);
    }
}