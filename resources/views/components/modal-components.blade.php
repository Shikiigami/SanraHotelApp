<dialog id="roomDialog" aria-labelledby="room-title"
  class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">

  <el-dialog-backdrop
    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in">
  </el-dialog-backdrop>

  <div tabindex="0"
    class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">

    <el-dialog-panel
      class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all sm:my-8 sm:w-full sm:max-w-5xl data-closed:sm:translate-y-0 data-closed:sm:scale-95">

      <!-- Header -->
      <div class="bg-orange-600 px-6 pt-5 pb-4 border-b border-gray-700">
        <h3 id="room-title" class="text-xl font-semibold text-white">Add New Room</h3>
        <p class="text-sm text-white">Fill out the details to add a new room to the hotel.</p>
      </div>

      <!-- Form -->
      <form id="addRoomForm" method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data"
        class="bg-gray-800 px-6 pt-4 pb-6">
        @csrf

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mb-4">
          <!-- Room Number -->
          <div>
            <label for="room_number" class="block text-sm font-medium text-gray-300">Room Number</label>
            <input type="text" name="roomnumber" id="room_number" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Room Name -->
          <div>
            <label for="room_name" class="block text-sm font-medium text-gray-300">Room Name</label>
            <input type="text" name="roomname" id="room_name" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Room Type -->
          <div>
            <label for="type" class="block text-sm font-medium text-gray-300">Room Type</label>
            <select name="type" id="type" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="" disabled selected>-- Select Room Type --</option>
              <option value="standard">Standard</option>
              <option value="deluxe">Deluxe</option>
              <option value="premier-deluxe">Premiere Deluxe</option>
              <option value="family">Family</option>
              <option value="premier-family">Premiere Family</option>
              <option value="executive">Executive</option>
              <option value="presidential-suite">Presidential Suite</option>
            </select>
          </div>

          <!-- Capacity -->
          <div>
            <label for="capacity" class="block text-sm font-medium text-gray-300">Capacity</label>
            <input type="number" name="capacity" id="capacity" min="1" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Price Per Night -->
          <div>
            <label for="price" class="block text-sm font-medium text-gray-300">Price Per Night</label>
            <input type="number" step="0.01" name="price" id="price" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Status -->
          <div>
            <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
            <select name="status" id="status" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="available">Available</option>
              <option value="occupied">Occupied</option>
              <option value="maintenance">Maintenance</option>
            </select>
          </div>

          <!-- Description -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-300">Room Description</label>
            <textarea name="description" id="description" rows="2"
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
              placeholder="Enter room description here..."></textarea>
          </div>

          <!-- Amenities -->
          <div>
            <label for="amenities" class="block text-sm font-medium text-gray-300">Room Amenities</label>
            <textarea name="amenities" id="amenities" rows="2" 
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
              placeholder="Enter room amenities here..."></textarea>
          </div>
        </div>

        <!-- Image Upload -->
        <div class="w-full">
          <label for="imagePath" class="block text-sm font-medium text-gray-300">Image</label>

          <input type="file" name="image_path" id="imagePath" accept="image/*"
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">

          <!-- Preview container -->
          <div id="previewContainer" class="relative mt-3 hidden">
            <img id="imagePreview" src="" alt="Preview"
              class="w-full max-h-64 object-contain rounded-md border border-gray-600">

            <!-- X Button -->
            <button type="button" id="removeImageBtn"
              class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-700 focus:outline-none">
              ✕
            </button>
          </div>
        </div>
        <!-- Footer -->
        <div class="mt-6 flex justify-end gap-3 border-t border-gray-700 pt-4">
          <button type="button" command="close" commandfor="roomDialog"
            class="inline-flex justify-center rounded-md bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20">
            Cancel
          </button>
          <button type="submit"
            class="inline-flex justify-center rounded-md bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-500">
            Save Room
          </button>
        </div>
      </form>
    </el-dialog-panel>
  </div>
</dialog>

