<?php
session_start();

// Destroy the session
session_destroy();

// Redirect the user to the specified page (if provided), otherwise, redirect to the homepage
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'home.html';
header("Location: $redirect");
exit();
?>
