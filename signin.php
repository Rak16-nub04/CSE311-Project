<?php
$login_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM registration WHERE username='$username' AND Password='$password'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // User found, redirect to dashboard or any other page
        header("Location: dashboard.php");
        exit();
    } else {
        $login_error = "Invalid username or password. Please try again.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">

    <title>Sign In Page</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Sign In</h1>
    <form action="signin.php" method="post" autocomplete="off">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username"
                   required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Enter your password" required>
        </div>
        <?php
        if (!empty($login_error)) {
            echo '<div class="alert alert-danger" role="alert">' . $login_error . '</div>';
        }
        ?>
        <button type="submit" class="btn btn-primary w-100">Sign In</button>
    </form>
</div>

</body>
</html>
