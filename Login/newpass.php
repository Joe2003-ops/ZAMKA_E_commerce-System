<?php
error_reporting(0);
    require '../inc/connection.inc.php';
    $db = db_conn();

    $password ="";
    $confirmPassword="";

    if(isset($_SESSION['email']))
    {
        $email = $_SESSION['email'];
    }

    if(isset($_POST['newpass']))
    {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/',$password))
        {
            ?>
                <script>
                    alert("use 8 more characters with a mixture of letters, digits & symbols");
                </script>
            <?php
        } 
        else 
        {
            if ($password != $confirmPassword)
            {
                ?>
                    <script>
                        alert("Password do not match");
                    </script>
                <?php
            } 
            else
            {
                $password_hash = md5($password);
                $email = $_SESSION['email'];
                $updatePassword = "UPDATE users SET password = '$password_hash' WHERE email = '$email'";
                $stmt = $db->prepare($updatePassword);
                session_unset();
                session_destroy();
                if($stmt->execute())
                {
                    ?>
                    <script>
                        alert("<?php echo "Password Reset Successfully, You can proceed to Login"?>");
                        window.location.replace('signin.php');
                    </script>
                <?php
                }
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Title -->
    <title>New Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

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
								<h4 class="card-title">Reset Password</h4>
								<form method="post" role="form" id="signup">
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password"  id="password" placeholder="Password" autocomplete="on" required>
                                        <i class="fas fa-eye-slash showhide" id="hide" onclick="myshowhidefunc()"></i>
                                        <i class="fas fa-eye showhide" id="show" onclick="myshowhidefunc()"></i>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="confirmPassword"  id="password2" placeholder="Confirm password" autocomplete="on" required>
                                        <i class="fas fa-eye-slash showhide" id="hidee" onclick="myshowhideconfpassfunc()"></i>
                                        <i class="fas fa-eye showhide" id="showw" onclick="myshowhideconfpassfunc()"></i>
                                    </div>

                                    <div class="form-group no-margin">
										<button type="submit" name="newpass" id="submit" class="btn btn-dark btn-block">RESET</button>
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