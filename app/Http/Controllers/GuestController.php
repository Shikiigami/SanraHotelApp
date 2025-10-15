<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Exception;


class GuestController extends Controller
{
public function index()
{
    return view('layouts.hotel-guest');
}

public function getGuestsData()
{
    return DataTables::of(
        $guests = Guest::select(['id', 'name', 'email', 'phone', 'id_type', 'id_number', 'address'])
        ->orderBy('created_at', 'desc')
    )
    ->editColumn('address', function ($row) {
        return strlen($row->address) > 8 
            ? substr($row->address, 0, 8) . '...' 
            : $row->address;
    })
    ->addColumn('actions', function($row) {
        return '
            <div class="flex space-x-3">
                <button 
                    onclick="editGuestDialog(this)"
                    data-id="'.$row->id.'"
                    data-name="'.e($row->name).'"
                    data-email="'.e($row->email).'"
                    data-phone="'.e($row->phone).'"
                    data-idtype="'.e($row->id_type).'"
                    data-idnumber="'.e($row->id_number).'"
                    data-address="'.e($row->address).'"
                    class="px-3 py-1 text-xs font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 transition">
                    Edit
                </button>
               <button 
                onclick="openDeleteGuestDialog(this)"
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

 public function storeGuest(Request $request)
    {
        try {
            $guest = new Guest();
            $guest->name = $request->name ;
            $guest->email = $request->email ?? '';
            $guest->phone = $request->phone ?? '';
            $guest->id_type = $request->id_type;
            $guest->id_number = $request->id_number;
            $guest->address = $request->address ?? '';

            $guest->save();
            return redirect()->back()->with('success', 'Guest added successfully.');    

            } catch (\Exception $e) {
          return redirect()->back()->with('error', 'Failed to add guest: ' . $e->getMessage());
      }
  }

 public function updateGuest(Request $request, $id)
{
    try {
        $guest = Guest::findOrFail($id);
        $guest->name = $request->name;
        $guest->email = $request->email ?? '';
        $guest->phone = $request->phone ?? '';
        $guest->id_type = $request->id_type;
        $guest->id_number = $request->id_number;
        $guest->address = $request->address ?? '';
        $guest->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Guest updated successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update guest: ' . $e->getMessage()
        ], 500);
    }
}

public function deleteGuest($id)
{
    try {
        $guest = Guest::findOrFail($id);
        $guest->delete();

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