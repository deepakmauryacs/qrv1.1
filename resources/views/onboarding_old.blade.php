<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />

   <!-- Dynamic Title -->
   <title>@yield('title', 'Onboarding - DigitalQR')</title>

   <!-- Meta Description (Important for SEO) -->
   <meta name="description" content="DigitalQR is a smart, contactless QR menu and product listing solution for restaurants and businesses in India. Enhance customer experience with digital menus.">

   <!-- Keywords (Optional but can help SEO) -->
   <meta name="keywords" content="QR menu, digital menu, restaurant QR, contactless ordering, DigitalQR, product listing">

   <!-- Author (Good for branding) -->
   <meta name="author" content="DigitalQR by AetherGrid Innovatech Pvt Ltd">

   <!-- Robots Tag (Control indexing) -->
   <meta name="robots" content="index, follow">

   <!-- Canonical URL (Avoid duplicate content issues) -->
   <link rel="canonical" href="https://www.digitalqr.in/onboarding">

   <!-- Open Graph Meta Tags (for Facebook & LinkedIn) -->
   <meta property="og:title" content="Onboarding - DigitalQR">
   <meta property="og:description" content="Get started with DigitalQR - the smart, contactless QR menu and product listing solution for restaurants and businesses.">
   <meta property="og:image" content="https://www.digitalqr.in/web-app/images/preview.png">
   <meta property="og:url" content="https://www.digitalqr.in/onboarding">
   <meta property="og:type" content="website">
   <meta property="og:site_name" content="DigitalQR">

   <!-- Twitter Card Meta Tags (for better Twitter sharing) -->
   <meta name="twitter:card" content="summary_large_image">
   <meta name="twitter:title" content="Onboarding - DigitalQR">
   <meta name="twitter:description" content="Join DigitalQR - the leading QR menu and product listing solution for restaurants and businesses.">
   <meta name="twitter:image" content="https://www.digitalqr.in/web-app/images/preview.png">
   <meta name="twitter:site" content="@DigitalQR">

   <!-- Favicon -->
   <link rel="shortcut icon" href="https://www.digitalqr.in/web-app/images/favicon.png" type="image/x-icon">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

   <!-- Bootstrap -->
   <link rel="stylesheet" href="{{ asset('onboarding/bootstrap/css/bootstrap.min.css')}}"/>

   <!-- Theme Files -->
   <link rel="stylesheet" href="{{ asset('onboarding/dist/theme/css/color.css')}}" />
   <link rel="stylesheet" href="{{ asset('onboarding/dist/theme/css/theme.css')}}" />
   <link rel="stylesheet" href="{{ asset('onboarding/dist/theme/css/responsive.css')}}" />
   <link rel="stylesheet" href="{{ asset('onboarding/dist/theme/css/animation.css')}}" />

   <!-- Structured Data (Schema.org for better SEO) -->
   <script type="application/ld+json">
   {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "DigitalQR",
      "url": "https://www.digitalqr.in",
      "logo": "https://www.digitalqr.in/web-app/images/logo.png",
      "sameAs": [
         "https://www.facebook.com/digitalqr",
         "https://www.instagram.com/digitalqr",
         "https://twitter.com/DigitalQR"
      ]
   }
   </script>
</head>
<body>
   <div class="comingSoonMain flex-grow-1">
      <header>
         <a href="https://www.digitalqr.in">
            <div class="logo">
               <img src="https://img.freepik.com/premium-vector/qr-code-icon-smartphone-apps-symbol-scanning-encrypted-information-vector_717770-74.jpg" alt="Icon" />DigitMenu<span>.</span>
            </div>
         </a>
         <div class="icons">
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
         </div>
      </header>
      <div class="container d-flex flex-column flex-grow-1 justify-content-center">
         <div class="row w-100 my-5">
            <div class="col-md-5">
               <h1 class="mainHeading">www.digitalqr.in</h1>
               <p class="soonDesc mt-3">
                  DigitalQR.in is transforming the restaurant experience. With QR code-powered digital menus, your customers can easily view, order, and pay – all from their smartphones.
               </p>
               <ul class="checkList list-unstyled">
                  <li><i class="fa-solid fa-circle-check"></i>Easy QR Code Menu Access</li>
                  <li><i class="fa-solid fa-circle-check"></i>Instant Menu Updates</li>
                  <li><i class="fa-solid fa-circle-check"></i>Contactless Ordering & Payment</li>
                  <li><i class="fa-solid fa-circle-check"></i>Affordable Subscription Plans</li>
               </ul>
               <p class="soonDesc highlight mb-3">Don't miss out on the future of dining! <br> Start using our Digital Menu today.</p>
               <h2 class="mainHeading2">Affordable Subscription: <span>₹99/month</span></h2>
            </div>
            <div class="col-md-6 offset-md-1">
               <!-- Form -->
               <form id="steps" method="POST" action="{{ route('vendor.store') }}">
                  @csrf
                  <div id="step1" class="form-inner lightSpeedIn">
                     <div class="input-field">
                        <label><i class="fa-regular fa-user"></i> Business Name <span>*</span></label>
                        <input  type="text" name="name" id="vendor-name" placeholder="Type Vendor Name" />
                     </div>
                     <div class="input-field">
                        <label for="email"><i class="fa-regular fa-envelope"></i> Email Address <span>*</span></label>
                        <input  type="email" name="email" id="vendor-email" placeholder="Type email address" />
                     </div>
                     <div class="input-field">
                        <label for="phone"><i class="fa-solid fa-phone"></i> Contact Number <span>*</span></label>
                        <input  type="text" name="contact_number" id="contact-number" placeholder="Type Contact Number" />
                     </div>

                     <div class="input-field">
                      <label for="password"><i class="fa-solid fa-lock"></i> Password <span>*</span></label>
                      <div style="position: relative;">
                          <input type="password" name="password" id="password" placeholder="Enter Password" />
                          <i class="fa-solid fa-eye" id="togglePassword" 
                             style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                      </div>
                    </div>

                    <div class="input-field">
                        <label><i class="fa-regular fa-user"></i> Owner Name <span>*</span></label>
                        <input  type="text" name="owner_name" id="owner-name" placeholder="Type Owner Name" />
                    </div>

                    <div class="input-field">
                        <label for="address"><i class="fa-solid fa-map-marker-alt"></i> Address <span>*</span></label>
                        <input  type="text" name="address" id="address" placeholder="Type Vendor Address" />
                    </div>

                    <div class="input-field">
                        <label for="math_captcha"><i class="fa-solid fa-calculator"></i> Solve this: <span id="math-question"></span> <span>*</span></label>
                        <input type="number" name="math_captcha" id="math_captcha" placeholder="Enter the answer" />
                    </div>

                  </div>
                  <div class="submit">
                     <button type="submit" id="sub">Submit <span><i class="fa-solid fa-thumbs-up"></i></span></button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- jQuery -->
   <script src="{{ asset('onboarding/dist/lib/jQuery/jquery-3.7.1.min.js')}}"></script>
   <!-- Bootstrap JS -->
   <script src="{{ asset('onboarding/dist/framework/bootstrap/js/bootstrap.min.js')}}"></script>
   <!-- Theme Files -->
   <script src="{{ asset('onboarding/dist/theme/js/custom.js')}}"></script>
   <!-- Toastr CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
   <!-- Toastr JS -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   <style>
   .error-label {
       color: red !important;
   }
