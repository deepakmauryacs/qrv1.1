@extends('default')
@section('title', 'Privacy Policy - Digital QR')
@section('content')
<style>
    .terms-para {
        font-size: 18px !important;
        color: #fffff8 !important;
    }
    .fullPara h2 {
        color: #fffff8 !important;
        font-size: 20px !important;
        font-weight: bold !important;
    }
    .fullPara p {
        margin-bottom: 20px !important;;
    }
    .fullPara ul li strong {
        color: #fffff8 !important;
    }
</style>

<section class="herobannersect">
    <div class="container">
        <div class="herob-wrap">
            <h1>Privacy Policy</h1>
        </div>
    </div>
</section>

<section class="screens-sect digitalMenu">
    <div class="container">
        <div class="col-md-12">
            <p class="terms-para">
                Welcome to <strong>Digital QR</strong>! We value your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and safeguard your data.
            </p>
            <p class="terms-para">
                By using our services at <a href="https://www.digitalqr.in" target="_blank">https://www.digitalqr.in</a>, you consent to the practices described in this Privacy Policy. Your use of the platform and website is also governed by our Terms and Conditions.
            </p>
        </div>

        <div class="fullPara">
            <h2>1. General Information</h2>
            <p class="terms-para">The personal data collected through <a href="https://www.digitalqr.in" target="_blank">Digital QR</a> is managed by:</p>
            <ul>
                <li><strong>AETHERGRID INNOVATECH PRIVATE LIMITED</strong></li>
                <li><strong>Email:</strong> <a href="mailto:support@digitalqr.in">support@digitalqr.in</a></li>
            </ul>

            <h2>2. Types of Information Collected</h2>
            <p class="terms-para">We collect the following information to enhance your experience:</p>
            <ul>
                <li style="color: white;">First and last name</li>
                <li style="color: white;">Email address</li>
                <li style="color: white;">Phone number</li>
                <li style="color: white;">Address</li>
                <li style="color: white;">IP address</li>
                <li style="color: white;">Payment information (processed securely via third-party platforms)</li>
            </ul>

            <h2>3. Payment Information</h2>
            <p class="terms-para">Payments are processed through secure third-party providers like Razorpay, Stripe, and PayU. We do not store full payment information on our servers.</p>

            <h2>4. Automatic Data Collection</h2>
            <p class="terms-para">We use cookies and tools like Google Analytics to collect non-personal information, including browser type, device details, and usage patterns, to improve our services.</p>

            <h2>5. How We Use Your Information</h2>
            <p class="terms-para">Collected data is used to:</p>
            <ul>
                <li style="color: white;">Provide and maintain our services</li>
                <li style="color: white;">Process payments securely</li>
                <li style="color: white;">Improve customer support</li>
                <li style="color: white;">Detect and prevent fraud</li>
                <li style="color: white;">Comply with legal obligations</li>
            </ul>

            <h2>6. Data Retention</h2>
            <p class="terms-para">We retain your information as long as necessary to provide services and meet legal requirements. You may request deletion of your data at any time by contacting us.</p>

            <h2>7. Your Rights</h2>
            <p class="terms-para">You have rights to access, correct, delete, or restrict the processing of your personal information. Contact us at <a href="mailto:support@digitalqr.in">support@digitalqr.in</a> to exercise your rights.</p>

            <h2>8. Security Measures</h2>
            <p class="terms-para">We employ SSL encryption and other security protocols to protect your data. However, no transmission method over the Internet is 100% secure.</p>

            <h2>9. Third-Party Services</h2>
            <p class="terms-para">We may share data with trusted third parties (e.g., payment processors, analytics providers) but do not sell or rent your personal data.</p>

            <h2>10. Cookies</h2>
            <p class="terms-para">We use cookies to enhance user experience. You can control cookies through your browser settings. Disabling cookies may affect some features of the site.</p>

            <h2>11. Updates to This Policy</h2>
            <p class="terms-para">We may update this Privacy Policy from time to time. Continued use of Digital QR after updates means you accept the new terms.</p>

            <h2>12. Contact Us</h2>
            <p class="terms-para">If you have any questions about this Privacy Policy, reach out to us:</p>
            <ul>
                <li><strong>Email:</strong> <a href="mailto:support@digitalqr.in">support@digitalqr.in</a></li>
                <li><strong>Website:</strong> <a href="https://www.digitalqr.in" target="_blank">www.digitalqr.in</a></li>
            </ul>

            <p><em>Effective Date: February 2025</em></p>
        </div>
    </div>
</section>

<section class="joindigital-sect">
    <div class="container">
        <div class="join-grid">
            <div class="join-left">
                <h2>Ready to Get Started with Digital QR?</h2>
                <div class="btn-action-wrap">
                    <a href="{{ url('vendor/onboarding') }}" class="action-filled">Start for free</a>
                    <a href="{{ url('contact-us') }}" class="action-outline">Contact Us</a>
                </div>
            </div>
            <div class="join-right">
                <img src="{{ asset('qr-app/images/join.svg') }}">
            </div>
        </div>
    </div>
</section>
@endsection
