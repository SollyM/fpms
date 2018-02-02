<?php 

session_start();

include_once "../inc/systeminfo.inc.php";

if (isset($_SESSION['username'])) {
  header("location:{$baseUrl}/dashboard/");
}

require_once '../classes/classes.php';
include_once '../inc/config.inc.php';

$bodyClassAdditional = " login-page";
require_once "../inc/header-inner.inc.php";


?>



<div class="login-box">
  <div class="login-logo">
    <?php echo $sysLogoLong; ?>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="login.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="myusername" id="myusername" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="mypassword" id="mypassword" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <!--label>
              <input type="checkbox" disabled> Remember Me
            </label-->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" id="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <div id="message" class="col-xs-12"></div>
        <!-- /.col -->
      </div>
    </form>

    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
    <!-- /.social-auth-links -->

    <!-- <a href="#">I forgot my password</a><br>
    <a href="#" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>





<style>
.main-footer {
    visibility: hidden !important;
}
</style>

<?php
require_once "../inc/footer.inc.php" ?>

<script>
    $(document).ready(function () {
    "use strict";
    $("#submit").click(function () {
        console.log("Submitted");
        var username = $("#myusername").val(), password = $("#mypassword").val();

        if ((username === "") || (password === "")) {
            $("#message").html("<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Please enter a username and a password</div>");
        } else {
          console.log("Username and Password passed check-point");
            $.ajax({
                type: "POST",
                url: "doLogin.php",
                data: "myusername=" + username + "&mypassword=" + password,
                dataType: 'JSON',
                success: function (html) {
                    console.log(html.response + ' ' + html.username);
                    if (html.response === 'true') {
                       location.assign("../dashboard");
                       //location.reload();
                       // return html.username;
                    } else {
                      console.log(html.response);
                        $("#message").html(html.response);
                    }
                },
                error: function (textStatus, errorThrown) {
                    console.log(textStatus);
                    console.log(errorThrown);
                },
                beforeSend: function () {
                    $("#message").html("<p class='text-center'><img src='../images/ajax-loader.gif'></p>");
                }
            });
        }
        return false;
    });
});
</script>