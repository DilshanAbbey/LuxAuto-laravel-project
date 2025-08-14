<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $employees = Employee::all();
        return response()->json($employees);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'employeeName' => 'required|string|max:255',
            'nic' => 'required|string|unique:employees,nic',
            'email' => 'required|email|unique:employees,email',
            'contactNumber' => 'required|string|max:20',
            'role' => 'required|in:administrator,employee,technician',
            'salary' => 'required|numeric|min:0',
            'username' => 'required|string|unique:employees,username',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $employee = Employee::create([
            'idEmployee' => 'EMP' . str_pad(Employee::count() + 1, 4, '0', STR_PAD_LEFT),
            'employeeName' => $request->employeeName,
            'nic' => $request->nic,
            'email' => $request->email,
            'contactNumber' => $request->contactNumber,
            'role' => $request->role,
            'salary' => $request->salary,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Employee created successfully',
            'data' => $employee
        ]);
    }

    public function show(Employee $employee)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($employee);
    }

    public function update(Request $request, Employee $employee)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'employeeName' => 'required|string|max:255',
            'nic' => 'required|string|unique:employees,nic,' . $employee->id,
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'contactNumber' => 'required|string|max:20',
            'role' => 'required|in:administrator,employee,technician',
            'salary' => 'required|numeric|min:0',
            'username' => 'required|string|unique:employees,username,' . $employee->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $employee->update($request->only([
            'employeeName', 'nic', 'email', 'contactNumber', 
            'role', 'salary', 'username'
        ]));

        if ($request->password) {
            $employee->password = bcrypt($request->password);
            $employee->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully',
            'data' => $employee
        ]);
    }

    public function destroy(Employee $employee)
    {
        if (!auth()->user()->isAdministrator()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $employee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully'
        ]);
    }
}