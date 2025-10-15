@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Hospitality Management Hostel PMS')

@section('content')
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Reservations -->
    <div class="bg-white shadow rounded-lg p-6 text-center">
      <h3 class="text-sm font-medium text-gray-500">Reservations Today</h3>
      <p class="text-2xl font-bold text-orange-600 mt-2">{{$reservations}}</p>
    </div>

    <!-- Check-In Today -->
    <div class="bg-white shadow rounded-lg p-6 text-center">
      <h3 class="text-sm font-medium text-gray-500">Check-Ins Today</h3>
      <p class="text-2xl font-bold text-green-600 mt-2">{{$checkedins}}</p>
    </div>

    <!-- Check-Out Today -->
    <div class="bg-white shadow rounded-lg p-6 text-center">
      <h3 class="text-sm font-medium text-gray-500">Check-Outs Today</h3>
      <p class="text-2xl font-bold text-red-600 mt-2">{{$checkedOutToday}}</p>
    </div>

    <!-- Available Rooms -->
    <div class="bg-white shadow rounded-lg p-6 text-center">
      <h3 class="text-sm font-medium text-gray-500">Available Rooms</h3>
      <p class="text-2xl font-bold text-blue-600 mt-2">{{$availableRooms}}</p>
    </div>
  </div>

  <!-- Recent Reservations Table -->
  <div class="mt-8 bg-white rounded-lg shadow overflow-hidden">
    <div class="p-4 border-b">
      <h2 class="text-lg font-semibold">Recent Checked Ins</h2>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full border-collapse">
        <thead class="bg-orange-100 text-orange-700">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-medium">Guest</th>
            <th class="px-6 py-3 text-left text-sm font-medium">Room</th>
            <th class="px-6 py-3 text-left text-sm font-medium">Check-in</th>
            <th class="px-6 py-3 text-left text-sm font-medium">Check-out</th>
            <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @foreach($recentCheckins as $checkin)
          <tr class="divide-x transition duration-300 hover:bg-orange-50">
            <td class="px-6 py-4">{{$checkin->guest->name}}</td>
            <td class="px-6 py-4">{{$checkin->room->roomnumber}}</td>
            <td class="px-6 py-4">{{\Carbon\Carbon::parse($checkin->actual_check_in_time)->format('M d, Y : h:i A')}}</td>
            <td class="px-6 py-4">{{\Carbon\Carbon::parse($checkin->actual_check_out_time)->format('M d, Y : h:i A')}}</td>
            <td class="px-6 py-4">
              @if($checkin->payment_status === 'Paid')
              <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">{{$checkin->payment_status}}</span>
              @elseif($checkin->payment_status === 'Partially Paid')
              <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">{{$checkin->payment_status}}</span>
              @else
              <span class="px-2 py-1 text-xs bg-orange-100 text-orange-700 rounded">{{$checkin->payment_status}}</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>

      </table>
    </div>
  </div>

  <!-- Billing Overview -->
  <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white shadow rounded-lg p-6 text-center">
      <h3 class="text-sm font-medium text-gray-500">Today's Revenue</h3>
      <p class="text-2xl font-bold text-orange-600 mt-2">₱{{$todayRevenue}}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-6 text-center">
      <h3 class="text-sm font-medium text-gray-500">Outstanding Balance</h3>
     <p class="text-2xl font-bold text-red-600 mt-2">₱{{ number_format($outstandingBalance, 0, '.', ',') }}</p>
    </div>
    <div class="bg-white shadow rounded-lg p-6 text-center">
      <h3 class="text-sm font-medium text-gray-500">Recent Payments</h3>
      <p class="text-2xl font-bold text-green-600 mt-2">₱{{number_format($recentPayment, 0, '.', ',')}}</p>
    </div>
  </div>

  <!-- Mini Calendar -->
  <div class="mt-8 bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold mb-4">Upcoming Reservations (Calendar)</h2>
    <div id="calendar"></div>
  </div>
@endsection

@push('scripts')
  <!-- FullCalendar JS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 500,
        events: [
          {
            title: 'Mark Ompad - Room 0163',
            start: '2025-09-16',
            end: '2025-09-17',
            color: '#f97316'
          },
          {
            title: 'Jane Dela Cruz - Room 0210',
            start: '2025-09-18',
            end: '2025-09-20',
            color: '#22c55e'
          }
        ]
      });
      calendar.render();
    });
  </script>
@endpush