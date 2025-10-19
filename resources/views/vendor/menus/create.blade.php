@extends('vendor.layouts.default')
@section('pageTitle', 'Add Menu Item')
@section('content')
<div class="container-fluid">
    @php
        $formDisabled = isset($hasCategories) ? !$hasCategories : false;
    @endphp
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Add Menu Item</h1>
        <a href="{{ route('vendor.menus') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Menu Details</h6>
        </div>
        <div class="card-body">
            @if($formDisabled)
                <div class="alert alert-warning" role="alert">
                    Please add your menu categories first before creating a menu item.
                </div>
            @endif
            <form id="menuForm" action="{{ route('vendor.menus.store') }}" method="POST" enctype="multipart/form-data" data-form-disabled="{{ $formDisabled ? 'true' : 'false' }}">
                @csrf
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="language" class="form-label">Language</label>
                        <select class="form-control" id="language" name="language" {{ $formDisabled ? 'disabled' : '' }}>
                            <option value="">Select Language</option>
                            <option value="english">English</option>
                            <option value="hindi" selected>Hindi</option>
                            <option value="tamil">Tamil</option>
                            <option value="telugu">Telugu</option>
                            <option value="malayalam">Malayalam</option>
                            <option value="kannada">Kannada</option>
                            <option value="bengali">Bengali</option>
                            <option value="marathi">Marathi</option>
                            <option value="gujarati">Gujarati</option>
                            <option value="punjabi">Punjabi</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="category_id" name="category_id" {{ $formDisabled ? 'disabled' : '' }}>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Menu Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" {{ $formDisabled ? 'disabled' : '' }}/>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" {{ $formDisabled ? 'disabled' : '' }}></textarea>
                    </div>



                    <div class="col-md-6 mb-3">
                        <label for="price_half" class="form-label">Half Price</label>
                        <input type="number" class="form-control" id="price_half" name="price_half" {{ $formDisabled ? 'disabled' : '' }}/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="price_full" class="form-label">Full Price</label>
                        <input type="number" class="form-control" id="price_full" name="price_full" {{ $formDisabled ? 'disabled' : '' }}/>
                    </div>

                   <div class="col-md-6 mb-3">
                        <label for="menu_type" class="form-label">Menu Type</label>
                        <select class="form-control" id="menu_type" name="menu_type" {{ $formDisabled ? 'disabled' : '' }}>
                            <option value="">Select Menu Type</option>
                            <option value="veg">Veg</option>
                            <option value="non-veg">Non-Veg</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" {{ $formDisabled ? 'disabled' : '' }}>
                            <option value="1">Available</option>
                            <option value="2">Not Available</option>
                        </select>
                    </div>

                     <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Menu Image</label>
                        <div class="custom-file-upload">
                            <input type="file" class="form-control d-none" id="image" name="image" accept="image/*" onchange="previewImage(event)" {{ $formDisabled ? 'disabled' : '' }}>
                            <label for="image" class="upload-label {{ $formDisabled ? 'disabled' : '' }}">
                                <i class="bi bi-cloud-upload"></i> Click to Upload
                            </label>
                            <div class="preview-container mt-2">
                                <img id="imagePreview" class="img-thumbnail d-none" style="max-width: 50px; max-height: 50px;">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success" {{ $formDisabled ? 'disabled' : '' }}><i class="bi bi-floppy"></i> Save Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

           
       $(document).ready(function() {
        const formDisabled = $('#menuForm').data('form-disabled') === 'true';

        if (formDisabled) {
            return;
        }

        $('#menuForm').submit(function(e) {
            e.preventDefault();

            var isValid = true;

            if ($('#category_id').val() == '') {
                toastr.error("Please select a category.");
                isValid = false;
            }

            if ($('#language').val() == '') {
                toastr.error("Please select a language.");
                isValid = false;
            }

            if ($('#name').val() == '') {
                toastr.error("Please enter the menu name.");
                isValid = false;
            }

            if ($('#menu_type').val() == '') {
                toastr.error("Please select the menu type.");
                isValid = false;
            }

            if (isValid) {
                let formData = new FormData(this);
                
                // Disable the submit button and show spinner
                let submitButton = $('button[type="submit"]');
                submitButton.prop('disabled', true);
                submitButton.html('<i class="bi bi-hourglass-split spin"></i> Saving...');

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
                                window.location.reload();
                            }, 300);
                        } else {
                            $.each(response.message, function(index, error) {
                                toastr.error(error);
                            });
                        }
                        
                        // Re-enable button and reset text
                        submitButton.prop('disabled', false);
                        submitButton.html('<i class="bi bi-floppy"></i> Save Menu');
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred: ' + error);
                        
                        // Re-enable button and reset text
                        submitButton.prop('disabled', false);
                        submitButton.html('<i class="bi bi-floppy"></i> Save Menu');
                    }
                });
            }
        });
    });

    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.classList.remove('d-none');
        };
        reader.readAsDataURL(event.target.files[0]);
    }

</script>
@if($formDisabled)
<style>
    .custom-file-upload .upload-label.disabled {
        pointer-events: none;
        opacity: 0.6;
    }
</style>
@endif
@endsection
