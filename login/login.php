<?php
session_start();
if(isset($_POST['login'])){

  $password = $_POST['password'];
   if($password === '@RX_TW'){
     $_SESSION['login'] = true; header('LOCATION:../index.php'); die();
   } {
     echo "<div class='alert alert-danger'>PASSWORD WRONG </div>";
   }

 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>𝑳𝑶𝑮𝑰𝑵 ▽</title>
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="shortcut icon" href="assets" />
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<center>
        <div class="wrapper">
    <div class="authentication-lock-screen d-flex align-items-center justify-content-center">
      <div class="card shadow-n
      one bg-transparent">
        <div class="card-body p-md-5 text-center">
          <h2 class="text-white">⸢𝑨𝑹𝑴𝑿 𝑺𝑻𝑨𝑹⸥</h2>
          <h5 class="text-white"><a href="https://t.me/RX_TW">CONTACT :) TO GET PASS</a></h5>
          <div class="">
            <img src="assets" class="mt-5" width="120" alt="" />
          </div> 💳​💸​​💳💸
          <p class="mt-2 text-white">⸢𝑨𝑹𝑴𝑿 𝑺𝑻𝑨𝑹⸥ </p><br>
          <form method="POST" id="signup-form" class="signup-form">
            <div class="form-group">
              <input type="password" class="btn btn-light" name="password" id="password"
                placeholder="Password" />
              <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
            </div></br>

            <div class="form-group">
              <input type="submit" name="login" id="login" class="btn btn-light" value="Sign-In" />
            </div>
          </form>
        </div>
      </div>
    </div>
   </div>
  </div>
 </div>
</div>
</center>
</body>
</html>
