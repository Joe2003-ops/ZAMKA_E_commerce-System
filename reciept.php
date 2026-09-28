<?php
session_start();
error_reporting(0);
// connect to database
include('inc/connect.php');
include('inc/connection.inc.php');
$dbc = db_conn();

include('prod_edit.php');
if (!isset($_SESSION['email'])) {
  echo "<script>
    alert('Login first to access this page');
    location.assign('Login/login.php');
    </script>";
} else {
  $email = $_SESSION['email'];
}

if (isset($_POST['add_to_cart'])) {
  $product_name = $_POST['pname'];
  $product_price = $_POST['price'];
  $product_image = $_POST['product_image'];
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

  <title>ZABKA ELECTRICALS | RECIEPT</title>
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


  <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <!-- Datatables -->

  <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <!-- CUSTOM CSS -->
  <!-- <link href="theme/assets/css/styles.css" rel="stylesheet" media="all"> -->
  <link href="theme/assets/css/prod.css" rel="stylesheet" media="all">
  <link href="theme/assets/css/footer.css" rel="stylesheet" media="all">
  <link rel="stylesheet" href="theme/assets/css/all.css" media="all">
  <link rel="stylesheet" href="theme/assets/css/heros.css" media="all">

  <style type="text/css" media="print">
    @media print {

      .noprint,
      .noprint * {
        display: none !important;
      }
    }
  </style>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="index.html">ZABKA ELECTRICALS</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.php">Home</a></li>
          <li><a class="nav-link scrollto" href="products.php">Products</a></li>
          <li><a class="nav-link scrollto" href="cart.php">Cart</a></li>
          <li><a class="getstarted scrollto" onclick="print()" href="#">Download Reciept</a></li>
          <li><a class="getstarted scrollto" onclick="return confirm('Are you sure you want to sign out?');" href="Login/logout.php">Sign out</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->



  <main id="main" class="mt-5">
    <!-------------------------------FEATURES SECTION--------------------------->
    <section class="cart_container">
      <!-- <a  style="margin-left: 507px;" href="#" onclick="" class="btn btn-primary btn-block mt-5 checkout_btn">PRINT RECIEPT</a> -->
      <div class="shopping_cart" id="shop_cart">
        <h1 style="font-size: 30px;text-align: center;">ZABKA ELECTRICALS</h1>
        <h1 style="font-size: 30px;text-align: center;">-----START OF LEGAL RECIEPT -----</h1>
        <table>
          <thead>
            <th>Product Image</th>
            <th>Product name</th>
            <th>price</th>
            <th>quantity</th>
            <th>Sub Total</th>
          </thead>
          <tbody>
            <?php
            $grand_total = 0;
            $id = "";
            $cart_select = "SELECT * FROM cart where email= '$email'";
            $cart_query = mysqli_query($db, $cart_select);
            if (mysqli_num_rows($cart_query) > 0) {
              while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
            ?>
                <tr>
                  <td><img src="http://localhost/HARD/ADMIN/product_images/<?php echo $fetch_cart['image']; ?>" alt="" height="80"></td>
                  <td><?php echo $fetch_cart['name']; ?></td>
                  <td> KES <?php echo $fetch_cart['price']; ?> /-</td>
                  <td>
                    <form action="" method="post">
                      <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                      <input type="hidden" name="cart_name" value="<?php echo $fetch_cart['name']; ?>">
                      <input disabled type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['qty']; ?>">
                      <!-- <button type="submit" name="update_cart" value="update" class="btn btn-success"><i class="fas fa-edit"></i></button> -->
                      <!-- <input type="submit" name="update_cart" value="update" class="option_btn"> -->
                    </form>
                  </td>
                  <td>
                    Ksh <?php echo $sub_total = $fetch_cart['price'] * $fetch_cart['qty']; ?> /-
                  </td>
                </tr>
            <?php

                $grand_total = $grand_total + $sub_total;
              };
            } else {
              echo '<tr><td style="padding:20px;text-transform:capitalize; "colspan="6">
                       no cart added</td></tr>';
            };
            ?>
            <tr class="table_bottom">
              <td colspan="4">TOTALPAYABLE </td>
              <td style="color: white!important;"> Ksh <?php echo $grand_total; ?> /-</td>
            </tr>

            <?php
            //Consumer Details
            $sql = "SELECT  * FROM customer_payments where email = :email";
            $fetchdatastmt = $dbc->prepare($sql);
            $fetchdatastmt->bindValue(':email', $email);
            $fetchdatastmt->execute();
            while ($row = $fetchdatastmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
              <tr class="table_bottom">
                <td colspan="4">RECIEPT NO </td>
                <td style="color: white!important;"> <?php echo $row['MpesaRefNo']; ?></td>
              </tr>
              <tr class="table_bottom">
                <td colspan="4">PAID AMOUNT </td>
                <td style="color: white!important;"> Ksh <?php echo $row['amount']; ?> /-</td>
              </tr>
              <tr class="table_bottom">
                <td colspan="4">Mobile No </td>
                <td style="color: white!important;"> Ksh <?php echo $row['phone']; ?> /-</td>
              </tr>
              <tr class="table_bottom">
                <td colspan="4">PAYMENT STATUS </td>
                <td style="color: white;ite!important"> <?php echo "FULLY PAID"; ?> </td>
              </tr>
              <tr class="table_bottom">
                <td colspan="4">PAYMENT MODE </td>
                <td style="color: white;ite!important"> <?php echo "M-PESA"; ?> </td>
              </tr>
            <?php } ?>

          </tbody>
        </table>
        <h4 class="mt-5" style="font-size: 30px;text-align: center;">THANK YOY FOR SHOPPING WITH US!!!!</h4>
        <h1 class="mt-5" style="font-size: 30px;text-align: center;">-----END OF LEGAL RECIEPT -----</h1>

      </div>
    </section>



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
  <!-- jQuery -->
  <script src="vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- FastClick -->
  <script src="vendors/fastclick/lib/fastclick.js"></script>
  <!-- NProgress -->
  <script src="vendors/nprogress/nprogress.js"></script>
  <!-- iCheck -->
  <script src="vendors/iCheck/icheck.min.js"></script>
  <!-- Datatables -->
  <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="vendors/jszip/dist/jszip.min.js"></script>
  <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="build/js/custom.min.js"></script>

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