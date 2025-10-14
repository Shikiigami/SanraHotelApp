<dialog id="checkinDialog" aria-labelledby="checkin-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
  <el-dialog-backdrop class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

  <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
    <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-3xl data-closed:sm:translate-y-0 data-closed:sm:scale-95">
      
      <!-- Header -->
      <div class="bg-orange-600 px-6 pt-5 pb-4 border-b border-gray-700">
        <h3 id="checkin-title" class="text-lg font-semibold text-white">Add Check-in</h3>
        <p class="text-sm text-white">Fill out the form below to add a new Checkin.</p>
      </div>

      <!-- Form -->
      <form method="POST" action="{{route('store.checkin')}}" class="bg-gray-800 px-6 pt-4 pb-6">
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
            <label for="actual_check_in_time" class="block text-sm font-medium text-gray-300">Check In Date</label>
            <input type="datetime-local" name="actual_check_in_time" id="actual_check_in_time" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Check Out Date -->
          <div>
            <label for="actual_check_out_time" class="block text-sm font-medium text-gray-300">Check Out Date</label>
            <input type="datetime-local" name="actual_check_out_time" id="actual_check_out_time" 
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Total Amount -->
          <div>
            <label for="total_amount" class="block text-sm font-medium text-gray-300">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount"
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Deposit Amount -->
          <div>
            <label for="deposit" class="block text-sm font-medium text-gray-300">Deposit Amount</label>
            <input type="number" name="deposit" id="deposit"
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Balance Amount -->
          <div>
            <label for="balance" class="block text-sm font-medium text-gray-300">Balance Amount</label>
            <input type="number" name="balance" id="balance" readonly
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Status -->
          <div>
            <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
            <select name="status" id="status" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="" selected disabled>--Select Status--</option>
              <option value="Checked In">Checked In</option>
              <option value="Checked Out">Checked Out</option>
            </select>
          </div>

            <div>
            <label for="payment_status" class="block text-sm font-medium text-gray-300">Payment Status</label>
            <select name="payment_status" id="payment_status" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="" selected disabled>--Select Status--</option>
              <option value="Pending">Pending</option>
              <option value="Paid">Paid</option>
              <option value="Partially Paid">Partially Paid</option>
            </select>
          </div>

           <div>
            <label for="payment_method" class="block text-sm font-medium text-gray-300">Payment Method</label>
            <input type="text"  id="payment_method" name="payment_method"
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

         <div class="sm:col-span-2 w-full">
            <label for="payment_reference" class="block text-sm font-medium text-gray-300">Payment Reference</label>
            <input type="text"  id="payment_reference" name="payment_reference" class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

        </div>
        <!-- Footer -->
        <div class="mt-6 flex justify-end gap-3 border-t border-gray-700 pt-4">
          <button type="button" command="close" commandfor="checkinDialog"
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

