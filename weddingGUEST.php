<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_guest_info'])) {
    $wedding_id = $_POST['wedding_id'];
    $guest_name = $_POST['guest_name'];
    $num_members = $_POST['num_members'];
    $gift = $_POST['gift'];

    $insert_sql = "INSERT INTO wedding_guests (wedding_id, guest_name, num_members, gift) VALUES ('$wedding_id', '$guest_name', '$num_members', '$gift')";
    if (mysqli_query($con, $insert_sql)) {
        $save_success = "Guest information saved successfully.";
    } else {
        $save_error = "Failed to save guest information. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Guest Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="weddingCHECK.php">Go Back To Wedding Dashboard</a>
    
<li class="nav-item">
                    <a class="nav-link" href="home.html">Home Page</a>
                </li>
<li class="nav-item">
                    <a class="nav-link" href="home1.html">Profile Page</a>
                </li>
</nav>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Provide Your Information</h1>
    <?php
    if (isset($save_success)) {
        echo '<div class="alert alert-success" role="alert">' . $save_success . '</div>';
    }
    if (isset($save_error)) {
        echo '<div class="alert alert-danger" role="alert">' . $save_error . '</div>';
    }
    ?>
    <div class="row mt-4">
        <div class="col-md-6 offset-md-3">
            <form method="post" action="weddingGUEST.php">
                <input type="hidden" name="wedding_id" value="<?php echo $_POST['wedding_id']; ?>">
                <div class="form-group">
                    <label for="guest_name">Your Name</label>
                    <input type="text" class="form-control" id="guest_name" name="guest_name" required>
                </div>
                <div class="form-group">
                    <label for="num_members">Number of Members</label>
                    <input type="number" class="form-control" id="num_members" name="num_members" required>
                </div>
                <div class="form-group">
                    <label for="gift">Gift</label>
                    <input type="text" class="form-control" id="gift" name="gift" required>
                </div>
                <button type="submit" name="submit_guest_info" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
