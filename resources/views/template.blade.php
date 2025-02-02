<!DOCTYPE html>
<html lang="en">
<>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('Title')</title>
    <link rel="stylesheet" href="{{ asset('skydash/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('skydash/js/select.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/css/vertical-layout-light/style.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/mdi/css/materialdesignicons.min.css') }}">
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include('navbar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        @include($sideBar)
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
                </div>
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://www.themewagon.com/" target="_blank">Themewagon</a></span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{ asset('skydash/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ asset('skydash/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('skydash/js/dataTables.select.min.js') }}"></script>

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('skydash/js/off-canvas.js') }}"></script>
<script src="{{ asset('skydash/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('skydash/js/template.js') }}"></script>
<script src="{{ asset('skydash/js/settings.js') }}"></script>
<script src="{{ asset('skydash/js/todolist.js') }}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset('skydash/js/dashboard.js') }}"></script>
<!-- End custom js for this page-->
</body>

</html>

