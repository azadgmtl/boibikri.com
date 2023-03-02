<?php
    include 'config.php';

    session_start();

    if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    }else{
    $user_id = '';
    header('location:login.php');
    };



    if(isset($_POST['order_btn'])){

        $name = $_POST['name'];
        // $name = filter_var($name, FILTER_SANITIZE_STRING);

        $number = $_POST['number'];
        // $number = filter_var($number, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        // $email = filter_var($email, FILTER_SANITIZE_STRING);

        $method = $_POST['method'];
        // $method = filter_var($method, FILTER_SANITIZE_STRING);

        $trans_num = $_POST['acount_num'];
        // $method = filter_var($method, FILTER_SANITIZE_STRING);

        $trans_id = $_POST['transac_id'];
        // $method = filter_var($method, FILTER_SANITIZE_STRING);
        
        $address =  $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
        // $address = filter_var($address, FILTER_SANITIZE_STRING);
        $total_products = $_POST['total_products'];
        $total_price = $_POST['total_price'];

        $placed_on = date('d-M-Y');
     
        $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $check_cart->execute([$user_id]);
     
        if($check_cart->rowCount() > 0){
     
           $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, tran_num, tran_id, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
           $insert_order->execute([$user_id, $name, $number, $email, $method, $trans_num, $trans_id, $address, $total_products, $total_price, $placed_on]);
     
           $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
           $delete_cart->execute([$user_id]);
     
           $success_msg[] = 'order placed successfully! We will Contact with you evry soon.';
        // header("location:order.php");
        }else{
           $warning_msg[] = 'your cart is empty';
        }
     
    }
     




  
     

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

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


     <!-- Checkout  banner Section started from here -->

     <section class="checkout_banner">
        <div class="container">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col-lg">
                    <div class="content">
                        <h2>Shopping Cart</h2>
                        <h4><a href="home.php">Home</a> <i class="fas fa-angle-right"></i> Chekout</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Checkout banner Section ended here -->



    <!-- Checkout Display order Section started from here -->
    <section class="display_order">
        <div class="container">
            <div class="row">
                    <?php
                        $grand_total = 0;
                        $cart_items[] = '';
                        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                        $select_cart->execute([$user_id]);
                        if($select_cart->rowCount() > 0){
                            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                            $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
                            $total_products = implode($cart_items);
                            $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                    ?>

                <div class="col-lg-4">
                    <div class="box">
                        <p> <?= $fetch_cart['name']; ?> <span>( <?= '$'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?> )</span> </p>
                    </div>
                </div>

                    <?php
                            }
                        }else{
                            echo '<p class="empty">your cart is empty!</p>';
                        }
                    ?>
                    
                 <div class="grand_total"> grand total : <span>৳<?= $grand_total; ?>/-</span> </div>
            </div>
        </div>
    </section>

    <!-- Checkout Display order Section ended here -->




    <!-- Checkout Form Section Started from here -->
    <section class="checkout_form">
        <div class="container">
            <h2 class="heading">Confirm Your Order</h2>

            <form action="" method="post">
                    <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                    <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
            <div class="forms">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">Your Name:</label>
                            <input type="text" name="name" placeholder="enter your name" class="box" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">Your Mobile Number:</label>
                            <input type="number" name="number" placeholder="enter your number" class="box" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">Your Email:</label>
                            <input type="text" name="email" placeholder="enter your email" class="box" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">Payment Method:</label>
                            <select name="method">
                                <option value="cash on delivery">cash on delivery</option>
                                <option value="bkash">Bkash</option>
                                <option value="nogod">Nogod</option>
                                <option value="rocket">Rocket</option>
                                <!-- <option value="paytm">Upay</option> -->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">Bkas/Nogod/Rocket Number</label>
                            <input type="number" min="0" name="acount_num" required placeholder="enter your transacted number" class="box" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">Transaction ID</label>
                            <input type="text" name="transac_id" required placeholder="enter transaction id" class="box" required>
                        </div>
                    </div>
                </div>

                
                <!-- <div class="row">
                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">Flat No:</label>
                            <input type="number" min="0" name="flat" required placeholder="e.g. flat no." class="box" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">Road No:</label>
                            <input type="text" name="street" required placeholder="e.g. street name" class="box" required>
                        </div>
                    </div>
                </div> -->
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">Area Name:</label>
                            <select name="city">
                                <option value="Chawkbazar">Chawkbazar</option>
                                <option value=">A.K Khan">A.K Khan</option>
                                <option value="Patenga">Patenga</option>
                                <option value="Khulshi">Khulshi</option>
                                <option value="Agrabad">Agrabad</option>
                                <option value="New Market">New Market</option>
                                <option value="Zamal Khan">Zamal Khan</option>
                                <option value="Mirpur">Mirpur</option>
                                <option value="Gulshan">Gulshan</option>
                                <option value="Banglabazar">Banglabazar</option>
                                <option value="Banani">Banani</option>
                                <option value="Eidhgah">Eidhgah</option>
                                <option value="Cox'sbazar Sadar">Cox'sbazar Sadar</option>
                                <option value="Ramu">Ramu</option>
                                <option value="Ramu">Ramu</option>
                                <option value="Teknaf">Teknaf</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">District Name:</label>
                            <select name="state" >
                                <option value="Dhaka">Dhaka</option>
                                <option value="Chattogram">Chattogram</option>
                                <option value="Cox'sBazar">Cox'sBazar</option>
                                <option value="Noakhali">Noakhali</option>
                                <option value="Feni">Feni</option>
                                <option value="Barishal">Barishal</option>
                                <option value="Cumilla">Cumilla</option>
                                <option value="Pabna">Pabna</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">Country Name:</label>
                            <input type="text" name="country" placeholder="enter your name" class="box" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="input_box">
                            <label for="">Country Code:</label>
                            <input type="number" min="0" name="pin_code" required placeholder="e.g. +880" class="box" required>
                        </div>
                    </div>
                </div>

                    <input type="submit" value="order now" name="order_btn" class="order_btn">

            </div>
            </form>


        </div>
    </section>


    <!-- Checkout Form Section ended here -->


    
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