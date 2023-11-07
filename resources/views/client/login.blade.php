<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!----------Custom CSS------------>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <section class="registrsecty loginscty py-5">
        <div class="container">
            <div class="row g-0 align-items-center">
                <div class="col-md-4">
                    <div class="lftprt">
                        <div>
                            <h2>Create your Account</h2>
                            <p>To keep track on your dashboard please login with your personal info.</p>
                            <div class="btnprt mt-4">
                                <a href="https://countrywideprocess.com/new/user-information-register"
                                    class="lgmnbtn">Register</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 text-center">
                    <div class="rghtprt d-flex flex-column justify-content-center">
                        <h2>Login</h2>
                        {{-- <div class="mdlicns mt-4">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-github" aria-hidden="true"></i></a></li>
                            </ul>
                        </div> --}}
                        <!-- <div class="infost mt-4">
                        <ul>
                           <li>User Information <a href="#" class="active">1</a></li>
                           <li>Account Information <a href="#">2</a></li>
                           <li>Payment Information <a href="#">3</a></li>
                        </ul>
                     </div> -->
                        <div class="cform mt-4">
                            <form method="POST" action="{{ @url('auth') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3 material-textfield">
                                            <input type="email" id="email" name="email" placeholder="">
                                            <label for="">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3 material-textfield">
                                            <input type="password" id="password" name="password" placeholder="">
                                            <label for="">Password</label>
                                        </div>
                                    </div>
                                </div>
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
                                <div class="actnbtns mt-5">
                                    <ul>
                                        <li><button type="submit" href="javascript:void(0)"
                                                class="penqbtn">Login</button></li>
                                        <!-- <li><a href="javascript:void(0)" class="penqbtn">Next</a></li> -->
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>

</html>
