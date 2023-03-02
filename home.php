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
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/animations.min.css" integrity="sha512-GKHaATMc7acW6/GDGVyBhKV3rST+5rMjokVip0uTikmZHhdqFWC7fGBaq6+lf+DOS5BIO8eK6NcyBYUBCHUBXA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>


   <?php include 'header.php' ?>

   <!-- Home Slider Started from here -->

    <section class="home">
        <div class="swiper home_slider">
            <div class="swiper-wrapper">

                <div class="swiper-slide slide" style="background: url(images/Home_Slider/banner_01.png) no-repeat;">
                    <div class="content">
                        <h2>HAND PICKED BOOK TO YOUR DOOR.</h2>
                        <p>We learned about honesty and integrity - that the truth matters, that you don't take shortcuts or play <br> by your own set of rules and success doesn't count unless you earn it.</p>

                        <div class="slide_btn">
                            <a href="#">view more</a>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide slide" style="background: url(images/Home_Slider/banner_02.jfif) no-repeat;">
                    <div class="content">
                       <h2>Online Education Academy</h2>
                       <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus, unde expedita debitis praesentium dolore sequi eaque possimus. Veniam nemo omnis harum corrupti et, voluptas aliquid</p>
                        <div class="slide_btn">
                            <a href="#">view More</a>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide slide" style="background: url(images/Home_Slider/banner_03.jfif) no-repeat;">
                    <div class="content">
                       <h2>New Published Books are Available</h2>
                       <p>Newly published books famous writer are available in our website. You can easily buy books from us with discountable and reasonale price.
                       </p>
                        <div class="slide_btn">
                            <a href="#">view More</a>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide slide" style="background: url(images/Home_Slider/banner_04.webp) no-repeat;">
                    <div class="content">
                       <h2>HAND PICKED BOOK TO YOUR DOOR</h2>
                       <p>We learned about honesty and integrity - that the truth matters, that you don't take shortcuts or play <br> by your own set of rules and success doesn't count unless you earn it.
                       </p>
                        <div class="slide_btn">
                            <a href="#">view More</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <!-- Home Slider ended here -->





    <!-- Home Products Started from here -->
    <section class="products pb-5 mt-5">
        <div class="container">
            <div class="row justify-content-center align-items-center mt-5 g-2">
                    
                        <?php
                            $select_products = $conn->prepare("SELECT * FROM `products`");
                            $select_products->execute();
                            if($select_products->rowCount() > 0){
                                while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){         
                        ?>

                <div class="col-lg-4">
                    <form action="" method="post" class="box <?php if($fetch_product['stock'] == 0){echo 'disabled';}; ?>">
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


                        <h3 class="name"><?= $fetch_product['name']; ?></h3>
                        <p>By</p>
                        <h3 class="name text fw-bolder text-info fs-4"><?= $fetch_product['writer_name']; ?></h3>

                        
                        <div class="flex">
                            <p class="price"><i class="fas fa-indian-rupee-sign"></i> <?= $fetch_product['price']; ?></p>
                            <input type="number" name="qty" value="1" min="1" max="99" maxlength="2" required class="qty">
                        </div>


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

    <!-- Home Products ended here -->



    <!-- Home Clients review section sarted from here -->
    <!-- <section class="customer_review">
        <h2 class="text-center text-primary fs- mt-3 mb-5">Some review f our customer</h2>
    </section> -->
    <!-- Home Clients review section ended here -->
    

    <!-- Questions started-->
    <section class="questions">
        <div class="container">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col-lg-6">
                    <h3> Do  you wanna know more about us??</h3>
                    <p>Please do contact with us. You can ask anything about us or about our services.</p>
                    <div class="contact_btn">
                        <a href="contact.php" target="_blank">Contact Us</a>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Questions ended-->



    <!-- Footer started from here -->
    <?php include 'footer.php'; ?>
    <!-- Footer ended  here -->

  
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/dist/boxicons.js" integrity="sha512-Dm5UxqUSgNd93XG7eseoOrScyM1BVs65GrwmavP0D0DujOA8mjiBfyj71wmI2VQZKnnZQsSWWsxDKNiQIqk8sQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/script.js"></script>


    <?php include 'alers.php'; ?>
</body>
</html>