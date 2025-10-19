@extends('vendor.layouts.default')
@section('pageTitle', 'Social Media Setting')
@section('content')
<style type="text/css">
.iti {
  width: 100% !important;
}
</style>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"> Social Media Setting </h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Social Media Setting Details</h6>
        </div>
        <div class="card-body">
            <form id="settingForm" action="{{ route('vendor.settings.saveOrUpdateSocialMedia') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($setting))
                    @method('PUT')
                @endif
                <div class="row">
                    <!-- Social Media Links -->
                    <div class="col-md-6 mb-3">
                        <label for="facebook" class="form-label">Facebook URL</label>
                        <input type="url" class="form-control" id="facebook" name="facebook" value="{{ old('facebook', $setting->facebook ?? '') }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="instagram" class="form-label">Instagram URL</label>
                        <input type="url" class="form-control" id="instagram" name="instagram" value="{{ old('instagram', $setting->instagram ?? '') }}">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="twitter" class="form-label">Twitter URL</label>
                        <input type="url" class="form-control" id="twitter" name="twitter" value="{{ old('twitter', $setting->twitter ?? '') }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-floppy"></i> {{ isset($setting) ? 'Update Setting' : 'Save Setting' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#settingForm').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);
            let submitButton = $('button[type="submit"]');

            // Disable button and show spinner
            submitButton.prop('disabled', true).html('<i class="bi bi-hourglass-split spin"></i> Saving...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is included
                },
                success: function (response) {
                    if (response.status == 1) {
                        toastr.success(response.message);
                        setTimeout(function () {
                            window.location.href = "{{ route('vendor.settings.socialmedia') }}";
                        }, 300);
                    } else {
                        $.each(response.message, function (index, error) {
                            toastr.error(error);
                        });
                    }

                    // Re-enable the button
                    submitButton.prop('disabled', false).html('<i class="bi bi-floppy"></i> {{ isset($setting) ? "Update Setting" : "Save Setting" }}');
                },
                error: function (xhr, status, error) {
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : error;
                    toastr.error('An error occurred: ' + errorMessage);

                    // Re-enable the button
                    submitButton.prop('disabled', false).html('<i class="bi bi-floppy"></i> {{ isset($setting) ? "Update Setting" : "Save Setting" }}');
                }
            });
        });
    });
</script>
@endsection
