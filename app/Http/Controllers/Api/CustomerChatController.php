<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CustomerChatController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Please login first'], 401);
        }
        
        if (!auth()->user()->isCustomer()) {
            return response()->json(['error' => 'Only customers can send messages'], 403);
        }
        
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $customerChat = CustomerChat::create([
                'customer_id' => auth()->user()->original_id,
                'employee_id' => null,
                'date' => now()->format('Y-m-d'),
                'description' => $request->input('message'),
                'status' => 'not resolved'
            ]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Message sent successfully',
                'data' => $customerChat
            ]);
        } catch (\Exception $e) {
            Log::error('Chat message error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to send message. Please try again.'
            ], 500);
        }
    }
}