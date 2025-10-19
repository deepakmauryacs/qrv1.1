@extends('vendor.layouts.default')
@section('pageTitle', 'QR Menu Categories')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">QR Menu Categories</h1>
            <p class="text-muted mb-0">Create and manage the categories that power your digital QR menu.</p>
        </div>
        <div class="text-right">
            <a href="{{ route('vendor.categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create Category
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="categoriesTable" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
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

@push('scripts')
<script>
    $(document).ready(function () {
        const table = $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            lengthChange: false,
            ajax: '{{ route('vendor.categories.data') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description', defaultContent: '—' },
                { data: 'is_active', name: 'is_active', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        function handleErrors(messages) {
            if (Array.isArray(messages)) {
                messages.forEach(message => toastr.error(message));
            } else if (messages) {
                toastr.error(messages);
            } else {
                toastr.error('Something went wrong.');
            }
        }

        $('#categoriesTable').on('click', '.btn-delete', function () {
            const deleteUrl = $(this).data('url');

            if (!confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
                return;
            }

            $.ajax({
                url: deleteUrl,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function (response) {
                    if (response.status === 1) {
                        toastr.success(response.message);
                        table.ajax.reload(null, false);
                    } else {
                        handleErrors(response.message);
                    }
                },
                error: function (xhr) {
                    handleErrors(xhr.responseJSON?.message);
                }
            });
        });

    });
</script>
@endpush
@endsection
