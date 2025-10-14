<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkin;
use App\Models\Reservation;
use App\Models\Guest;
use App\Models\Billing;
use App\Models\BillingDetails;
use App\Models\Room;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class CheckinController extends Controller
{
    public function index(){
        return view('layouts.checkin');
    }

    public function getCheckinData()
    {
        try {

        $checkins = Checkin::select('checkins.*')
            ->with(['guest', 'room', 'reservation'])
            ->orderBy('created_at', 'desc');

       

        return DataTables::of($checkins)
        ->addColumn('reservation_id', fn($row) => $row->reservation ? e($row->reservation->id) : 'N/A')
        ->addColumn('guest_name', fn($row) => $row->guest ? e($row->guest->name) : 'N/A')
        ->addColumn('room_number', fn($row) => $row->room ? e($row->room->roomnumber) : 'N/A')
        ->addColumn('stay_duration', function ($row) {
            if ($row->actual_check_in_time && $row->actual_check_out_time) {
                $checkIn = \Carbon\Carbon::parse($row->actual_check_in_time);
                $checkOut = \Carbon\Carbon::parse($row->actual_check_out_time);

                $nights = $checkIn->diffInDays($checkOut);
                $days = $nights > 0 ? $nights + 1 : 1;
                return "{$days} days / {$nights} nights";
            }
            return 'N/A';
        })

        ->filterColumn('guest_name', function ($query, $keyword) {
            $query->whereHas('guest', function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%");
            });
        })
        ->filterColumn('room_number', function ($query, $keyword) {
            $query->whereHas('room', function ($q) use ($keyword) {
                $q->where('roomnumber', 'like', "%{$keyword}%");
            });
        })
        ->filterColumn('reservation_id', function ($query, $keyword) {
            $query->whereHas('reservation', function ($q) use ($keyword) {
                $q->where('id', 'like', "%{$keyword}%");
            });
        })
        ->editColumn('actual_check_in_time', function ($row) {
            return \Carbon\Carbon::parse($row->actual_check_in_time)->format('M d, Y : h:i A');
        })
        ->editColumn('actual_check_out_time', function ($row) {
            return \Carbon\Carbon::parse($row->actual_check_out_time)->format('M d, Y : h:i A');
        })
        ->addColumn('actions', function ($row) {
            $exists = Billing::where('checkin_id', $row->id)->exists();
            $guestName = optional($row->guest)->name ?? 'N/A';
            $roomNumber = optional($row->room)->roomnumber ?? 'N/A';
            $balance = $row->total_amount - $row->deposit;
            return '
                <div class="flex space-x-3">
                    <button 
                        onclick="editCheckinDialog(this)"
                        data-id="'.$row->id.'"
                        data-guest="'.e($row->guest_id).'"
                        data-guestname="'.e($guestName).'"
                        data-room="'.e($row->room_id).'"
                        data-rnumber="'.e($roomNumber).'"
                        data-checkin="'.e($row->actual_check_in_time).'"
                        data-checkout="'.e($row->actual_check_out_time).'"
                        data-amount="'.e($row->total_amount).'"
                        data-depamount="'.e($row->deposit).'"
                        data-balance="'.e($balance).'"
                        data-status="'.e($row->status).'"
                        data-paystatus="'.e($row->payment_status).'"
                        data-paymet="'.e($row->payment_method).'"
                        data-payref="'.e($row->payment_reference).'"
                        class="w-20 h-6 flex items-center justify-center text-xs font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 transition">
                        Edit
                    </button>'
                     .(!$exists ? '
                  <form method="POST" action="'.route('add.to.billing', $row->id).'" 
                    onsubmit="return confirm(\'Are you sure you want to add this in billing?\');" 
                    class="inline-block">
                    '.csrf_field().'
                    <button type="submit" 
                        class="px-6 h-6 flex items-center justify-center text-xs font-medium text-white bg-green-500 rounded-md hover:bg-green-600 transition">
                        Add to billing
                    </button>
                </form>' : '')
         .'</div>';
        })
        ->rawColumns(['actions'])
        ->make(true);
 } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function storeCheckin(Request $request)
{
    try {
        $room = Room::find($request->room_id);

        if (!$room) {
            return redirect()->back()->with('error', 'Selected room not found.');
        }

        if ($room->status !== 'available') {
            return redirect()->back()->with('error', 'Selected room is not available.');
        }

        $guest = Guest::find($request->guest_id);
        if (!$guest) {
            return redirect()->back()->with('error', 'Guest not found.');
        }

        $checkInTime = \Carbon\Carbon::parse($request->actual_check_in_time);
        $checkOutTime = \Carbon\Carbon::parse($request->actual_check_out_time);
        $nights = $checkInTime->diffInDays($checkOutTime);
        $totalAmount = $room->price * $nights;

        if ($request->payment_status === 'Paid') {
            $totalBalance = 0;
        } else {
            // If balance is given in request, use it; otherwise compute it
            $deposit = $request->deposit ?? 0;
            $totalBalance = $totalAmount - $deposit;
        }

        $checkin = new Checkin();
        $checkin->guest_id = $request->guest_id;
        $checkin->room_id = $request->room_id;
        $checkin->actual_check_in_time = $request->actual_check_in_time;
        $checkin->actual_check_out_time = $request->actual_check_out_time;
        $checkin->total_amount = $totalAmount;
        $checkin->deposit = $request->deposit ?? 0;
        $checkin->balance = $totalBalance;
        $checkin->status = $request->status ?? 'Checked In';
        $checkin->payment_status = $request->payment_status ?? 'Pending';
        $checkin->payment_method = $request->payment_method ?? '';
        $checkin->payment_reference = $request->payment_reference ?? '';
        $checkin->save();

        $room->status = 'occupied';
        $room->save();

        return redirect()->back()->with('success', "Checkin #{$checkin->id} added successfully.");
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to add Checkin: ' . $e->getMessage());
    }
}

public function updateCheckin(Request $request, $id)
{
    try {
        $checkin = Checkin::find($id);
        if (!$checkin) {
            return redirect()->back()->with('error', 'Checkin record not found.');
        }

        $room = Room::find($request->room_id);
        if (!$room) {
            return redirect()->back()->with('error', 'Selected room not found.');
        }

        $guest = Guest::find($request->guest_id);
        if (!$guest) {
            return redirect()->back()->with('error', 'Guest not found.');
        }

        // Calculate totals
        $checkInTime = \Carbon\Carbon::parse($request->actual_check_in_time);
        $checkOutTime = \Carbon\Carbon::parse($request->actual_check_out_time);
        $nights = $checkInTime->diffInDays($checkOutTime);
        $totalAmount = $room->price * $nights;

        $deposit = $request->deposit ?? 0;
        $totalBalance = $request->payment_status === 'Paid' ? 0 : ($totalAmount - $deposit);

        // Update room availability if checked out
        if ($request->status == 'Checked Out') {
            $room->status = 'available';
            $room->save();
        }

        // Update checkin
        $checkin->update([
            'guest_id'          => $request->guest_id,
            'room_id'           => $request->room_id,
            'actual_check_in_time'  => $request->actual_check_in_time,
            'actual_check_out_time' => $request->actual_check_out_time,
            'total_amount'      => $totalAmount,
            'deposit'           => $deposit,
            'balance'           => $totalBalance,
            'status'            => $request->status ?? $checkin->status,
            'payment_status'    => $request->payment_status ?? $checkin->payment_status,
            'payment_method'    => $request->payment_method ?? '',
            'payment_reference' => $request->payment_reference ?? '',
        ]);

        // Prepare billing dates
        $invoiceDate = \Carbon\Carbon::parse($checkin->actual_check_in_time);
        $dueDate = $invoiceDate->copy()->addWeeks(2);

        // Update or create billing
        Billing::updateOrCreate(
            ['checkin_id' => $checkin->id],
              [
                'guest_name'   => $guest->name,
                'guest_address' => $guest->address,
                'room_number'  => $room->roomnumber,
                'total_amount' => $totalAmount,
                'invoice_date' => $invoiceDate,
                'due_date'     => $dueDate,
                'status'       => $request->payment_status ?? $checkin->payment_status,
                'created_by'   => auth()->user()->name ?? 'System'
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Checkin and billing updated successfully.'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update checkin: ' . $e->getMessage()
        ], 500);
    }
}


public function addToBill($id){

$checkin = Checkin::where('id', $id)->first();

if(!$checkin) {
        return redirect()->back()->with('error', 'Checkin is not found.');
}

    if ($checkin->actual_check_in_time && $checkin->actual_check_out_time) {
            $checkIn = \Carbon\Carbon::parse($checkin->actual_check_in_time);
            $checkOut = \Carbon\Carbon::parse($checkin->actual_check_out_time);

            $nights = $checkIn->diffInDays($checkOut);
            $days = $nights > 0 ? $nights + 1 : 1;
        }

    $invoiceDate = Carbon::parse($checkin->actual_check_in_time);
    $dueDate = $invoiceDate->copy()->addWeeks(2);
    $discount = 0;
    $tax = 0;
    $billing = Billing::create([
        'checkin_id'           => $checkin->id,
        'guest_name'           => $checkin->guest->name,
        'guest_address'        => $checkin->guest->address,
        'room_number'          => $checkin->room->roomnumber,
        'total_amount'         => $checkin->total_amount,
        'invoice_date'         => $invoiceDate,
        'due_date'             => $dueDate,
        'status'               => $checkin->payment_status,
        'created_by'           => auth()->user()->name ?? 'System',
    ]);

    BillingDetails::create([
        'billing_id'           => $billing->id,
        'description'          => $checkin->room->type . ', ' . $nights . ' nights',
        'unit_price'           => $checkin->room->price,
        'quantity'             => $nights,
        'discount'             => $discount,
        'tax'                  => $tax,
        'total_amount'         => $checkin->total_amount, 
    ]);
    return redirect()->back()->with('success', 'Reservation converted to Checkin successfully.');
}

}