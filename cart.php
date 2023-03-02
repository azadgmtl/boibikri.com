<?php

include 'config.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};


if(isset($_POST['update_cart'])){
     $cart_id = $_POST['cart_id'];
      $qty = $_POST['cart_quantity'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);
      $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
      $update_qty->execute([$qty, $cart_id]);
      $success_msg[] = 'cart quantity updated';
}


if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}


if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   $success_msg[] = 'Deleted all cart products';
}






?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cart</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

</head>
<body>
   <!-- Header starts -->
   <?php include 'header.php' ?>
    <!-- Header end -->


     <!-- Shooping Cart banner Section started from here -->

     <section class="shopping_cart_banner">
        <div class="container">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col-lg">
                    <div class="content">
                        <h2>Shopping Cart</h2>
                        <h4><a href="home.php">Home</a> <i class="fas fa-angle-right"></i> Shopping Cart</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shooping Cart banner Section ended here -->




   <!-- Shooping Cart Details banner Section ended here -->
   <section class="shopping_cart">
      <div class="container">
         <div class="heading">
               <h2>Your Cart</h2>
         </div>

         
        
         <table class="table table-hover">
            

            <thead>
               <tr>
                  <!-- <th scope="col">#</th> -->
                  <th scope="col">Book Images</th>
                  <th scope="col">Book Name</th>
                  <th scope="col">Writer Name</th>
                  <th scope="col">Price</th>
                  <th scope="col">Total</th>
               </tr>
            </thead>

            <tbody class="table_body">
                
                  <?php
                     $grand_total = 0;
                     $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                     $select_cart->execute([$user_id]);
                     if($select_cart->rowCount() > 0){
                        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                  ?>

               <tr class="table_row">
                  <th scope="row">
                        <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="" class="mb-3"> <br>
                        <a href="cart.php?delete=<?= $fetch_cart['id']; ?>" class=" text-danger" onclick="return confirm('delete this from cart?');">Remove this book</a>
                  </th>
                  <td> <?= $fetch_cart['name']; ?> </td>
                  <td> <?= $fetch_cart['writer_name']; ?> </td>
                  <td> ৳ <?= $fetch_cart['price']; ?> /- </td>
                  <!-- <td> 
                     <form action="" method="POST">
                        <input type="hidden" name="cart_id" value=" <?= $fetch_cart['id']; ?> ">
                        <input type="number" min="1" name="cart_quantity" value=" <?= $fetch_cart['quantity']; ?> " placeholder="enter quantity" class="cart_quantity">
                        <input type="submit" name="update_cart" value="update" class="update_btn me-3 rounded-2">
                       
                     </form>
                  </td> -->
                  
                  <td>  <span>৳ <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?> /-</span> </td>
               </tr>

                  <?php
                     $grand_total += $sub_total;
                        }
                     }else{
                        echo '<p class="empty">your cart is empty</p>';
                     }
                  ?>
            </tbody>

            
         </table>
        

         <div class="row mt-5">
            <div class="col-lg-12 ">
               <div class="cart_bottom">
                  <div class="sub_total">
                     <h4 sty>Sub Total:  <span>৳ <?= $grand_total; ?> /-</span></h4>
                  </div>

                  <div class="update_checkout">
                     
                     <a href="cart.php?delete_all" class="delet_btn me-3 rounded-2  <?= ($grand_total > 1)?'':'disabled'; ?> " onclick="return confirm('delete all from cart?');">Empty Cart</a>
                     <a href="checkout.php" class="checkout_btn rounded-2 <?= ($grand_total > 1)?'':'disabled'; ?> "> Checkout</a>
                  </div>
               </div>
            </div>
         </div>









      </div>
   </section>


   <!-- <section class="cart_bottom m-auto">
      <div class="container border-dark">
         <div class="row ">
            <div class="col-lg-12">
               <div class="deletr_all_btn">
                  <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all</a>
               </div>
            </div>
         </div>

         <div class="row">
            <div class="col-lg-12">
               <div class="cart_procced">
                  <p>grand total : <span>$<?php echo $grand_total; ?>/-</span></p>
                  <div class="procedd">
                     <a href="shop.php" class="shopping_btn">Return to Shopping</a>
                     <a href="checkout.php" class="procced_btn <?php echo ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section> -->

   <!-- Shopping Cart Details banner Section ended here -->


   


    
     <!-- Footer started from here -->
     <?php include 'footer.php'; ?>
    <!-- Footer ended  here -->

     <!-- Scrolling top Button here-->
     <a href="about.php" class="fas fa-angle-up" id="top_scroll"></a>

   <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   <script src="js/sweetalert.min.js"></script>
   <script src="js/bootstrap.bundle.min.js"></script>
   <script src="js/script.js"></script>

    
    <?php include 'alers.php'; ?>
</body>
</html>