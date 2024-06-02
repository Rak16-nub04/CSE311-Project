<?php
session_start();

// Include database connection code
$HOSTNAME= 'localhost';
$USERNAME= 'rakib';
$PASSWORD= 'password';
$DATABASE= 'project';

$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);

if(!$con){
    die(mysqli_error($con));
}

// Check if the user is logged in as an admin
if (!isset($_SESSION['username']) || !$_SESSION['is_admin']) {
    header("Location: adminSIGNIN.php"); // Redirect to signin page if not logged in as admin
    exit();
}

// Function to delete user account
function deleteUser($con, $username) {
    $sql = "DELETE FROM signup WHERE username = '$username'";
    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

// Check if user deletion request is made
if (isset($_POST['deleteBtn']) && isset($_POST['username'])) {
    $username = $_POST['username'];
    if (deleteUser($con, $username)) {
        // User deleted successfully
        header("Location: adminPROFILE.php"); // Redirect to admin profile after deletion
        exit();
    } else {
        echo "Failed to delete user.";
    }
}
?>
