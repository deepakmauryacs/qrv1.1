@extends('admin.layouts.default') <!-- Adjust the layout path according to your project -->
@section('pageTitle', 'Vendor Menu Request')
@section('content')
<style type="text/css">
    .ticket-status{
        cursor: pointer;
        color: #4e73de;
    }
</style>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Vendor Menu Request</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Vendor Menu Request</h6>
        </div>
        <div class="card-body">
            <!-- Table container for responsiveness -->
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Request Id</th>
                            <th>Vendor Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Message</th>
                            <th>Documents</th>
                            <th>Date</th>
                            <th>Status</th>
                            <!-- <th>Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="categoryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketModalLabel">Update Ticket Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ticket-id" />
                    <div class="mb-3">
                        <label for="ticket-status-field" class="form-label">Ticket Status</label>
                        <select id="ticket-status-field" class="form-control">
                            <option value="1">Request Sent</option>
                            <option value="2">Request Updated</option>
                            <option value="3">Request Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update-ticket-status">Update</button>
                </div>
            </form>
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
            ajax: '{{ route('admin.menu-request.list') }}', // Your AJAX route
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // Serial number column
                { data: 'request_id', name: 'request_id', orderable: false },
                { data: 'vendor_name', name: 'vendor_name', orderable: false },
                { data: 'name', name: 'name', orderable: false },
                { data: 'email', name: 'email', orderable: false },
                { data: 'mobile', name: 'mobile', orderable: false },
                { data: 'message', name: 'message', orderable: false },
                { data: 'documents', name: 'documents', orderable: false },
                { data: 'created_at', name: 'created_at', orderable: false },
                { data: 'status', name: 'status', orderable: false },
                // { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // $('.ticket-status').click(function() {
        $(document).on("click", ".ticket-status", function(){
            let status = $(this).data('status');
            let id = $(this).data('id');
            console.log(id, status);

            $('#ticket-id').val(id);
            $('#ticket-status-field').val(status);
            $("#ticketModal").modal("show");
        });

        // Submit form for adding or editing
        $('#update-ticket-status').click(function(e) {
            e.preventDefault();
            var id = $('#ticket-id').val();
            var status = $('#ticket-status-field').val();

            if (id) {
                // Update existing category
                $.ajax({
                    url: "{{ route('admin.menu-request.update-status') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        status: status,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if(response.status==1){
                            location.reload();
                        }else{
                            alert(response.message);
                        }
                    }
                });
            } else {
                alert("something went wrong.....");
            }
        });
    });
</script>
@endsection
