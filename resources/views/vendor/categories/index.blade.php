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
            <a href="{{ route('vendor.categories.create') }}" class="btn btn-outline-primary mb-2">
                <i class="bi bi-plus-circle"></i> Create New QR Category
            </a>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCategoryModal">
                <i class="bi bi-folder-plus"></i> New Category
            </button>
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

<!-- Create Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">Create QR Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createCategoryForm" action="{{ route('vendor.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="create-name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="create-name" name="name" placeholder="e.g., Starters" required>
                    </div>
                    <div class="form-group">
                        <label for="create-description">Description</label>
                        <textarea class="form-control" id="create-description" name="description" rows="3" placeholder="Short description (optional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit QR Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-description">Description</label>
                        <textarea class="form-control" id="edit-description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Category
                    </button>
                </div>
            </form>
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

        $('#createCategoryForm').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            const submitButton = form.find('button[type="submit"]');

            submitButton.prop('disabled', true).html('<i class="bi bi-hourglass-split spin"></i> Saving...');

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function (response) {
                    if (response.status === 1) {
                        toastr.success(response.message);
                        form.trigger('reset');
                        $('#createCategoryModal').modal('hide');
                        table.ajax.reload(null, false);
                    } else {
                        handleErrors(response.message);
                    }
                },
                error: function (xhr) {
                    handleErrors(xhr.responseJSON?.message);
                },
                complete: function () {
                    submitButton.prop('disabled', false).html('<i class="bi bi-save"></i> Save Category');
                }
            });
        });

        $('#categoriesTable').on('click', '.btn-edit', function () {
            const button = $(this);
            const id = button.data('id');
            const name = button.data('name');
            const description = button.data('description');

            $('#edit-name').val(name);
            $('#edit-description').val(description);

            const action = '{{ route('vendor.categories.update', ':id') }}'.replace(':id', id);
            $('#editCategoryForm').attr('action', action);
            $('#editCategoryModal').modal('show');
        });

        $('#editCategoryForm').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            const submitButton = form.find('button[type="submit"]');
            const action = form.attr('action');

            submitButton.prop('disabled', true).html('<i class="bi bi-hourglass-split spin"></i> Updating...');

            $.ajax({
                url: action,
                method: 'POST',
                data: form.serialize(),
                success: function (response) {
                    if (response.status === 1) {
                        toastr.success(response.message);
                        $('#editCategoryModal').modal('hide');
                        table.ajax.reload(null, false);
                    } else {
                        handleErrors(response.message);
                    }
                },
                error: function (xhr) {
                    handleErrors(xhr.responseJSON?.message);
                },
                complete: function () {
                    submitButton.prop('disabled', false).html('<i class="bi bi-save"></i> Update Category');
                }
            });
        });

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
