@extends('admin.layouts.default')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Add Menu Item</h1>
        <a href="{{ route('admin.menus') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Menu Details</h6>
        </div>
        <div class="card-body">
            <form id="menuForm" action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="language" class="form-label">Language</label>
                        <select class="form-control" id="language" name="language">
                            <option value="">Select Language</option>
                            <option value="english">English</option>
                            <option value="hindi">Hindi</option>
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
                        <label for="name" class="form-label">Menu Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Menu Image</label>
                        <input type="file" class="form-control" id="image" name="image"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="price_half" class="form-label">Half Price</label>
                        <input type="number" class="form-control" id="price_half" name="price_half"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="price_full" class="form-label">Full Price</label>
                        <input type="number" class="form-control" id="price_full" name="price_full"/>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="number" class="form-control" id="order" name="order" value="0"/>
                    </div>

                   <div class="col-md-6 mb-3">
                        <label for="menu_type" class="form-label">Menu Type</label>
                        <select class="form-control" id="menu_type" name="menu_type">
                            <option value="">Select Menu Type</option>
                            <option value="veg">Veg</option>
                            <option value="non-veg">Non-Veg</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="2">Not Active</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Save Menu</button>
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
                toastr.error("Please enter the menu type.");
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
                                window.location.reload();
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
