window.checkinTable = null;

$(document).ready(function () {
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
  window.checkinTable = $('#checkinTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/get-billings/data',
    columns: [
      {
        orderable: false,
        data: null,
        defaultContent: `
          <button 
            class="expand-btn w-6 h-6 flex items-center justify-center bg-orange-500 text-white rounded-full text-sm font-bold hover:bg-orange-600 transition">
            +
          </button>
        `
      },
      { data: 'id', name: 'id', className: 'whitespace-nowrap px-3 py-2' },
      { data: 'checkin_id', name: 'checkin_id', className: 'whitespace-nowrap px-3 py-2' },
      { data: 'guest_name', name: 'guest_name', className: 'whitespace-nowrap px-3 py-2' },
      { data: 'room_number', name: 'room_number', className: 'whitespace-nowrap px-3 py-2' },
      { data: 'total_amount', name: 'total_amount', className: 'whitespace-nowrap px-3 py-2' },
      { data: 'invoice_date', name: 'invoice_date', className: 'whitespace-nowrap px-3 py-2' },
      { data: 'due_date', name: 'due_date', className: 'whitespace-nowrap px-3 py-2' },
      { data: 'status', name: 'status', className: 'whitespace-nowrap px-3 py-2' },
      { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'whitespace-nowrap px-3 py-2' },
    ],
    language: {
      emptyTable: "<span class='text-gray-500'>No data available</span>",
    },
    drawCallback: function () {
      if (typeof lucide !== 'undefined') lucide.createIcons();
    }
  });

  // ==== ADD MODAL ====
  window.addBillingDetail = function (billingId) {
    $('#billing_id').val(billingId || ''); 
    $('#addBillingModal').removeClass('hidden').addClass('flex');
  }

  window.closeAddModal = function () {
    $('#addBillingModal').addClass('hidden').removeClass('flex');
    $('#addBillingForm')[0].reset();
  }

  // ==== DELETE MODAL ====
  let deleteId = null;

  window.deleteBillingDetail = function (id) {
    deleteId = id;
    $('#deleteBillingModal').removeClass('hidden').addClass('flex');
  }

  window.closeDeleteModal = function () {
    $('#deleteBillingModal').addClass('hidden').removeClass('flex');
    deleteId = null;
  }

  // ==== SUBMIT ADD FORM ====
$('#addBillingForm').on('submit', function (e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.ajax({
        url: '/billing-details',
        method: 'POST',
        data: formData,
        success: function (response) {
            closeAddModal();
            const billingId = $('#billing_id').val();

            // Refresh expanded table
            refreshBillingDetails(billingId);

            // Refresh DataTable to update main total_amount column
            window.checkinTable.ajax.reload(function () {
    if (expandedBillingId) {
        // Wait until DataTable redraws, then try to re-expand
        const tryReexpand = () => {
            const tr = $('#checkinTable tbody tr').filter(function () {
                return window.checkinTable.row(this).data()?.id == expandedBillingId;
            });

            if (tr.length) {
                const row = window.checkinTable.row(tr);
                $.ajax({
                    url: '/get-billing-details/' + expandedBillingId,
                    type: 'GET',
                    success: function (details) {
                        const childTable = formatDetails(details, expandedBillingId);
                        row.child(childTable).show();
                        tr.addClass('shown');
                        tr.find('button.expand-btn')
                          .text('-')
                          .removeClass('bg-orange-500')
                          .addClass('bg-orange-700');
                    }
                });
            } else {
                // Row not yet redrawn — retry briefly (helps after delete)
                setTimeout(tryReexpand, 100);
            }
        };

        tryReexpand(); // run initial attempt
    }
}, false);


            Swal.fire({
                icon: 'success',
                title: 'Added Successfully!',
                text: response.message || 'The billing detail has been added.',
                showConfirmButton: false,
                timer: 2000
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error adding billing detail. Please check your input.',
                showConfirmButton: true
            });
        }
    });
});

// ==== DELETE BILLING DETAIL ====
$('#confirmDeleteBtn').on('click', function () {
    if (!deleteId) return;

    $.ajax({
        url: `/billing-details/${deleteId}`,
        type: 'DELETE',
        data: { _token: $('meta[name="csrf-token"]').attr('content') },
        success: function (response) {
            closeDeleteModal();
            const billingId = expandedBillingId || $('tr.shown').find('td:eq(1)').text();
            refreshBillingDetails(billingId);
            window.checkinTable.ajax.reload(function () {
                if (expandedBillingId) {
                    const tryReexpand = () => {
                        const tr = $('#checkinTable tbody tr').filter(function () {
                            return window.checkinTable.row(this).data()?.id == expandedBillingId;
                        });
                        if (tr.length) {
                            const row = window.checkinTable.row(tr);
                            $.ajax({
                                url: '/get-billing-details/' + expandedBillingId,
                                type: 'GET',
                                success: function (details) {
                                    const childTable = formatDetails(details, expandedBillingId);
                                    row.child(childTable).show();
                                    tr.addClass('shown');
                                    tr.find('button.expand-btn')
                                    .text('-')
                                    .removeClass('bg-orange-500')
                                    .addClass('bg-orange-700');
                                }
                            });
                        } else {
                            setTimeout(tryReexpand, 100);
                        }
                    };

                    tryReexpand();
                }
            }, false);
            Swal.fire({
                icon: 'success',
                title: 'Deleted Successfully!',
                text: response.message || 'The billing detail has been deleted.',
                showConfirmButton: false,
                timer: 2000
            });
        },

        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error deleting billing detail. Please try again.',
                showConfirmButton: true
            });
        }
    });
});

 // ==== SINGLE EXPAND/COLLAPSE HANDLER ====
