<?php
// error_reporting(0);
session_start();
//   connect to the database
include('inc/connect.php');
// ----the customer cannot access flowers page without login first
if (!isset($_SESSION['email'])) {
    echo "<script>
    alert('Login first to access this page');
    location.assign('Login/login.php');
    </script>";
} else {
    $email = $_SESSION['email'];
}

// -------updating and deleting after adding to cart
if (isset($_POST['update_cart'])) {
    $update_quantity = $_POST['cart_quantity'];
    $update_id = $_POST['cart_id'];
    $pn = $_POST['cart_name'];
    $upd = "UPDATE cart SET qty = '$update_quantity' WHERE id= '$update_id' and email ='$email'";
    $upd_qry = mysqli_query($db, $upd);
    if ($upd_qry) {
        echo "<script>
            alert('Product Updated Successfully!');
            location.assign('cart.php#shop_cart');
            </script>";
    }
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $rem_qry = mysqli_query($db, "DELETE FROM cart WHERE id = '$remove_id' and email= '$email'");
    if ($rem_qry) {
        echo "<script>
        alert('Product Removed Successfully!');
        location.assign('cart.php#shop_cart');
        </script>";
    }
}


if (isset($_GET['delete_all'])) {
    $rem_all_qry = mysqli_query($db, "DELETE FROM cart");
    if ($rem_all_qry) {
        echo "<script>
        alert('Products Removed Successfully!');
        location.assign('cart.php#shop_cart');
        </script>";
    }
}

// ======PAY AUTH==========
$paybill = 211211;
$account_no = "";
$amount = "";
$cust_email = "";
$sub_total = "";

$account_name = "ZABKA ELECTRICAL APPLIANCES SHOP";


$grand_total = 0;
$cart_select = "SELECT sum(price * qty) as gt FROM cart where email= '$email'";
$cart_query = mysqli_query($db, $cart_select);
if (mysqli_num_rows($cart_query) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
        $grand_total = $fetch_cart['gt'];

        $_SESSION['order_details'] = [
            'amount' => $grand_total
        ];
    }
}

if (isset($_SESSION['order_details']['amount'])) {
    $grandt = $_SESSION['order_details']['amount'];
    // echo $grand_total;
}

$user_check_query = "SELECT SUM(amount) as f from payments where email = '$email'";
$result = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result);
if ($user) {
    if ($user['f'] < $grandt) {
        $amt_to_pay = $grandt - $user['f'];
    } elseif (empty($user['amt'])) {
        $amt_to_pay = $grandt;
    }
}


$transref =  "SYQ" . mt_rand(911234, 999999) . "L";
if (isset($_POST['insert_data'])) {
    $account_no = $_POST['account_no'];

    $user_check_query = "SELECT SUM(amount) as f from payments where email = '$email'";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user['f'] === $grandt) {
?>
        <script>
            alert("You have already paid for this order!");
        </script>
        <?php
    } elseif (empty($user['f'])) {
        $insert_query = "INSERT into payments (MpesaRefNo,shortcode,phone,amount,email) 
        VALUES ('$transref','$paybill','$account_no','$grandt','$email')";
        $query_run = mysqli_query($db, $insert_query);
        if ($query_run) {
            echo "<script>
                alert('Payment of KES " . $grandt . " has been paid successfully ,Click OK to download your receipt.Delivery in progress!!');
                location.assign('reciept.php');
                </script>";
        } else {
        ?>
            <script>
                alert("Failed to insert into the database");
                window.location.assign('cart.php');
            </script>
<?php
        }
    } elseif ($user['f'] < $grandt) {
        $balance = $grandt - $user['f'];
        $newbalance = $balance + $user['f'];
        $update = "UPDATE customer_payments SET amount = '$newbalance' WHERE email = '$email'";
        $stmt = $db->prepare($update);
        if ($stmt->execute()) {
            echo "<script>
            alert('Payment of KES " . $balance . " has been paid successfully ,Click OK to download your receipt.Delivery in progress!!');
            location.assign('reciept.php');
            </script>";
        } else {

            echo "<script>
            alert('Something went wrong. Please try again.');
            location.assign('cart.php');
            </script>";
        }
    }
}



// check for cookies
if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
    // echo $email;
    echo "<script>
    document.getElemetById('email').value = '$email'
    document.getElemetById('password').value = '$password'
    </script>";
}

?>