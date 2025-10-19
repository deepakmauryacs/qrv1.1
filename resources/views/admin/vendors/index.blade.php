@extends('admin.layouts.default')
@section('title', 'Manage Vendors')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Vendor List</h1>
        <!-- Add Button to trigger modal -->
        <a href="{{ route('admin.vendors.create') }}" type="button" class="btn btn-primary">
           <i class="bi bi-plus-circle"></i>  Add Vendor 
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Vendors</h6>
        </div>
        <div class="card-body">
            <!-- Table container for responsiveness -->
            <div class="table-responsive">
                <!-- Vendors Table -->
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Subscription</th>
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
        responsive: true, // Enable responsive mode
        lengthChange: false,
        searching: false,
        pageLength: 25,
        ajax: '{{ route('admin.vendors.data') }}', // Your AJAX route
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'code', name: 'code', orderable: false },
            { data: 'name', name: 'name', orderable: false },
            { data: 'email', name: 'email', orderable: false },
            { data: 'contact_number', name: 'contact_number', orderable: false },
            { data: 'subscription_plan', name: 'subscription_plan', orderable: false },  // Subscription column
            {
                data: 'status', 
                name: 'status', 
                orderable: false, 
                render: function(data, type, row) {
                    // Check if the status is 1 (Active) or 2 (Inactive)
                    if (data == 1) {
                        return '<span class="bg-success text-white" style="padding: 2px;border-radius: 5px;font-size: 12px;">Active</span>';
                    } else {
                        return '<span class="bg-danger text-white" style="padding: 2px;border-radius: 5px;font-size: 12px;">Inactive</span>';
                    }
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }  // Action column
        ]
    });

    // Handle subscription plan selection
    $(document).on('change', '.plan-dropdown', function() {
        var vendorId = $(this).data('vendor-id');
        var subscriptionId = $(this).val();

        if (subscriptionId) {
            // Prepare data for the AJAX request
            var data = {
                vendor_id: vendorId,
                subscription_id: subscriptionId,
                month: 3, // 3-month subscription
                start_date: new Date(), // Current date as start date
                end_date: new Date(new Date().setMonth(new Date().getMonth() + 3)), // End date after 3 months
            };

            // Send the data to store the subscription
            $.ajax({
                url: '{{ route('admin.vendors_subscriptions.store') }}', // Define the appropriate route
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Include CSRF token
                },
                success: function(response) {
                    if (response.status == 1) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + error);
                }
            });
        }
    });
});
function confirmDelete(deleteUrl) {
    // Show a confirmation dialog
    if (confirm('Are you sure you want to delete this subscription? This action cannot be undone.')) {
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
