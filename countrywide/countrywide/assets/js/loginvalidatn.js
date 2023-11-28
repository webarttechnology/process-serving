$(document).ready(function () {

    var eflag=0;//chk on load======================
    var pattern1 = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var email = $('#email').val();
    var validemail = pattern1.test(email);
    if (!validemail) {
        $('#email_err').html('invalid email');
        eflag=1;
    }
    else {
        $('#email_err').html('');
        eflag=0;
    }
    var pflag=checkpass();
    if(eflag==0 && pflag==0)
    {
      $('#submit').css('background-image','linear-gradient(144deg,#AF40FF, #5B42F3 50%,#00DDEB)');
      $('#submit').prop('disabled', false);
    }
    else
    {
      $('#submit').css('background-image','');
      $('#submit').css('background-color','#CECECE');
      $('#submit').prop('disabled', true);
    }//chk on load=============================
  
    $('#email').on('input', function () {
        var eflag=checkemail();
        var pflag=checkpass();
        // console.log(eflag);
        // console.log(pflag);
        if(eflag==0 && pflag==0)
        {
          $('#submit').css('background-image','linear-gradient(144deg,#AF40FF, #5B42F3 50%,#00DDEB)');
          $('#submit').prop('disabled', false);
        }
        else
        {
          $('#submit').css('background-image','');
          $('#submit').css('background-color','#CECECE');
          $('#submit').prop('disabled', true);
        }
    });
  
    $('#pass').on('input', function () {
        var pflag=checkpass();
        var eflag=checkemail();
        // console.log(eflag);
        // console.log(pflag);
        if(eflag==0 && pflag==0)
        {
          $('#submit').css('background-image','linear-gradient(144deg,#AF40FF, #5B42F3 50%,#00DDEB)');
          $('#submit').prop('disabled', false);
        }
        else
        {
          $('#submit').css('background-image','');
          $('#submit').css('background-color','#CECECE');
          $('#submit').prop('disabled', true);
        }
    });
  
  
  //   $('#submitbtn').click(function () {
  //       if (!checkuser() && !checkemail() && !checkmobile() && !checkpass() && !checkcpass()) {
  //           console.log("er1");
  //           $("#message").html(`<div class="alert alert-warning">Please fill all required field</div>`);
  //       } else if (!checkuser() || !checkemail() || !checkmobile() || !checkpass() || !checkcpass()) {
  //           $("#message").html(`<div class="alert alert-warning">Please fill all required field</div>`);
  //           console.log("er");
  //       }
  //       else {
  //           console.log("ok");
  //           $("#message").html("");
  //           var form = $('#myform')[0];
  //           var data = new FormData(form);
  //           $.ajax({
  //               type: "POST",
  //               url: "process.php",
  //               data: data,
  //               processData: false,
  //               contentType: false,
  //               cache: false,
  //               async: false,
  //               beforeSend: function () {
  //                   $('#submitbtn').html('<i class="fa-solid fa-spinner fa-spin"></i>');
  //                   $('#submitbtn').attr("disabled", true);
  //                   $('#submitbtn').css({ "border-radius": "50%" });
  //               },
  //               success: function (data) {
  //                   $('#message').html(data);
  //               },
  //               complete: function () {
  //                   setTimeout(function () {
  //                       $('#myform').trigger("reset");
  //                       $('#submitbtn').html('Submit');
  //                       $('#submitbtn').attr("disabled", false);
  //                       $('#submitbtn').css({ "border-radius": "4px" });
  //                   }, 50000);
  //               }
  //           });
  //       }
  //   });
  });
  
  
  
  
  
  function checkemail() {
      var pattern1 = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      var email = $('#email').val();
      var validemail = pattern1.test(email);
      if (email == "") {
          $('#email_err').html('required field');
          return 1;
      } else if (!validemail) {
          $('#email_err').html('invalid email');
          return 1;
      } else {
          $('#email_err').html('');
          return 0;
      }
  }
  
  function checkpass() {
      var pattern2 = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,15}$/;
      var pass = $('#pass').val();
      var validpass = pattern2.test(pass);
      if (pass == "") {
          //$('#password_err').html('password can not be empty');
          return 1;
      }
      // else if (!validpass) {
      //     $('#password_err').html('Minimum 5 and upto 15 characters, at least one uppercase letter, one lowercase letter, one number and one special character:');
      //     return 1;
      // }
      else {
          $('#password_err').html("");
          return 0;
      }
  }
  
  // function checkcpass() {
  //     var pass = $('#password').val();
  //     var cpass = $('#cpassword').val();
  //     if (cpass == "") {
  //         $('#cpassword_err').html('confirm password cannot be empty');
  //         return false;
  //     } else if (pass !== cpass) {
  //         $('#cpassword_err').html('confirm password did not match');
  //         return false;
  //     } else {
  //         $('#cpassword_err').html('');
  //         return true;
  //     }
  // }
  
  // function password_show_hide() {
  //     console.log('ok');
  //     var x = document.getElementById("password");
  //     var show_eye = document.getElementById("show_eye");
  //     var hide_eye = document.getElementById("hide_eye");
  //     hide_eye.classList.remove("d-none");
  //     if (x.type === "password") {
  //         x.type = "text";
  //         show_eye.style.display = "none";
  //         hide_eye.style.display = "block";
  //     } else {
  //         x.type = "password";
  //         show_eye.style.display = "block";
  //         hide_eye.style.display = "none";
  //     }
  // }