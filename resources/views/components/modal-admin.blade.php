
<!-- ADD GUEST DIALOG -->
<dialog id="addAdminDialog" aria-labelledby="admin-title" 
    class="fixed inset-0  w-full max-w-3xl mx-auto bg-transparent p-0 overflow-hidden">

  <!-- Backdrop -->
  <div class="fixed inset-0 bg-gray-900/50"></div>

  <div class="flex min-h-screen items-center justify-center p-4 text-center">

    <div class="relative transform rounded-lg bg-gray-800 text-left shadow-xl w-full max-w-3xl">

      <!-- Header -->
      <div class="bg-orange-600 rounded-t-md px-5 pt-3 pb-3 border-b border-gray-700">
        <h3 id="guest-title" class="text-2xl font-semibold text-white">Add Admin</h3>
        <p class="text-sm text-white mt-1">Fill out the details to add a new admin to the hotel.</p>
      </div>

      <!-- Form -->
      <form id="addAdminForm" method="POST" action="{{ route('admin.store') }}" class="px-10 pt-6 pb-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
        @csrf
        <div>
          <label for="name" class="block text-sm font-medium text-gray-300">Admin Name</label>
          <input type="text" name="name" id="name" :value="old('name')" required autofocus autocomplete="name"
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
         <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
          <input type="email" name="email" id="email" :value="old('email')" required autocomplete="username" 
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
         <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
          <label for="phone" class="block text-sm font-medium text-gray-300">Password</label>
          <input type="password" name="password" id="password"  required autocomplete="new-password" 
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
         <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
          <label for="phone" class="block text-sm font-medium text-gray-300">Confirm Password</label>
          <input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password"
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
         <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        
        <!-- Footer -->
        <div class="col-span-2 mt-2 flex justify-end gap-4 border-t border-gray-700 pt-4">
          <button type="button" onclick="document.getElementById('addAdminDialog').close()"
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


<!-- Edit Admin Dialog -->
<dialog id="editAdminDialog" aria-labelledby="admin-title" 
    class="fixed inset-0  w-full max-w-3xl mx-auto bg-transparent p-0 overflow-hidden">

  <!-- Backdrop -->
  <div class="fixed inset-0 bg-gray-900/50"></div>

  <div class="flex min-h-screen items-center justify-center p-4 text-center">

    <div class="relative transform rounded-lg bg-gray-800 text-left shadow-xl w-full max-w-3xl">

      <!-- Header -->
      <div class="bg-orange-600 rounded-t-md px-5 pt-3 pb-3 border-b border-gray-700">
        <h3 id="admin-title" class="text-2xl font-semibold text-white">Edit Admin</h3>
        <p class="text-sm text-white mt-1">Fill out the details to add a edit admin to the hotel.</p>
      </div>

      <!-- Form -->
      <form id="editAdminForm" method="POST" action="" class="px-10 pt-6 pb-8 grid grid-cols-1 sm:grid-cols-2 gap-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="editAdminId">

        <div>
          <label for="name" class="block text-sm font-medium text-gray-300">Admin Name</label>
          <input type="text" name="name" id="editName" :value="old('name')" required autofocus autocomplete="name"
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
         <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
          <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
          <input type="email" name="email" id="editEmail" :value="old('email')" required autocomplete="username" 
            class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
         <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Footer -->
        <div class="col-span-2 mt-4 flex justify-end gap-4 border-t border-gray-700 pt-4">
          <button type="button" onclick="document.getElementById('editAdminDialog').close()"
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

<form method="POST" id="deleteAdminForm">
  @csrf
  @method('DELETE')

 <div id="deleteAdminDialog" class="fixed inset-0 hidden items-center justify-center z-50">
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
          Delete Admin <span id="deleteAdminName" class="font-semibold text-red-600 ml-1"></span>?
        </h2>
      </div>

      <p class="mt-3 text-sm text-gray-600">
        Are you sure you want to delete this admin? This action cannot be undone.
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