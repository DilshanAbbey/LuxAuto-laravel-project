<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $parts = Part::all();
        return response()->json($parts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'partName' => 'required|string|max:255',
            'partNumber' => 'required|string|unique:parts,partNumber',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'quantityInStock' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $part = Part::create([
            'idPart' => 'PART' . str_pad(Part::count() + 1, 4, '0', STR_PAD_LEFT),
            'partName' => $request->partName,
            'partNumber' => $request->partNumber,
            'brand' => $request->brand,
            'model' => $request->model,
            'price' => $request->price,
            'description' => $request->description,
            'quantityInStock' => $request->quantityInStock
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Part created successfully',
            'data' => $part
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($part);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'partName' => 'required|string|max:255',
            'partNumber' => 'required|string|unique:parts,partNumber,' . $part->id,
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'quantityInStock' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $part->update($request->only([
            'partName', 'partNumber', 'brand', 'model', 
            'price', 'description', 'quantityInStock'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Part updated successfully',
            'data' => $part
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = auth()->user();
        
        if (!$user->isAdministrator() && !$user->isEmployee()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $part->delete();

        return response()->json([
            'success' => true,
            'message' => 'Part deleted successfully'
        ]);
    }
}
