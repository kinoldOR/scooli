<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">



   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">bookus.</a>

         <nav class="navbar">
            <a class="kodf2" href="home.php">خانه</a>
            <a class="kodf2" href="about.php">درباره ما</a>
            <a class="kodf2" href="shop.php">فروشگاه</a>
            <a class="kodf2" href="contact.php">ارتباط با ما</a>
            <a class="kodf2" href="orders.php">سفارشات</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="user-box">
            <p>نام کاربری : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>ایمیل : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">خروج</a>
         </div>
      </div>
   </div>

</header>