</style>

<script>
$(document).ready(function () {
    let num1, num2, correctAnswer;

    // Function to generate a new math question
    function generateMathCaptcha() {
        num1 = Math.floor(Math.random() * 10) + 1; // Random number between 1-10
        num2 = Math.floor(Math.random() * 10) + 1; // Random number between 1-10
        correctAnswer = num1 + num2; // Store correct answer
        $("#math-question").text(`${num1} + ${num2} = ?`);
    }

    // Generate the first captcha question when the page loads
    generateMathCaptcha();

    $('#steps').submit(function (event) {
        event.preventDefault();
        let isValid = true;

        // Get form fields using jQuery
        let $name = $('#vendor-name');
        let $email = $('#vendor-email');
        let $contactNumber = $('#contact-number');
        let $ownerName = $('#owner-name');
        let $address = $('#address');
        let $password = $('#password');
        let $mathCaptcha = $('#math_captcha');

        // Reset error styles before validation
        $('label').not('[for="file"]').removeClass('error-label');

        // Validate Vendor Name
        if ($name.val().trim().length < 3) {
            showError("Vendor Name", $name);
            isValid = false;
        }

        // Validate Email
        let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test($email.val().trim())) {
            showError("Email Address", $email);
            isValid = false;
        }

        // Validate Contact Number
        let phonePattern = /^[0-9]{10,15}$/;
        if (!phonePattern.test($contactNumber.val().trim())) {
            showError("Contact Number", $contactNumber);
            isValid = false;
        }

        // Validate Password
        if ($password.val().trim().length < 6) {
            showError("Password", $password);
            isValid = false;
        }

        // Validate Owner Name
        if ($ownerName.val().trim().length < 3) {
            showError("Owner Name", $ownerName);
            isValid = false;
        }

        // Validate Address
        if ($address.val().trim().length < 5) {
            showError("Address", $address);
            isValid = false;
        }

        // Validate Math CAPTCHA
        if (parseInt($mathCaptcha.val()) !== correctAnswer) {
            showError("Math CAPTCHA", $mathCaptcha);
            toastr.error("Incorrect Math CAPTCHA! Please try again.");
            isValid = false;
            generateMathCaptcha(); // Reset CAPTCHA on failure
        }

        if (isValid) {
            let formData = new FormData(this);
            let $submitButton = $('#sub');

            $submitButton.prop('disabled', true).text('Submitting...');

            $.ajax({
                url: "{{ route('vendor.store') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    if (response.status == 1) {
                        toastr.success(response.message);
                        setTimeout(function () {
                            window.location.href = "https://www.digitalqr.in/vendor/login";
                        }, 300);
                    } else {
                        if (Array.isArray(response.message)) {
                            response.message.forEach(function (error) {
                                toastr.error(error);
                            });
                        } else if (typeof response.message === 'string') {
                            toastr.error(response.message);
                        } else {
                            toastr.error('An unknown error occurred.');
                        }
                    }
                },
                error: function (xhr) {
                    let errorMessage = "An error occurred. Please try again.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    toastr.error(errorMessage, "Error");
                },
                complete: function () {
                    $submitButton.prop('disabled', false).text('Submit');
                }
            });
        }
    });

    function showError(fieldName, $inputField) {
        let $label = $inputField.closest('.input-field').find('label');
        if ($inputField.attr('type') !== 'file') {
            $label.addClass('error-label');
        }
        toastr.error(fieldName + " is required or invalid.");
    }

    // Remove error when the user starts typing again
    $('input').on('input', function () {
        let $label = $(this).closest('.input-field').find('label');
        $label.removeClass('error-label');
    });
});

    document.getElementById("togglePassword").addEventListener("click", function() {
        const passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text"; // Show password
            this.classList.remove("fa-eye");
            this.classList.add("fa-eye-slash"); // Change icon to eye-slash
        } else {
            passwordInput.type = "password"; // Hide password
            this.classList.remove("fa-eye-slash");
            this.classList.add("fa-eye"); // Change icon back to eye
        }
    });
</script>
</body>
</html>