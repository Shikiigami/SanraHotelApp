<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Billing;
use App\Models\BillingDetails;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class BillingsController extends Controller
{
    public function index()
    {
        return view('layouts.billings');
    }

    public function getBillingData()
{
    $billings = Billing::with('details')
        ->orderBy('created_at', 'desc')
        ->select([
            'id',
            'checkin_id',
            'guest_name',
            'room_number',
            'total_amount',
            'invoice_date',
            'due_date',
            'status',
            'created_by'
        ]);

    return DataTables::of($billings)
        ->editColumn('invoice_date', fn($row) => \Carbon\Carbon::parse($row->invoice_date)->format('M d, Y h:i A'))
        ->editColumn('due_date', fn($row) => \Carbon\Carbon::parse($row->due_date)->format('M d, Y h:i A'))
        ->addColumn('actions', function ($row) {
            return '
                <div class="flex space-x-3">
                    <button 
                        onclick="printDialog(this)"
                        data-id="'.$row->id.'"
                        class="px-3 py-1 text-xs font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 transition">
                        Print
                    </button>
                </div>
            ';
        })
        ->rawColumns(['actions'])
        ->make(true);
}

public function getBillingDetails($id)
{
    $details = BillingDetails::where('billing_id', $id)->get();
    return response()->json($details);
}

public function showInvoice($id)
{
    $billing = Billing::findOrFail($id);
    $details = BillingDetails::where('billing_id', $id)->get();

    // Optional: calculate subtotal/tax/total if not stored
    $subtotal = $details->sum('total_amount');
    $tax = $details->sum('tax');
    $total = $subtotal + $tax;

    return view('layouts.invoice', compact('billing', 'details', 'subtotal', 'tax', 'total'));
}

}
