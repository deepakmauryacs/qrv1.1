@extends('admin.layouts.default') <!-- Adjust the layout path according to your project -->

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Menu Category</h1>
        <!-- Add Button to trigger modal -->
        <a  href="{{ route('admin.menu_categories.create') }}" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal">
           <i class="bi bi-plus-circle"></i>  Add Category 
        </a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Menu Items</h6>
        </div>
        <div class="card-body">
            <!-- Table container for responsiveness -->
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add/Edit -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="categoryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Add/Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="categoryId">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="categoryDescription"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveCategoryBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Initialize DataTable

    $(document).ready(function() {
      $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true, // Enable responsive mode
            lengthChange: false,
            searching: false,
            pageLength: 25,
            ajax: '{{ route('admin.menucategory.data') }}', // Your AJAX route
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // Serial number column
                { data: 'name', name: 'name', orderable: false },
                { data: 'description', name: 'description', orderable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    searchable: false
                }
            ]
        });





        // Add button click event
        $('#addCategoryBtn').click(function() {
            $('#categoryId').val('');
            $('#categoryName').val('');
            $('#categoryDescription').val('');
            $('#categoryModalLabel').text('Add Category');
        });

        // Edit button click event
        $('.edit-btn').click(function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var description = $(this).data('description');

            $('#categoryId').val(id);
            $('#categoryName').val(name);
            $('#categoryDescription').val(description);
            $('#categoryModalLabel').text('Edit Category');
        });

        // Submit form for adding or editing
        $('#categoryForm').submit(function(e) {
            e.preventDefault();
            var id = $('#categoryId').val();
            var name = $('#categoryName').val();
            var description = $('#categoryDescription').val();

            if (id) {
                // Update existing category
                $.ajax({
                    url: '/admin/menu-categories/' + id,
                    type: 'PUT',
                    data: {
                        name: name,
                        description: description,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            } else {
                // Add new category
                $.ajax({
                    url: '/admin/menu-categories',
                    type: 'POST',
                    data: {
                        name: name,
                        description: description,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });

        // Delete category
        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: '/admin/menu-category/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $('#category-' + id).remove();
                    }
                });
            }
        });
    });

    function confirmDelete(deleteUrl) {
        // Show a confirmation dialog
        if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
            // If confirmed, perform an Ajax request to delete the category
            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',  // Pass CSRF token
                    _method: 'DELETE',  // Use DELETE method
                },
                success: function(response) {
                    // If successful, show a success message and reload the page
                    if (response.status == 1) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.reload();  // Reload the page after the delete action
                        }, 300); // Slight delay to allow the server to process the delete
                    } else {
                        toastr.error('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('An error occurred: ' + error);
                }
            });
        }
    }


</script>
@endsection
