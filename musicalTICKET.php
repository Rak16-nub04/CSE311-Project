<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';


if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    $event_query = "SELECT * FROM musical_event_details WHERE id = $event_id";
    $event_result = mysqli_query($con, $event_query);
    if (mysqli_num_rows($event_result) > 0) {
        $event = mysqli_fetch_assoc($event_result);
    } else {
        
        header("Location: musicalCHECK.php");
        exit();
    }
} else {
    
    header("Location: musicalCHECK.php");
    exit();
}


$max_tickets = 3;


$ticket_price = $event['ticket_price'];
if (isset($_POST['num_tickets'])) {
    $num_tickets = $_POST['num_tickets'];
    $amount_to_pay = $ticket_price * $num_tickets;
} else {
    
    $amount_to_pay = $ticket_price;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Tickets</title>
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
    <h1 class="text-center">Buy Tickets for <?php echo $event['event_name']; ?></h1>
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Event Details</h5>
            <p class="card-text">Location: <?php echo $event['venue']; ?></p>
            <p class="card-text">Date: <?php echo $event['event_date']; ?></p>
            <p class="card-text">Performer: <?php echo $event['performer']; ?></p>
            <p class="card-text">Ticket Price: <?php echo $event['ticket_price']; ?></p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Buy Tickets</h5>
            <form method="post" action="musicalTICKETprocess.php">
                <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" id="age" name="age" required>
                </div>
                <div class="form-group">
                    <label for="nid">NID</label>
                    <input type="text" class="form-control" id="nid" name="nid" required>
                </div>
                <div class="form-group">
                    <label for="num_tickets">Number of Tickets (Max <?php echo $max_tickets; ?>)</label>
                    <input type="number" class="form-control" id="num_tickets" name="num_tickets" min="1" max="<?php echo $max_tickets; ?>" required>
                </div>
                <div class="form-group">
                    <label for="money">Amount to Pay</label>
                    <input type="text" class="form-control" id="money" name="money" value="<?php echo $amount_to_pay; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="payment_method">Payment Method</label>
                    <select class="form-control" id="payment_method" name="payment_method" required>
                        <option value="credit card">Credit Card</option>
                        <option value="debit card">Debit Card</option>
                        <option value="bkash">Bkash</option>
                        <option value="nagad">Nagad</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Proceed</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
