<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'کارتت خالیه';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'سفارش از قبل انجام شده.';
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'سفارش با موفقیت انجام شد.';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
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
   <title>پرداخت</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div dir="rtl"  class="heading">
   <h3 class="kodf">پرداخت</h3>
   <p class="fatext"> <a class="fatext" href="home.php">خانه</a> / پرداخت </p>
</div>

<section dir="rtl" class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo ''.$fetch_cart['price'].'ریال'.' ضرب '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">موجودی کافی نیست</p>';
   }
   ?>
   <div class="grand-total"> کل قیمت : <span><?php echo $grand_total; ?>ریال</span> </div>

</section>

<section dir="rtl" class="checkout">

   <form action="" method="post">
      <h3 class="kodf">مشخصلات و ادرس تحویل گیرنده</h3>
      <div class="flex">
         <div class="inputBox">
            <span class="fatext">نام و نام خانوادگی:</span>
            <input type="text" name="name" required placeholder="علی ممحدی نژاد وند">
         </div>
         <div class="inputBox">
            <span class="fatext">تلفن منزل</span>
            <input type="number" name="number" required placeholder="42490587">
         </div>
         <div class="inputBox">
            <span class="fatext">ادرس ایمیل:</span>
            <input type="email" name="email" required placeholder="S&M@scoolproject.com">
         </div>
         <div class="inputBox">
            <span class="fatext">روش پرداخت :</span>
            <select name="method">
               <option value="cash on delivery">پرداخت درب منزل</option>
               <option value="credit card">درگاه پرداخت</option>

            </select>
         </div>
         <div class="inputBox">
            <span class="fatext">پیش شماره استان</span>
            <input type="number" min="0" name="flat" required placeholder="021">
         </div>
         <div class="inputBox">
            <span class="fatext">ادرس کلی:</span>
            <input type="text" name="street" required placeholder="خیابان محموی کوچه نژادی و..">
         </div>
         <div class="inputBox">
            <span class="fatext">شهر:</span>
            <input type="text" name="city" required placeholder="نجف اباد">
         </div>
         <div class="inputBox">
            <span class="fatext">استان:</span>
            <input type="text" name="state" required placeholder="اصفهان">
         </div>
         <div class="inputBox">
            <span class="fatext">کشور:</span>
            <input type="text" name="country" required placeholder="ما میدونیم ایرانه ولی خب گذاشتیم">
         </div>
         <div class="inputBox">
            <span class="fatext">کد پستی:</span>
            <input type="number" min="0" name="pin_code" required placeholder="بدون خط تیره">
         </div>
      </div>
      <input type="submit" value="نهایی کردن خرید" class="btn" name="order_btn">
   </form>

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>