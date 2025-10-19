@php
    $version = time();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>
    <!-- Favicon with dynamic versioning -->
    <link rel="icon" type="image/jpg" href="{{ asset('admin/img/digital-qr.jpg') }}?v={{ $version }}">
    
    <!-- Custom fonts for this template -->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}?v={{ $version }}" rel="stylesheet" type="text/css">
    <!-- Google Fonts - DM Sans (external, so no versioning needed) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}?v={{ $version }}" rel="stylesheet">
    
    <style>
        body {
            font-family: 'DM Sans', sans-serif !important;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .bg-login-image {
            /* Dynamic versioning for background image */
            background: url('{{ asset('admin/img/login-bg.jpg') }}?v={{ $version }}') center/cover no-repeat;
        }
        .captcha-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .captcha-box span {
            font-size: 18px;
            font-weight: bold;
            width: 100px;
        }
        .refresh-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #007bff;
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container login-container">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Log in to DigitalQR</h1>
                                </div>

                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <form class="user" method="POST" action="{{ route('vendor.login.submit') }}" onsubmit="return validateCaptcha()">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email"
                                            placeholder="Enter Email Address..." required>
                                    </div>
                                    <div class="form-group position-relative">
                                        <input type="password" class="form-control form-control-user" name="password" id="password"
                                            placeholder="Password" required>
                                        <span class="position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;" onclick="togglePassword()">
                                            <i id="toggleIcon" class="fas fa-eye"></i>
                                        </span>
                                    </div>

                                    <!-- Dynamic Math Captcha with Refresh Button -->
                                    <div class="form-group captcha-box">
                                        <span id="captchaQuestion">5 + 4 = </span>
                                        <input type="text" class="form-control form-control-user" id="captchaInput" placeholder="Enter answer" required>
                                        <button type="button" class="refresh-btn" onclick="generateCaptcha()">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>

                                <!-- Back to Main Button -->
                                <a href="/" class="btn btn-secondary btn-user btn-block mt-3">Back to Main</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

    <!-- Bootstrap core JavaScript with dynamic versioning -->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}?v={{ $version }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}?v={{ $version }}"></script>

    <!-- Core plugin JavaScript with dynamic versioning -->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}?v={{ $version }}"></script>

    <!-- Custom scripts for all pages with dynamic versioning -->
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}?v={{ $version }}"></script>
    
    <script>
        let correctAnswer = 9; // Default correct answer

        function generateCaptcha() {
            let num1 = Math.floor(Math.random() * 10) + 1;
            let num2 = Math.floor(Math.random() * 10) + 1;
            correctAnswer = num1 + num2;
            document.getElementById("captchaQuestion").textContent = `${num1} + ${num2} = `;
            document.getElementById("captchaInput").value = ""; // Clear input field
        }

        function validateCaptcha() {
            let captchaAnswer = document.getElementById("captchaInput").value;
            if (parseInt(captchaAnswer) !== correctAnswer) {
                alert("Captcha incorrect! Please enter the correct answer.");
                return false;
            }
            return true;
        }

        function togglePassword() {
            let passwordInput = document.getElementById("password");
            let toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }

        // Generate a random CAPTCHA on page load
        window.onload = generateCaptcha;
    </script>
</body>
</html>
