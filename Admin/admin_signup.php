<?php 

include '../config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}


if(isset($_POST['submit'])){

    $name = $_POST['username'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['password']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['rpassword']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
 
    $select_admin = $conn->prepare("SELECT * FROM `admin_user` WHERE name = ?");
    $select_admin->execute([$name]);
 
    if($select_admin->rowCount() > 0){
       $info_msg[] = 'username already exist!';
    }else{
       if($pass != $cpass){
          $error_msg[] = 'confirm password not matched!';
       }else{
          $insert_admin = $conn->prepare("INSERT INTO `admin_user`(name, password) VALUES(?,?)");
          $insert_admin->execute([$name, $cpass]);
          $success_msg[] = 'Signed up successfully!';
        header("location:admin_login.php");
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
    <title>Admin Sign Up</title>
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
                    <input type="text" name="username" class="form-control form-control-lg" placeholder="enter your username" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>

                <!-- <div class="form-outline mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg"  placeholder="enter your email"/>
                </div> -->

                <div class="form-outline mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg"  placeholder="enter your password"maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label">Repeat password</label>
                    <input type="password" name="rpassword" class="form-control form-control-lg"  placeholder="repeat your username" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
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
                            <button type="submit" name="submit" class="btn btn-block btn-lg vw-100 bg-primary text-white">Sign Up</button>
                        </div>

                <p class="text-center text-muted mt-4">Have already an account? <a href="admin_login.php" class="fw-bold">Login here </a></p>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>