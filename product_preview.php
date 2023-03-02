<?php

include 'config.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};



if(isset($_POST['add_cart'])){

    $id = create_unique_id();
    $product_id = $_POST['product_id'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $wr_name = $_POST['writer_name'];
    $wr_name = filter_var($wr_name, FILTER_SANITIZE_STRING);

    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);

    $image = $_POST['image'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);

    
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
 
    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND pid = ?");
    $verify_cart->execute([$user_id, $product_id]);
 
    $max_cart_limit = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $max_cart_limit->execute([$user_id]);
 
    if($verify_cart->rowCount() > 0){
       $warning_msg[] = 'Already added to cart!';
    }elseif($max_cart_limit->rowCount() == 10){
       $warning_msg[] = 'Cart is full!';
    }else{
 
       $select_p = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
       $select_p->execute([$product_id]);
       $fetch_p = $select_p->fetch(PDO::FETCH_ASSOC);
 
       $total_stock = ($fetch_p['stock'] - $qty);
 
       if($qty > $fetch_p['stock']){
          $warning_msg[] = 'Only '.$fetch_p['stock'].' stock is left';
       }else{
          $insert_cart = $conn->prepare("INSERT INTO `cart`(id, user_id, pid, name, writer_name, price, quantity, image) VALUES(?,?,?,?,?,?,?,?)");
          $insert_cart->execute([$id, $user_id, $product_id, $name, $wr_name, $price, $qty, $image]);
 
          $update_stock = $conn->prepare("UPDATE `products` SET stock = ? WHERE id = ?");
          $update_stock->execute([$total_stock, $product_id]);
          $success_msg[] = 'Added to cart!';


          
 
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
    <title>Product Preview</title>
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






    <!-- Product Review Started from here -->
    <section class="preview_products">
        <h2 class="text-center text-primary mt-3 mb-5">Products Preview</h2>
        <div class="container">
            <div class="row">
                    <!-- <?php
                        // $select_products = $conn->prepare("SELECT * FROM `products`");
                        // $select_products->execute();
                        // if($select_products->rowCount() > 0){
                        //      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){         
                    ?> -->

                    <?php
                        $pid = $_GET['pid'];
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
                        $select_products->execute([$pid]);
                        if($select_products->rowCount() > 0){
                        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                    ?>

            <div class="col-lg-12">
                <form class="preview_box" action="" method="post" class="box <?php if($fetch_product['stock'] == 0){echo 'disabled';}; ?> ">

                    <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">

                    <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">

                    <input type="hidden" name="writer_name" value="<?= $fetch_product['writer_name']; ?>">

                    <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">

                    <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">

                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col-lg-6">
                            <div class="preview_image">
                                <img src="uploaded_img/<?= $fetch_product['image']; ?>" alt="">

                                    
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="preview_content">
                                <span class="book_name"><?= $fetch_product['name']; ?></span>
                                <h3 class="writer_name"><?= $fetch_product['writer_name']; ?></h3>
                                <h5 class="discount"> <del>৳<?= $fetch_product['price']; ?></del> ৳<?= $fetch_product['discounted_price']; ?></h5>

                                <?php if($fetch_product['stock'] > 9){ ?>
                                        <p class="stock  text-success fs-5 m-3"><i class="fas fa-check"></i> in stock</p>
                                    <?php }elseif($fetch_product['stock'] == 0){ ?>

                                        <p class="stock  text-danger fs-5 m-3"><i class="fas fa-times"></i> out of stock</p>
                                    <?php }else{ ?>

                                        <p class="stock  text-primary fs-5 m-3" >hurry, only <?= $fetch_product['stock']; ?> left</p>
                                    <?php } ?>


                                <p class="description"><?= $fetch_product['description']; ?></p>

                                <input type="number" min="1" name="qty" max="99" maxlength="2" placeholder="enter quantity" class="qty" required>

                                <?php if($fetch_product['stock'] != 0){ ?>
                                    
                                        <input type="submit" value="Add to cart" class="add_cart_btn" name="add_cart">
                                        
                                <?php }; ?>

                                
                                <a href="home.php" class="back_home">Back to home</a>
                            </div> 
                        </div>
                    </div>
                </form>


            </div>
            
<!-- 
                <?php
                    //     }
                    // }else{
                    //     echo '<p class="empty">no products added yet!</p>';
                    // }
                ?> -->

                    <?php
                        }
                    }else{
                        echo '<p class="empty">no products added yet!</p>';
                    }
                    ?>

            </div>
        </div>
    </section>


    <!-- Product Review ended  here -->








    
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