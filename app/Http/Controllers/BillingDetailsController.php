<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillingDetails;
use App\Models\Billing;


class BillingDetailsController extends Controller
{
     public function store(Request $request)
    {
        $request->validate([
            'billing_id'   => 'required|exists:billing,id',
            'description'  => 'required|string|max:255',
            'quantity'     => 'required|numeric|min:1',
            'unit_price'   => 'required|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0|max:100',
            'tax'          => 'nullable|numeric|min:0|max:100',
            'invoice_date' => 'nullable|date',
            'due_date'     => 'nullable|date',
        ]);

        $quantity = $request->quantity;
        $unit_price = $request->unit_price;
        $discount_percent = $request->discount ?? 0;
        $tax_percent = $request->tax ?? 0;

        // Compute subtotal, discount, tax, and total
        $subtotal = $quantity * $unit_price;
        $discount_amount = ($discount_percent / 100) * $subtotal;
        $tax_amount = ($tax_percent / 100) * $subtotal;
        $total_amount = $subtotal - $discount_amount + $tax_amount;

        $detail = BillingDetails::create([
            'billing_id'   => $request->billing_id,
            'description'  => $request->description,
            'unit_price'   => $unit_price,
            'quantity'     => $quantity,
            'discount'     => $discount_percent,
            'tax'          => $tax_percent,
            'total_amount' => $total_amount,
        ]);

        // Update parent billing total
        $total = BillingDetails::where('billing_id', $request->billing_id)->sum('total_amount');
        Billing::where('id', $request->billing_id)->update(['total_amount' => $total]);

        return response()->json([
            'success' => true,
            'message' => 'Billing detail added successfully.',
            'data' => $detail
        ]);
    }

    // Delete detail
    public function destroy($id)
    {
        $detail = BillingDetails::findOrFail($id);
        $billingId = $detail->billing_id;
        $detail->delete();

        // Update parent billing total after delete
        $total = BillingDetails::where('billing_id', $billingId)->sum('total_amount');
        Billing::where('id', $billingId)->update(['total_amount' => $total]);

        return response()->json([
            'success' => true,
            'message' => 'Billing detail deleted successfully.'
        ]);
    }
}
