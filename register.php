<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'رمز کاربری موجود است';
   }else{
      if($pass != $cpass){
         $message[] = 'رمزها با هم یکی نیستند!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'ثبت نام با موفقیت انجام شد!';
         header('location:login.php');
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ثبت نام</title>




   <!-- فایل سی اس اس اکسترنال  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body dir="rtl">



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span  class="erorfa">'.$message.'</span>
         <i  class="erorfa" class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3 class="fatext">ثبت نام</h3>
      <input type="text" name="name" placeholder="نام کاربر" required class="box">
      <input type="email" name="email" placeholder="ایمیل کاربر" required class="box">
      <input type="password" name="password" placeholder="رمز عبور" required class="box">
      <input type="password" name="cpassword" placeholder="تکرار رمز عبور" required class="box">
      <select name="user_type" class="box">
         <option value="user">کاربر</option>
         <option value="admin">مدیر</option>
      </select>
      <input type="submit" name="submit" value="ثبت نام" class="btn">
      <p class="fatext">حساب کاربری داری؟ <a class="fatextbl" href="login.php">همین الان وارد شو</a></p>
   </form>

</div>

</body>
</html>