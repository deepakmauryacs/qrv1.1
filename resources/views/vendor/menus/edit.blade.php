@extends('vendor.layouts.default')
@section('pageTitle', 'Edit Menu Item')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Edit Menu Item</h1>
        <a href="{{ route('vendor.menus') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Menu Details</h6>
        </div>
        <div class="card-body">
            <form id="menuForm" action="{{ route('vendor.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Use PUT method for update -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == old('category_id', $menu->menu_category_id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="language" class="form-label">Language</label>
                        <select class="form-control" id="language" name="language">
                            <option value="">Select Language</option>
                            <option value="english" {{ old('language', $menu->language) == 'english' ? 'selected' : '' }}>English</option>
                            <option value="hindi" {{ old('language', $menu->language) == 'hindi' ? 'selected' : '' }}>Hindi</option>
                            <option value="tamil" {{ old('language', $menu->language) == 'tamil' ? 'selected' : '' }}>Tamil</option>
                            <option value="telugu" {{ old('language', $menu->language) == 'telugu' ? 'selected' : '' }}>Telugu</option>
                            <option value="malayalam" {{ old('language', $menu->language) == 'malayalam' ? 'selected' : '' }}>Malayalam</option>
                            <option value="kannada" {{ old('language', $menu->language) == 'kannada' ? 'selected' : '' }}>Kannada</option>
                            <option value="bengali" {{ old('language', $menu->language) == 'bengali' ? 'selected' : '' }}>Bengali</option>
                            <option value="marathi" {{ old('language', $menu->language) == 'marathi' ? 'selected' : '' }}>Marathi</option>
                            <option value="gujarati" {{ old('language', $menu->language) == 'gujarati' ? 'selected' : '' }}>Gujarati</option>
                            <option value="punjabi" {{ old('language', $menu->language) == 'punjabi' ? 'selected' : '' }}>Punjabi</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Menu Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menu->name) }}"/>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{!! old('description', $menu->description) !!}</textarea>
                    </div>

                    


                    <div class="col-md-6 mb-3">
                        <label for="price_half" class="form-label">Half Price</label>
                        <input type="number" class="form-control" id="price_half" name="price_half" value="{{ old('price_half', $menu->price_half) }}"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="price_full" class="form-label">Full Price</label>
                        <input type="number" class="form-control" id="price_full" name="price_full" value="{{ old('price_full', $menu->price_full) }}"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $menu->order) }}"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="menu_type" class="form-label">Menu Type</label>
                        <select class="form-control" id="menu_type" name="menu_type">
                            <option value="veg" {{ old('menu_type', $menu->menu_type) == 'veg' ? 'selected' : '' }}>Veg</option>
                            <option value="non-veg" {{ old('menu_type', $menu->menu_type) == 'non-veg' ? 'selected' : '' }}>Non-Veg</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1" {{ old('status', $menu->status) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="2" {{ old('status', $menu->status) == '2' ? 'selected' : '' }}>Not Active</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Menu Image</label>
                        
                        <div class="custom-file-upload">
                            <input type="file" class="form-control d-none" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                            <label for="image" class="upload-label">
                                <i class="bi bi-cloud-upload"></i> Click to Upload
                            </label>
                        </div>

                        <!-- Image Preview Section -->
                        <div class="preview-container mt-3">
                            @if($menu->image)
                                <div class="image-preview">
                                    <img id="imagePreview" src="{{ asset($menu->image) }}" alt="Menu Image" class="img-thumbnail">
                                </div>
                            @else
                                <img id="imagePreview" class="img-thumbnail d-none">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Save Changes</button>
                </div>
            </form>  
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
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
                
                // Disable button and show loading spinner
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

                        // Re-enable button after success/error
                        submitButton.prop('disabled', false);
                        submitButton.html('<i class="bi bi-floppy"></i> Save Changes');
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred: ' + error);

                        // Re-enable button after error
                        submitButton.prop('disabled', false);
                        submitButton.html('<i class="bi bi-floppy"></i> Save Changes');
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

@endsection
