@extends('vendor.layouts.default') <!-- Adjust the layout path according to your project -->
@section('pageTitle', 'Generate New Ticket')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Generate New Ticket</h1>
        <!-- Back Button -->
        <a href="{{ route('vendor.tickets.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Generate New Ticket</h6>
        </div>
        <div class="card-body">
            <form id="ticketForm" action="{{ route('vendor.tickets.store') }}" method="POST" class="row" enctype="multipart/form-data">
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

                <div class="col-md-6 mb-3">
                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="message" name="message" rows="2"></textarea>
                </div>
                <!-- <div class="col-md-6 mb-3">
                    <label for="document" class="form-label">Document </label>
                    <input type="file" class="form-control" id="document" name="document" />
                </div> -->
                <div class="col-md-12 mb-3">
                    <label for="document" class="form-label">Document (File Type: JPG, JPEG, PNG, WEBP, PDF)</label>
                    <div class="custom-file-upload">
                        <input type="file" class="form-control d-none" id="document" name="document" 
                               accept=".pdf, .jpg, .jpeg, .png, .webp" onchange="validateFile(event)">
                        <label for="document" class="upload-label">
                            <i class="bi bi-cloud-upload"></i> Click to Upload
                        </label>
                        <div class="preview-container mt-2">
                            <img id="imagePreview" class="img-thumbnail d-none" style="max-width: 50px; max-height: 50px;">
                            <p id="pdfFileName" class="d-none mt-2 fw-bold"></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Generate Ticket</button>
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
                                window.location.href = "{{ route('vendor.tickets.index') }}";
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
    function validateFile(event) {
        var file = event.target.files[0];
        var imagePreview = document.getElementById('imagePreview');
        var pdfFileName = document.getElementById('pdfFileName');

        if (!file) return;

        var validTypes = ["application/pdf", "image/jpeg", "image/png", "image/webp"];
        if (!validTypes.includes(file.type)) {
            alert("Invalid file type! Please upload a PDF, JPG, PNG, or WEBP file.");
            event.target.value = ""; // Clear the file input
            return;
        }

        // If the file is a PDF, show the filename and hide the image preview
        if (file.type === "application/pdf") {
            imagePreview.classList.add('d-none');
            imagePreview.src = "";
            pdfFileName.textContent = "Uploaded: " + file.name;
            pdfFileName.classList.remove('d-none');
            return;
        }

        // If the file is an image, preview it and hide the PDF filename
        pdfFileName.classList.add('d-none');
        previewImage(file);
    }

    function previewImage(file) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection
