<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $nid = $_POST['nid'];
    $num_tickets = $_POST['num_tickets'];
    $payment_method = $_POST['payment_method'];
    $amount_to_pay = $_POST['money'];

    

    
    $stmt = $con->prepare("INSERT INTO musical_ticket (event_id, name, age, nid, num_tickets, payment_method, amount_paid) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isisiis", $event_id, $name, $age, $nid, $num_tickets, $payment_method, $amount_to_pay);

    if ($stmt->execute()) {
        
        $ticket_id = $stmt->insert_id;
        header("Location: musicalTICKETprint.php?ticket_id=" . $ticket_id);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$con->close();
?>
