<?php
// error_reporting(0);
require '../inc/connection.inc.php';
$db = db_conn();

//sign up / register the user if no error   //if true,then save to the database
if(isset($_POST['send']))
{
    try 
    {
        
        $message = $_POST['message'];
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];

        $query = "INSERT into contact (name,email,subject,message)
        values (:name,:email,:subject,:message)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        if($stmt->execute())
        {
            echo "<script>
            alert('Your message has been sent Successfuly');
            location.assign('../');
            </script>";
        }
        else
        {
            ?>
                <script>
                    alert("Failed!, please try again");
                </script>
            <?php
        }


    } 
    catch (PDOException $e) {
        $err = "Error: ".$e->getMessage();
        echo '<script>alert("'.$err.'")</script>';
    }
}

?>