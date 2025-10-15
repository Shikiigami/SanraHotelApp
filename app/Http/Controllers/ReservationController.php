<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Guest;
use App\Models\Checkin;
use App\Models\Room;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class ReservationController extends Controller
{
    public function index()
{
    return view('layouts.reservation');
}

public function getReservationData()
{
    $reservations = Reservation::select([
            'id',
            'guest_id',
            'room_id',
            'check_in_date',
            'check_out_date',
            'total_amount',
            'deposit_amount',
            'status',
        ])
        ->with(['guest', 'room'])
        ->orderBy('created_at', 'desc');

    return DataTables::of($reservations)
        ->addColumn('guest_name', fn($row) => $row->guest ? e($row->guest->name) : 'N/A')
        ->addColumn('room_number', fn($row) => $row->room ? e($row->room->roomnumber) : 'N/A')
        ->addColumn('stay_duration', function ($row) {
            if ($row->check_in_date && $row->check_out_date) {
                $checkIn = \Carbon\Carbon::parse($row->check_in_date);
                $checkOut = \Carbon\Carbon::parse($row->check_out_date);

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
        ->editColumn('check_in_date', function ($row) {
            return \Carbon\Carbon::parse($row->check_in_date)->format('M d, Y : h:i A');
        })
        ->editColumn('check_out_date', function ($row) {
            return \Carbon\Carbon::parse($row->check_out_date)->format('M d, Y : h:i A');
        })
        ->addColumn('actions', function ($row) {
            $guestName = optional($row->guest)->name ?? 'N/A';
            $roomNumber = optional($row->room)->roomnumber ?? 'N/A';
            $balance = $row->total_amount - $row->deposit_amount;
            return '
                <div class="flex space-x-3">
                    <button 
                        onclick="editReservationDialog(this)"
                        data-id="'.$row->id.'"
                        data-guest="'.e($row->guest_id).'"
                        data-guestname="'.e($guestName).'"
                        data-room="'.e($row->room_id).'"
                        data-rnumber="'.e($roomNumber).'"
                        data-checkin="'.e($row->check_in_date).'"
                        data-checkout="'.e($row->check_out_date).'"
                        data-amount="'.e($row->total_amount).'"
                        data-depamount="'.e($row->deposit_amount).'"
                        data-balance="'.e($balance).'"
                        data-status="'.e($row->status).'"
                        class="px-3 py-1 text-xs font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 transition">
                        Edit
                    </button>'
                     .($row->status !== 'Checked In' ? '
                    <form method="POST" action="'.route('reserve.to.checkin', $row->id).'" 
                        onsubmit="return confirm(\'Are you sure you want to convert this reservation to check-in?\');" 
                        class="inline-block">
                        '.csrf_field().'
                        <button type="submit" class="px-3 py-1 text-xs font-medium text-white bg-orange-500 rounded-md hover:bg-orange-600 transition">
                            Checkin
                        </button>
                    </form>' : '')
                .'</div>';
        
        })
        ->rawColumns(['actions'])
        ->make(true);
}
public function getGuest($id)
{
    $reservation = Guest::find($id);
    return response()->json($reservation);
}

public function getRoom($id)
{
    $room = Room::select('id', 'roomnumber', 'price', 'status')->find($id);
    return response()->json($room);
}

public function storeReservation(Request $request)
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
            return redirect()->back()->with('error', 'Guest Not Found');
        }

        $checkIn = \Carbon\Carbon::parse($request->check_in_date);
        $checkOut = \Carbon\Carbon::parse($request->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $room->price * $nights;

        // Save reservation
        $reservation = new Reservation();
        $reservation->guest_id = $request->guest_id;
        $reservation->room_id = $request->room_id;
        $reservation->check_in_date = $request->check_in_date;
        $reservation->check_out_date = $request->check_out_date;
        $reservation->total_amount = $totalAmount;
        $reservation->deposit_amount = $request->deposit_amount ?? 0;
        $reservation->status = $request->status;
        $reservation->save();

        // Update room status
        $room->status = 'occupied';
        $room->save();

        return redirect()->back()->with('success', "Reservation {$reservation->id} added successfully.");
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to add Reservation: ' . $e->getMessage());
    }
}

public function updateReservation(Request $request, $id)
{
    try {
        $room = Room::find($request->room_id);

        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'Selected room not found.'
            ], 404);
        }


        $guest = Guest::find($request->guest_id);
        if (!$guest) {
            return response()->json([
                'status' => 'error',
                'message' => 'Guest not found.'
            ], 404);
        }


        $checkIn = \Carbon\Carbon::parse($request->check_in_date);
        $checkOut = \Carbon\Carbon::parse($request->check_out_date);
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $room->price * max($nights, 1); // ensure at least 1 night

        $reservation = Reservation::findOrFail($id);
        $reservation->guest_id = $request->guest_id;
        $reservation->room_id = $request->room_id;
        $reservation->check_in_date = $request->check_in_date;
        $reservation->check_out_date = $request->check_out_date;
        $reservation->total_amount = $totalAmount;
        $reservation->deposit_amount = $request->deposit_amount ?? 0;
        $reservation->status = $request->status ?? 'Pending';
        $reservation->save();

        if($request->status == 'Cancelled'){
        $room->status = 'available';
        $room->save();
        }elseif($request->status == 'Confirmed'){
          $room->status = 'occupied';
          $room->save();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Reservation updated successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update reservation: ' . $e->getMessage()
        ], 500);
    }
}

public function reserveTocheckin($id)
{
    $reservation = Reservation::where('status', 'Confirmed')
        ->where('id', $id)
        ->first();

    if (!$reservation) {
        return redirect()->back()->with('error', 'Reservation is not yet Confirmed.');
    }

    if ($reservation->deposit_amount > 0) {
        $paymentStatus = 'Partially Paid';
    } elseif ($reservation->deposit_amount == $reservation->total_amount) {
        $paymentStatus = 'Paid';
    } else {
        $paymentStatus = 'Pending';
    }

    Checkin::create([
        'reservation_id'       => $reservation->id,
        'guest_id'             => $reservation->guest_id,
        'room_id'              => $reservation->room_id,
        'actual_check_in_time' => $reservation->check_in_date,
        'actual_check_out_time'=> $reservation->check_out_date,
        'status'               => 'Checked In',
        'total_amount'         => $reservation->total_amount,
        'deposit'              => $reservation->deposit_amount,
        'balance'              => $reservation->total_amount - $reservation->deposit_amount,
        'payment_status'       => $paymentStatus,
        'payment_method'       => '',
        'payment_reference'    => '',
        'created_by'           => auth()->user()->name ?? 'System',
    ]);

    $reservation->status = "Checked In";
    $reservation->save();

    return redirect()->route('checkins.index')->with('success', 'Reservation converted to Checkin successfully.');
    }
}
