<?php
// Start session to manage user login state
session_start();

include 'connect.php';

// Logout logic
if(isset($_GET['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to home page after logout
    header("Location: home.html");
    exit;
}

// Check if user is not logged in, then redirect to login page
if(!isset($_SESSION['username'])) {
    header("Location: adminSIGNIN.php");
    exit;
}

if(isset($_POST['delete_confirmed'])){
    $username = $_POST['username'];
    $sql = "DELETE FROM signup WHERE username = '$username'";
    $result = mysqli_query($con, $sql);
    if($result){
        echo '<div class="alert alert-success" role="alert">
                User deleted successfully!
              </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
                Error deleting user!
              </div>';
    }
}

if(isset($_POST['delete_event'])){
    $event_id = $_POST['event_id'];
    $sql = "DELETE FROM birthday_event_details WHERE id = '$event_id'";
    $result = mysqli_query($con, $sql);
    if($result){
        echo '<div class="alert alert-success" role="alert">
                Event deleted successfully!
              </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
                Error deleting event!
              </div>';
    }
}

if(isset($_POST['delete_wedding'])){
    $wedding_id = $_POST['wedding_id'];
    $sql = "DELETE FROM wedding_details WHERE id = '$wedding_id'";
    $result = mysqli_query($con, $sql);
    if($result){
        echo '<div class="alert alert-success" role="alert">
                Wedding event deleted successfully!
              </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
                Error deleting wedding event!
              </div>';
    }
}

if(isset($_POST['delete_musical_event'])){
    $musical_event_id = $_POST['musical_event_id'];
    
    // Delete related entries in musical_ticket table
    $sql = "DELETE FROM musical_ticket WHERE event_id = '$musical_event_id'";
    mysqli_query($con, $sql);
    
    // Now delete from musical_event_details table
    $sql = "DELETE FROM musical_event_details WHERE id = '$musical_event_id'";
    $result = mysqli_query($con, $sql);
    
    if($result){
        echo '<div class="alert alert-success" role="alert">
                Musical event deleted successfully!
              </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">
                Error deleting musical event!
              </div>';
    }
}

$sql = "SELECT * FROM signup";
$result = mysqli_query($con, $sql);

$current_date = date('Y-m-d');
$upcoming_events_query = "SELECT * FROM birthday_event_details WHERE birthday_event_date >= '$current_date'";
$upcoming_events_result = mysqli_query($con, $upcoming_events_query);

$upcoming_weddings_query = "SELECT * FROM wedding_details WHERE wedding_date >= '$current_date'";
$upcoming_weddings_result = mysqli_query($con, $upcoming_weddings_query);

$upcoming_musical_events_query = "SELECT * FROM musical_event_details WHERE event_date >= '$current_date'";
$upcoming_musical_events_result = mysqli_query($con, $upcoming_musical_events_query);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Admin Page</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Admin Page</h1>
    <div class="float-right mb-3">
        <a href="?logout=true" class="btn btn-danger">Logout</a>
    </div>
    <div class="table-responsive">
        <h2>Users</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>DOB</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['Full_Name']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['Phone']; ?></td>
                    <td><?php echo $row['DoB']; ?></td>
                    <td>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal<?php echo $row['username']; ?>">Delete</button>
                    </td>
                </tr>
                <!-- Delete Modal for each user -->
                <div class="modal fade" id="deleteModal<?php echo $row['username']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this user? This action cannot be undone.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form method="post" action="admin.php">
                                    <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                                    <button type="submit" name="delete_confirmed" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="table-responsive mt-5">
        <h2>Upcoming Birthday Events</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($event = mysqli_fetch_assoc($upcoming_events_result)): ?>
                <tr>
                    <td><?php echo $event['location']; ?></td>
                    <td><?php echo $event['birthday_event_date']; ?></td>
                    <td>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteEventModal<?php echo $event['id']; ?>">Delete</button>
                    </td>
                </tr>
                <!-- Delete Modal for each event -->
                <div class="modal fade" id="deleteEventModal<?php echo $event['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteEventModalLabel">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this event? This action cannot be undone.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form method="post" action="admin.php">
                                    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                    <button type="submit" name="delete_event" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="table-responsive mt-5">
        <h2>Upcoming Wedding Events</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($wedding = mysqli_fetch_assoc($upcoming_weddings_result)): ?>
                <tr>
                    <td><?php echo $wedding['location']; ?></td>
                    <td><?php echo $wedding['wedding_date']; ?></td>
                    <td>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteWeddingModal<?php echo $wedding['id']; ?>">Delete</button>
                    </td>
                </tr>
                <!-- Delete Modal for each wedding event -->
                <div class="modal fade" id="deleteWeddingModal<?php echo $wedding['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteWeddingModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteWeddingModalLabel">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this wedding event? This action cannot be undone.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form method="post" action="admin.php">
                                    <input type="hidden" name="wedding_id" value="<?php echo $wedding['id']; ?>">
                                    <button type="submit" name="delete_wedding" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="table-responsive mt-5">
        <h2>Upcoming Musical Events</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Performer</th>
                    <th>Ticket Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($musical_event = mysqli_fetch_assoc($upcoming_musical_events_result)): ?>
                <tr>
                    <td><?php echo $musical_event['event_name']; ?></td>
                    <td><?php echo $musical_event['venue']; ?></td>
                    <td><?php echo $musical_event['event_date']; ?></td>
                    <td><?php echo $musical_event['performer']; ?></td>
                    <td><?php echo $musical_event['ticket_price']; ?></td>
                    <td>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteMusicalEventModal<?php echo $musical_event['id']; ?>">Delete</button>
                    </td>
                </tr>
                <!-- Delete Modal for each musical event -->
                <div class="modal fade" id="deleteMusicalEventModal<?php echo $musical_event['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteMusicalEventModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteMusicalEventModalLabel">Confirm Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this musical event? This action cannot be undone.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form method="post" action="admin.php">
                                    <input type="hidden" name="musical_event_id" value="<?php echo $musical_event['id']; ?>">
                                    <button type="submit" name="delete_musical_event" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
