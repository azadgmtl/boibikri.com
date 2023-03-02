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
        $delete_user = $conn->prepare("DELETE FROM `user` WHERE id = ?");
        $delete_user->execute([$delete_id]);
        $info_msg[] = 'One user has been removed';
        // header('location:admin_user.php');
     }



?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin User</title>
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


    <!-- user account satrted from here -->
    <section class="user_accounts">
        <div class="container">
            <div class="row">
                <div class="heading text-center">
                    <h1>All Users</h1>
                </div>
                    <?php
                        $select_accounts = $conn->prepare("SELECT * FROM `user`");
                        $select_accounts->execute();
                        if($select_accounts->rowCount() > 0){
                            while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
                    ?>

                <div class="col-lg-4 mb-3">
                    <div class="box">
                        <p> user id : <span> <?= $fetch_accounts['id']; ?> </p>
                        <p> username : <span><?= $fetch_accounts['username']; ?></span> </p>
                        <p> email : <span><?= $fetch_accounts['email']; ?></span> </p>
                        
                        <a href="admin_user.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this user?');" class="user_delete_btn">delete user</a>
                    </div>

                </div>

                    <?php
                            }
                        }else{
                            echo '<p class="empty">no accounts available!</p>';
                        }
                    ?>
                
            </div>
        </div>
    </section>



    <!-- user account ended here -->
    






    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/admin.js"></script>


    <?php include '../alers.php'; ?>
</body>
</html>