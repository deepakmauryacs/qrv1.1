@extends('vendor.layouts.default')
@section('pageTitle', 'Change Password')
@section('content')
<style>
    .input-group:not(.has-validation) > .custom-file:not(:last-child) .custom-file-label::after, .input-group:not(.has-validation) > .custom-select:not(:last-child), .input-group:not(.has-validation) > .form-control:not(:last-child) {
        border-top-right-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
    }
    .input-group {
        position: relative;
    }
    .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Change Password</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update Your Password</h6>
        </div>
        <div class="card-body">
            <form id="changePasswordForm" action="{{ route('vendor.settings.update-password') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Current Password -->
                    <div class="col-md-6 mb-3">
                        <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="current_password" name="current_password">
                            <i class="bi bi-eye-slash toggle-password" data-target="current_password"></i>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="col-md-6 mb-3">
                        <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password" minlength="6">
                            <i class="bi bi-eye-slash toggle-password" data-target="new_password"></i>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="col-md-6 mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            <i class="bi bi-eye-slash toggle-password" data-target="confirm_password"></i>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-shield-lock"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery & AJAX submission with validation -->
<script>
    $(document).ready(function () {
        $('.toggle-password').click(function () {
            let target = $(this).data('target');
            let input = $('#' + target);
            let icon = $(this);

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            }
        });

        $('#changePasswordForm').submit(function (e) {
            e.preventDefault();

            let currentPassword = $('#current_password').val();
            let newPassword = $('#new_password').val();
            let confirmPassword = $('#confirm_password').val();
            let formData = new FormData(this);
            let submitButton = $('button[type="submit"]');

            if (currentPassword.trim() === '') {
                toastr.error("Current password is required.");
                return;
            }

            if (newPassword.trim() === '') {
                toastr.error("New password is required.");
                return;
            }

            if (newPassword.length < 6) {
                toastr.error("New password must be at least 6 characters long.");
                return;
            }

            if (confirmPassword.trim() === '') {
                toastr.error("Confirm password is required.");
                return;
            }

            if (newPassword !== confirmPassword) {
                toastr.error("New password and confirmation password do not match.");
                return;
            }

            submitButton.prop('disabled', true);
            submitButton.html('<i class="bi bi-hourglass-split spin"></i> Updating...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status == 1) {
                        toastr.success(response.message);
                        $('#changePasswordForm')[0].reset();
                    } else {
                        toastr.error(response.message);
                    }
                    submitButton.prop('disabled', false);
                    submitButton.html('<i class="bi bi-shield-lock"></i> Update Password');
                },
                error: function (xhr, status, error) {
                    toastr.error('An error occurred: ' + error);
                    submitButton.prop('disabled', false);
                    submitButton.html('<i class="bi bi-shield-lock"></i> Update Password');
                }
            });
        });
    });
</script>
@endsection