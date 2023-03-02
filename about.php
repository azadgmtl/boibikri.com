<?php

include 'config.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';
 };

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/swiper-bundle.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

</head>
<body>
    <!-- Header starts -->
    <?php include 'header.php' ?>
    <!-- Header end -->


    <!-- Bannner section satrted from here -->

    <section class="about_banner">
        <div class="container">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col-lg">
                    <div class="content">
                        <h2>About Us</h2>
                        <h4><a href="home.php">Home</a> <i class="fas fa-angle-right"></i> About Us</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bannner section ended here -->




    <!-- About_us section Started from here -->

    <section class="about_us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="content mt-5">
                        <h4 class="about_heading">About Us</h4>
                        <h2>We are commited to provide you the best books of any writter..</h2>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donecodio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.</p>

                        <p>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. </p>
                    </div>
                   
                </div>

                <div class="col-lg-3 mt-5">
                    <div class="image_one">
                        <img src="images/about_us/about_01.png" alt="">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="image_two_three">
                        <img src="images/about_us/about_02.png" alt="" class="image_1">
                        <img src="images/about_us/about_03.png" alt="" class="image_2">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About_us section ended here -->




    <!-- Our_offer section Started from here -->
    <section class="our_offer">
        <div class="container">
            <div class="image_and_content">
                <div class="row justify-content-center align-items-center g-2">
                
                    <div class="col-lg-6">
                        <div class="image">
                            <img src="images/about_us/discounted.png" alt="">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="content">
                            <span>LIMITED TIME OFFER</span>
                            <h2>45% Discount On All Of Our New & Upcoming Books</h2>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing .  Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper.</p>

                            <a href="order.php" class="order_btn">Order Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our_offer section ended here -->



    <!-- Our Team Member section Started from here here -->

    <section class="our_team">
        <div class="container">
           
            <div class="row mb-5">
                <div class="heading text-center mb-5">
                    <h1>Our Team</h1>
                </div>
                
                <div class="col-lg-4 mb-3">
                    <div class="team_box">
                        <img src="images/Sakib.png" class="img-fluid rounded-top" alt="">
                        <div class="overlay">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <h3>Sakib Hossain</h3>
                        <p>Fron-end Developer</p>
                    </div>
                </div>

                <div class="col-lg-4  mb-3">
                    <div class="team_box">
                        <img src="images/ovijeet.png" class="img-fluid rounded-top" alt="">
                        <div class="overlay">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <h3>Ovijeet</h3>
                        <p>Fron-end Developer</p>
                    </div>
                </div>

                <div class="col-lg-4  mb-3">
                    <div class="team_box">
                        <img src="images/apon.png" class="img-fluid rounded-top" alt="">
                        <div class="overlay">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <h3>Shahedul Islam Apon</h3>
                        <p>Fron-end Developer</p>
                    </div>
                </div>

                <div class="col-lg-4  mb-3">
                    <div class="team_box">
                        <img src="images/ovijeet.png" class="img-fluid rounded-top" alt="">
                        <div class="overlay">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <h3>Mr Shanto</h3>
                        <p>Fron-end Developer</p>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="team_box">
                        <img src="images/apon.png" class="img-fluid rounded-top" alt="">
                        <div class="overlay">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <h3>Saiful Isam Azad</h3>
                        <p>Fron-end Developer</p>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="team_box">
                        <img src="images/apon.png" class="img-fluid rounded-top" alt="">
                        <div class="overlay">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <h3>Pronob Kanti</h3>
                        <p>Fron-end Developer</p>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="team_box">
                        <img src="images/Oishee.png" class="img-fluid rounded-top" alt="">
                        <div class="overlay">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <h3>Oishee Chakraborty</h3>
                        <p>Fron-end Developer</p>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="team_box">
                        <img src="images/Oishee.png" class="img-fluid rounded-top" alt="">
                        <div class="overlay">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <h3>Samiya Chowdhury</h3>
                        <p>Fron-end Developer</p>
                    </div>
                </div>

                <div class="col-lg-4 mb-3">
                    <div class="team_box">
                        <img src="images/jwad.png" class="img-fluid rounded-top" alt="">
                        <div class="overlay">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                        <h3>Shaukat Jawad</h3>
                        <p>Fron-end Developer</p>
                    </div>
                </div>

                
            </div>

        </div>
    </section>

    <!-- Our Team Member section ended here -->
    


    <!-- Footer started from here -->
    <?php include 'footer.php'; ?>
    <!-- Footer ended  here -->


    
     <!-- Scrolling top Button here-->
     <a href="about.php" class="fas fa-angle-up" id="top_scroll"></a>







    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>