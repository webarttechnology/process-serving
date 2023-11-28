<?php

session_start();

if(isset($_SESSION['invalidlogin']))

  $invalidlogin=$_SESSION['invalidlogin'];

else

  $invalidlogin="";

?>



<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Document</title>

  <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>

  <link href="assets/css/app.css" rel="stylesheet"/>

  <link href="assets/css/login.css" rel="stylesheet"/>

</head>

<body>

  <div class="login_wraper">

      <div class="login__box">

        <div class="row g-0">

            <div class="col-lg-5">

                <div class="loginbox_left">

                  <img class="img-fluid" src='assets/images/countrywide_logonew02.svg' alt='logo_countrywide'>

                </div>

            </div>

            <div class="col-lg-7">

              <form action="dashboard.php" method="post">

                <div class="inset">

                    <div class="login__heading">

                      <h5>Secure Login</h5>

                      <h1>Welcome Back</h1>

                    </div>

                    <span id="invalidlog"><?php echo $invalidlogin; ?></span>

                    <p class="mb-3">

                        <label class="mb-1" for="email">Email Address</label>

                        <span class="log_username"><input type="text" class="form-control" name="email" value="<?php if(isset($_COOKIE['email'])) echo $_COOKIE['uname']; ?>" id="email"></span>

                        <span id="email_err"></span>

                    </p>



                    <p class="mb-2">

                        <label class="mb-1" for="password">Password</label>

                        <span class="log_password"><input type="password" class="form-control" name="pass" value="<?php if(isset($_COOKIE['Pass'])) echo $_COOKIE['pass']; ?>" id="pass"></span>

                        <span id="password_err"></span>

                    </p>



                    <p class="mb-2 d-flex align-items-center">

                        <input type="checkbox" class="form-check-input" name="remember" id="remember" value="rembr" <?php if(isset($_COOKIE['rem'])) echo "checked"; ?>>

                        <label class="lbl-remember" for="remember">Remember me</label>

                    </p>

                    <div class="action mt-4">

                      <input type="submit" class="button-sty01" name="go" id="submit" value="Login" disabled>

                      <a href="">Forgot password ?</a>

                    </div>

                </div>

              </form>

            </div>

        </div>

        <footer class="copyright">

            <p>2022  All Right Received ©Countrywide | v1.0.0</p>

        </footer>

      </div>

  </div>

  <!--end wrapper-->

  <script src="assets/js/jquery.min.js"></script>

  <!-- Bootstrap JS -->

  <script src="assets/js/bootstrap.bundle.min.js"></script>

  </body>

  <?php

  if(isset($_SESSION['invalidlogin']))

  {

    unset($_SESSION['invalidlogin']);

  }

  ?>

  <script src="assets/js/jquery.min.js"></script>

  <script src="assets/js/loginvalidatn.js"></script>

</html>