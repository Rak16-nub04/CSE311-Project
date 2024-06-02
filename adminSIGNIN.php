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

// Handle admin sign-in
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $admin['username'];
        $_SESSION['is_admin'] = true;
        header("Location: adminPROFILE.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS file here -->
</head>
<body>
    <header>
        <h1>Admin Sign In</h1>
    </header>
    <main>
        <form action="adminSIGNIN.php" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Sign In</button>
        </form>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </main>
</body>
</html>
