@extends('vendor.layouts.default')

@section('pageTitle', 'Create QR Menu Category')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Add Category</h1>
        <a href="{{ route('vendor.categories.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Category Details</h6>
        </div>
        <div class="card-body">
            <form id="createCategoryForm" action="{{ route('vendor.categories.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="create-name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="create-name" name="name" placeholder="e.g., Starters" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="create-display-order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="create-display-order" name="display_order" value="{{ old('display_order', 0) }}" min="0" step="1">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="create-description" class="form-label">Description</label>
                        <textarea class="form-control" id="create-description" name="description" rows="3" placeholder="Optional: describe what is included in this category"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label d-block" for="create-is-active">Status</label>
                        <input type="hidden" name="is_active" value="0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="create-is-active" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="create-is-active">Active</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        const form = $('#createCategoryForm');
        const submitButton = form.find('button[type="submit"]');
        const redirectUrl = '{{ route('vendor.categories.index') }}';

        function handleErrors(messages) {
            if (Array.isArray(messages)) {
                messages.forEach(message => toastr.error(message));
            } else if (typeof messages === 'object' && messages !== null) {
                Object.values(messages).forEach(value => {
                    (Array.isArray(value) ? value : [value]).forEach(message => toastr.error(message));
                });
            } else if (messages) {
                toastr.error(messages);
            } else {
                toastr.error('Something went wrong.');
            }
        }

        form.on('submit', function (e) {
            e.preventDefault();

            submitButton.prop('disabled', true).html('<i class="bi bi-hourglass-split spin"></i> Saving...');

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function (response) {
                    if (response.status === 1) {
                        toastr.success(response.message);
                        form.trigger('reset');
                        setTimeout(() => window.location.href = redirectUrl, 300);
                    } else {
                        handleErrors(response.message);
                    }
                },
                error: function (xhr) {
                    handleErrors(xhr.responseJSON?.message || xhr.responseJSON?.errors);
                },
                complete: function () {
                    submitButton.prop('disabled', false).html('<i class="bi bi-floppy"></i> Save Category');
                }
            });
        });
    });
</script>
@endpush
