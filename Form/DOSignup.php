<?php
session_start();
include 'conf.php';

// Catch the data from HTML form
$uname = $_POST['userName'];  // Add semicolon
$email = $_POST['email'];
$pass = $_POST['pass'];  // Correct the variable name and add semicolon

$sql = "INSERT INTO userdata (username, email, password) VALUES ('$uname', '$email','$pass')";

$result = mysqli_query($conn, $sql);

if ($result == TRUE) {
    echo "New record inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>

