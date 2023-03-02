<?php
    include '../config.php';
  
    session_start();


    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id))
    {
       header('location:admin_login.php');
    }


    if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");
        $delete_message->execute([$delete_id]);
        $success_msg[] = 'Deleted all messages';
        // header('location:admin_contact.php');
     }


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <!-- Font awesome css filee here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="css/fontawesome.min.css"> -->
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
    



    <!-- user Message satrted from here -->
    <section class="user_message">
        <div class="container">
            <div class="row">
                <div class="heading text-center mb-5">
                    <h1>All Message</h1>
                </div>
                    <?php
                        $select_messages = $conn->prepare("SELECT * FROM `message`");
                        $select_messages->execute();
                        if($select_messages->rowCount() > 0){
                            while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
                    ?>

                <div class="col-lg-4 mb-3">
                    <div class="box">
                        <p> User id : <span><?= $fetch_message['user_id']; ?></span> </p>
                        <p> Name : <span> <?= $fetch_message['name']; ?> </span> </p>
                        <p> Email : <span> <?= $fetch_message['email']; ?> </span> </p>
                        <p> Number : <span> <?= $fetch_message['number']; ?> </span> </p>
                        <p> Message : <span> <?= $fetch_message['message']; ?> </span> </p>
                        <a href="admin_contact.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="message_delete_btn">delete message</a>
                    </div>

                </div>
                <?php
                    };
                    }else{
                        echo '<p class="empty">you have no messages!</p>';
                    }
                ?>
                
            </div>
        </div>
    </section>

    <!-- user Message ended here -->
    










    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/admin.js"></script>

    
    <?php include '../alers.php'; ?>
</body>
</html>