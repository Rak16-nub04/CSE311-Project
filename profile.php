<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';

$username = $_SESSION['username'];
$sql = "SELECT * FROM signup WHERE username='$username'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User not found.";
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="profileSTYLE.css">
    <title>Profile</title>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center text-primary">Profile Details</h1>
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($user['Full_Name']); ?></h5>
            <p class="card-text"><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
            <p class="card-text"><strong>Phone:</strong> <?php echo htmlspecialchars($user['Phone']); ?></p>
            <p class="card-text"><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['DoB']); ?></p>
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </div>
</div>
</body>
</html>
