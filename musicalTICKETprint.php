<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';

if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];
    $ticket_query = "SELECT t.*, e.event_name, e.performer, e.event_date, e.ticket_price 
                     FROM musical_ticket t 
                     JOIN musical_event_details e ON t.event_id = e.id 
                     WHERE t.id = $ticket_id";
    $ticket_result = mysqli_query($con, $ticket_query);

    if (mysqli_num_rows($ticket_result) > 0) {
        $ticket = mysqli_fetch_assoc($ticket_result);
    } else {
        echo "Invalid ticket ID.";
        exit();
    }
} else {
    echo "No ticket ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Ticket</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Your Ticket</h1>
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Event: <?php echo $ticket['event_name']; ?></h5>
            <p class="card-text">Performer: <?php echo $ticket['performer']; ?></p>
            <p class="card-text">Date: <?php echo $ticket['event_date']; ?></p>
            <p class="card-text">Ticket Price: <?php echo $ticket['ticket_price']; ?></p>
            <p class="card-text">Number of Tickets: <?php echo $ticket['num_tickets']; ?></p>
            <p class="card-text">Amount Paid: <?php echo $ticket['amount_paid']; ?></p>
            <p class="card-text">Booked By: <?php echo $ticket['name']; ?></p>
            <p class="card-text">Booking Time: <?php echo $ticket['booking_time']; ?></p>
        </div>
    </div>
    <button class="btn btn-primary mt-3" onclick="window.print()">Print Ticket</button>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
