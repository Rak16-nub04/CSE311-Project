<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- You can link your CSS file here -->
    <script>
        function confirmDelete(username) {
            return confirm('Are you sure you want to delete user: ' + username + '?');
        }
    </script>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $admin['Full_Name']; ?>!</h1>
        <a href="adminLOGOUT.php">Logout</a>
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
                        <form method="post" action="deleteUSER.php">
                            <input type="hidden" name="username" value="<?= $user['username'] ?>">
                            <button type="submit" name="deleteBtn" onclick="return confirmDelete('<?= $user['username'] ?>')">Delete</button>
                        </form>
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
