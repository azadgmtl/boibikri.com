

<!-- Top Header Started from here -->
<section class="top_header bg-light p-2">
    <div class="container d-flex justify-content-around" >
        <div class="col-lg-9">
            <div class="social_icons">
                <a href="#" class="fa-brands fa-facebook-f"></a>
                <a href="#" class="fa-brands fa-twitter"></a>
                <a href="#" class="fa-brands fa-instagram"></a>
                <a href="#" class="fa-brands fa-linkedin-in"></a>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="singup_login mt-2">
                <a href="signup.php"><i class="fas fa-user-plus"></i> <span>Sign Up</span></a>
                <a href="login.php"><i class="fas fa-lock"></i> <span> Login </span> </a>
            </div>
        </div>

    </div>
</section>
<!-- Top Header ended here -->




<!-- Main Header Startd from here -->
<section class="header p-2 shadow-sm">
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold logo" href="home.php" > <i class="fas fa-book"></i> Bikri.com </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon "></span> -->
                    <!-- <i class="fas fa-bars" id="menu_bars"></i> -->
                    <i class="fa-solid fa-bars-staggered text-dark fs-3"></i>
                    <!-- <i class='bx bx-menu-alt-right bg-success text-dark'></i> -->
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="shop.php">Products</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contacts</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="order.php">Orders</a>
                        </li>

                    </ul>

                    <ul class="navbar-nav sm-icons">
                   
                    
                        <li><a class="nav-link" href="search.php"><i class="fas fa-search"></i></a></li>
                            <!-- <?php
                                // $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                                // $cart_rows_number = mysqli_num_rows($select_cart_number); 
                            ?> -->
                                <li class="nav-item dropdown">
                                 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#"> <i class="fas fa-user-circle"></i> </a>
                                    
                                    <?php          
                                        $select_profile = $conn->prepare("SELECT * FROM `user` WHERE id = ?");
                                        $select_profile->execute([$user_id]);
                                        if($select_profile->rowCount() > 0){
                                        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                                    ?>

                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                        <li>Username : <span class="text-primary"> <?= $fetch_profile["username"]; ?> </span></li>

                                        <li>Email : <span class="text-primary"> <?= $fetch_profile["email"]; ?> </span></li>
                                        <hr class="dropdown-divider">

                                        <li><a class="dropdown-item nav-link rounded-2" href="edit_profile.php">Update Profle <i class="fa-solid fa-right-to-bracket"></i></a></li>

                                        <li><a class="dropdown-item nav-link rounded-2" href="logout.php">Log Out  <i class="fa-solid fa-right-from-bracket"></i> </a></li>
                                     </ul>

                                     <?php
                                        }else{
                                        }
                                    ?>

                     
                                </li>

                                <?php
                                    $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                                    $count_cart_items->execute([$user_id]);
                                    $total_cart_counts = $count_cart_items->rowCount();
                                ?>
                        <li><a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span> <?= $total_cart_counts; ?> </a></li>

                        
                    </ul>

                </div>
            </div>
        </nav>
    </div>
</section>
<!-- Main Header ended Here -->