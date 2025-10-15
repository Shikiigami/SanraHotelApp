@extends('layouts.app')

@section('title', 'Admin')

@section('page-title', 'Hospitality Management Hostel PMS')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">
  <div class="flex items-center justify-between text-white bg-orange-400 rounded-lg shadow p-6">
    <div>
      <p class="text-2xl font-bold">Admin</p>
      <h2 class="text-lg">Admin Management</h2>
    </div>
      <button onclick="addAdminDialog()" 
      class="flex items-center gap-2 bg-white text-orange-500 px-4 py-2 rounded-lg shadow hover:bg-orange-100">
      <i data-lucide="plus" class="w-5 h-5"></i>
      <span>Add Admin</span>
    </button>
  </div>
</div>

<!-- Guest List Section -->
<div class="mt-8">
  <!-- Filters + Search -->
  
 <div class="bg-white rounded-lg shadow overflow-hidden mt-6 p-2">
  <div class="flex justify-between items-center border-b pb-2 mb-4">
    <h2 class="text-lg font-semibold text-gray-800">Admin Table</h2>
  </div>
  <div class="overflow-x-auto">
    <table id="adminTable" class="border-collapse text-sm mx-auto w-auto min-w-[600px] border border-gray-300 divide-y divide-gray-200">
      <thead class="bg-orange-100 text-orange-700">
        <tr>
          <th class="px-6 py-3 text-left font-medium">ID</th>
          <th class="px-6 py-3 text-left font-medium">Name</th>
          <th class="px-6 py-3 text-left font-medium">Email</th>
          <th class="px-6 py-3 text-left font-medium">Date Created</th>
          <th class="px-6 py-3 text-left font-medium">Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

</div>
@endsection

@section('add-modal')
@include('components.modal-admin')
@endsection


@push('scripts')
<script src="{{ asset('assets/js/jquery-3.6.0.min.js')}}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js')}}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/admin.js')}}?v={{ time() }}"></script>

<script src="{{ asset('asset/js/tailwindplus.js')}}?v={{ time() }}" type="module"></script>
<script src="{{asset('assets/js/alpine.js')}}?v={{ time() }}" defer></script>
<script src="{{asset('assets/js/sweetAlert.js')}}?v={{ time() }}"></script>
@endpush