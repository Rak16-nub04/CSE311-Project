<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_birthday_event'])) {
    $location = $_POST['location'];
    $num_guests = $_POST['num_guests'];
    $birthday_event_date = $_POST['birthday_event_date'];

    $insert_sql = "INSERT INTO birthday_event_details (username, location, num_guests,birthday_event_date) VALUES ('$username', '$location', '$num_guests', '$birthday_event_date')";
    if (mysqli_query($con, $insert_sql)) {
        $save_success = "BirthDay EVent details saved successfully.";
    } else {
        $save_error = "Failed to save BirthDAy Event details. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Dashboard</title>
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
                    <a class="nav-link" href="birthdayCHECK.php">Check Birthday</a>
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
    <h1 class="text-center">If You Want to Add  a BirthDay Party,Please Fill Up the Form:</h1>
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
            <h5 id="wedding-details" class="card-title">Birthday Event Details</h5>
            <form method="post" action="birthday_dashboard.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="location">Birtday Event Location</label>
                    <select class="form-control" id="location" name="location" required>
                        <option value="Le Meridian,Dhaka">Le Meridian,Dhaka</option>
                        <option value="Lake Terrace,Dhaka">Lake Terrace,Dhaka</option>
                        <option value="SkyPool Restaurant,Dhaka">SkyPool Restaurant,Dhaka</option>
                        <option value="S&W Restaurant,Dhaka">AS&W Restaurant,Dhaka</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="num_guests">Number of Guests</label>
                    <select class="form-control" id="num_guests" name="num_guests" required>
                        <option value="50">Up to 50</option>
                        <option value="100">Up to 100</option>
                        <option value="250">Up to 250</option>
                        <option value="500">Up to 500</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="birthday_event_date">BirthDay Party Date</label>
                    <input type="date" class="form-control" id="birthday_event_date" name="birthday_event_date" required>
                </div>
                <button type="submit" name="save_birthday_event" class="btn btn-primary">Save BirthDay Party Details</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
