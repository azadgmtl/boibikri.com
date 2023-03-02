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
  $success_msg[] = 'Deleted one user';
  // header('location:admin_user.php');
}
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Font awesome css filee here -->
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Box icon css file here -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- <link rel="stylesheet" href="css/boxicons.min.css"> -->
    <!-- Bootstrap 5 css file here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Custom css file here -->
    <link rel="stylesheet" href="css/admin.css">

</head>
<body>

        <?php include 'admin_header.php'; ?>
        
        <!-- Admin Panel Home page's main content started from here -->

        <div class="home-content">
          <div class="overview-boxes">
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Messages <br> Recieved </div>
                <div class="number">
                  <?php
                      $select_messages = $conn->prepare("SELECT * FROM `message`");
                      $select_messages->execute();
                      $number_of_messages = $select_messages->rowCount()
                  ?>
                </div>
                <div class="indicator">
                  <i class='bx bx-up-arrow-alt'></i>
                  <span class="text"> <?= $number_of_messages; ?> </span>
                </div>
              </div>
              <i class='bx bx-cart-alt cart'></i>
            </div>

            <div class="box">
              <div class="right-side">
                <div class="box-topic">Total <br>  Pendings </div>
                <div class="number">
                  <?php
                      $total_pendings = 0;
                      $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                      $select_pendings->execute(['pending']);
                      if($select_pendings->rowCount() > 0){
                        while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                            $total_pendings += $fetch_pendings['total_price'];
                        }
                      }
                  ?>
                </div>
                
                <div class="indicator">
                  <i class='bx bx-up-arrow-alt'></i>
                  <span class="text"> ৳ <?= $total_pendings; ?>/- </span>
                </div>
              </div>
              <i class='bx bxs-cart-add cart two' ></i>
            </div>

            <div class="box">
              <div class="right-side">
                <div class="box-topic">Completed <br> Payments</div>
                <div class="number">
                    <?php
                        $total_completes = 0;
                        $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                        $select_completes->execute(['completed']);
                        if($select_completes->rowCount() > 0){
                          while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                              $total_completes += $fetch_completes['total_price'];
                          }
                        }
                    ?>
                </div>

                <div class="indicator">
                  <i class='bx bx-up-arrow-alt'></i>
                  <span class="text"> ৳ <?= $total_completes; ?>/- </span>
                </div>
              </div>
              <i class='bx bx-cart cart three' ></i>
            </div>

            <div class="box">
              <div class="right-side">
                <div class="box-topic">Order <br> Placed </div>
                <div class="number">
                  <?php
                      $select_orders = $conn->prepare("SELECT * FROM `orders`");
                      $select_orders->execute();
                      $number_of_orders = $select_orders->rowCount()
                  ?>
                </div>
                <div class="indicator">
                  <i class='bx bx-down-arrow-alt down'></i>
                  <span class="text"><?= $number_of_orders; ?></span>
                </div>
              </div>
              <i class='bx bxs-cart-download cart four' ></i>
            </div>

            <div class="box mt-3">
              <div class="right-side">
                <div class="box-topic">Products <br> Added </div>
                <div class="number">
                  <?php
                      $select_products = $conn->prepare("SELECT * FROM `products`");
                      $select_products->execute();
                      $number_of_products = $select_products->rowCount()
                  ?>
                </div>
                <div class="indicator">
                  <i class='bx bx-down-arrow-alt down'></i>
                  <span class="text"><?= $number_of_products; ?></span>
                </div>
              </div>
              <i class='bx bxs-cart-download cart four' ></i>
            </div>

            <div class="box mt-3">
              <div class="right-side">
                <div class="box-topic">Local User <br> Accounts</div>
                <div class="number">
                  <?php
                    $select_users = $conn->prepare("SELECT * FROM `user`");
                    $select_users->execute();
                    $number_of_users = $select_users->rowCount()
                  ?>
                </div>
                <div class="indicator">
                  <i class='bx bx-down-arrow-alt down'></i>
                  <span class="text"><?= $number_of_users; ?></span>
                </div>
              </div>
              <i class='bx bxs-cart-download cart four' ></i>
            </div>

            <div class="box mt-3">
              <div class="right-side">
                <div class="box-topic">Admin User <br> Accounts</div>
                <div class="number">
                  <?php
                      $select_admins = $conn->prepare("SELECT * FROM `admin_user`");
                      $select_admins->execute();
                      $number_of_admins = $select_admins->rowCount()
                  ?>
                </div>
                <div class="indicator">
                  <i class='bx bx-down-arrow-alt down'></i>
                  <span class="text"><?= $number_of_admins; ?></span>
                </div>
              </div>
              <i class='bx bxs-cart-download cart four' ></i>
            </div>

            <div class="box mt-3">
              <div class="right-side">
                <div class="box-topic">Total <br> Accounts </div>
                <div class="number">
                    <?php
                        $select_users = $conn->prepare("SELECT * FROM `user`");
                        $select_users->execute();
                        $number_of_users = $select_users->rowCount()
                    ?>
                </div>
                <div class="indicator">
                  <i class='bx bx-down-arrow-alt down'></i>
                  <span class="text"><?= $number_of_users; ?></span>
                </div>
              </div>
              <i class='bx bxs-cart-download cart four' ></i>
            </div>

          </div>
    

          <div class="sales-boxes">
            <div class="recent-sales box">
              
              <div class="title">Recent Sales</div>
             
                <?php
                    $select_orders = $conn->prepare("SELECT * FROM `orders`");
                    $select_orders->execute();
                    if($select_orders->rowCount() > 0){
                      while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                ?>

              
              <div class="sales-details">
                
             
                  <ul class="details">
                      <li class="topic">Date</li>
                      <li><a href="#"> <?= $fetch_orders['placed_on']; ?> </a></li>
                     
                  </ul>
                  
                  <ul class="details">
                      <li class="topic">Customer Name</li>
                      <li><a href="#"> <?= $fetch_orders['name']; ?> </a></li>
                     
                  </ul>
                  
                  
                  <ul class="details">
                      <li class="topic">Sales Method</li>
                      <li><a href="#"> <?= $fetch_orders['method']; ?> </a></li>
                  </ul>
                  

                  <ul class="details">
                      <li class="topic">Total</li>
                      <li><a href="#"> ৳ <?php echo $fetch_orders['total_price']; ?>/- </a></li>
                  </ul>
                  
              </div>
              

              <?php
                    }
                  }else{
                    echo '<p class="empty">no orders placed yet!</p>';
                  }
              ?>

               

              <div class="button">
                <a href="#">See All</a>
              </div>
            </div>

            
            
            <div class="top-sales box">
             
              <div class="title">Top Seling Books</div>
              
              <ul class="top-sales-details">
                  <?php
                      $select_orders = $conn->prepare("SELECT * FROM `orders`");
                      $select_orders->execute();
                      if($select_orders->rowCount() > 0){
                        while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                  ?>


                  <li>
                      <a href="#">
                        <!--<img src="images/sunglasses.jpg" alt="">-->
                        <span class="product"> <?= $fetch_orders['total_products']; ?> </span>
                      </a>
                      <span class="price">৳ <?= $fetch_orders['total_price']; ?> /-</span>
                  </li>

                  
                  <?php
                      }
                      }else{
                        echo '<p class="empty">no orders placed yet!</p>';
                      }
                  ?>
              </ul>
              
            </div>
            
            
          </div>

        </div>
      </section>
      
     

      <!-- Admin Panel Home page's main content ended here -->

    <section class="all_user_table">
      <div class="container">
          <table class="table mt-5">
            <thead>
                <tr class="bg-info text-white p-4 fs-4">
                    <th scope="col">ID</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email Name</th>
                    <th scope="col">Remove User</th>
                </tr>
            </thead>
            <tbody>
                  <?php
                      $select_accounts = $conn->prepare("SELECT * FROM `user`");
                      $select_accounts->execute();
                      if($select_accounts->rowCount() > 0){
                        while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
                  ?>

                <tr>
                    <th scope="row"> <?= $fetch_accounts['id']; ?> </th>
                    <td> <span><?= $fetch_accounts['username']; ?> </td>
                    <td> <span><?= $fetch_accounts['email']; ?> </td>
                    <td>
                    <!-- <a href="admin_home.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="user_delete_btn bg-danger fs-5 p-1 text-white rounded-2"><i class='bx bxs-trash'></i> Remove</a> -->

                    <a href="admin_home.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this user?');" class="user_delete_btn bg-danger fs-5 p-1 text-white rounded-2"> <i class='bx bxs-trash'></i> Remove</a>
                    
                    </td>
                </tr>


                <?php
                      }
                    }else{
                      echo '';
                    }
                ?>
              
            </tbody>
        </table>
      </div>
    </section>













    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/admin.js"></script>

    <?php include '../alers.php'; ?>

</body>
</html>