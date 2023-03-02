<?php
    include '../config.php';

    session_start();


    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id))
    {
       header('location:admin_login.php');
    }
   

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our team</title>
    <!-- Box icon css file here -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Font awesome css filee here -->
    <!-- <link rel="stylesheet" href="css/fontawesome.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap 5 css file here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Custom css file here -->
    <link rel="stylesheet" href="css/admin.css">

</head>
<body>

     <!-- Header starts -->
     <?php include 'admin_header.php'; ?>
    <!-- Header ends--  -->


    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/admin.js"></script>
</body>
</html>