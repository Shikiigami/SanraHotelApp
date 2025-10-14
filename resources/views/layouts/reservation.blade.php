@extends('layouts.app')

@section('title', 'Reservation')
@section('page-title', 'Hostel Front Desk - Reservation')

@section('content')
<div class="grid grid-cols-1 gap-6">
  <!-- Header -->
  <div class="flex items-center justify-between text-white bg-orange-400 rounded-lg shadow p-6">
    <div>
      <p class="text-2xl font-bold">Reservations</p>
      <h2 class="text-lg">Manage Guest Bookings</h2>
    </div>
    <!-- Add Reservation Button -->
    <button onclick="document.getElementById('reservationDialog').showModal()" 
            class="flex items-center gap-2 bg-white text-orange-500 px-4 py-2 rounded-lg shadow hover:bg-orange-100">
      <i data-lucide="plus" class="w-5 h-5"></i>
      <span>New Reservation</span>
    </button>
  </div>
</div>

<!-- Recent Reservations -->
<div class="bg-white rounded-lg shadow overflow-hidden mt-6 p-2">
   <div class="flex justify-between items-center border-b pb-2 mb-4">
    <h2 class="text-lg font-semibold text-gray-800">Recent Reservations</h2>
  </div>
  <div class="overflow-x-auto">
   <table id="reservationTable" class="border-collapse text-sm mx-auto w-auto min-w-[600px] border border-gray-300 divide-y divide-gray-200">
      <thead class="bg-orange-100 text-orange-700">
        <tr>
          <th class="px-4 py-2 text-left font-medium">ID</th>
          <th class="px-4 py-2 text-left font-medium">Guest</th>
          <th class="px-4 py-2 text-left font-medium">Room</th>
          <th class="px-4 py-2 text-left font-medium">Check-in</th>
          <th class="px-4 py-2 text-left font-medium">Check-out</th>
          <th class="px-4 py-2 text-left font-medium">Nights</th>
          <th class="px-4 py-2 text-left font-medium">Total Amount</th>
          <th class="px-4 py-2 text-left font-medium">Dep. Amount</th>
          <th class="px-4 py-2 text-left font-medium">Status</th>
          <th class="px-4 py-2 text-left font-medium">Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@section('add-modal')
@include('components.modal-components')
@endsection

@push('scripts')
<script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js')}}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/reservation.js')}}?v={{ time() }}"></script>

<script src="{{ asset('asset/js/tailwindplus.js')}}?v={{ time() }}" type="module"></script>
<script src="{{asset('assets/js/alpine.js')}}?v={{ time() }}" defer></script>
<script src="{{asset('assets/js/sweetAlert.js')}}?v={{ time() }}"></script>
@endpush




