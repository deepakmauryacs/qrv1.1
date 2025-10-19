@extends('vendor.layouts.default')
@section('pageTitle', 'Digital QR & Dine-In Order Dashboard')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Dashboard Stats Row -->
    <!-- Include Bootstrap Icons (if not already included in your project) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="row">
    

    <!-- Total Menu Items -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Menu Items</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMenuItems }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-card-list text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total QR Scans Today -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            QR Scans Today</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $qrScansToday }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-day text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total QR Scans (All Time) -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Total QR Scans</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalQrScans }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-qr-code text-secondary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Total Feedback -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Total Feedback</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFeedback }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-chat-square-dots text-dark" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row justify-content-center">
    <div class="col-md-4 text-center mb-4">
        <div class="qr-card">
            <div class="qr-header">
                <h4>MENU <span style="font-weight: bold;">QR</span></h4>
            </div>
            <div id="qr-container">
                {!! QrCode::size(180)->generate(url('/items/' . Auth::user()->code)) !!}
            </div>
            <div class="qr-footer">
                <p> Scan to View Menu <br> & Prices</p>
            </div>
        </div>
        <div class="mt-3">
            <a id="downloadBtn" class="btn btn-primary"><i class="bi bi-download"></i> Download QR Code</a>
            <a id="shareBtn" class="btn btn-success" data-toggle="modal" data-target="#shareModal"><i class="bi bi-share"></i> Share QR Code</a>
        </div>
    </div>
    <!-- QR Scan Bar Chart -->
    <div class="col-md-8 mb-4">
        <div class="card shadow p-3">
            <h5 class="text-center">QR Code Scans (Sunday - Monday)</h5>
            <div style="height: 300px;">
              <canvas id="qrScanBarChart"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share Your QR Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Share this QR Code with others:</p>
                
                <div class="d-flex justify-content-center flex-wrap">
                    <a href="#" id="whatsappShare" class="btn btn-success mr-2 mt-2">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                    <a href="#" id="facebookShare" class="btn btn-primary mr-2 mt-2">
                        <i class="bi bi-facebook"></i> Facebook
                    </a>
                    <a href="#" id="twitterShare" class="btn btn-info mr-2 mt-2">
                        <i class="bi bi-twitter"></i> Twitter
                    </a>
                    <a href="#" id="linkedinShare" class="btn btn-secondary mr-2 mt-2">
                        <i class="bi bi-linkedin"></i> LinkedIn
                    </a>
                    <a type="button" onclick="copyToClipboard()" class="btn btn-dark mt-2">
                        <i class="bi bi-clipboard"></i> Copy Link
                    </a>
                </div>
                <div class="mt-3">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .qr-card {
        width: 100%;
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
        border: 2px solid #000;
        position: relative;
        overflow: hidden;
    }

    .qr-header {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .qr-footer {
        font-size: 18px;
        font-style: italic;
        font-family: 'Courier New', Courier, monospace;
        margin-top: 10px;
    }

    .qr-card p {
        margin: 0;
        font-weight: bold;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let qrSvg = document.getElementById('qr-container').querySelector('svg');
        let qrUrl = "{{ url('/items/' . Auth::user()->code) }}";

        // Download QR Code
        document.getElementById('downloadBtn').addEventListener('click', function() {
            let serializer = new XMLSerializer();
            let svgString = serializer.serializeToString(qrSvg);
            let canvas = document.createElement('canvas');
            let ctx = canvas.getContext('2d');

            let img = new Image();
            let svgBlob = new Blob([svgString], {type: 'image/svg+xml;charset=utf-8'});
            let url = URL.createObjectURL(svgBlob);

            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);

                let pngUrl = canvas.toDataURL('image/png');
                let link = document.createElement('a');
                link.href = pngUrl;
                link.download = "qr-code.png";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
            };
            img.src = url;
        });

        // Share Buttons in Modal
        document.getElementById("whatsappShare").href = "https://api.whatsapp.com/send?text=" + encodeURIComponent(qrUrl);
        document.getElementById("facebookShare").href = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(qrUrl);
        document.getElementById("twitterShare").href = "https://twitter.com/intent/tweet?url=" + encodeURIComponent(qrUrl) + "&text=Check%20this%20out!";
        document.getElementById("linkedinShare").href = "https://www.linkedin.com/sharing/share-offsite/?url=" + encodeURIComponent(qrUrl);
    });

    function copyToClipboard() {
        let qrUrl = "{{ url('/items/' . Auth::user()->code) }}";
        navigator.clipboard.writeText(qrUrl).then(() => {
            toastr.success("Link copied to clipboard!");
        }).catch(err => console.log("Error copying link:", err));
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let ctx = document.getElementById('qrScanBarChart').getContext('2d');

        let days = @json($days); // Get days from Laravel controller
        let scanData = @json($scanData); // Get scan counts from Laravel controller

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: days,
                datasets: [{
                    label: "QR Scans",
                    data: scanData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
