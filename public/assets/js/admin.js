window.adminTable = null;

$(document).ready(function() {
    $('#adminTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/admins/data',
        columns: [
            
            { data: 'id', name: 'id', searchable: true },
            { data: 'name', name: 'name', className: 'whitespace-nowrap px-4 py-2'},
            { data: 'email', name: 'email', searchable: false, className: 'whitespace-nowrap px-4 py-2' },
            { data: 'created_at', name: 'created_at', searchable: false, className: 'whitespace-nowrap px-4 py-2' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ],
        
        language: {
            emptyTable: "<span class='text-gray-500'>No data available</span>",
        },
         drawCallback: function() {
            lucide.createIcons();
        }
    });

});

window.addAdminDialog = function () {
    const dlg = document.getElementById('addAdminDialog');
    if (dlg && typeof dlg.showModal === 'function') {
        dlg.showModal();
        return dlg;
    }
};

window.editAdminDialog = function (button) {
  const editdlg = document.getElementById('editAdminDialog');
  const form = document.getElementById('editAdminForm');

  if (!editdlg || typeof editdlg.showModal !== 'function') {
    console.error('Dialog not found or not supported.');
    return;
  }

  form.onsubmit = async function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    formData.append('_method', 'PUT');

    try {
      const response = await fetch(form.action, {
        method: 'POST', // Laravel sees it as PUT
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const data = await response.json();

      if (data.status === 'success') {
        editdlg.close(); 

        Swal.fire({
          icon: 'success',
          title: 'Updated!',
          text: data.message,
          timer: 2000,
          showConfirmButton: false
        });

        $('#adminTable').DataTable().ajax.reload(null, false);

      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: data.message
        });
      }

    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Something went wrong!',
        text: error.message
      });
    }
  };

  // Populate form fields from data attributes
  const id = button.getAttribute('data-id');
  form.action = `/update/admin/${id}`;

  document.getElementById('editAdminId').value = id || '';
  document.getElementById('editName').value = button.getAttribute('data-name') || '';
  document.getElementById('editEmail').value = button.getAttribute('data-email') || '';

  editdlg.showModal();
};


// Open Delete Modal
window.openDeleteAdminDialog = function (button) {
    const id = button.getAttribute('data-id');
    const name = button.getAttribute('data-name');

    document.getElementById('deleteAdminName').textContent = name || '';
    document.getElementById('deleteAdminDialog').classList.remove('hidden');
    document.getElementById('deleteAdminDialog').classList.add('flex');

    const form = document.getElementById('deleteAdminForm');
    form.setAttribute('action', `/delete/admin/${id}`);
};

// Close modal
window.closeDangerModal = function () {
    const modal = document.getElementById('deleteAdminDialog');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
};

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('deleteAdminForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const actionUrl = form.getAttribute('action');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(actionUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Optional: refresh table or remove row dynamically
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }

                    window.closeDangerModal();
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again.'
                    });
                });
            }
        });
    });
});