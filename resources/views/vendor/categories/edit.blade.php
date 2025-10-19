@extends('vendor.layouts.default')

@section('pageTitle', 'Edit QR Menu Category')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Edit Category</h1>
        <a href="{{ route('vendor.categories.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Category Details</h6>
        </div>
        <div class="card-body">
            <form id="editCategoryForm" action="{{ route('vendor.categories.update', $category->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit-name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit-name" name="name" value="{{ old('name', $category->name) }}">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="edit-display-order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="edit-display-order" name="display_order" value="{{ old('display_order', $category->display_order) }}" min="0" step="1">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="edit-description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit-description" name="description" rows="3" placeholder="Optional: describe what is included in this category">{{ old('description', $category->description) }}</textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label d-block" for="edit-is-active">Status</label>
                        <select class="form-control" id="edit-is-active" name="is_active">
                            <option value="1" {{ old('is_active', $category->is_active) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $category->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    const form = $('#editCategoryForm');
    const submitButton = form.find('button[type="submit"]');
    const redirectUrl = '{{ route('vendor.categories.index') }}';

    // ---------- validation helpers ----------
    function showError($el, msg) {
        $el.addClass('is-invalid');
        // for selects and inputs, place message in the next .invalid-feedback
        if ($el.next('.invalid-feedback').length) {
            $el.next('.invalid-feedback').text(msg);
        } else {
            // fallback (e.g., input-group)
            $el.parent().find('.invalid-feedback').first().text(msg);
        }
    }

    function clearError($el) {
        $el.removeClass('is-invalid');
        if ($el.next('.invalid-feedback').length) {
            $el.next('.invalid-feedback').text('');
        } else {
            $el.parent().find('.invalid-feedback').first().text('');
        }
    }

    function validateForm() {
        let ok = true;

        // reset all
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').text('');

        // Name
        const $name = $('#edit-name');
        const name = $.trim($name.val() || '');
        if (!name) {
            showError($name, 'Please enter a category name.');
            ok = false;
        } else if (name.length < 2) {
            showError($name, 'Category name must be at least 2 characters.');
            ok = false;
        } else if (name.length > 100) {
            showError($name, 'Category name cannot exceed 100 characters.');
            ok = false;
        } else if (/<[^>]*>/g.test(name)) {
            showError($name, 'HTML tags are not allowed.');
            ok = false;
        } else {
            clearError($name);
        }

        // Display Order (optional, must be non-negative integer if present)
        const $order = $('#edit-display-order');
        const orderVal = $order.val();
        if (orderVal !== '' && (!/^\d+$/.test(orderVal) || parseInt(orderVal, 10) < 0)) {
            showError($order, 'Display order must be a non-negative integer.');
            ok = false;
        } else {
            clearError($order);
        }

        // Description (optional, max 500, no HTML tags)
        const $desc = $('#edit-description');
        const desc = $.trim($desc.val() || '');
        if (desc.length > 500) {
            showError($desc, 'Description cannot exceed 500 characters.');
            ok = false;
        } else if (/<[^>]*>/g.test(desc)) {
            showError($desc, 'HTML tags are not allowed.');
            ok = false;
        } else {
            clearError($desc);
        }

        // Status
        const $status = $('#edit-is-active');
        if ($status.val() === '') {
            showError($status, 'Please select status.');
            ok = false;
        } else {
            clearError($status);
        }

        return ok;
    }

    // optional: live validation on blur/change
    form.on('blur change', 'input, textarea, select', function () {
        validateForm(); // lightweight enough for this small form
    });

    function handleErrors(messages) {
        if (Array.isArray(messages)) {
            messages.forEach(m => toastr.error(m));
        } else if (typeof messages === 'object' && messages !== null) {
            Object.values(messages).forEach(v => (Array.isArray(v) ? v : [v]).forEach(m => toastr.error(m)));
        } else if (messages) {
            toastr.error(messages);
        } else {
            toastr.error('Something went wrong.');
        }
    }

    form.on('submit', function (e) {
        e.preventDefault();

        // trim fields before validate/submit
        $('#edit-name').val($.trim($('#edit-name').val() || ''));
        $('#edit-description').val($.trim($('#edit-description').val() || ''));

        if (!validateForm()) {
            toastr.error('Please correct the highlighted fields.');
            return;
        }

        submitButton.prop('disabled', true).html('<i class="bi bi-hourglass-split spin"></i> Saving...');

        $.ajax({
            url: form.attr('action'),
            method: 'POST', // _method=PUT is present via @method('PUT')
            data: form.serialize(),
            success: function (response) {
                if (response.status === 1) {
                    toastr.success(response.message || 'Category updated successfully.');
                    setTimeout(() => window.location.href = redirectUrl, 300);
                } else {
                    handleErrors(response.message || 'Unable to save changes.');
                }
            },
            error: function (xhr) {
                handleErrors(xhr.responseJSON?.message || xhr.responseJSON?.errors);
            },
            complete: function () {
                submitButton.prop('disabled', false).html('<i class="bi bi-floppy"></i> Save Changes');
            }
        });
    });
});
</script>
@endpush
