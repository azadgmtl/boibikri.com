<?php

include '../config.php';


    session_start();
    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id))
    {
       header('location:admin_login.php');
    }

if(isset($_POST['update_order'])){
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];
    // $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
    $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
    $update_payment->execute([$payment_status, $order_id]);
    $success_msg[] = 'payment status has been updated!';
}    



 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
    $delete_order->execute([$delete_id]);
    $info_msg[] = 'Deleted one order!';
    // header('location:admin_order.php');
 }
 



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Order</title>
    <!-- Font awesome css filee here -->
    <!-- <link rel="stylesheet" href="css/fontawesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Box icon css file here -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Bootstrap 5 css file here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Custom css file here -->
    <link rel="stylesheet" href="css/admin.css">

</head>
<body>

     <!-- Header starts -->
     <?php include 'admin_header.php'; ?>
    <!-- Header ends--  -->


    <!-- Order section started from here -->

    <section class="orders_products">
        <div class="container">
            
            <div class="row">
            <div class="heading text-center">
                <h2>Recieved Oroders</h2>
            </div>
               
                    <?php
                        $select_orders = $conn->prepare("SELECT * FROM `orders`");
                        $select_orders->execute();
                        if($select_orders->rowCount() > 0){
                            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                    ?>

                <div class="col-lg-4 mb-3">
                    <div class="box">
                        <p> user id : <span> <?= $fetch_orders['user_id']; ?> </span> </p>
                        <p> order date : <span> <?= $fetch_orders['placed_on']; ?> </span> </p>
                        <p> name : <span> <?= $fetch_orders['name']; ?> </span> </p>
                        <p> number : <span> <?= $fetch_orders['number']; ?> </span> </p>
                        <p> email : <span> <?= $fetch_orders['email']; ?> </span> </p>
                        <p> address : <span> <?= $fetch_orders['address']; ?> </span> </p>
                        <p> total products : <span> <?= $fetch_orders['total_products']; ?> </span> </p>
                        <p> total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
                        <p> payment method : <span> <?= $fetch_orders['method']; ?> </span> </p>
                        <p> payment method : <span> <?= $fetch_orders['tran_num']; ?> </span> </p>
                        <p> payment method : <span> <?= $fetch_orders['tran_id']; ?> </span> </p>
                        <form action="" method="post">
                            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                            <select name="payment_status">
                                <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                                <option value="pending">pending</option>
                                <option value="completed">completed</option>
                            </select>
                            <input type="submit" value="update" name="update_order" class="order_up_btn">
                            <a href="admin_order.php?delete=<?= $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="order_delete_btn">delete</a>
                        </form>
                    </div>

                </div>

                    <?php
                            }
                        }else{
                            echo '<p class="empty">no orders placed yet!</p>';
                        }
                    ?>

            </div>
        </div>
    </section>


    <!-- Order section ended here -->
    


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/admin.js"></script>

    <?php include '../alers.php'; ?>
</body>
</html>