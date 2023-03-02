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
     
        $update_profile_name = $conn->prepare("UPDATE `user` SET username = ? WHERE id = ?");
        $update_profile_name->execute([$name, $user_id]);
     
        $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
        $prev_pass = $_POST['prev_pass'];
        $old_pass = sha1($_POST['opassword']);
        $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
        $new_pass = sha1($_POST['npassword']);
        $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
        $confirm_pass = sha1($_POST['rpassword']);
        $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
     
        if($old_pass == $empty_pass){
           $info_msg[] = 'please enter old password!';
        }elseif($old_pass != $prev_pass){
           $error_msg[] = 'old password not matched!';
        }elseif($new_pass != $confirm_pass){
           $error_msg[] = 'confirm password not matched!';
        }else{
           if($new_pass != $empty_pass){
              $update_admin_pass = $conn->prepare("UPDATE `user` SET password = ? WHERE id = ?");
              $update_admin_pass->execute([$confirm_pass, $user_id]);
              $success_msg[] = 'password updated successfully!';
            header("location:home.php");
           }else{
              $info_msg[] = 'please enter a new password!';
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

                <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">

                <div class="form-outline mb-4">
                    <label class="form-label">Old Password</label>
                    <input type="password" name="opassword" class="form-control form-control-lg"  placeholder="enter your password"/>
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label">New Password</label>
                    <input type="password" name="npassword" class="form-control form-control-lg"  placeholder="enter your password"/>
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label">Repeat password</label>
                    <input type="password" name="rpassword" class="form-control form-control-lg"  placeholder="repeat your username"/>
                </div>

                


                      <div class="form-outline bg-danger rounded-3 mb-4">
                          <?php
                              if(isset($message)){
                                  foreach($message as $message){
                                    echo '
                                      <div class="message">
                                          <span>'.$message.'</span>
                                         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                                      </div>
                                         ';

                                  
                                  }
                            }
                           ?>
                        
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
    <script src="js/script.js"></script>

    
    <?php include 'alers.php'; ?>

</body>
</html>