<?php
session_start();


//destroying the sessions
session_destroy();

//destroying cookies
if(isset($_COOKIE['email']) && isset($_COOKIE['password'])){
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
    setcookie("email",$email, time() - 1);
    setcookie("password",$password, time() - 1);
}


// the customer will be redirected to the login page if he/she has logged out
header("location: ../index.php");
exit();
?>

