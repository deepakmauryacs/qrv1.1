<!DOCTYPE html>
<html lang="en">
<head>
    @php $version = time(); @endphp
    <title>Onboarding - DigitalQR</title>
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('onboarding/images/favicon.png')}}?v={{ $version }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('onboarding/images/favicon.png')}}?v={{ $version }}" type="image/x-icon">
    <!-- Meta Description (Important for SEO) -->
    <meta name="description" content="DigitalQR is a smart, contactless QR menu and product listing solution for restaurants and businesses in India. Enhance customer experience with digital menus.">
    <!-- Keywords (Optional but can help SEO) -->
    <meta name="keywords" content="QR menu, digital menu, restaurant QR, contactless ordering, DigitalQR, product listing">
    <!-- Author (Good for branding) -->
    <meta name="author" content="DigitalQR by AetherGrid Innovatech Pvt Ltd">
    <!-- Robots Tag (Control indexing) -->
    <meta name="robots" content="index, follow">
    <!-- Canonical URL (Avoid duplicate content issues) -->
    <link rel="canonical" href="https://www.digitalqr.in/vendor/onboarding">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Open Graph / Social Media Meta Tags (Important for social sharing) -->
    <meta property="og:title" content="DigitalQR - Smart Contactless QR Menu Solution">
    <meta property="og:description" content="DigitalQR is a smart, contactless QR menu and product listing solution for restaurants and businesses in India.">
    <meta property="og:image" content="{{ asset('onboarding/images/og-image.jpg')}}?v={{ $version }}">
    <meta property="og:url" content="https://www.digitalqr.in/vendor/onboarding">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="DigitalQR">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="DigitalQR - Smart Contactless QR Menu Solution">
    <meta name="twitter:description" content="DigitalQR is a smart, contactless QR menu and product listing solution for restaurants and businesses in India.">
    <meta name="twitter:image" content="{{ asset('onboarding/images/twitter-card.jpg')}}?v={{ $version }}">
    
    <!-- Schema.org Markup (Structured Data) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "DigitalQR",
      "url": "https://www.digitalqr.in",
      "description": "Smart contactless QR menu and product listing solution for restaurants and businesses",
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "Web"
    }
    </script>
    
    <!-- Language Tags -->
    <meta http-equiv="content-language" content="en-IN">
  
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link href="{{ asset('onboarding/css/bootstrap.min.css')}}?v={{ $version }}" rel="stylesheet">
    <script src="{{ asset('onboarding/js/bootstrap.bundle.min.js')}}?v={{ $version }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="{{ asset('onboarding/css/onboarding.css')}}?v={{ $version }}" rel="stylesheet">
    <style>
    	#steps{
    		width: 100%;
    	}
    	#password{
    	  	width: 100%;  
    	}
    </style>
    <!-- Inline CSS for Preloader -->
    <style>
        /* Preloader styles */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000; /* Black background */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* On top of everything */
            transition: opacity 0.5s ease; /* Fade out effect */
        }
        #preloader.hidden {
            opacity: 0;
            pointer-events: none; /* Disable interaction when hidden */
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #333; /* Dark gray for contrast */
            border-top: 5px solid #fff; /* White spinner */
            border-radius: 50%;
            animation: spin 1s linear infinite; /* Spin animation */
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* Hide content initially */
        #content {
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        #content.loaded {
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <figure class="logo">
         <a href="https://www.digitalqr.in"><img src="https://www.digitalqr.in/web-app/images/logo-blue-white.png?v={{ $version }}"></a>
    </figure>
    <div class="onboardContainer">
        <div class="onboard-left">
            <h1>Revolutionizing Dining with QR Code Menus!</h1>
            <p>DigitalQR.in is transforming the restaurant experience. With QR code-powered digital menus, your customers can easily view, order, and pay – all from their smartphones.</p>
            <ul>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 408.576 408.576" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                    Easy QR Code Menu Access
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 408.576 408.576" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                    Instant Menu Updates
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 408.576 408.576" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                    Contactless Ordering & Payment
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 408.576 408.576" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                        <g>
                            <path d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z" fill="#000000" opacity="1" data-original="#000000" class=""></path>
                        </g>
                    </svg>
                    Affordable Subscription Plans
                </li>
            </ul>
            <div class="tagline">Don't miss out on the future of dining! Start using our Digital Menu today.</div>
            <div class="affordable">
                <h3>Affordable Subscription:</h3>
                <h4>₹99/month</h4>
            </div>
        </div>
        <div class="onboard-right">
            <h6>Fill the form to join the Digital QR</h6>
            <form id="steps" method="POST" action="{{ route('vendor.store') }}">
                @csrf
                <div class="login-section">
                    <div class="form-group">
                        <label>Business Name <span>*</span></label>
                        <input type="text" name="name" id="vendor-name" placeholder="Type Business Name" oninput="restrictLength(this, 255)">
                    </div>
                    <div class="form-group">
                        <label>Email Address <span>*</span></label>
                        <input type="email" name="email" id="vendor-email" placeholder="Type email address" oninput="restrictLength(this, 255)">
                    </div>
                    <div class="form-group">
                        <label>Contact Number <span>*</span></label>
                        <input type="text" name="contact_number" id="contact-number" placeholder="Type Contact Number" oninput="restrictLength(this, 15)">
                    </div>
                    <div class="form-group">
                        <label>Password <span>*</span></label>
                        <div style="position: relative;">
                            <input type="password" name="password" id="password" placeholder="Enter Password" oninput="restrictLength(this, 20)">
                            <i class="fa-solid fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;color: black;"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Owner Name <span>*</span></label>
                        <input type="text" name="owner_name" id="owner-name" placeholder="Type Owner Name"  oninput="restrictLength(this, 255)">
                    </div>
                    <div class="form-group">
                        <label>Address <span>*</span></label>
                        <input type="text" name="address" id="address" placeholder="Type Vendor Address" oninput="restrictLength(this, 1000)">
                    </div>
                    <div class="form-group">
                        <label for="math_captcha"><i class="fa-solid fa-calculator"></i> Solve this: <span id="math-question"></span> <span>*</span></label>
                        <input type="number" name="math_captcha" id="math_captcha" placeholder="Enter the answer">
                    </div>
                    <div class="form-group">
                        <button>Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- jQuery -->
   <script src="{{ asset('onboarding/dist/lib/jQuery/jquery-3.7.1.min.js')}}"></script>
   <!-- Toastr CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
   <!-- Toastr JS -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   <script>
    // Preloader logic
    $(window).on('load', function() {
        $('#preloader').addClass('hidden'); // Fade out preloader
        $('#content').addClass('loaded');   // Fade in content
        setTimeout(function() {
            $('#preloader').remove(); // Remove preloader from DOM after fade-out
        }, 500); // Match the CSS transition duration
    });
    $(document).ready(function () {
        
        // Configure Toastr globally to show a close button
        toastr.options = {
            "closeButton": true, // Enable the close button
            "debug": false,
            "newestOnTop": false,
            "progressBar": true, // Optional: Adds a progress bar
            "positionClass": "toast-top-right", // Position of the toast
            "preventDuplicates": false,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000", // Time before auto-close (5 seconds), set to 0 to disable auto-close
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    
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
    // Existing code...
    function restrictLength(input, maxLength) {
        if (input.value.length > maxLength) {
            input.value = input.value.substring(0, maxLength); // Truncate to maxLength
        }
    }
    // Existing code...
    </script>
</body>
</html>