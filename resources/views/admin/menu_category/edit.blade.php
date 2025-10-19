@extends('admin.layouts.default')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Edit Menu Category</h1>
        <!-- Back Button -->
        <a href="{{ route('admin.menu-categories') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    
    <!-- Edit Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Category</h6>
        </div>
        <div class="card-body">
            <form id="categoryForm" action="{{ route('admin.menu-categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Method spoofing for PUT request -->
                
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="{{ old('category_name', $category->name) }}" required />
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-floppy"></i> Save Changes
                    </button>
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
                                window.location.href = '{{ route('admin.menu-categories') }}'; // Redirect to the categories index page
                            }, 300);
                        } else {
                            // Display validation errors
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
