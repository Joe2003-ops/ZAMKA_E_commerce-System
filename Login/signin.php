<?php
error_reporting(0);
require '../inc/connection.inc.php';
$db = db_conn();
if (isset($_POST['login'])) {
  try {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //HINT-remove the condion "if" and set cookie by just clicking ligin btn instead of remeber me chkbox
    if (isset($_POST['remember_me'])) {
      setcookie("email", $email, time() + 30 * 24 * 60 * 60);
      setcookie("password", $password, time() + 30 * 24 * 60 * 60);
    }
    // $password_hash = password_hash($password1, PASSWORD_BCRYPT);
    $password_hash = md5($password);
    // Retrieve data
    $Query = "SELECT * FROM users WHERE email = :email AND password = :password";
    $stmt = $db->prepare($Query);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password_hash);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
      $_SESSION['email'] = $email;
      $fetchInfo = $result;
      $name = $fetchInfo['name'];
      $_SESSION['email'] = $fetchInfo['email'];
      $_SESSION['password'] = $fetchInfo['password'];

      echo "<script>
                alert('login successfull');
                location.assign('../products.php');
                </script>";
    } else {
?>
      <script>
        alert("wrong password or email!!!");
      </script>
<?php
    }
  } catch (PDOException $e) {
    $err = "Error: " . $e->getMessage();
    echo '<script>alert("' . $err . '")</script>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Title -->
  <title>DURAPOA</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- Favicon -->
  <!-- <link rel="shortcut icon" href="public/img/favicon.ico"> -->

  <!-- Template -->
  <!-- <link rel="stylesheet" href="public/graindashboard/css/graindashboard.css"> -->
  <link rel="stylesheet" href="../theme/assets/css/graindashboard.css" media="all">
  <link rel="stylesheet" href="../theme/assets/css/all.css" media="all">
  <link href="../theme/assets/css/style.css" rel="stylesheet">
</head>

<body class="">

  <main class="main">

    <div class="content">

      <div class="container-fluid pb-5">

        <div class="row justify-content-md-center">
          <div class="card-wrapper col-12 col-md-4 mt-5">
            <div class="card">
              <div class="card-body">
                <span class="text-center" style="font-weight: 800;font-size:20px">LOGIN</span>
                <form action="" method="post" role="form" id="signup">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" value="<?php if (isset($_COOKIE['email'])) {
                                                            echo $_COOKIE['email'];
                                                          } ?>" class="form-control" name="email" required="">
                  </div>

                  <div class="form-group">
                    <label for="password">Password
                    </label>
                    <input id="password" type="password" value="<?php if (isset($_COOKIE['password'])) {
                                                                  echo $_COOKIE['password'];
                                                                } ?>" class="form-control" name="password" required="">
                    <i class="fas fa-eye-slash showhide" id="hide" onclick="myshowhidefunc()"></i>
                    <i class="fas fa-eye showhide" id="show" onclick="myshowhidefunc()"></i>
                  </div>

                  <div class="form-group">
                    <div class="text-right">
                      <a style="color: slateblue;" href="recover_password.php" class="small">
                        Forgot Password?
                      </a>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="form-check position-relative mb-2">
                      <input style="box-shadow: none;" class="form-check-input remember-me" name="remember_me" checked type="checkbox">
                      <label class="form-check-label" for="remember_me"><?php if (isset($_COOKIE['email'])) { ?> <?php } ?> remember me</label>
                    </div>
                  </div>

                  <div class="form-group no-margin">
                    <button type="submit" name="login" id="submit" class="btn btn-dark btn-block">LOGIN</button>
                  </div>
                  <div class="text-center mt-3 small">
                    NOT A MEMBER? <a class="text-primary" href="register.php">REGISTER</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>



      </div>

    </div>
  </main>

  <script src="../theme/assets/css/all.js"></script>
  <script src="../theme/assets/js/graindashboard.js"></script>
  <script src="../theme/assets/js/graindashboard.vendor.js"></script>
  <script src="../js/main.js"></script>

</body>

</html>