<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerChatController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $chats = CustomerChat::with(['customer', 'employee'])->get();
        return response()->json($chats);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'description' => 'required|string',
            'status' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $chat = CustomerChat::create([
            'idCustomer_Chat' => $request->id,
            'customer_id' => $request->customer_id,
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer chat created successfully',
            'data' => $chat->load(['customer', 'employee'])
        ]);
    }

    public function update(Request $request, CustomerChat $customerChat)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'description' => 'required|string',
            'status' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $customerChat->update($request->only([
            'customer_id', 'employee_id', 'date', 
            'description', 'status'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Customer chat updated successfully',
            'data' => $customerChat->load(['customer', 'employee'])
        ]);
    }

    public function destroy(CustomerChat $customerChat)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $customerChat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer chat deleted successfully'
        ]);
    }
}