<!-- Edit Modal -->
<dialog id="editRoomDialog" aria-labelledby="room-title"
  class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">

  <el-dialog-backdrop
    class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in">
  </el-dialog-backdrop>

  <div tabindex="0"
    class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">

    <el-dialog-panel
      class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all sm:my-8 sm:w-full sm:max-w-5xl data-closed:sm:translate-y-0 data-closed:sm:scale-95">

      <!-- Header -->
      <div class="bg-orange-600 px-6 pt-5 pb-4 border-b border-gray-700">
        <h3 id="room-title" class="text-xl font-semibold text-white">Edit Room <span id="roomNumber"></span></h3>
        <p class="text-sm text-white">Fill out the details to add a new room to the hotel.</p>
      </div>

      <!-- Form -->
      @if(isset($room))
        <form id="editRoomForm" method="POST" action="{{ route('rooms.update', $room->id) }}" enctype="multipart/form-data" class="bg-gray-800 px-6 pt-4 pb-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id">

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mb-4">
              <!-- Room Number -->
              <div>
                <label for="editRoomNumber" class="block text-sm font-medium text-gray-300">Room Number</label>
                <input type="text" name="roomnumber" id="editRoomNumber" value="{{ $room->roomnumber ?? '' }}" required
                  class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              </div>

              <!-- Room Name -->
              <div>
                <label for="editRoomName" class="block text-sm font-medium text-gray-300">Room Name</label>
                <input type="text" name="roomname" id="editRoomName" value="{{ $room->roomname ?? '' }}" required
                  class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              </div>

              <!-- Room Type -->
              <div>
                <label for="editType" class="block text-sm font-medium text-gray-300">Room Type</label>
                <select name="type" id="editType" required
                  class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="" disabled selected>-- Select Room Type --</option>
                    <option value="standard">Standard</option>
                    <option value="deluxe">Deluxe</option>
                    <option value="premier-deluxe">Premiere Deluxe</option>
                    <option value="family">Family</option>
                    <option value="premier-family">Premiere Family</option>
                    <option value="executive">Executive</option>
                    <option value="presidential-suite">Presidential Suite</option>
                </select>
              </div>

              <!-- Capacity -->
              <div>
                <label for="editCapacity" class="block text-sm font-medium text-gray-300">Capacity</label>
                <input type="number" name="capacity" id="editCapacity" min="1" value="{{ $room->capacity ?? '' }}" required
                  class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              </div>

              <!-- Price Per Night -->
              <div>
                <label for="editPrice" class="block text-sm font-medium text-gray-300">Price Per Night</label>
                <input type="number" step="0.01" name="price" id="editPrice" value="{{ $room->price ?? '' }}" required
                  class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              </div>

              <!-- Status -->
              <div>
                <label for="editStatus" class="block text-sm font-medium text-gray-300">Status</label>
                <select name="status" id="editStatus" required
                  class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                  <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                  <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                  <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
              </div>

              <!-- Description -->
              <div>
                <label for="editDescription" class="block text-sm font-medium text-gray-300">Room Description</label>
                <textarea name="description" id="editDescription" rows="2" required
                  class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                  placeholder="Enter room description here...">{{ $room->description ?? '' }}</textarea>
              </div>

              <!-- Amenities -->
              <div>
                <label for="editAmenities" class="block text-sm font-medium text-gray-300">Room Amenities</label>
                <textarea name="amenities" id="editAmenities" rows="2" required
                  class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                  placeholder="Enter room amenities here...">{{ $room->amenities ?? '' }}</textarea>
              </div>
            </div>

            <!-- Image Upload -->
            <div class="w-full">
              <label for="editImagePath" class="block text-sm font-medium text-gray-300">Image</label>

            <input type="file" name="image_path" id="editImagePath" accept="image/*"
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">

              <div id="editPreviewContainer" class="relative mt-3">
                <img id="editImagePreview" src="{{ asset($room->image_path ?? '') }}" alt="Preview"
                  class="w-full max-h-64 object-contain rounded-md border border-gray-600 {{ empty($room->image_path) ? 'hidden' : '' }}">
                <button type="button" id="removeImageBtn"
                        class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-700 focus:outline-none">
                  ✕
                </button>
              </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 flex justify-end gap-3 border-t border-gray-700 pt-4">
              <button type="button" command="close" commandfor="editRoomDialog"
                class="inline-flex justify-center rounded-md bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20">
                Cancel
              </button>
              <button type="submit"
                class="inline-flex justify-center rounded-md bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-500">
                Save Room
              </button>
            </div>
        </form>
      @else
        <div class="bg-gray-800 px-6 py-10 text-center text-gray-400 rounded-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 h-10 w-10 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 17v-2h6v2m3 4H6a2 2 0 01-2-2V7a2 2 0 
                    012-2h3l2-2h2l2 2h3a2 2 0 012 2v12a2 2 0 
                    01-2 2z" />
          </svg>
          <p class="text-lg font-semibold">No data available</p>
          <p class="text-sm text-gray-500">There are currently no rooms to edit.</p>
        </div>
      @endif

    </el-dialog-panel>
  </div>
