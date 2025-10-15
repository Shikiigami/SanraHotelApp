<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Billing;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Checkin;
use App\Models\Room;


class DashboardController extends Controller
{
    public function index(){

        $availableRooms = Room::where('status', 'available')->count();
        $checkedOutToday = Checkin::where('status', 'Checked Out')
        ->whereDate('updated_at', today())
        ->count();

        $checkedins = Checkin::where('status', 'Checked In')->count();
        $reservations = Reservation::whereDate('created_at', today())->count();

       $recentCheckins = Checkin::with('guest', 'room')
        ->orderBy('created_at', 'desc')
        ->limit(3)
        ->get();

        $todayRevenue = Billing::where('status', 'Paid')->whereDate('created_at', today())->sum('total_amount');
        $outstandingBalance = Billing::where('status', '!=', 'Paid')->sum('total_amount');
        $recentPayment = Billing::where('status', 'Paid')->whereDate('created_at', today())->sum('total_amount');
        return view('layouts.dashboard', compact('availableRooms', 'checkedOutToday', 'checkedins','reservations','recentCheckins',
        'todayRevenue', 'outstandingBalance', 'recentPayment'));
    }




}
