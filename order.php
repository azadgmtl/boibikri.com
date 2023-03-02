<?php

    include 'config.php';

    session_start();

    if(isset($_SESSION['user_id'])){
       $user_id = $_SESSION['user_id'];
    }else{
       $user_id = '';
    };

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
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


     <!-- Order banner Section started from here -->

     <section class="oders">
        <div class="container">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col-lg">
                    <div class="content">
                        <h2>Orders</h2>
                        <h4><a href="home.php">Home</a> <i class="fas fa-angle-right"></i> Orders</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Order banner Section ended here -->



    <!-- Order Placed Section started from here -->
    <section class="order_recieved">
        <div class="container">
            <div class="heading">
                <h2>Your Order</h2>
            </div>
            <div class="row">
                    <?php
                        if($user_id == ''){
                            echo '<p class="empty">please login to see your orders</p>';
                        }else{
                            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
                            $select_orders->execute([$user_id]);
                            if($select_orders->rowCount() > 0){
                                while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                    ?>

                <div class="col-lg-4">
                    <div class="box">
                        <p> order date : <span><?= $fetch_orders['placed_on']; ?></span> </p>
                        <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
                        <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
                        <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
                        <p> Transaction Number : <span><?= $fetch_orders['tran_num']; ?></span> </p>
                        <p> Transaction ID : <span> <?= $fetch_orders['tran_id']; ?> </span> </p>
                        <p> address : <span> <?= $fetch_orders['address']; ?>  </span> </p>
                        <p> payment method : <span>  <?= $fetch_orders['method']; ?>  </span> </p>
                        <p> your orders : <span>  <?= $fetch_orders['total_products']; ?>  </span> </p>
                        <p> total price : <span>৳<?= $fetch_orders['total_price']; ?>/-</span> </p>
                        <p> payment status :  <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span>  </p>
                    </div>
                </div>

                    <?php
                        }
                        }else{
                            echo '<p class="empty">no orders placed yet!</p>';
                        }
                        }
                    ?>
            </div>
        </div>
    </section>
    
    <!-- Order Placed Section ended here -->

    


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