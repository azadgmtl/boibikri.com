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
        $name = filter_var($product_id, FILTER_SANITIZE_STRING);

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
    <title>Search</title>
    
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


     <!-- Search Page  banner Section started from here -->

     <section class="search_banner">
        <div class="container">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col-lg">
                    <div class="content">
                        <h2>Search here Cart</h2>
                        <h4><a href="home.php">Home</a> <i class="fas fa-angle-right"></i> Search</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Page banner Section ended here -->



    <!-- Search Page input Box Section started from here -->
    <section class="search_box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form action="" method="post">
                        <input type="text" name="search_box" placeholder="search books..." class="box">
                        <input type="submit" name="search_btn" value="search" class="search_btn">
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Search Page input Box Section ended here -->



    <!-- Search Page Show Searched Result Section started from here -->
    <section class="show_result">
        <div class="container">
            <div class="row">
                        <?php
                            $select_products = $conn->prepare("SELECT * FROM `products`");
                            $select_products->execute();
                            if($select_products->rowCount() > 0){
                                while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){         
                        ?>

                <div class="col-lg-4">
                    <form action="" method="POST" class="box  <?php if($fetch_product['stock'] == 0){echo 'disabled';}; ?>">

                        <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">

                        <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">

                        <input type="hidden" name="writer_name" value="<?= $fetch_product['writer_name']; ?>">
                        
                        <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                        
                        <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">



                        <img src="uploaded_img/<?= $fetch_product['image']; ?>" alt="" class="image">

                        <?php if($fetch_product['stock'] > 9){ ?>
                            <p class="stock text-center text-success fs-5 m-3"><i class="fas fa-check"></i> in stock</p>
                        <?php }elseif($fetch_product['stock'] == 0){ ?>

                            <p class="stock text-center text-danger fs-5 m-3"><i class="fas fa-times"></i> out of stock</p>
                        <?php }else{ ?>

                            <p class="stock text-center text-primary fs-5 m-3" >hurry, only <?= $fetch_product['stock']; ?> left</p>
                        <?php } ?>


                        <div class="name"><?= $fetch_product['name']; ?></div>
                        <p>By</p>
                        <h3 class="text-primary fs-4"> <?= $fetch_product['writer_name']; ?> </h3>
                        <div class="price">৳ <?= $fetch_product['price']; ?> /-</div>
                        <input type="number" name="qty" value="1" min="1" max="99" maxlength="2" required class="qty">
                        <!-- <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>"> -->

                        <?php if($fetch_product['stock'] != 0){ ?>
                            <input type="submit" value="Add to cart" name="add_cart" class="add_cart_btn">
                            
                        <?php }; ?>
                        
                        <a href="product_preview.php?pid=<?= $fetch_product['id']; ?>" class="view_book_btn"> <i class="fa-brands fa-readme"></i> Read Book </a>
                    </form>
                </div>


                        <?php
                                }
                            }else{
                                echo '<p class="empty">no products added yet!</p>';
                            }
                        ?>
                
            </div>
        </div>
    </section>


    <!-- Search Page Show Searched Result Section ended here -->
    





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