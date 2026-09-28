<?php
error_reporting(0);
require '../inc/connection.inc.php';
$db = db_conn();
if (isset($_POST['recover'])) {
	$email = $_POST['email'];
	$emailCheckQuery = "SELECT * FROM users WHERE email = :email";
	$stmt = $db->prepare($emailCheckQuery);
	$stmt->bindValue(':email', $email);
	$stmt->execute();
	$emailCheckResult = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($emailCheckResult) {
		echo "<script>
            location.assign('newpass.php');
            </script>";
	} else {
?>
		<script>
			alert("Invalid Email Address");
		</script>
<?php
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Title -->
	<title>Reset Password </title>

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
								<h4 class="card-title">VERIFY YOUR EMAIL </h4>

								<form method="post" role="form" id="signup">
									<div class="form-group">
										<label for="email">Email</label>
										<input id="email" type="email" class="form-control" name="email" required="">
									</div>

									<div class="form-group no-margin">
										<button type="submit" name="recover" id="submit" class="btn btn-dark btn-block">Send</button>
									</div>
									<div class="text-center  mt-3 small">
										Don't have an account? <a class="text-primary" href="register.php">Register</a>
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