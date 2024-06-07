<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_wedding'])) {
    $location = $_POST['location'];
    $num_guests = $_POST['num_guests'];
    $wedding_date = $_POST['wedding_date'];

    $insert_sql = "INSERT INTO wedding_details (username, location, num_guests, wedding_date) VALUES ('$username', '$location', '$num_guests', '$wedding_date')";
    if (mysqli_query($con, $insert_sql)) {
        $save_success = "Wedding details saved successfully.";
    } else {
        $save_error = "Failed to save wedding details. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
    <a class="navbar-brand" href="#"></a>
    <div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"> 
                <li class="nav-item">
                    <a class="nav-link" href="weddingCHECK.php">Check Wedding</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.html">Home Page</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home1.html">Profile Page</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <h1 class="text-center">If You Want to Add  an Wedding Event,Please Fill Up the Form:</h1>
    <?php
    if (isset($save_success)) {
        echo '<div class="alert alert-success" role="alert">' . $save_success . '</div>';
    }
    if (isset($save_error)) {
        echo '<div class="alert alert-danger" role="alert">' . $save_error . '</div>';
    }
    ?>

    <div class="card mt-4">
        <div class="card-body">
            <h5 id="wedding-details" class="card-title">Wedding Details</h5>
            <form method="post" action="wedding_dashboard.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="location">Wedding Location</label>
                    <select class="form-control" id="location" name="location" required>
                        <option value="Orchid Convention Hall,Dhaka">Orchard Convention Hall,Dhaka</option>
                        <option value="Raowa Convention Hall,Dhaka">Raowa Convention Hall,Dhaka</option>
                        <option value="Sena Kunjo,Dhaka">Sena Kunjo,Dhaka</option>
                        <option value="Madhuban Convention Hall,Rajshahi">Madhuban Convention Hall,Rajshahi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="num_guests">Number of Guests</label>
                    <select class="form-control" id="num_guests" name="num_guests" required>
                        <option value="300">Up to 300</option>
                        <option value="500">Up to 500</option>
                        <option value="800">Up to 800</option>
                        <option value="1000">Up to 1000</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="wedding_date">Wedding Date</label>
                    <input type="date" class="form-control" id="wedding_date" name="wedding_date" required>
                </div>
                <button type="submit" name="save_wedding" class="btn btn-primary">Save Wedding Details</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