</dialog>


<!-- Delete Form -->
<form method="POST" id="deleteRoomForm">
  @csrf
  @method('DELETE')
  <!-- Modal Wrapper -->
  <div id="deleteRoomDialog" class="fixed inset-0 hidden items-center justify-center z-50">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <!-- Modal Content -->
    <div class="relative bg-white rounded-lg shadow-lg max-w-sm w-full p-6 z-10">
      <div class="flex items-center">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 text-red-600 mr-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h2 class="text-lg font-semibold text-gray-800">
          Delete Room <span id="deleteRoomName">?</span>
        </h2>
      </div>

      <p class="mt-3 text-sm text-gray-600">
        Are you sure you want to delete this item? This action cannot be undone.
      </p>

      <div class="mt-6 flex justify-end space-x-3">
        <button type="button" onclick="closeDangerModal()"
          class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-800">
          Cancel
        </button>
        <button type="submit" class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white">
          Delete
        </button>
      </div>
    </div>
  </div>
</form>


<!-- ADD GUEST DIALOG -->
<dialog id="addGuestDialog" aria-labelledby="guest-title" 
    class="fixed inset-0  w-full max-w-3xl mx-auto bg-transparent p-0 overflow-hidden">

  <!-- Backdrop -->
  <div class="fixed inset-0 bg-gray-900/50"></div>

  <div class="flex min-h-screen items-center justify-center p-4 text-center">

    <div class="relative transform rounded-lg bg-gray-800 text-left shadow-xl w-full max-w-3xl">

      <!-- Header -->
      <div class="bg-orange-600 rounded-t-md px-5 pt-3 pb-3 border-b border-gray-700">
        <h3 id="guest-title" class="text-2xl font-semibold text-white">Add Guest</h3>
        <p class="text-sm text-white mt-1">Fill out the details to add a new guest to the hotel.</p>
      </div>

      <!-- Form -->
      <form id="addGuestForm" method="POST" action="{{route('store.guest')}}" class="px-10 pt-6 pb-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
        @csrf
        <div>
          <label for="name" class="block text-sm font-medium text-gray-300">Guest Name</label>
          <input type="text" name="name" id="name" required
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
          <input type="email" name="email" id="email"
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label for="phone" class="block text-sm font-medium text-gray-300">Phone</label>
          <input type="text" name="phone" id="phone"
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label for="id_type" class="block text-sm font-medium text-gray-300">ID Type</label>
          <input type="text" name="id_type" id="id_type" required
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label for="id_number" class="block text-sm font-medium text-gray-300">ID Number</label>
          <input type="text" name="id_number" id="id_number" required
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label for="address" class="block text-sm font-medium text-gray-300">Address</label>
          <input type="text" name="address" id="address"
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Footer -->
        <div class="col-span-2 mt-2 flex justify-end gap-4 border-t border-gray-700 pt-4">
          <button type="button" onclick="document.getElementById('addGuestDialog').close()"
            class="inline-flex justify-center rounded-md bg-white/10 px-5 py-2 text-sm font-semibold text-white hover:bg-white/20">
            Cancel
          </button>
          <button type="submit"
            class="inline-flex justify-center rounded-md bg-orange-600 px-5 py-2 text-sm font-semibold text-white hover:bg-orange-500">
            Save Guest
          </button>
        </div>
      </form>
    </div>
  </div>
</dialog>

