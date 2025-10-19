@extends('vendor.layouts.default')
@section('pageTitle', 'Menu Items Setup')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Menu Items Setup</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Set Discount</h6>
        </div>
        <div class="card-body">
            <form id="vendorMenuForm">
                @csrf
                <div class="mb-3">
                    <label for="discount" class="form-label">Discount (%)</label>
                    <input type="number" class="form-control" id="discount" name="discount" min="1" max="99" required>
                </div>
                <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Save</button>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    // Fetch existing discount value when the page loads
    $.ajax({
        url: '{{ route("vendor.get.discount") }}',
        type: 'GET',
        success: function (response) {
            if (response.success && response.discount) {
                $('#discount').val(response.discount);
            }
        }
    });

    // Handle form submission
    $('#vendorMenuForm').submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        let submitButton = $('button[type="submit"]');

        // Disable the button and show a spinner
        submitButton.prop('disabled', true);
        submitButton.html('<i class="bi bi-hourglass-split spin"></i> Saving...');

        $.ajax({
            url: '{{ route("vendor.menu.save") }}',
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error('Something went wrong.');
                }
                
                // Re-enable the button after success/error
                submitButton.prop('disabled', false);
                submitButton.html('<i class="bi bi-floppy"></i> Save');
            },
            error: function () {
                toastr.error('An error occurred.');

                // Re-enable the button after error
                submitButton.prop('disabled', false);
                submitButton.html('<i class="bi bi-floppy"></i> Save');
            }
        });
    });
});
</script>
@endsection
