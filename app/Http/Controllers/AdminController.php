<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function adminIndex(){
        return view('layouts.admin');
    }

    public function getAdminsData()
{

 $users = User::select(['id','name','email', 'created_at'])->orderBy('created_at', 'desc');
    
  return DataTables::of($users)
    ->editColumn('created_at', function ($row) {
            return \Carbon\Carbon::parse($row->created_at)->format('M d, Y : h:i A');
    })
    ->addColumn('actions', function($row) {
        return '
            <div class="flex space-x-3">
                <button 
                    onclick="editAdminDialog(this)"
                    data-id="'.$row->id.'"
                    data-name="'.e($row->name).'"
                    data-email="'.e($row->email).'"
                    class="px-3 py-1 text-xs font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 transition">
                    Edit
                </button>
               <button 
                onclick="openDeleteAdminDialog(this)"
                data-id="'.$row->id.'"
                data-name="'.e($row->name).'"
                class="px-3 py-1 text-xs font-medium text-white bg-orange-400 rounded-md hover:bg-orange-500 transition">
                Delete
                </button>
            </div>
        ';
    })
    ->rawColumns(['actions'])
    ->make(true);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => ['required', 'confirmed', Password::defaults()],
    ]);


    if ($request->password !== $request->password_confirmation) {
     return back()->with('error', 'Password did not match');
    }

    // If validation passes, create the user
    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    return back()->with('success', 'Admin added successfully!');
}

    public function updateAdmin(Request $request, $id)
{
    try{
        $admin = User::findOrFail($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Admin updated successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update guest: ' . $e->getMessage()
        ], 500);
    }
}



public function deleteAdmin($id)
{
    try {
        $admin = User::findOrFail($id);
        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Guest deleted successfully.'
        ]);
    } catch (\Exception $e) {
        \Log::error('Failed to delete guest: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete guest.'
        ]);
    }
}
}