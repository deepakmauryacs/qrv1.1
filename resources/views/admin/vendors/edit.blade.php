@extends('admin.layouts.default')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Edit Vendor</h1>
        <a href="{{ route('admin.vendors') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Vendor Details</h6>
        </div>
        <div class="card-body">
            <form id="vendorForm" action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="code" class="form-label">Vendor Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $vendor->code) }}"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Vendor Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $vendor->name) }}"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $vendor->email) }}"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number', $vendor->contact_number) }}"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="owner_name" class="form-label">Owner Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ old('owner_name', $vendor->owner_name) }}"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $vendor->address) }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1" {{ $vendor->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="2" {{ $vendor->status == 2 ? 'selected' : '' }}>Not Active</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Save Changes</button>
                </div>
            </form>  
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#vendorForm').submit(function(e) {
            e.preventDefault();

            var isValid = true;

            // Validation checks for required fields
            if ($('#code').val() == '') {
                toastr.error("Please enter the vendor code.");
                isValid = false;
            }

            if ($('#name').val() == '') {
                toastr.error("Please enter the vendor name.");
                isValid = false;
            }

            if ($('#contact_number').val() == '') {
                toastr.error("Please enter the contact number.");
                isValid = false;
            }

            if ($('#owner_name').val() == '') {
                toastr.error("Please enter the owner name.");
                isValid = false;
            }

            if (isValid) {
                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == 1) {
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.href = '{{ route('admin.vendors') }}';
                            }, 300);
                        } else {
                            $.each(response.message, function(index, error) {
                                toastr.error(error);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred: ' + error);
                    }
                });
            }
        });
    });
</script>

@endsection