<!-- Edit Guest Dialog -->
<dialog id="editGuestDialog" aria-labelledby="guest-title" 
    class="fixed inset-0  w-full max-w-3xl mx-auto bg-transparent p-0 overflow-hidden">

  <!-- Backdrop -->
  <div class="fixed inset-0 bg-gray-900/50"></div>

  <div class="flex min-h-screen items-center justify-center p-4 text-center">

    <div class="relative transform rounded-lg bg-gray-800 text-left shadow-xl w-full max-w-3xl">

      <!-- Header -->
      <div class="bg-orange-600 rounded-t-md px-5 pt-3 pb-3 border-b border-gray-700">
        <h3 id="guest-title" class="text-2xl font-semibold text-white">Edit Guest</h3>
        <p class="text-sm text-white mt-1">Fill out the details to add a new guest to the hotel.</p>
      </div>

      <!-- Form -->
      <form id="editGuestForm" method="POST" action="" class="px-10 pt-6 pb-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="editGuestId">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-300">Guest Name</label>
          <input type="text" name="name" id="editGuestName" required
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
          <input type="email" name="email" id="editGuestEmail"
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label for="phone" class="block text-sm font-medium text-gray-300">Phone</label>
          <input type="text" name="phone" id="editGuestPhone"
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label for="id_type" class="block text-sm font-medium text-gray-300">ID Type</label>
          <input type="text" name="id_type" id="editGuestIdType" required
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label for="id_number" class="block text-sm font-medium text-gray-300">ID Number</label>
          <input type="text" name="id_number" id="editGuestIdNumber" required
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label for="address" class="block text-sm font-medium text-gray-300">Address</label>
          <input type="text" name="address" id="editGuestAddress"
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Footer -->
        <div class="col-span-2 mt-4 flex justify-end gap-4 border-t border-gray-700 pt-4">
          <button type="button" onclick="document.getElementById('editGuestDialog').close()"
            class="inline-flex justify-center rounded-md bg-white/10 px-5 py-2 text-sm font-semibold text-white hover:bg-white/20">
            Cancel
          </button>
          <button type="submit"
            class="inline-flex justify-center rounded-md bg-orange-600 px-5 py-2 text-sm font-semibold text-white hover:bg-orange-500">
            Save Guest
          </button>
        </div>
      </form>
    </div>
  </div>
</dialog>

<form method="POST" id="deleteGuestForm">
  @csrf
  @method('DELETE')

 <div id="deleteGuestDialog" class="fixed inset-0 hidden items-center justify-center z-50">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <div class="relative bg-white rounded-lg shadow-lg max-w-sm w-full p-6 z-10">
      <div class="flex items-center">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 text-red-600 mr-3">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h2 class="text-lg font-semibold text-gray-800">
          Delete Guest <span id="deleteGuestName" class="font-semibold text-red-600 ml-1"></span>?
        </h2>
      </div>

      <p class="mt-3 text-sm text-gray-600">
        Are you sure you want to delete this item? This action cannot be undone.
      </p>

      <div class="mt-6 flex justify-end space-x-3">
        <button type="button" onclick="closeDangerModal()"
          class="px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-800">
          Cancel
        </button>
        <button type="submit"
          class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white">
          Delete
        </button>
      </div>
    </div>
  </div>
</form>

<!-- Reservation Modal -->
<dialog id="reservationDialog" aria-labelledby="reservation-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
  <el-dialog-backdrop class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

  <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
    <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-3xl data-closed:sm:translate-y-0 data-closed:sm:scale-95">
      
      <!-- Header -->
      <div class="bg-orange-600 px-6 pt-5 pb-4 border-b border-gray-700">
        <h3 id="reservation-title" class="text-lg font-semibold text-white">Add Reservation</h3>
        <p class="text-sm text-white">Fill out the form below to add a new reservation.</p>
      </div>

      <!-- Form -->
      <form method="POST" action="{{route('store.reservation')}}" class="bg-gray-800 px-6 pt-4 pb-6">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          
          <!-- Guest ID -->
          <div>
            <label for="guest_id" class="block text-sm font-medium text-gray-300">Guest ID</label>
            <input type="number" name="guest_id" id="guest_id" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Guest Name -->
          <div>
            <label for="guest_name" class="block text-sm font-medium text-gray-300">Guest Name</label>
            <input type="text" id="guest_name" readonly
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Room ID -->
          <div>
            <label for="room_id" class="block text-sm font-medium text-gray-300">Room ID</label>
            <input type="number" name="room_id" id="room_id" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Room Number -->
          <div>
            <label for="roomnumber" class="block text-sm font-medium text-gray-300">Room Number</label>
            <input type="text"  id="roomnumber" readonly
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Check In Date -->
          <div>
            <label for="check_in_date" class="block text-sm font-medium text-gray-300">Check In Date</label>
            <input type="datetime-local" name="check_in_date" id="check_in_date" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Check Out Date -->
          <div>
            <label for="check_out_date" class="block text-sm font-medium text-gray-300">Check Out Date</label>
            <input type="datetime-local" name="check_out_date" id="check_out_date" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Total Amount -->
          <div>
            <label for="total_amount" class="block text-sm font-medium text-gray-300">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" readonly
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Deposit Amount -->
          <div>
            <label for="deposit_amount" class="block text-sm font-medium text-gray-300">Deposit Amount</label>
            <input type="number" name="deposit_amount" id="deposit_amount"
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Balance Amount -->
          <div>
            <label for="balance_amount" class="block text-sm font-medium text-gray-300">Balance Amount</label>
            <input type="number" name="balance_amount" id="balance_amount" readonly
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Status -->
          <div>
            <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
            <select name="status" id="status" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="" selected disabled>--Select Status--</option>
              <option value="Pending">Pending</option>
              <option value="Confirmed">Confirmed</option>
              <option value="Cancelled">Cancelled</option>
              <option value="Checked In">Checked</option>
            </select>
          </div>

        </div>
        <!-- Footer -->
        <div class="mt-6 flex justify-end gap-3 border-t border-gray-700 pt-4">
          <button type="button" command="close" commandfor="reservationDialog"
            class="inline-flex justify-center rounded-md bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20">
            Cancel
          </button>
          <button type="submit"
            class="inline-flex justify-center rounded-md bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-500">
            Save Reservation
          </button>
        </div>
      </form>
    </el-dialog-panel>
  </div>
