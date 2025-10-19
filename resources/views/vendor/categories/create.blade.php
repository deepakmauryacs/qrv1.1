@extends('vendor.layouts.default')

@section('pageTitle', 'Create QR Menu Category')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800">Create QR Menu Category</h1>
            <p class="text-muted mb-0">Add a new category to keep your digital menu organised and easy to browse.</p>
        </div>
        <div class="text-right">
            <a href="{{ route('vendor.categories.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Categories
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="createCategoryForm" action="{{ route('vendor.categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="create-name">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="create-name" name="name" placeholder="e.g., Starters" required>
                            <small class="form-text text-muted">Choose a short and descriptive name that guests will recognise.</small>
                        </div>
                        <div class="form-group">
                            <label for="create-description">Description</label>
                            <textarea class="form-control" id="create-description" name="description" rows="4" placeholder="Optional: describe what is included in this category"></textarea>
                            <small class="form-text text-muted">This appears on your menu and can highlight specials or dietary notes.</small>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
                        setTimeout(() => window.location.href = redirectUrl, 1200);
                    } else {
                        handleErrors(response.message);
                    }
                },
                error: function (xhr) {
                    handleErrors(xhr.responseJSON?.message || xhr.responseJSON?.errors);
                },
                complete: function () {
                    submitButton.prop('disabled', false).html('<i class="bi bi-save"></i> Save Category');
                }
            });
        });
    });
</script>
@endpush
