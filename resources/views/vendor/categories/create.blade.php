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
            <form id="createCategoryForm" action="{{ route('vendor.categories.store') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3 position-relative">
                        <label for="create-name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="create-name" name="name" placeholder="e.g., Starters">
                        <div class="invalid-feedback"></div>
                        <div id="category-suggestions" class="list-group position-absolute w-100 shadow-sm d-none" style="z-index: 1050;"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="create-display-order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="create-display-order" name="display_order" value="{{ old('display_order', 0) }}" min="0" step="1">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="create-description" class="form-label">Description</label>
                        <textarea class="form-control" id="create-description" name="description" rows="3" placeholder="Optional: describe what is included in this category"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label d-block" for="create-is-active">Status</label>
                        <select class="form-control" id="create-is-active" name="is_active">
                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <div class="invalid-feedback"></div>
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
$(function () {
    const form = $('#createCategoryForm');
    const submitButton = form.find('button[type="submit"]');
    const redirectUrl = '{{ route('vendor.categories.index') }}';
    const nameInput = $('#create-name');
    const suggestionBox = $('#category-suggestions');
    const suggestionUrl = '{{ route('vendor.categories.suggestions') }}';
    let suggestionRequest = null;
    let suggestionTimer = null;

    // Custom validation logic
    function validateForm() {
        let isValid = true;

        // Helper to show error
        const showError = (input, message) => {
            input.addClass('is-invalid');
            input.siblings('.invalid-feedback').text(message);
            isValid = false;
        };

        // Helper to clear errors
        const clearError = (input) => {
            input.removeClass('is-invalid');
            input.siblings('.invalid-feedback').text('');
        };

        // Reset all errors first
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').text('');

        // Validate Category Name
        const name = nameInput;
        const trimmedName = $.trim(name.val());
        if (trimmedName === '') {
            showError(name, 'Please enter a category name.');
        } else if (trimmedName.length < 2) {
            showError(name, 'Category name must be at least 2 characters.');
        } else if (trimmedName.length > 100) {
            showError(name, 'Category name cannot exceed 100 characters.');
        } else if (/<[^>]*>/g.test(trimmedName)) {
            showError(name, 'HTML tags are not allowed.');
        } else {
            clearError(name);
        }

        // Validate Display Order (optional but must be non-negative)
        const order = $('#create-display-order');
        if (order.val() !== '' && (isNaN(order.val()) || parseInt(order.val()) < 0)) {
            showError(order, 'Display order must be a non-negative number.');
        } else {
            clearError(order);
        }

        // Validate Description (optional, but safe)
        const desc = $('#create-description');
        const descVal = $.trim(desc.val());
        if (descVal.length > 500) {
            showError(desc, 'Description cannot exceed 500 characters.');
        } else if (/<[^>]*>/g.test(descVal)) {
            showError(desc, 'HTML tags are not allowed.');
        } else {
            clearError(desc);
        }

        // Validate Status
        const status = $('#create-is-active');
        if (status.val() === '') {
            showError(status, 'Please select status.');
        } else {
            clearError(status);
        }

        return isValid;
    }

    function hideSuggestions() {
        if (suggestionTimer) {
            clearTimeout(suggestionTimer);
            suggestionTimer = null;
        }

        if (suggestionRequest) {
            suggestionRequest.abort();
            suggestionRequest = null;
        }

        suggestionBox.addClass('d-none').empty();
    }

    function renderSuggestions(items) {
        if (!Array.isArray(items) || items.length === 0) {
            hideSuggestions();
            return;
        }

        const fragment = document.createDocumentFragment();
        items.forEach((item) => {
            const button = $('<button/>', {
                type: 'button',
                class: 'list-group-item list-group-item-action',
                'data-value': item,
                text: item,
            })[0];

            fragment.appendChild(button);
        });

        suggestionBox.empty().append(fragment).removeClass('d-none');
    }

    function fetchSuggestions(term) {
        if (suggestionRequest) {
            suggestionRequest.abort();
        }

        suggestionRequest = $.ajax({
            url: suggestionUrl,
            method: 'GET',
            data: { q: term },
        })
            .done((response) => {
                if (response.status === 1) {
                    renderSuggestions(response.data || []);
                } else {
                    hideSuggestions();
                }
            })
            .fail(() => {
                hideSuggestions();
            })
            .always(() => {
                suggestionRequest = null;
            });
    }

    nameInput.on('input', function () {
        const term = $.trim($(this).val());

        if (suggestionTimer) {
            clearTimeout(suggestionTimer);
        }

        if (term.length < 2) {
            hideSuggestions();
            return;
        }

        suggestionTimer = setTimeout(() => fetchSuggestions(term), 200);
    });

    nameInput.on('focus', function () {
        const term = $.trim($(this).val());
        if (term.length >= 2 && suggestionBox.children().length === 0) {
            fetchSuggestions(term);
        }
    });

    suggestionBox.on('click', 'button', function () {
        const value = $(this).data('value');
        nameInput.val(value);
        hideSuggestions();
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('#create-name, #category-suggestions').length) {
            hideSuggestions();
        }
    });

    // Error toaster aggregator
    function handleErrors(messages) {
        if (Array.isArray(messages)) {
            messages.forEach(msg => toastr.error(msg));
        } else if (typeof messages === 'object' && messages !== null) {
            Object.values(messages).forEach(val => {
                (Array.isArray(val) ? val : [val]).forEach(msg => toastr.error(msg));
            });
        } else if (messages) {
            toastr.error(messages);
        } else {
            toastr.error('Something went wrong.');
        }
    }

    // Submit via AJAX
    form.on('submit', function (e) {
        e.preventDefault();

        if (!validateForm()) {
            toastr.error('Please correct the highlighted fields.');
            return;
        }

        submitButton.prop('disabled', true).html('<i class="bi bi-hourglass-split spin"></i> Saving...');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function (response) {
                if (response.status === 1) {
                    toastr.success(response.message || 'Category saved successfully.');
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
