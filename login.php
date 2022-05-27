<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');

      }

   }else{
      $message[] = 'رمز یا ایمیل کاربری اشتباه است';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ورود</title>




   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">


</head>
<body dir="rtl">

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div   class="message">
         <span class="erorfa">'.$message.'</span>
         <i  class="erorfa" class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container" >

   <form action="" method="post">
      <h3 class="fatext">فروم ورود</h3>
      <h5 class="fatextbig">برای دیدن وب سایت حتما وارد شوید.</h5>
      <input  type="email" name="email" placeholder="ایمیل کاربری" required class="box">
      <input  type="password" name="password" placeholder="رمز کاربری" required class="box">
      <input  type="submit" name="submit" value="ورود" class="btn">
      <p class="fatext">حساب کاربری نداری؟ <a class="fatextbl" href="register.php">همین الان ثبت نام کن</a></p>
   </form>

</div>

</body>
</html>