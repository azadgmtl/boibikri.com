
        <?php
            $select_profile = $conn->prepare("SELECT * FROM `admin_user` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>



<!-- =================== Side bar section started from here =================== -->

<section class="sidebar">
    <div class="logo-details">
        <a class="logo_name" href="admin_home.php"> <i class='bx bxs-book'></i>Bikri.com </a>
    </div>

    <ul class="nav-links">
        <li>
            <a href="admin_home.php" class="active">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboad</span>
            </a>
        </li>

        <li>
            <a href="admin_product.php">
                <i  class='bx bx-box'></i>
                <span class="links_name">Products</span>
            </a>
        </li>

        <!-- <li class="nav-item dropdown">
            <a class="nav-link  text-white" href="admin_product.php" id="navbarDropdown"  data-bs-toggle="dropdown" > <i  class='bx bx-box'></i> <span class="links_name">Categories</span> <i class="fas fa-angle-right dropdown"></i></a>

            <ul class="dropdown-menu" >

                <li><a  href="#" class=" nav-link">All Categories</a></li>
                
                <li><a href="admin_islamic.php" class="nav-link ">Islamic</a></li>

                <li><a href="admin_fiction.php" class="nav-link ">Fiction</a></li>

                <li><a class=" nav-link " href="admin_novel.php">Bangla Novels </a></li>


            </ul>
        </li> -->

        <li>
            <a href="admin_order.php">
                <i  class='bx bx-list-ul'></i>
                <span class="links_name">Order list</span>
            </a>
        </li>

        <li>
            <a href="admin_user.php">
                <i  class='bx bx-pie-chart-alt-2'></i>
                <span class="links_name">Users</span>
            </a>
        </li>

            <!-- <li>
                <a href="">
                    <i  class='bx bx-coin-stack'></i>
                    <span class="links_name">Stock</span>
                </a>
            </li> -->
            <!-- <li>
                <a href="">
                    <i  class='bx bx-book-alt'></i>
                    <span class="links_name">Total order</span>
                </a>
            </li> -->

        <li>
            <a href="admin_team.php">
                <i  class='bx bx-user'></i>
                <span class="links_name">Team</span>
            </a>
        </li>

        <li>
            <a href="admin_contact.php">
                <i  class='bx bx-message'></i>
                <span class="links_name">Messages</span>
            </a>
        </li>
            <!-- <li>
                <a href="">
                    <i class='bx bx-heart'></i>
                    <span class="links_name">Favrorites</span>
                </a>
            </li> -->
        <li>
            <a href="#">
                <i  class='bx bx-cog'></i>
                <span class="links_name">Setting</span>
            </a>
        </li>

        <li>
            <a href="admin_logout.php">
                <i  class='bx bx-log-out'></i>
                <span class="links_name">Log out</span>
            </a>
        </li>

        <li class="logged_in">
            <p>You're now logged in as:
                <span> <?= $fetch_profile['name']; ?> </span>
            </p>
        </li>
    </ul>
</section>



     <!-- =================== Side bar section started from here =================== -->


<section class="home-section">
        <!-- ========== Top navbar section started from here ==========-->


    <nav>
        <div class="sidebar-button">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="dashboard">Dashboard</span>
        </div>
        <div class="search-box">
            <input type="text" placeholder="Search...">
            <i class='bx bx-search' ></i>
        </div>

        <div class="profile-details"> 
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <i class="fas fa-user-circle"></i> </a>


                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                    <li>Username: <span class="text-primary"> <?= $fetch_profile['name']; ?> </span></li>

                  
                    <hr class="dropdown-divider">

                    <li><a class="dropdown-item nav-link p-2 rounded-2" href="admin_logout.php">Log Out <i class="fa-solid fa-right-from-bracket"></i> </a></li>

                </ul>
            </li>
           
        </div>
    </nav>

    

        <!-- ========== Top navbar section ended here ==========-->
    
      


        
    
      











</body>
</html>