<!-- Edit checkin Modal -->
<dialog id="editCheckinDialog" aria-labelledby="checkin-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
  <el-dialog-backdrop class="fixed inset-0 bg-gray-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

  <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
    <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-gray-800 text-left shadow-xl outline -outline-offset-1 outline-white/10 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-3xl data-closed:sm:translate-y-0 data-closed:sm:scale-95">
      
      <!-- Header -->
      <div class="bg-orange-600 px-6 pt-5 pb-4 border-b border-gray-700">
        <h3 id="checkin-title" class="text-lg font-semibold text-white">Edit Checkin <span id="checkinId"></span></h3>
        <p class="text-sm text-white">Fill out the form below to edit checkin.</p>
      </div>

      <!-- Form -->
      <form method="POST" id="editCheckinForm" action="" class="bg-gray-800 px-6 pt-4 pb-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="editCheckinId">
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
            <input type="datetime-local" name="actual_check_in_time" id="editCheck_in_date" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Check Out Date -->
          <div>
            <label for="editCheck_out_date" class="block text-sm font-medium text-gray-300">Check Out Date</label>
            <input type="datetime-local" name="actual_check_out_time" id="editCheck_out_date" required
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
            <label for="editDeposit" class="block text-sm font-medium text-gray-300">Deposit Amount</label>
            <input type="number" name="deposit" id="editDeposit"
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <!-- Balance Amount -->
          <div>
            <label for="editBalance" class="block text-sm font-medium text-gray-300">Balance Amount</label>
            <input type="number" name="balance" id="editBalance" readonly
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

          <div>
            <label for="editStatus" class="block text-sm font-medium text-gray-300">Status</label>
            <select name="status" id="editStatus" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="" selected disabled>--Select Status--</option>
              <option value="Checked In">Checked In</option>
              <option value="Checked Out">Checked Out</option>
            </select>
          </div>

            <div>
            <label for="editPaymentStatus" class="block text-sm font-medium text-gray-300">Payment Status</label>
            <select name="payment_status" id="editPaymentStatus" required
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option value="" selected disabled>--Select Status--</option>
              <option value="Pending">Pending</option>
              <option value="Paid">Paid</option>
              <option value="Partially Paid">Partially Paid</option>
            </select>
          </div>

           <div>
            <label for="editPaymentMethod" class="block text-sm font-medium text-gray-300">Payment Method</label>
            <input type="text"  id="editPaymentMethod" name="payment_method"
              class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>

         <div class="sm:col-span-2 w-full">
            <label for="editPaymentReference" class="block text-sm font-medium text-gray-300">Payment Reference</label>
            <input type="text"  id="editPaymentReference" name="payment_reference" class="mt-1 block w-full rounded-md bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

        </div>
        <!-- Footer -->
        <div class="mt-6 flex justify-end gap-3 border-t border-gray-700 pt-4">
        <button type="button" onclick="document.getElementById('editCheckinDialog').close()"
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


<!-- Add Billing Detail Modal -->
<div id="addBillingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
  <div class="bg-white w-full max-w-md rounded-lg shadow-lg">
    <div class="flex justify-between items-center px-4 py-2 border-b">
      <h2 class="text-lg font-semibold text-gray-700">Add Billing Detail</h2>
      <button onclick="closeAddModal()" class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
    </div>
    <form id="addBillingForm" class="space-y-3 p-4 bg-white rounded-md">
      @csrf
      <input type="hidden" id="billing_id" name="billing_id">
      <div>
        <label class="block text-sm font-medium">Description</label>
        <input type="text" name="description" id="description" class="w-full border rounded p-2">
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-sm font-medium">Quantity</label>
          <input type="number" name="quantity" id="quantity" class="w-full border rounded p-2">
        </div>
        <div>
          <label class="block text-sm font-medium">Unit Price</label>
          <input type="number" name="unit_price" id="unit_price" class="w-full border rounded p-2">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="block text-sm font-medium">Discount (%)</label>
          <input type="number" name="discount" id="discount" class="w-full border rounded p-2">
        </div>
        <div>
          <label class="block text-sm font-medium">Tax (%)</label>
          <input type="number" name="tax" id="tax" class="w-full border rounded p-2">
        </div>
      </div>

      <div class="flex justify-end gap-2 mt-4">
        <button type="button" onclick="closeAddModal()" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteBillingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
  <div class="bg-white w-full max-w-sm rounded-lg shadow-lg p-5 text-center">
    <h3 class="text-lg font-semibold text-gray-700 mb-3">Delete Billing Detail?</h3>
    <p class="text-sm text-gray-500 mb-5">This action cannot be undone.</p>
    <div class="flex justify-center space-x-3">
      <button onclick="closeDeleteModal()" class="px-4 py-2 text-sm bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</button>
      <button id="confirmDeleteBtn" class="px-4 py-2 text-sm bg-red-600 text-white rounded-md hover:bg-red-700">Delete</button>
    </div>
  </div>
</div>
