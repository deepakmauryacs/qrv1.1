@extends('admin.layouts.default')
@section('title', 'Manage Subscriptions')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Subscription Plans</h1>
        <!-- Add Button to trigger modal -->
        <a href="{{ route('admin.subscriptions.create') }}" type="button" class="btn btn-primary">
           <i class="bi bi-plus-circle"></i>  Add Subscription 
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Subscriptions</h6>
        </div>
        <div class="card-body">
            <!-- Table container for responsiveness -->
            <div class="table-responsive">
                <!-- Subscriptions Table -->
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Plan Name</th>
                            <th>Amount</th>
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
            ajax: '{{ route('admin.subscriptions.data') }}', // Your AJAX route
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'plan_name', name: 'plan_name', orderable: false },
                { data: 'amount', name: 'amount', orderable: false },
                { data: 'status', name: 'status', orderable: false, render: function(data, type, row) {
                    // Display subscription status
                    if (data == 1) {
                        return '<span class="bg-success text-white" style="padding: 2px;border-radius: 5px;font-size: 12px;">Active</span>';
                    } else {
                        return '<span class="bg-danger text-white" style="padding: 2px;border-radius: 5px;font-size: 12px;">Inactive</span>';
                    }
                }},
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection
