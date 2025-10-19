<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('pageTitle', 'Digital QR || Dashboard')</title>
    <link rel="icon" type="image/jpg" href="{{ asset('admin/img/digital-qr.jpg') }}">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template -->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    <!-- Google Fonts - DM Sans -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
     body {
        font-family: 'DM Sans', sans-serif !important;
     }
     .change-my-email{
        padding: 5px;
        font-size: 13px;
        color: blue;
        cursor: pointer;
     }
    </style>
    <style>
        /* Ensure DataTable is 100% width */
        #dataTable {
            width: 100% !important; 
        }
        
        /* Prevent the table from overflowing */
        .dataTables_wrapper {
            width: 100% !important;
        }
        
        /*table.dataTable thead th, table.dataTable thead td {
            padding: 10px 18px;
            /* Remove the border-bottom property */
            border-bottom: none;
        }

        table.dataTable thead th:hover, table.dataTable thead td:hover,
        table.dataTable thead th:focus, table.dataTable thead td:focus {
            /* Ensure no border-bottom on hover or focus */
            border-bottom: none;
        }*/


        /* Apply responsive styles */
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>
<body id="page-top">
    @php

    @endphp

    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('vendor.dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="bi bi-qr-code-scan"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Digital QR <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('vendor.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Menu -->
            <li class="nav-item {{ request()->routeIs('vendor.menus', 'vendor.menus.create', 'vendor.menus.clone', 'vendor.menu.setup') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="bi bi-bag"></i>
                    <span>Menu</span>
                </a>
                <div id="collapseTwo" class="collapse {{ request()->routeIs('vendor.menus', 'vendor.menus.create', 'vendor.menus.clone', 'vendor.menu.setup') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ request()->routeIs('vendor.menus') ? 'active' : '' }}" href="{{ route('vendor.menus') }}">QR Menu</a>
                        <a class="collapse-item {{ request()->routeIs('vendor.menus.create') ? 'active' : '' }}" href="{{ route('vendor.menus.create') }}">Create New QR Menu</a>
                        <a class="collapse-item {{ request()->routeIs('vendor.menus.clone') ? 'active' : '' }}" href="{{ route('vendor.menus.clone') }}">Clone Existing Menu</a>
                        <a class="collapse-item {{ request()->routeIs('vendor.menu.setup') ? 'active' : '' }}" href="{{ route('vendor.menu.setup') }}">Menu Setup</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Categories -->
            <li class="nav-item {{ request()->routeIs('vendor.categories.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories"
                    aria-expanded="true" aria-controls="collapseCategories">
                    <i class="bi bi-tags"></i>
                    <span>Categories</span>
                </a>
                <div id="collapseCategories" class="collapse {{ request()->routeIs('vendor.categories.*') ? 'show' : '' }}" aria-labelledby="headingCategories" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ request()->routeIs('vendor.categories.index') ? 'active' : '' }}" href="{{ route('vendor.categories.index') }}">QR Menu Categories</a>
                        <a class="collapse-item {{ request()->routeIs('vendor.categories.create') ? 'active' : '' }}" href="{{ route('vendor.categories.create') }}">Create QR Categories</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('vendor.dining-orders.index') }}">
                    <i class="bi bi-basket3"></i>
                    <span>Dining Orders</span></a>
            </li>


            <!-- Nav Item - QR Code -->
            <li class="nav-item {{ request()->routeIs('vendor.settings.qrcodecustomize') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('vendor.settings.qrcodecustomize') }}">
                    <i class="bi bi-qr-code-scan"></i>
                    <span>QR Code</span></a>
            </li>
            
             <!-- Nav Item - Ticket ( Help ) -->
            <li class="nav-item {{ request()->routeIs('vendor.tickets.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('vendor.tickets.index') }}">
                    <i class="bi bi-question-circle"></i>
                    <span>Ticket (Help)</span></a>
            </li>
            
            <!-- Nav Item - Ticket ( Help ) -->
            <li class="nav-item {{ request()->routeIs('vendor.menu-request.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('vendor.menu-request.index') }}">
                    <i class="bi bi-file-arrow-up"></i>
                    <span>Menu Request</span></a>
            </li>
            
             <!-- Nav Item - Invoice -->
            <li class="nav-item {{ request()->routeIs('vendor.invoice.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('vendor.invoice.index') }}">
                    <i class="bi bi-receipt"></i>
                    <span>Invoice</span></a>
            </li>
            

            <!-- Nav Item - Settings -->
            <li class="nav-item {{ request()->routeIs('vendor.settings.index', 'vendor.settings.change-password') ? 'active' : '' }}">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                aria-expanded="true" aria-controls="collapseThree">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
             </a>
             <div id="collapseThree" class="collapse {{ request()->routeIs('vendor.settings.index', 'vendor.settings.change-password') ? 'show' : '' }}" 
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->routeIs('vendor.settings.index') ? 'active' : '' }}" 
                        href="{{ route('vendor.settings.index') }}">Profile</a>
                    <a class="collapse-item {{ request()->routeIs('vendor.settings.socialmedia') ? 'active' : '' }}" 
                        href="{{ route('vendor.settings.socialmedia') }}">Social Media</a>
                    <a class="collapse-item {{ request()->routeIs('vendor.settings.change-password') ? 'active' : '' }}" 
                        href="{{ route('vendor.settings.change-password') }}">Change Password</a>
                </div>
             </div>
           </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <a href="{{ route('vendor.logout') }}"><i class="bi bi-lock"></i> Logout</a>
            </div>

        </ul>

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
              
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                             <a class="nav-link" href="javascript:void(0);">
                                <span id="timezone-clock" style="color: #8d8d96;"></span>                             
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>
                       
                        <li class="nav-item  no-arrow mx-1">
                            <a class="nav-link" href="{{ url('/items/' . Auth::user()->code) }}"  
                                 aria-haspopup="true" target="_blank">
                                <i class="bi bi-globe2" style="font-size:20px;"></i>
                            </a>
                        </li>
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-bell-fill" style="font-size:20px;"></i>

                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">
                                    {{ $unreadNotifications->count() > 0 ? $unreadNotifications->count() . '+' : '0' }}
                                </span>
                            </a>

                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>

                                @forelse($unreadNotifications as $notification)
                                    <a class="dropdown-item d-flex align-items-center" href="{{ $notification->url ?? '#' }}" data-id="{{ $notification->id }}">
                                        <div class="mr-3">
                                            <div class="icon-circle 
                                                @if($notification->type == 'order') bg-primary
                                                @elseif($notification->type == 'payment') bg-success
                                                @elseif($notification->type == 'system') bg-dark
                                                @elseif($notification->type == 'account') bg-info
                                                @elseif($notification->type == 'feedback') bg-warning
                                                @elseif($notification->type == 'contact_us') bg-secondary
                                                @endif">
                                                <i class="bi bi-bell text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">{{ \Carbon\Carbon::parse($notification->created_at)->format('M d, Y') }}</div>
                                            <span class="font-weight-bold">{{ $notification->title }}</span>
                                            <p class="mb-0">{{ Str::limit($notification->message, 50) }}</p>
                                        </div>
                                    </a>
                                @empty
                                    <a class="dropdown-item text-center small text-gray-500">No new notifications</a>
                                @endforelse

                                <a class="dropdown-item text-center small text-gray-500" href="{{ route('vendor.notifications.index') }}">Show All Alerts</a>
                            </div>
                        </li>



                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    @if(Auth::check())
                                     {{ Auth::user()->name }}
                                    @endif
                               </span>
                                <i class="bi bi-person-circle" style="font-size: 25px;"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#update-profile" type="button">
                                   <i class="bi bi-person"></i>
                                    Profile
                                </a>
                                
                             
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="{{ route('vendor.logout') }}">
                                   <i class="bi bi-lock"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!--Begin::Content-->
                   @yield('content')
                <!--End::Content-->

            </div>
            <!-- End of Main Content -->

            <div class="modal fade" id="update-profile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Edit Profile</h5>
                            <!-- Changed btn-close to close and added styling -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if(Auth::check())
                            <form id="update-profile-form" action="{{ route('vendor.setting.update-profile') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="contact_number" name="contact_number" value="{{ Auth::user()->contact_number }}" />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <span class="change-my-email">Change Email</span>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" readonly />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="owner_name" class="form-label">Owner Name</label>
                                        <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ Auth::user()->owner_name }}" />
                                    </div>
                                    <!-- Commented password fields remain unchanged -->
                                    <!-- <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password </label>
                                        <input type="password" class="form-control" id="password" name="password"/>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="confirm_password" class="form-label">Confirm Password </label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"/>
                                    </div> -->
                                </div>
                            </form>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-info" type="submit" form="update-profile-form" id="update-profile-form-submit-btn"><i class="bi bi-floppy"></i> Update</button>
                            <button class="btn btn-primary" type="button" data-dismiss="modal">Close</button>
                        </div>
                    </div>
    </div>
            </div>
            
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; digitalqr.in 2025-2026</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('admin/js/sb-admin-2.min.js')}}"></script>
    <script src="{{ asset('admin/js/custom-ckeditor.js')}}"></script>
    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
        }

        $(document).ready(function() {
            $('#update-profile-form').submit(function(e) {
                e.preventDefault();

                var isValid = true;

                if ($(this).find("#name").val() == '') {
                    toastr.error("Please enter name");
                    isValid = false;
                }
                if ($(this).find("#contact_number").val() == '') {
                    toastr.error("Please enter Contact Number");
                    isValid = false;
                }
                if ($(this).find("#email").val() == '') {
                    toastr.error("Please enter email");
                    isValid = false;
                }
                if ($(this).find("#owner_name").val() == '') {
                    toastr.error("Please enter owner name");
                    isValid = false;
                }
                /*if ($(this).find("#password").val() != '' && $(this).find("#confirm_password").val() == '') {
                    toastr.error("Please enter confirm password");
                    isValid = false;
                }
                if ($(this).find("#password").val() != '' && $(this).find("#confirm_password").val() != '' && $(this).find("#password").val() != $(this).find("#confirm_password").val()) {
                    toastr.error("Password and confirm password not matching");
                    isValid = false;
                }*/

                if (isValid) {
                    let formData = new FormData(this);
                    
                    // Disable the submit button and show spinner
                    let submitButton = $('#update-profile-form-submit-btn');
                    submitButton.prop('disabled', true);
                    submitButton.html('<i class="bi bi-hourglass-split spin"></i> Updating...');

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.status == 1) {
                                toastr.success(response.message);
                                setTimeout(function () {
                                    window.location.reload();
                                }, 300);
                            } else {
                                $.each(response.message, function(index, error) {
                                    toastr.error(error);
                                });
                            }
                            
                            // Re-enable button and reset text
                            submitButton.prop('disabled', false);
                            submitButton.html('<i class="bi bi-floppy"></i> Update');
                        },
                        error: function(xhr, status, error) {
                            toastr.error('An error occurred: ' + error);
                            
                            // Re-enable button and reset text
                            submitButton.prop('disabled', false);
                            submitButton.html('<i class="bi bi-floppy"></i> Update');
                        }
                    });
                }
            });
            $(".change-my-email").on("click", function(){
                $(this).parent().find("#email").prop("readonly", function(_, val) {
                    return !val;
                });
                
                // if($(this).parent().find("#email").hasClass("readonly")){
                //     $(this).parent().find("#email").removeAttr("readonly").removeClass("readonly");
                // }else{
                //     $(this).parent().find("#email").attr("readonly").addClass("readonly");
                // }
            });
        });
    </script>
    <script>
        function updateClock() {
            // let timezone = "Asia/Kolkata";
            let timezone = "{{ session('time_zone') }}";
            let now = new Date();
            let options = { timeZone: timezone, hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
            let timeString = new Intl.DateTimeFormat('en-US', options).format(now);
            document.getElementById('timezone-clock').textContent = timeString;
        }
        setInterval(updateClock, 1000); // Update every second
        updateClock(); // Initial call
    </script>
    @stack('scripts')
</body>
</html>
