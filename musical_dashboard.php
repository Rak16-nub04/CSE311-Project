<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_event'])) {
    $event_name = $_POST['event_name'];
    $venue = $_POST['venue'];
    $num_audience = $_POST['num_audience'];
    $event_date = $_POST['event_date'];
    $performer = $_POST['performer'];
    $ticket_price = $_POST['ticket_price'];

    $insert_sql = "INSERT INTO musical_event_details (username, event_name, venue, num_audience, event_date, performer, ticket_price) VALUES ('$username', '$event_name', '$venue', '$num_audience', '$event_date', '$performer', '$ticket_price')";
    if (mysqli_query($con, $insert_sql)) {
        $save_success = "Event details saved successfully.";
    } else {
        $save_error = "Failed to save event details. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Musical Evening Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
    <a class="navbar-brand" href="#">Musical Evening Dashboard</a>
    <div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="musicalCHECK.php">Check Musical Evening</a>
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
    <h1 class="text-center">If You Want to Add a Musical Evening Event, Please Fill Up the Form:</h1>
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
            <h5 id="event-details" class="card-title">Musical Evening Details</h5>
            <form method="post" action="musical_dashboard.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="event_name">Musical Event Name</label>
                    <input type="text" class="form-control" id="event_name" name="event_name" required>
                </div>
                <div class="form-group">
                    <label for="performer">Performer</label>
                    <input type="text" class="form-control" id="performer" name="performer" required>
                </div>
                <div class="form-group">
                    <label for="ticket_price">Ticket Price</label>
                    <input type="text" class="form-control" id="ticket_price" name="ticket_price" required>
                </div>
                <div class="form-group">
                    <label for="venue">Event Venue</label>
                    <select class="form-control" id="venue" name="venue" required>
                        <option value="ICCB,Dhaka">ICCB,Dhaka</option>
                        <option value="NSU,Dhaka">NSU,Dhaka</option>
                        <option value="Army Stadium,Dhaka">Army Stadium,Dhaka</option>
                        <option value="The Junction,Dhaka">The Junction,Dhaka</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="num_audience">Number of Audience</label>
                    <select class="form-control" id="num_audience" name="num_audience" required>
                        <option value="500">Up to 500</option>
                        <option value="1000">Up to 1000</option>
                        <option value="1500">Up to 1500</option>
                        <option value="2000">Up to 2000</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="event_date">Event Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                </div>
                <button type="submit" name="save_event" class="btn btn-primary">Save Event Details</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
