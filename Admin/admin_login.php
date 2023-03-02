<?php

include '../config.php';


session_start();

if(isset($_POST['submit'])){

   $name = $_POST['username'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['password']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin_user` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      $success_msg[] = 'Successfully logged in';
      header('location:admin_home.php');
   }else{
      $error_msg[] = 'incorrect username or password!';
   }

}


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!--bootstrap4 library linked-->
  <link rel="stylesheet" href="css/admin.css">

  
</head>
<body>

      <!-- Admin Login Form started from here -->
      <section id="sign_up" class="vh-100 mt-4">
  <div class="mask d-flex align-items-center h-100">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-md-7 col-lg-6">
          <div class="card" style="border-radius: 15px; background-color: #fafafa">
            <div class="card-body p-5">
              <h2 class="text-capatilize text-center mb-4">Login</h2>

              <form action="" method="POST">
                <div class="form-outline mb-4">
                    <label class="form-label">Name</label>
                    <input type="text" name="username" class="form-control form-control-lg"  placeholder="enter your name" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>

                <!-- <div class="form-outline mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg"  placeholder="enter your email"/>
                </div> -->

                <div class="form-outline mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg"  placeholder="enter your password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" name="submit" class="btn btn-block btn-lg vw-100 bg-primary text-white">Login</button>
                </div>

                <p class="text-center text-muted mt-4">Dont't have any account? <a href="admin_signup.php" class="fw-bold text-body">Sign up here </a></p>

                <p class="text-center text-muted mt-4"> <i class="fas fa-angles-left"></i> <a href="../home.php" class="fw-bold">Back to the webpage </a></p>
              </form>

               
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  

    <!-- Admin Login Form ended here -->








 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/admin.js"></script>


    <?php include '../alers.php'; ?>
</body>
</html>