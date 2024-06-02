<?php
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
session_start();
if (!isset($_SESSION['username']) || !$_SESSION['is_admin']) {
    header("Location: adminSIGNIN.php"); // Redirect to signin page if not logged in as admin
    exit();
}

// Fetch admin details from the database
$username = $_SESSION['username'];
$sql = "SELECT * FROM admins WHERE username='$username'";
$result = mysqli_query($con, $sql);
$admin = mysqli_fetch_assoc($result);

// Function to delete user account
function deleteUser($con, $userId) {
    $sql = "DELETE FROM signup WHERE id = $userId";
    if (mysqli_query($con, $sql)) {
        return true;
    } else {
        return false;
    }
}

// Check if user deletion request is made
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $userId = $_GET['id'];
    if (deleteUser($con, $userId)) {
        // User deleted successfully
        header("Location: admin.php"); // Redirect to admin dashboard after deletion
        exit();
    } else {
        echo "Failed to delete user.";
    }
}

// Fetch all users from the database
$sql_users = "SELECT * FROM signup";
$result_users = mysqli_query($con, $sql_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- You can link your CSS file here -->
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $admin['Full_Name']; ?>!</h1>
        <a href="logout.php">Logout</a>
    </header>
    <main>
        <h2>User Management</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date of Birth</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($result_users)): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['Full_Name']) ?></td>
                    <td><?= htmlspecialchars($user['Email']) ?></td>
                    <td><?= htmlspecialchars($user['Phone']) ?></td>
                    <td><?= htmlspecialchars($user['DoB']) ?></td>
                    <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <a href="?delete=true&id=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>© 2024 Admin Panel</p>
    </footer>
</body>
</html>
