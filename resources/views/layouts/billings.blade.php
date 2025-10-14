@extends('layouts.app')

@section('title', 'Checkin')
@section('page-title', 'Hostel Front Desk - Checkin')

<style>
  .dataTables_wrapper .dataTables_filter {
    float: left !important;
    margin-left: 1rem;
}

.dataTables_wrapper .dataTables_length {
    float: left !important;
    margin-right: 1rem;
}

.dataTables_wrapper .dataTables_filter input {
    display: inline-block;
    width: 200px;
    margin-left: 0.5rem;
}
</style>
@section('content')
<div class="grid grid-cols-1 gap-6">
  <!-- Header -->
  <div class="flex items-center justify-between text-white bg-orange-400 rounded-lg shadow p-6">
    <div>
      <p class="text-2xl font-bold">Billings</p>
      <h2 class="text-lg">Manage Guest Billings</h2>
    </div>
    <!-- Add Reservation Button -->
    <button onclick="document.getElementById('checkinDialog').showModal()" 
            class="flex items-center gap-2 bg-white text-orange-500 px-4 py-2 rounded-lg shadow hover:bg-orange-100">
      <i data-lucide="plus" class="w-5 h-5"></i>
      <span>New Checkin</span>
    </button>
  </div>
</div>

<!-- Recent Reservations -->
<div class="bg-white rounded-lg shadow mt-6 p-4">
<div class="flex items-center gap-4 border-b border-gray-200 pb-2 mb-4">
  <h2 class="text-lg font-semibold text-gray-800">Recent Billings</h2>

  <button onclick="document.getElementById('checkinDialog').showModal()" 
          class="flex items-center gap-2 bg-orange-500 text-white px-4 py-2 rounded-lg shadow hover:bg-orange-600 transition">
    <i data-lucide="plus" class="w-5 h-5"></i>
    <span>New Checkin</span>
  </button>
</div>


<div class="w-full overflow-x-auto">
  <div class="w-full">
  <table id="checkinTable" class="text-sm w-full border border-gray-300 divide-y divide-gray-200">
      <thead class="bg-orange-100 text-orange-700">
        <tr>
          <th>+</th>
           <th class="px-4 py-2 text-left font-medium">Bid</th>
          <th class="px-4 py-2 text-left font-medium">CheckinId</th>
          <th class="px-4 py-2 text-left font-medium">Guest</th>
          <th class="px-4 py-2 text-left font-medium">Room</th>
          <th class="px-4 py-2 text-left font-medium">Total Amount</th>
          <th class="px-4 py-2 text-left font-medium">Invoice Date</th>
          <th class="px-4 py-2 text-left font-medium">Due Date</th>
          <th class="px-4 py-2 text-left font-medium">Status</th>
          <th class="px-4 py-2 text-left font-medium">Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

</div>
@endsection

@section('add-modal')
  @include('components.modal-checkin')
@endsection


@push('scripts')
<script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js')}}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/billing.js')}}?v={{ time() }}"></script>

<script src="{{ asset('assets/js/tailwindplus.js')}}?v={{ time() }}" type="module"></script>
<script src="{{ asset('assets/js/tailwindcss.js')}}?v={{ time() }}" type="module"></script>
<script src="{{ asset('assets/js/alpine.js')}}?v={{ time() }}" defer></script>
<script src="{{ asset('assets/js/sweetAlert.js')}}?v={{ time() }}"></script>
@endpush
