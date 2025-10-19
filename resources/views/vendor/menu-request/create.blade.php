@extends('vendor.layouts.default') <!-- Adjust the layout path according to your project -->
@section('pageTitle', 'Add Menu Request')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Add Menu Request</h1>
        <!-- Back Button -->
        <a href="{{ route('vendor.menu-request.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Menu Request</h6>
        </div>
        <div class="card-body">
            <form id="ticketForm" action="{{ route('vendor.menu-request.store') }}" method="POST" class="row" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" />
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="mobile" name="mobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                </div>
                <!-- <div class="col-md-6 mb-3">
                    <label for="document" class="form-label">Document (Maximum 5 files, File Type: JPG, JPEG, PNG, WEBP, PDF) <span class="text-danger">*</span></label>
                    <input type="file" name="documents[]" multiple class="form-control" id="document" />
                </div> -->

                <div class="col-md-6 mb-3">
                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="message" name="message" rows="2"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="documents" class="form-label">Documents (Maximum 5 files, File Type: JPG, JPEG, PNG, WEBP, PDF)</label>
                    <div class="custom-file-upload">
                        <input type="file" class="form-control d-none" id="documents" name="documents[]" multiple
                               accept=".pdf, .jpg, .jpeg, .png, .webp" onchange="validateFiles(event)">
                        <label for="documents" class="upload-label">
                            <i class="bi bi-cloud-upload"></i> Click to Upload
                        </label>
                        <div class="preview-container mt-2" id="previewContainer"></div>
                    </div>
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Submit</button>
                </div>
            </form>  
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#ticketForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            var isValid = true;

            // Simple Validation
            if ($(this).find('#name').val() == '') {
                toastr.error("Please enter the name.");
                isValid = false;
            }
            if ($(this).find('#email').val() == '') {
                toastr.error("Please enter the email.");
                isValid = false;
            }
            if ($(this).find('#mobile').val() == '') {
                toastr.error("Please enter the mobile.");
                isValid = false;
            }
            if ($(this).find('#message').val() == '') {
                toastr.error("Please enter the message.");
                isValid = false;
            }

            if (isValid) {
                // Ajax form submission
                let formData = new FormData(this); // Use FormData to handle files
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 1) {
                            toastr.success(response.message);
                            setTimeout(function () {
                                // window.location.reload();
                                window.location.href = "{{ route('vendor.menu-request.index') }}";
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
    function validateFiles(event) {
        var files = event.target.files;
        var previewContainer = document.getElementById('previewContainer');

        // Clear previous previews
        previewContainer.innerHTML = "";

        if (files.length > 5) {
            alert("You can upload a maximum of 5 files.");
            event.target.value = ""; // Clear the file input
            return;
        }

        var validTypes = ["application/pdf", "image/jpeg", "image/png", "image/webp"];

        for (let i = 0; i < files.length; i++) {
            let file = files[i];

            if (!validTypes.includes(file.type)) {
                alert("Invalid file type! Please upload a PDF, JPG, PNG, or WEBP file.");
                event.target.value = ""; // Clear the file input
                return;
            }

            if (file.type.startsWith("image/")) {
                previewImage(file, previewContainer);
            } else if (file.type === "application/pdf") {
                previewPDF(file, previewContainer);
            }
        }
    }

    function previewImage(file, container) {
        var reader = new FileReader();
        reader.onload = function () {
            var img = document.createElement("img");
            img.src = reader.result;
            img.classList.add("img-thumbnail", "me-2");
            img.style.maxWidth = "50px";
            img.style.maxHeight = "50px";
            container.appendChild(img);
        };
        reader.readAsDataURL(file);
    }

    function previewPDF(file, container) {
        var p = document.createElement("p");
        p.textContent = "Uploaded: " + file.name;
        p.classList.add("fw-bold", "mt-1");
        container.appendChild(p);
    }
</script>
@endsection
