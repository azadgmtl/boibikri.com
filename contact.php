<?php

    include 'config.php';

    session_start();

    if(isset($_SESSION['user_id'])){
       $user_id = $_SESSION['user_id'];
    }else{
       $user_id = '';
    };
    

    if(isset($_POST['send_message'])){

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $number = $_POST['number'];
        $number = filter_var($number, FILTER_SANITIZE_STRING);

        $msg = $_POST['message'];
        $msg = filter_var($msg, FILTER_SANITIZE_STRING);
     
        $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
        $select_message->execute([$name, $email, $number, $msg]);
     
        if($select_message->rowCount() > 0){
           $info_msg[] = 'already sent message!';
        }else{
     
           $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
           $insert_message->execute([$user_id, $name, $email, $number, $msg]);
     
           $success_msg[] = 'Your message has sent successfully!';
     
        }
     
    }
     

    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

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


     <!-- Contact Us banner Section started from here -->

     <section class="contact_us">
        <div class="container">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col-lg">
                    <div class="content">
                        <h2>Contact Us</h2>
                        <h4><a href="home.php">Home</a> <i class="fas fa-angle-right"></i> Products</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us banner Section ended here -->



    <!-- Contact Us form Section Started from here -->
    <section class="contact_from">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto">
                    <form action="" method="post">
                        <h3>Wanna say something?</h3>
                        <input type="text" name="name" required placeholder="enter your name" class="box">
                        <input type="email" name="email" required placeholder="enter your email" class="box">
                        <input type="number" name="number" required placeholder="enter your number" class="box">
                        <textarea name="message" class="box" placeholder="enter your message" id="" cols="30" rows="10"></textarea>
                        <input type="submit" value="send message" name="send_message" class="sen_btn">
                    </form>
                </div>
            </div>
        </div>
    </section>


    <!-- Contact Us form Section ended here -->















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