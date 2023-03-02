<?php

    include '../config.php';
  
    session_start();


    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id))
    {
       header('location:admin_login.php');
    }



if(isset($_POST['add_books'])){

    $name = $_POST['name'];
    $wr_name = $_POST['writer_name'];
    $price = $_POST['price'];
    $disc_price = $_POST['discounted_price'];
    $stock = $_POST['stock'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image;
    $description = $_POST['description'];


    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if($select_products->rowCount() > 0){
        $message[] = 'product name already exist!';
    }else{

        $insert_products = $conn->prepare("INSERT INTO `products`(name, writer_name, price, discounted_price, stock, image, description) VALUES(?,?,?,?,?,?,?)");
        $insert_products->execute([$name, $wr_name, $price, $disc_price, $stock , $image, $description]);

        if($insert_products){
            if($image_size > 2000000){
                $warning_msg[] = 'Image size is too large!';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'This book has been added!';
            }
        }
    }  
}








if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink("../uploaded_img/".$fetch_delete_image['image']);

    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    // $success_msg[] = 'This book is removed';
    header('location:admin_product.php');
 }
 
 



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Product</title>
    <!-- Font awesome css filee here -->
    <!-- <link rel="stylesheet" href="css/fontawesome.min.css"> -->
    <!-- <link rel="stylesheet" href="css/fontawesome.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Box icon css file here -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <!-- Bootstrap 5 css file here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Custom css file here -->
    <link rel="stylesheet" href="css/admin.css">

</head>
<body>

    <!-- Header starts -->
    <?php include 'admin_header.php'; ?>
    <!-- Header ends--  -->

    <!-- Add Books started from here-->
<section id="add_product" class="mb-5">
  <div class="mask d-flex align-items-center h-100">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center mt-5 h-100">
        <div class="col-12 col-lg-9 col-lg-7 col-md-6">
          <div class="card mt-5" style="border-radius: 15px; background-color: #fafafa">
            <div class="card-body mt-5 p-5">
              <h2 class="text-capatilize text-center heading">Add Products</h2>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-outline mb-5">
                        <input type="text" name="name" class="form-control form-control-lg"  placeholder="enter book name" required>
                    </div>

                    <div class="form-outline mb-5">
                        <input type="text" name="writer_name" class="form-control form-control-lg"  placeholder="enter book writer name" required>
                    </div>

                    <div class="form-outline mb-5">
                        <input type="number"  min="0" name="price" class="form-control form-control-lg"  placeholder="enter book price" required>
                    </div>

                    <div class="form-outline mb-5">
                        <input type="number"  min="0" name="discounted_price" class="form-control form-control-lg"  placeholder="enter discounted price" required>
                    </div>

                    <div class="form-outline mb-5">
                        <input type="number"  min="0" name="stock" class="form-control form-control-lg"  placeholder="enter stock number" required>
                    </div>

                    <div class="form-outline mb-5">
                        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="form-control form-control-lg" required>
                    </div>

                    
                    <div class="form-outline mb-5">
                        <textarea name="description" id="" cols="30" rows="10" class="form-control form-control-lg" placeholder="enter books description" ></textarea>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" name="add_books" class="btn btn-block btn-lg vw-100">Add Books </button>
                    </div>
                </form>

                

            </div>
            
          </div>

          
        </div>
      </div>
    </div>
  </div>
</section>
    <!-- Add Books ended here -->





    <!-- Showing Books Started fromr here -->

    <section class="show-products">
        <div class="container">
            <div class="row">
                <?php
                    $select_products = $conn->prepare("SELECT * FROM `products`");
                    $select_products->execute();
                    if($select_products->rowCount() > 0){
                        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
                ?>

                <div class="col-lg-4 mb-3">
                    <div class="box">
                        <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="" class="img-fluid">
                        <div class="name"><?= $fetch_products['name']; ?></div>
                        <h3 class="text-primary"> <?= $fetch_products['writer_name']; ?> </h3>
                        <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
                        <a href="admin_product.php?update=<?= $fetch_products['id']; ?>" class="up_btn bg-success"> Edit </a>

                        <a href="admin_product.php?delete=<?= $fetch_products['id']; ?>" class="delete_btn bg-danger" onclick="return confirm('delete this product?');">Delete</a>
                    </div> 
                </div>

                <?php
                        }
                    }else{
                        echo '<p class="empty">no products added yet!</p>';
                    }
                ?>
            </div>
        </div>
    </section>

    <!-- Showing Books ended here -->

    


    <!-- update form of product  starts-->

   

<!-- <section class="edit-product-form">

    <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
            
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_p_id" value=" <?= $fetch_products['id']; ?> ">

            <input type="hidden" name="update_old_image" value="<?= $fetch_products['image']; ?>">

            <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="" class="img-fluid">

            <input type="text" name="update_name" value="<?= $fetch_products['name']; ?>" class="box" required placeholder="enter book name">

            <input type="text" name="update_wr_name" value="<?= $fetch_products['writer_name']; ?>" class="box" required placeholder="enter writer name">

            <input type="number" name="update_price" value="<?= $fetch_products['price']; ?>" min="0" class="box" required placeholder="enter product price">

            <input type="number" name="discounted_price" value="<?= $fetch_products['discounted_price']; ?>" min="0" class="box" required placeholder="enter discounted price">

            <input type="number" name="stock" value="<?= $fetch_products['stock']; ?>" min="0" class="box" required placeholder="enter stock product">

            <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
            <input type="text" name="description" value="<?= $fetch_products['description']; ?>" min="0" class="box" required placeholder="enter discounted price">

            <input type="submit" value="update" name="update_product" class="update_btn">
            <input type="reset" value="cancel" id="close-update" class="canel_btn">
        </form>

        <?php
         }
      }else{
         echo '<p class="empty">no product found!</p>';
      }
   ?>

</section>  -->



   
    <!-- update form of product  ends-->





    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/admin.js"></script>

    <?php include '../alers.php'; ?>
</body>
</html>