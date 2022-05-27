<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'وضعیت پرداخت به روز شد!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>سفارشات</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body dir="rtl">
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">سفارشات ثبت شده</h1>

   <div class="box-container">
      <?php
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p> ای دی کاربر: <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> بر شماره: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> نام: <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> شماره: <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> ایمیل: <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> ادرس: <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> کل محصولات: <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> کل قیمت: <span><?php echo $fetch_orders['total_price']; ?>ریال</span> </p>
         <p> روش پرداخت: <span><?php echo $fetch_orders['method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option value="" غیرفعال><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="pending">در انتظار</option>
               <option value="completed">کامل</option>
            </select>
            <input type="submit" value="update" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('این سفارش حذف شود؟');" class="delete-btn">حذف</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">هیچ سفارشی اضافه نشده</p>';
      }
      ?>
   </div>

</section>










<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>