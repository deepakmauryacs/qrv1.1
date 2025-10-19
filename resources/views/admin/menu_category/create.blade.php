@extends('admin.layouts.default') <!-- Adjust the layout path according to your project -->

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Menu Category</h1>
        <!-- Back Button -->
        <a href="{{ route('admin.menu-categories') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Menu Category</h6>
        </div>
        <div class="card-body">
            <form id="categoryForm" action="{{ route('admin.menu-categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="category_name" name="category_name"/>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Save Category</button>
                </div>
            </form>  
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#categoryForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            var isValid = true;

            // Simple Validation
            if ($('#category_name').val() == '') {
                toastr.error("Please enter the category name.");
                isValid = false;
            }

            if ($('#description').val() == '') {
                toastr.error("Please provide a description.");
                isValid = false;
            }

            if (isValid) {
                // Ajax form submission
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {

                        if (response.status == 1) {
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.reload();
                            }, 300);
                        } else {
                            // Properly handle array or string responses
                            if (Array.isArray(response.message)) {
                                response.message.forEach(function(error) {
                                    toastr.error(error);
                                });
                            } else if (typeof response.message === 'string') {
                                toastr.error(response.message);
                            } else {
                                toastr.error('An unknown error occurred.');
                            }
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
