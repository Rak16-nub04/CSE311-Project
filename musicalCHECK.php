<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';


$current_date = date('Y-m-d');
$upcoming_events_query = "SELECT * FROM musical_event_details WHERE event_date >= '$current_date'";
$upcoming_events_result = mysqli_query($con, $upcoming_events_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Musical Events</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <li class="nav-item">
        <a class="nav-link" href="home.html">Home Page</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="home1.html">Profile Page</a>
    </li>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Upcoming Musical Events</h1>
    <?php
    while ($row = mysqli_fetch_assoc($upcoming_events_result)) {
        echo '<div class="card mt-3">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">Event Name: ' . $row['event_name'] . '</h5>';
        echo '<p class="card-text">Location: ' . $row['venue'] . '</p>';
        echo '<p class="card-text">Date: ' . $row['event_date'] . '</p>';
        echo '<p class="card-text">Performer: ' . $row['performer'] . '</p>';
        echo '<p class="card-text">Ticket Price: ' . $row['ticket_price'] . '</p>';
       
        echo '<a href="musicalTICKET.php?event_id=' . $row['id'] .'" class="btn btn-primary">Buy Ticket</a>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