$('#checkinTable tbody').on('click', 'button.expand-btn', function () {
    const tr = $(this).closest('tr');
    const row = window.checkinTable.row(tr);
    const btn = $(this);
    const billingId = row.data().id;

    if (row.child.isShown()) {
        // Collapse
        row.child.hide();
        tr.removeClass('shown');
        btn.text('+').removeClass('bg-orange-700').addClass('bg-orange-500');
        expandedBillingId = null; // clear tracking
    } else {
        // Expand
        btn.text('-').removeClass('bg-orange-500').addClass('bg-orange-700');
        expandedBillingId = billingId; // remember which billing is expanded

        $.ajax({
            url: '/get-billing-details/' + billingId,
            type: 'GET',
            success: function (details) {
                const childTable = formatDetails(details, billingId);
                row.child(childTable).show();
                tr.addClass('shown');
            },
            error: function () {
                row.child('<div class="text-red-500 p-2">Error loading details.</div>').show();
            }
        });
    }
});
  let expandedBillingId = null; 


});

function formatDetails(details) {
  if (!details.length) {
    return '<div class="p-3 text-gray-500">No billing details found.</div>';
  }

  let html = `
    <div class="p-3">
      <div class="flex justify-end mb-2">
        <button 
            onclick="addBillingDetail(${details[0].billing_id})"
            class="px-6 h-6 flex items-center justify-center text-xs font-medium text-white bg-green-500 rounded-md hover:bg-green-600 transition"
            title="Add Billing Detail">Add</button>
      </div>

      <table class="w-full text-sm border border-gray-300 border-collapse">
        <thead class="bg-green-800 text-white">
          <tr>
            <th class="px-2 py-1 border border-gray-400">No</th>
            <th class="px-2 py-1 border border-gray-400">Description</th>
            <th class="px-2 py-1 border border-gray-400">Qty</th>
            <th class="px-2 py-1 border border-gray-400">Unit Price</th>
            <th class="px-2 py-1 border border-gray-400">Discount</th>
            <th class="px-2 py-1 border border-gray-400">Tax</th>
            <th class="px-2 py-1 border border-gray-400">Total</th>
            <th class="px-2 py-1 border border-gray-400 text-center">Action</th>
          </tr>
        </thead>
        <tbody>
  `;

  details.forEach((item, index) => {
    html += `
      <tr>
        <td class="px-2 py-1 border border-gray-400 text-center">${index + 1}</td>
        <td class="px-2 py-1 border border-gray-400">${item.description}</td>
        <td class="px-2 py-1 border border-gray-400 text-center">${item.quantity}</td>
        <td class="px-2 py-1 border border-gray-400 text-right">${item.unit_price}</td>
        <td class="px-2 py-1 border border-gray-400 text-right">${item.discount}</td>
        <td class="px-2 py-1 border border-gray-400 text-right">${item.tax}</td>
        <td class="px-2 py-1 border border-gray-400 font-semibold text-right">${item.total_amount}</td>
        <td class="px-2 py-1 border border-gray-400 text-center">
          <button 
            onclick="deleteBillingDetail(${item.id})"
            class="px-6 h-6 flex items-center justify-center text-xs font-medium text-white bg-red-500 rounded-md hover:bg-red-600 transition"
            title="Delete Billing Detail">Delete</button>
        </td>
      </tr>
    `;
  });

  html += `
        </tbody>
      </table>
    </div>
  `;

  return html;

}
function refreshBillingDetails(billingId) {
  const tr = $(`#checkinTable tbody tr.shown`);
  const row = window.checkinTable.row(tr);

  if (!row) return;

  $.ajax({
    url: '/get-billing-details/' + billingId,
    type: 'GET',
    success: function (details) {
      const updatedTable = formatDetails(details, billingId);
      row.child(updatedTable).show(); // Re-render the same child table content
    },
    error: function () {
      row.child('<div class="text-red-500 p-2">Error refreshing details.</div>').show();
    }
  });
}

window.printDialog = function (button) {
    const billingId = $(button).data('id');
    // Open the invoice view in a new tab for printing
    window.open(`/invoice/${billingId}`, '_blank');
};
