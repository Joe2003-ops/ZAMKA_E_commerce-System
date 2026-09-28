<?php
error_reporting(0);
require '../inc/connection.inc.php';
$db = db_conn();

// error_reporting(0);
//initialize the variables
$user_name = "";
$phone_number = "";
$email = "";
$password1 = "";
$password2 = "";
$agree = "";
$password_hash = "";



//sign up / register the user if no error   //if true,then save to the database
if (isset($_POST['register'])) {
    try {
        $user_name = $_POST['name'];
        $phone_number = $_POST['pnumber'];
        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];


        //check db for existing user with same user name and email
        $user_check_query = "SELECT * from users where  email = :email limit 1";
        $stmt = $db->prepare($user_check_query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            //matched email error definition
            if ($user['email'] === $email) {
?>
                <script>
                    alert("email already exists, please try another one!");
                </script>
                <?php
            }
        } else {
            if (preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/', $password1)) {
                // if password not matched so
                if ($password1 === $password2) {
                    if (preg_match('/^[0-9]*$/', $phone_number) && strlen($phone_number) == 10) {
                        if (preg_match('/^[a-z A-Z]*$/', $user_name)) {
                            // $password_hash = password_hash($password1, PASSWORD_BCRYPT);
                            $password_hash = md5($password1);
                            $query = "INSERT into users (name,phone,email,password)
                            values (:name,:phone,:email,:password)";
                            $stmt = $db->prepare($query);
                            $stmt->bindParam(':name', $user_name);
                            $stmt->bindParam(':phone', $phone_number);
                            $stmt->bindParam(':email', $email);
                            $stmt->bindParam(':password', $password_hash);
                            if ($stmt->execute()) {
                                $_SESSION['email'] = $email;
                                echo "<script>
                                alert('You have Registered Successfuly, click OK to login');
                                location.assign('signin.php');
                                </script>";
                            } else {
                ?>
                                <script>
                                    alert("Failed to register");
                                </script>
                            <?php
                            }
                        } else {
                            ?>
                            <script>
                                alert("Only Letters and White space are Allowed!");
                            </script>
                        <?php
                        }
                    } else {
                        ?>
                        <script>
                            alert("invalid phone number!");
                        </script>
                    <?php
                    }
                } else {
                    ?>
                    <script>
                        alert("Password do not match");
                    </script>
                <?php
                }
            } else {
                ?>
                <script>
                    alert("Must be a strong password");
                </script>
<?php
            }
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
    <title>ZABKA ELECTRICALS</title>

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
                                <span class="text-center" style="font-weight: 800;font-size:20px">REGISTER</span>
                                <!-- <h4 class="card-title">Create new account</h4> -->
                                <form action="" method="post" role="form" id="signup">

                                    <div class="form-group">
                                        <label for="name">UserName</label>
                                        <input type="text" name="name" value="<?php echo $user_name; ?>" class="form-control" id="name" placeholder="*Your Name" autocomplete="on" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="pnumber">Phone</label>
                                        <input type="text" class="form-control" name="pnumber" value="<?php echo $phone_number; ?>" id="pnumber" placeholder="*Your Phone" autocomplete="on" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" id="eamil" placeholder="*Your email" autocomplete="on" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" name="password1" value="<?php echo $password1; ?>" id="password" placeholder="Password" autocomplete="on" required>
                                        <i class="fas fa-eye-slash showhide" id="hide" onclick="myshowhidefunc()"></i>
                                        <i class="fas fa-eye showhide" id="show" onclick="myshowhidefunc()"></i>
                                    </div>
                                    <div class="form-group">
                                        <label for="password-confirm">Confirm Password</label>
                                        <input type="password" class="form-control" name="password2" value="<?php echo $password2; ?>" id="password2" placeholder="Re-enter password" autocomplete="on" required>
                                        <i class="fas fa-eye-slash showhide" id="hidee" onclick="myshowhideconfpassfunc()"></i>
                                        <i class="fas fa-eye showhide" id="showw" onclick="myshowhideconfpassfunc()"></i>
                                    </div>


                                    <div class="form-group no-margin">
                                        <button type="submit" name="register" id="submit" class="btn btn-dark btn-block">REGISTER</button>
                                    </div>
                                    <div class="text-center mt-3 small">
                                        Already have an account? <a class="text-primary" href="signin.php">Login</a>
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