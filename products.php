<?php
session_start();
error_reporting(0);
//connect to database
include('inc/connect.php');

if (!isset($_SESSION['email'])) {
  echo "<script>
    alert('Login first to access this page');
    location.assign('Login/signin.php');
    </script>";
} else {
  $email = $_SESSION['email'];
}

if (isset($_POST['add_to_cart'])) {
  $product_name = $_POST['pname'];
  $product_price = $_POST['price'];
  $product_image = $_POST['pimage'];
  $product_quantity = $_POST['product_quantity'];

  $select_query = "SELECT * FROM cart   where name = '$product_name' AND email = '$email'";
  $result = mysqli_query($db, $select_query);
  $user_cart = mysqli_fetch_assoc($result);
  if ($user_cart) {
    //matched product error definition
    if ($user_cart['name'] === $product_name) {
      echo "<script>
          alert('product already added to cart!');
          </script>";
    }
  } else {
    $insert_query = "INSERT INTO cart (name,price,qty,image,email) 
      VALUES ('$product_name', '$product_price','$product_quantity','$product_image','$email')";
    $query_run = mysqli_query($db, $insert_query);
    $_SESSION['name'] = $usname;
    if ($query_run) {

      echo "<script>
          alert('item added to cart!');
          location.assign('cart.php#shop_cart');
          </script>";
    } else {
      echo "<script>
          alert('Could not insert into the database');
          </script>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ZABKA ELECTRICALS | PRODUCTS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- CUSTOM CSS -->
  <!-- <link href="theme/assets/css/styles.css" rel="stylesheet" media="all"> -->
  <link href="theme/assets/css/prod.css" rel="stylesheet" media="all">
  <link href="theme/assets/css/footer.css" rel="stylesheet" media="all">
  <link rel="stylesheet" href="theme/assets/css/all.css" media="all">
  <link rel="stylesheet" href="theme/assets/css/heros.css" media="all">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="index.html">ZABKA ELECTRICALS</a></h1>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.php">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto active" href="products.php">Products</a></li>
          <li><a class="nav-link scrollto active" href="cart.php">Busket</a></li>
          <li><a class="nav-link scrollto" href="#">Chechout</a></li>
          <li><a class="getstarted scrollto" onclick="return confirm('Are you sure you want to sign out?');" href="Login/logout.php">Sign out</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h5 data-aos="fade-up">At Zabka, we're not just selling appliances — we're helping build smarter, more efficient homes and offices. Thank you for choosing us!</h5>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left" data-aos-delay="200">
          <img src="assets/img/category-2.jpg" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <section class="prodcuts">
          <h3 class="text-primary text-center">Products in Store</h3>
          <div class="box-conatiner">
            <?php
            $select_query = " SELECT * FROM product";
            $select_product = mysqli_query($db, $select_query);
            if (mysqli_num_rows($select_product) > 0) {
              while ($fetch_product = mysqli_fetch_assoc($select_product)) { ?>
                <form action="" method="post" class="box">
                  <img src="/ZABKA/admin/product_images/<?php echo $fetch_product['image']; ?>" alt="">
                  <div class="name" style="color: black!important;font-size: 20px"><b></b> <?php echo $fetch_product['name']; ?> </div>

                  <div class="price" style="color: black!important;font-size: 14px"><b>Price Kes </b> <?php echo $fetch_product['price']; ?> /-</div>

                  <input style="margin: auto; width:50px; height:40px;" placeholder="quantity" type="number" min="1" name="product_quantity" value="1">
                  <input type="hidden" name="pimage" value="<?php echo $fetch_product['image']; ?>">
                  <input type="hidden" name="pname" value="<?php echo $fetch_product['name']; ?>">
                  <input type="hidden" name="qty" value="<?php echo $fetch_product['qty']; ?>">
                  <input type="hidden" name="price" value="<?php echo $fetch_product['price']; ?>">
                  <input type="submit" value="ADD TO BAG" name="add_to_cart" class="cart_btn">
                </form>
            <?php
              }
            } else {
              echo '<tr><td style="padding:20px;text-transform:capitalize; "colspan="6">
            no Products Available</td></tr>';
            };
            ?>
          </div>
        </section>

      </div>
    </section><!-- End Services Section -->
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="row d-flex align-items-center">
        <div class="col-lg-6 text-lg-left text-center">
          <div class="copyright">
            &copy; Copyright <strong>ZABKA ELECTRICALS</strong>. All Rights Reserved
          </div>
        </div>
        <div class="col-lg-6">
          <nav class="footer-links text-lg-right text-center pt-2 pt-lg-0">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Use</a>
          </nav>
        </div>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


  <!-- Main JS File -->
  <script src="theme/assets/js/main.js"></script>
  <script src="theme/assets/css/all.js"></script>

  <script src="js/mainn.js"></script>

</body>

</html>