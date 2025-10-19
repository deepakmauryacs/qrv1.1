@extends('vendor.layouts.default')
@section('pageTitle', 'Menu Items')
@section('content')
<!-- Bootstrap Toggle CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

<!-- Bootstrap Toggle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<style type="text/css">
/* Toggle Switch Container */
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

/* Hide Default Checkbox */
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* Toggle Slider */
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
}

/* The Round Slider */
.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 4px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

/* When Checked */
input:checked + .slider {
    background-color: #20c997; /* Match the color in the uploaded image */
}

/* Move Toggle Button */
input:checked + .slider:before {
    transform: translateX(24px);
}

</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Menu Items</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Menu Items</h6>
        </div>
        <div class="card-body">
            <!-- Table container for responsiveness -->
            <div class="table-responsive">
                <!-- Menu Items Table -->
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Half Price</th>
                            <th>Full Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated here via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
      $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthChange: false,
        searching: false,
        pageLength: 25,
        ajax: '{{ route('vendor.menus.data') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'name', name: 'name', orderable: false },
            { data: 'category', name: 'category', orderable: false },
            { data: 'price_half', name: 'price_half', orderable: false },
            { data: 'price_full', name: 'price_full', orderable: false },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                render: function(data, type, row) {
                    let checked = data == 1 ? 'checked' : '';
                    return `
                        <label class="switch">
                            <input type="checkbox" class="toggle-switch" data-id="${row.id}" ${checked}>
                            <span class="slider round"></span>
                        </label>`;
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        drawCallback: function() {
            // Add event listener for the toggle switch
            // $('.toggle-switch').change(function() {
            //     let menuId = $(this).data('id');
            //     let status = $(this).prop('checked') ? 1 : 2;
            //     updateMenuStatus(menuId, status);
            // });
        }
    });

    $(document).on("change", ".toggle-switch", function(){
        let menuId = $(this).data('id');
        let status = $(this).prop('checked') ? 1 : 2;

        $.ajax({
            url: '{{ route("vendor.menus.updateStatus") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                menu_id: menuId,
                status: status
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr) {
                toastr.error("Something went wrong!");
            }
        });
    });

    // AJAX function to update status
    // function updateMenuStatus(menuId, status) {
    //     $.ajax({
    //         url: '{{ route("vendor.menus.updateStatus") }}',
    //         type: 'POST',
    //         data: {
    //             _token: '{{ csrf_token() }}',
    //             menu_id: menuId,
    //             status: status
    //         },
    //         success: function(response) {
    //             toastr.success(response.message);
    //         },
    //         error: function(xhr) {
    //             toastr.error("Something went wrong!");
    //         }
    //     });
    // }


    });
    function confirmDelete(deleteUrl) {
        // Show a confirmation dialog
        if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
            // If confirmed, perform an Ajax request to delete the subscription
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',  // Pass CSRF token
                    _method: 'DELETE',  // Use DELETE method
                },
                success: function(response) {
                    // If successful, show a success message and reload the page
                    if (response.status == 1) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.reload();  // Reload the page after the delete action
                        }, 300); // Slight delay to allow the server to process the delete
                    } else {
                        toastr.error('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + error);
                }
            });
        }
    }

</script>
@endsection