</dialog>


<dialog id="editReservationDialog" aria-labelledby="reservation-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
  <el-dialog-backdrop class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

  <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
    <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-3xl data-closed:sm:translate-y-0 data-closed:sm:scale-95">
      
      <!-- Header -->
      <div class="bg-orange-600 px-6 pt-5 pb-4 border-b border-gray-700">
        <h3 id="reservation-title" class="text-lg font-semibold text-white">Edit Reservation <span id="reservationId"></span></h3>
        <p class="text-sm text-white">Fill out the form below to edit reservation.</p>
      </div>

      <!-- Form -->
      <form method="POST" id="editReservationForm" action="" class="bg-gray-800 px-6 pt-4 pb-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="editReservationId">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          
          <!-- Guest ID -->
          <div>
            <label for="editGid" class="block text-sm font-medium text-gray-300">Guest ID</label>
            <input type="number" name="guest_id" id="editGid" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Guest Name -->
          <div>
            <label for="editGname" class="block text-sm font-medium text-gray-300">Guest Name</label>
            <input type="text" id="editGname" readonly
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Room ID -->
          <div>
            <label for="editRoomId" class="block text-sm font-medium text-gray-300">Room ID</label>
            <input type="number" name="room_id" id="editRoomId" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Room Number -->
          <div>
            <label for="editRoomNumber" class="block text-sm font-medium text-gray-300">Room Number</label>
            <input type="text"  id="editRoomNumber" readonly
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Check In Date -->
          <div>
            <label for="editCheck_in_date" class="block text-sm font-medium text-gray-300">Check In Date</label>
            <input type="datetime-local" name="check_in_date" id="editCheck_in_date" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Check Out Date -->
          <div>
            <label for="editCheck_out_date" class="block text-sm font-medium text-gray-300">Check Out Date</label>
            <input type="datetime-local" name="check_out_date" id="editCheck_out_date" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Total Amount -->
          <div>
            <label for="editTotal_amount" class="block text-sm font-medium text-gray-300">Total Amount</label>
            <input type="number" name="total_amount" id="editTotal_amount" readonly
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Deposit Amount -->
          <div>
            <label for="editDeposit_amount" class="block text-sm font-medium text-gray-300">Deposit Amount</label>
            <input type="number" name="deposit_amount" id="editDeposit_amount"
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Balance Amount -->
          <div>
            <label for="editBalance_amount" class="block text-sm font-medium text-gray-300">Balance Amount</label>
            <input type="number" name="balance_amount" id="editBalance_amount" readonly
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <div>
            <label for="editStatus" class="block text-sm font-medium text-gray-300">Status</label>
            <select name="status" id="editStatus" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="" selected disabled>--Select Status--</option>
              <option value="Pending">Pending</option>
              <option value="Confirmed">Confirmed</option>
              <option value="Cancelled">Cancelled</option>
              <option value="Checked In">Checked</option>
            </select>
          </div>

        </div>
        <!-- Footer -->
        <div class="mt-6 flex justify-end gap-3 border-t border-gray-700 pt-4">
        <button type="button" onclick="document.getElementById('editReservationDialog').close()"
            class="inline-flex justify-center rounded-md bg-white/10 px-4 py-2 text-sm font-semibold text-white hover:bg-white/20">
            Cancel
          </button>
          <button type="submit"
            class="inline-flex justify-center rounded-md bg-orange-600 px-4 py-2 text-sm font-semibold text-white hover:bg-orange-500">
            Save Reservation
          </button>
        </div>
      </form>
    </el-dialog-panel>
  </div>
</dialog>





