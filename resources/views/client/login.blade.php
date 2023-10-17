<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Process Serving</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <h4>Hello! Legal CRM</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            @if (null != session('error'))
                                <div class="alert alert-danger fade show pe-5" role="alert">
                                    <span class="badge rounded-pill badge-danger shadow-100">Error</span>
                                    &nbsp; {{ session('error') }}
                                </div>
                            @endif
                            @if (null != session('success'))
                                <div class="alert alert-success  fade show pe-5" role="alert">
                                    <span class="badge rounded-pill badge-success shadow-100">Success</span>
                                    &nbsp; {{ session('success') }}
                                </div>
                            @endif
                            @if (null != session('warning'))
                                <div class="alert alert-warning fade show pe-5" role="alert">
                                    <span class="badge rounded-pill badge-warning shadow-100">Warning</span>
                                    {{ session('warning') }}
                                </div>
                            @endif
                            <form class="pt-3" method="POST" action="{{ @url('auth') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg"
                                        placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        placeholder="Password" required>
                                </div>
                                <div class="mt-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN
                                        IN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('/js/off-canvas.js') }}"></script>
    <script src="{{ asset('/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('/js/template.js') }}"></script>
    <script src="{{ asset('/js/settings.js') }}"></script>
    <script src="{{ asset('/js/todolist.js') }}"></script>
    <!-- endinject -->
</body>

</html>
