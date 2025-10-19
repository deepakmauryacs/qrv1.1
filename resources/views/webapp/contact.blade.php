@extends('webapp.default')
@section('pageTitle', 'Clone Existing Menu')
@section('content')
<!-- jquery 3.6 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- TOP IMAGE HEADER -->
<section class="topSingleBkg topPageBkg">
   <div class="item-content-bkg">
      <div class="item-img" style="background-image: url('{{ asset('qr-webapp/images/top-headers/menu-1col-image.jpg') }}');"></div>
      <div class="inner-desc">
         <span class="post-subtitle">Contact</span>
      </div>
   </div>
</section>
<!-- SECTION 1 -->     	
<section id="wrap-content" class="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-5 mobile-margin-b48">
				<img class="img-fluid" src="{{ asset('qr-webapp/images/home/about-10.jpg')}}" alt="">
				<div class="contact3-info">
					<div class="box-contact">
						<figure class="image-box-img">
							<i class="fas fa-map-marker-alt"></i>
						</figure>
						<div class="image-box-content">
							<h5>Address</h5>
							<p>{{ $settings->store_address }}</p>
						</div>
					</div>
					<!-- /box-contact -->
					<div class="box-contact">
						<figure class="image-box-img">
							<i class="fas fa-phone"></i>
						</figure>
						<div class="image-box-content">
							<h5>Phone</h5>
							<p>{{ $settings->store_contact  }}</p>
						</div>
					</div>
					<!-- /box-contact -->
					<div class="image-box box-contact">
						<figure class="image-box-img">
							<i class="far fa-envelope"></i>
						</figure>
						<div class="image-box-content">
							<h5>Email</h5>
							<p><a href="mailto:{{ $settings->store_email }}">{{ $settings->store_email }}</a></p>
						</div>
					</div>
					<!-- /box-contact -->
				</div>
				<!-- /contact3-info -->
			</div>
			<!-- /col-md-5 -->
			<div class="col-md-7">
				<div class="headline">
					<h2>Get in Touch</h2>
				</div>
				<div class="margin-b24">You have a piece of advice or a suggestion that you would like to share with us? Feel free to contact us.</div>
				<div id="contact-form-holder">
				<form id="vendor-contact-form">
                        @csrf
                        <div class="form-group">
                            <label>Name <span>*</span></label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email <span>*</span></label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Subject <span>*</span></label>
                            <input type="text" name="subject" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Message <span>*</span></label>
                            <textarea name="message" class="form-control" rows="6"></textarea>
                        </div>
                        <div class="form-group" style="text-align: end;">
                         <button type="submit" class="btn btn-primary contact-btn">Send Message</button>
                        </div>
                    </form>

				</div>
				<!-- contact-form-holder-->
				<div id="output-contact"></div>
			</div>
			<!-- /col-md-7 -->
		</div>
		<!-- /row-->
	</div>
	<!-- /container-->
</section>
<!-- /SECTION 1 --> 
<script>
$(document).ready(function() {
    $("#vendor-contact-form").submit(function(e) {
        e.preventDefault(); // Prevent form submission

        // Clear previous Toastr messages
        toastr.clear();

        // Client-side validation
        let name = $("input[name='name']").val().trim();
        let email = $("input[name='email']").val().trim();
        let subject = $("input[name='subject']").val().trim();
        let message = $("textarea[name='message']").val().trim();
        let errors = [];

        // Basic validation rules
        if (name === "") {
            errors.push("Name is required.");
        }
        if (email === "") {
            errors.push("Email is required.");
        } else if (!validateEmail(email)) {
            errors.push("Enter a valid email address.");
        }
        if (subject === "") {
            errors.push("Subject is required.");
        }
        if (message === "") {
            errors.push("Message is required.");
        }

        // Show validation errors separately using Toastr
        if (errors.length > 0) {
            errors.forEach(error => toastr.error(error)); // Show each error as separate Toastr message
            return false; // Stop submission
        }

        // Proceed with AJAX submission if validation passes
        $.ajax({
            url: "{{ route('vendor.contact.save') }}", // Laravel route
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $("#vendor-contact-form button").prop("disabled", true); // Disable button
            },
            success: function(response) {
                if (response.status === 1) {
                    toastr.success(response.message);
                    $("#vendor-contact-form")[0].reset(); // Reset form
                } else {
                    response.message.forEach(msg => toastr.error(msg)); // Show each error separately
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value[0]); // Show each error separately
                });
            },
            complete: function() {
                $("#vendor-contact-form button").prop("disabled", false); // Re-enable button
            }
        });
    });

    // Function to validate email format
    function validateEmail(email) {
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});
</script>
@endsection