@extends('vendor.layouts.default')
@section('pageTitle', 'Clone Existing Menu')
@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Select Menu Items</h1>
        <a href="{{ route('vendor.menus') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
 <div class="card shadow mb-4">
 <div class="card-body"> 
 <div class="row">
    <!-- Category Selection -->
    <div class="col-md-4 mb-3">
        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
        <select class="form-control" id="category_id" name="category_id">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Language Selection -->
    <div class="col-md-4 mb-3">
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

    <!-- Type Selection (Veg/Non-Veg) -->
    <div class="col-md-4 mb-3">
        <label for="type" class="form-label">Type</label>
        <select class="form-control" id="type" name="type">
            <option value="">Select Type</option>
            <option value="veg">Veg</option>
            <option value="non-veg">Non-Veg</option>
        </select>
    </div>

</div> 
    </div>
    </div>
    <!-- Menu Items Container -->
    <div class="row" id="menuContainer"></div>
</div>

<script>
    $(document).ready(function() {
    // Initially disable Type and Language dropdowns
    $('#type, #language').prop('disabled', true);

    $('#category_id').change(function() {
        if ($(this).val() !== '') {
            // Enable Type and Language fields when a category is selected
            $('#type, #language').prop('disabled', false);
        } else {
            // Disable Type and Language fields if no category is selected
            $('#type, #language').prop('disabled', true).val('');
        }
    });
});

$(document).ready(function() {
    // Function to fetch menu items based on the filters
    function fetchMenuItems() {
        var categoryId = $('#category_id').val();
        var language = $('#language').val();
        var type = $('#type').val();
       

        $.ajax({
            url: '{{ route("vendor.menus.getByCategory") }}',
            type: 'GET',
            data: {
                category_id: categoryId,
                language: language,
                type: type,
            },
            success: function(response) {
                $('#menuContainer').html(response);
            }
        });
    }

    // Trigger menu item fetch when any filter is changed
    $('#category_id, #language, #type, #search').change(function() {
        fetchMenuItems();
    });

    // Handle Add Menu Click
    $(document).on('click', '.add-menu-btn', function() {
        var menuId = $(this).data('id');
        let _this = this;

        $.ajax({
            url: '{{ route("vendor.menus.add") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                menu_id: menuId
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $(_this).html('<i class="bi bi-check"></i> Added');
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });
});
</script>

@endsection
