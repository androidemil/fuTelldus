<?php

  require("../lib/base.inc.php");

  
  // Auto login with remember-me cookie
  if (isset($_COOKIE["user_loggedin"])) {
    if (!isset($_GET['msg'])) {
      $_SESSION['fuTelldus_user_loggedin'] = $_COOKIE["user_loggedin"];
      header("Location: ../index.php");
      exit();
    }
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title><?php echo $config['pagetitle']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


  

    <!-- Jquery -->
    <script src="../lib/packages/jquery/jquery-1.9.1.min.js"></script>

    <!-- Bootstrap framework -->
    <script src="../lib/packages/bootstrap/js/bootstrap.min.js"></script>
    <link href="../lib/packages/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../lib/packages/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">


    <link href="css/pagestyle.css" rel="stylesheet">


</head>

<body>
<div class="hidden-phone" style='height: 90px;'></div>
<div class="container">

    


    <form class="form-signin" action="login_exec.php" method="POST">
      <p class="hidden-phone" style='font-size:30px; font-weight: bold; text-align: right; margin-top: -10px;'>
        <img style='float: left; height:30px;' src="../images/logo.png" alt="brand" />
        <?php echo $config['pagetitle']; ?>
      </p>
      <p class="visible-phone" style='font-size:25px; font-weight: bold; text-align: right; margin-top: -10px; margin-left: -20px; margin-right: -20px;'>
        <img style='float: left; height:25px;' src="../images/logo.png" alt="brand" />
        <?php echo $config['pagetitle']; ?>
      </p>
      <div style='height: 30px;'></div>
      
        <?php
          if (isset($_GET['msg'])) {
              if ($_GET['msg'] == 01) echo "<div class='alert alert-error'>Wrong username and/or password</div>";
              if ($_GET['msg'] == 02) echo "<div class='alert alert-info'>You logged out</div>";
              if ($_GET['msg'] == 03) echo "<div class='alert alert-error'>No public sensors active</div>";
          }
        ?>

        
        <input type="text" class="input-block-level" name="mail" placeholder="Email address">
        <input type="password" class="input-block-level" name="password" placeholder="Password">

        <label class="checkbox">
          <input type="checkbox" name="remember" value="1"> Remember me
        </label>

        <div class="pull-right">

            <?php
              $query = "SELECT * FROM ".$db_prefix."sensors WHERE monitoring='1' AND public='1'";
              $result = $mysqli->query($query);
              $numRows = $result->num_rows;

              if ($numRows > 0) {
                echo "<a style='margin-right:10px;' href='../public/'>{$lang['View public sensors']}</a>";
              }
            ?>


            <button class="btn btn-large btn-inverse" type="submit">Sign in</button>
        </div>


        <div style="clear:both;"></div>


        <?php
          // Create a random key to secure the login from this form!
          $_SESSION['secure_fuCRM_loginForm'] = "fuTelldus3sfFwer35tF36¤234%&".time()."254543";
          $hashSecureFormLogin = hash('sha256', $_SESSION['secure_fuTelldus_loginForm']);
          echo "<input type='hidden' name='uniq' value='$hashSecureFormLogin' />";
        ?>
    </form>

</div> <!-- /container -->

</body>
</html>
