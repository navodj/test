<?php
session_start();
include 'conf.php';

// Catch the data from HTML form
$uname = $_POST['userName'];  
$pass = $_POST['pass'];  

$sql = "SELECT * FROM userdata WHERE username = '$uname' AND password = '$pass' ";  
$result = mysqli_query($conn, $sql);

// Verify if the SQL has data
if (mysqli_num_rows($result) == 1) {  
    $row = mysqli_fetch_assoc($result);
    if ($row['username'] === $uname && $row['password'] === $pass) {
        $_SESSION['username'] = $uname;
        // Redirect to shop.php in the adminshop folder
        header("Location: ../adminshop/shop.php");
        exit();  // Stop further execution
    } else {
        echo "Invalid password";
    }
} else {
    // If login fails, redirect to the form page
    header("Location: form.html");
    exit();
}
?>
