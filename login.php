<?php

include 'config.php';


session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['password']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `user` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      $success_msg[] = 'incorrect username or password!';
      header('location:home.php');
   }else{
      $warning_msg[] = 'incorrect username or password!';
   }

}


?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Boostrtap 5 css here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome css file here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="css/fontawesome.min.css"> -->
    <!-- Custom css file here -->
    <link rel="stylesheet" href="css/style.css">



</head>
<body>

    <!-- Login started from here -->

<section id="login" class="vh-100 mt-4">
  <div class="mask d-flex align-items-center h-100">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-lg-7 col-lg-6">
          <div class="card" style="border-radius: 15px; background-color: #fafafa">
            <div class="card-body p-5">
              <h2 class="text-capatilize text-center mb-4">Login</h2>

                <form action="" method="post">
                    <div class="form-outline mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg"  placeholder="enter your email"/>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg"  placeholder="enter your password"/>
                    </div>

                    <div class="form-outline bg-danger rounded-3 mb-4">
                          <?php
                              if(isset($error)){
                                  foreach($error as $error){
                                    echo '
                                      <div class="message">
                                          <span>'.$error.'</span>
                                         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                                      </div>
                                         ';

                                  
                                  }
                            }
                           ?>
                        
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" name="submit" class="btn btn-block btn-lg vw-100"> login </button>
                    </div>

                    <p class="text-center text-muted mt-4">Dont't have any account? <a href="signup.php" class="fw-bold text-body">Sign up here </a></p>
                </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


    <!-- Login ended here -->


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>


    
    <?php include 'alers.php'; ?>
    
</body>
</html>
