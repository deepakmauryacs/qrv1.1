@extends('vendor.layouts.default') <!-- Adjust the layout path according to your project -->
@section('pageTitle', 'Ticket (Help)')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Ticket (Help)</h1>
        <!-- Add Button to trigger modal -->
        <a  href="{{ route('vendor.tickets.create') }}" type="button" class="btn btn-primary">
           <i class="bi bi-plus-circle"></i> Generate New Ticket
        </a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ticket (Help)</h6>
        </div>
        <div class="card-body">
            <!-- Table container for responsiveness -->
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ticket Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Message</th>
                            <th>Document</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true, // Enable responsive mode
            lengthChange: false,
            searching: false,
            pageLength: 25,
            ajax: '{{ route('vendor.tickets.list') }}', // Your AJAX route
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // Serial number column
                { data: 'ticket_id', name: 'ticket_id', orderable: false },
                { data: 'name', name: 'name', orderable: false },
                { data: 'email', name: 'email', orderable: false },
                { data: 'mobile', name: 'mobile', orderable: false },
                { data: 'message', name: 'message', orderable: false },
                { data: 'document', name: 'document', orderable: false },
                { data: 'created_at', name: 'created_at', orderable: false },
                { data: 'status', name: 'status', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    function confirmDelete(deleteUrl) {
        // Show a confirmation dialog
        if (confirm('Are you sure you want to delete this Ticket? This action cannot be undone.')) {
            // If confirmed, perform an Ajax request to delete the subscription
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',  // Pass CSRF token
                    // _method: 'DELETE',  // Use DELETE method
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
