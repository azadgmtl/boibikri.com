<?php 
    include 'config.php';

    session_start();

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
     }else{
        $user_id = '';
     };
     

    if(isset($_POST['add_cart']))
    {

        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $wr_name = $_POST['writer_name'];
        // $product_quantity = $_POST['product_quantity'];
     
        $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
     
        if(mysqli_num_rows($check_cart_numbers) > 0)
        {
           $message[] = 'already added to cart!';
        }
        else
        {
           mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, writer_name) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$wr_name')") or die('query failed');
           $message[] = 'product added to cart!';
        }
     
     }
     


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/swiper-bundle.css"> 
 <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" /> -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

</head>
<body>
<?php include 'header.php' ?>



    <!-- Read Books section started from here -->
    <section class="products_preview justify-content-center">
                <div class="container">
                    <div class="row">
                    
                     <?php
                        $pid = $_GET['pid'];
                        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
                        $select_products->execute([$pid]);
                        if($select_products->rowCount() > 0){
                           while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
                     ?>

                <div class="col-lg-12">
                    <div class="preview_box">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="img">
                                    <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                                </div>
                            </div>

                            <div class="col-lg-6 mt-5">
                                <div class="details_books">
                                    <h3><?php echo $fetch_products['name']; ?></h3>

                                    <h4>By : <span><?php echo $fetch_products['writer_name']; ?></span></h4>
                                    <div class="ratings">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half"></i>
                                    </div>
                                    <div class="prices">
                                        <span><del class="text-danger fw-bolder">৳<?php echo $fetch_products['discounted_price']; ?>/-</del> </span>
                                        <span> ৳<?php echo $fetch_products['price']; ?>/-</span>
                                    </div>

                                    <p><?php echo $fetch_products['description']; ?></p>

                                    <input type="submit" value="add to cart" name="add_cart" class="add_cart_btn">
                                </div>
                            </div>
                        </div>
                       
                    </div>
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


    <!-- Read Books section ended here -->
















    <!-- Footer started from here -->
    <?php include 'footer.php'; ?>
    <!-- Footer ended  here -->

  
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

    
    <?php include '../alers.php'; ?>
</body>
</html>