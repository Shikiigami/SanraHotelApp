@extends('layouts.app')

@section('title', 'Rooms')

@section('page-title', 'Hospitality Management Hostel PMS')
<style>
  #alertContainer > div {
    opacity: 1;
    transform: translateX(0);
  }
  #alertContainer > div.opacity-0 {
    opacity: 0;
    transform: translateX(20px);
  }
</style>
@section('content')
<meta name="store-room-url" content="{{ route('rooms.store') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">
  <div class="flex items-center justify-between text-white bg-orange-400 rounded-lg shadow p-6">
    <div>
      <p class="text-2xl font-bold">ROOMS</p>
      <h2 class="text-lg">Available Rooms</h2>
    </div>
    <button onclick="roomDialog()" 
      class="flex items-center gap-2 bg-white text-orange-500 px-4 py-2 rounded-lg shadow hover:bg-orange-100">
      <i data-lucide="plus" class="w-5 h-5"></i>
      <span>Add Room</span>
    </button>
  </div>
</div>

<!-- Category Buttons -->
<div class="mt-8">
  <div class="flex flex-wrap gap-3 mb-6 items-center">
    <button onclick="filterRooms('all')" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-500">All</button>
    <button onclick="filterRooms('standard')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-orange-500 hover:text-white">Standard</button>
    <button onclick="filterRooms('deluxe')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-orange-500 hover:text-white">Deluxe</button>
    <button onclick="filterRooms('premier-deluxe')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-orange-500 hover:text-white">Premier Deluxe</button>
    <button onclick="filterRooms('family')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-orange-500 hover:text-white">Family</button>
    <button onclick="filterRooms('premier-family')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-orange-500 hover:text-white">Premier Family</button>
    <button onclick="filterRooms('executive')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-orange-500 hover:text-white">Executive</button>
    <button onclick="filterRooms('presidential-suite')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-orange-500 hover:text-white">Presidential Suite</button>

    <!-- Search -->
    <div class="flex ml-auto">
      <input type="text" id="roomSearch" placeholder="Search rooms..." 
             class="px-3 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
      <button onclick="searchRooms()" 
          class="px-4 py-2 bg-orange-600 text-white rounded-r-lg hover:bg-orange-500">Search</button>
    </div>
  </div>

  <!-- Rooms Grid -->
  <div class="grid grid-cols-3 gap-6 items-stretch">

    @foreach($rooms as $room)
      <div 
        class="room-card {{ str_replace(' ', '-', strtolower($room->type)) }} h-full flex flex-col bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300 relative" 
        x-data="{ showModal: false }">

        <!-- Room Image -->
        <img src="{{ asset($room->image_path) }}" alt="{{ $room->type }}" class="w-full h-48 object-cover">

        <div class="absolute top-3 right-3" x-data="{ open: false }">
          <button 
            @click="open = !open"
            class="p-2 rounded-full bg-black/50 text-white hover:bg-black/70 focus:outline-none backdrop-blur-sm transition">
            ⋮
          </button>

          <!-- Popover -->
          <div 
            x-show="open" 
            @click.away="open = false" 
            x-transition 
            class="absolute right-0 mt-2 w-32 bg-white border rounded-lg shadow-lg py-2 z-50">
            
            <!-- Edit button -->
            <button 
              type="button"
              onclick="openEditRoomDialog(
                  '{{ $room->id }}',
                  '{{ $room->roomnumber }}',
                  '{{ $room->roomname }}',
                  '{{ $room->type }}',
                  '{{ $room->capacity }}',
                  '{{ $room->price }}',
                  '{{ $room->status }}',
                  `{{ $room->description }}`,
                  `{{ $room->amenities }}`,
                  '{{ $room->image_path ? asset($room->image_path) : '' }}'
              )"
              class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
              Edit
            </button>
            <button  onclick="openDeleteRoomDialog(
                  '{{ $room->id }}',
                  '{{ $room->roomnumber }}',
                  '{{ $room->roomname }}',
              )" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
              Delete
            </button>
          </div>
        </div>

        <!-- Room Content -->
        <div class="p-6 flex flex-col flex-grow">
          <!-- Clickable Title -->
          <h3 
            class="text-xl font-bold text-orange-600 cursor-pointer hover:text-orange-600 transition"
            @click="showModal = true">
            {{ $room->id }} - {{ $room->roomname }} ({{ $room->roomnumber }})
           </h3>
          <p class="text-gray-600 mt-1">Capacity: {{ $room->capacity }} persons</p>
          <p class="text-gray-600 mt-1">Type: {{ $room->type }}</p>

          <p class="text-xl mt-5 font-bold text-orange-600">
            @if($room->status === 'available')
             <span class="px-2 py-1 bg-green-100 text-green-800 text-sm rounded-full">Available</span>
            @elseif($room->status === 'occupied')
             <span class="px-2 py-1 bg-red-100 text-red-800 text-sm rounded-full">Occupied</span>
            @elseif($room->status === 'maintenance')
             <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">Maintenance</span>
            @endif
          </p>

          <div class="flex justify-between items-center mt-3">
            <span class="text-lg font-bold text-orange-600">₱{{ $room->price }} / night</span>
            @if($room->status === 'available')
              <button onclick="document.getElementById('reservationDialog').showModal()" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-500 transition">Reserve</button>
            @endif
          </div>
        </div>

        <!-- Modal -->
        <template x-if="showModal">
          <div 
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
            x-transition
            @click.self="showModal = false">

            <div class="bg-white rounded-xl shadow-lg max-w-lg w-full p-6 relative">
              <!-- Close Button -->
              <button 
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600"
                @click="showModal = false">
                ✕
              </button>

              <h2 class="text-2xl font-bold text-orange-600 mb-2">
                {{ $room->roomnumber }} - {{ $room->roomname }}
              </h2>
              <p class="text-gray-700 italic mb-2">Type: {{ $room->type }}</p>
              
              <p class="text-gray-600 text-justify leading-relaxed mb-3">
                {{ $room->description }}
              </p>

              <p class="text-gray-700"><strong>Capacity:</strong> {{ $room->capacity }} persons</p>
              <p class="text-gray-700 mt-1"><strong>Amenities:</strong> {{ $room->amenities }}</p>

              <p class="text-orange-600 font-bold text-lg mt-3">
                ₱{{ $room->price }} / night
              </p>
              <div class="mt-4 text-right">
                <button 
                  @click="showModal = false"
                  class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-500">
                  Close
                </button>
              </div>
            </div>
          </div>
        </template>
      </div>
    @endforeach
  </div>
</div>
<script src="{{asset('assets/js/alpine.js')}}?v={{ time() }}" defer></script>
@endsection


@section('add-modal')
@include('components.modal-components')
@endsection

@push('scripts')
<script src="{{ asset('asset/js/tailwindplus.js')}}?v={{ time() }}" type="module"></script>
<script src="{{ asset('assets/js/room.js')}}?v={{ time() }}"></script>
<script src="{{ asset('assets/js/sweetAlert.js')}}?v={{ time() }}"></script>
@endpush

