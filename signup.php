<?php

include 'config.php';


session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['username'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['password']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['rpassword']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `user` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $info_msg[] = 'email already exists!';
   }else{
      if($pass != $cpass){
         $error_msg[] = 'confirm password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `user`(username, email, password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $success_msg[] = 'Successfully signed up. Now login';
        //  header("location:login.php");
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
    <title>Sign Up</title>
    <!-- Boostrtap 5 css here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome css file here -->
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <!-- Custom css file here -->
    <link rel="stylesheet" href="css/style.css">


</head>
<body>

<section id="sign_up" class="vh-100 mt-4">
  <div class="mask d-flex align-items-center h-100">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-lg-7 col-lg-6">
          <div class="card" style="border-radius: 15px; background-color: #fafafa">
            <div class="card-body p-5">
              <h2 class="text-capatilize text-center mb-4">Sign Up</h2>

              <form action="" method="post" enctype="multipart/form-data">
                <div class="form-outline mb-4">
                    <label class="form-label">User name</label>
                    <input type="text" name="username" class="form-control form-control-lg" placeholder="enter your username" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg"  placeholder="enter your email"/>
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg"  placeholder="enter your password"/>
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label">Repeat password</label>
                    <input type="password" name="rpassword" class="form-control form-control-lg"  placeholder="repeat your username"/>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" name="submit"  class="btn btn-block btn-lg vw-100">Sign Up</button>
                </div>

                <p class="text-center text-muted mt-4">Have already an account? <a href="login.php" class="fw-bold">Login here </a></p>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

    <?php include 'alers.php'; ?>
</body>
</html>