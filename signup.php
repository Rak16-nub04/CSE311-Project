<?php
$success=0;
$user=0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    $username = $_POST['username'];
    $fullname = $_POST['Full_Name'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];
    $dob = $_POST['DoB'];
    $password = $_POST['Password'];

    
    /*$check_sql = "SELECT * FROM registration WHERE username = '$username'";
    $check_result = mysqli_query($con, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "\r\n Username already exists!";
    } else {
        
        $sql = "INSERT INTO registration (username, Password) VALUES ('$username', '$password')";
        $result = mysqli_query($con, $sql);
        
        if ($result) {
            echo "\r\n Data inserted successfully";
        } else {
            die(mysqli_error($con));
        }
    }*/

    $sql="Select * from registration where username='$username'";

    $result=mysqli_query($con,$sql);
    
    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            //echo "SORRY,User already Exist!!";
            $user=1;
        }
        else {
            $sql = "INSERT INTO registration (username,Full_Name,Email,Phone,DoB, Password) VALUES ('$username','$fullname','$email','$phone','$dob', '$password')";
        $result = mysqli_query($con, $sql);
        if ($result) {
            //echo "CONGRATULATIONS!! Sign Up successful";
            $success=1;
        } else {
            die(mysqli_error($con));
        }
        }
    }


}

?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>SignUp page</title>
  </head>
  <body>

  <?php

  if($user){
    echo '<div class="alert alert-primary d-flex align-items-center" role="alert">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg>
    <div>
     <strong> SORRY! </strong> User already exists.
     </div>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    
  </div>';
  }

?>


<?php

  if($success){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>CONGRATULATIONS!</strong> You are successfully signed up.
    
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>

  </div>';
  }

?>


    <h1 class="text-center mt-5" >Sign Up Page</h1>
    <div class="container mt-5">
        <form action="signup.php" method="post" autocomplete="off">
    <div class="mb-3">
  <label for="formGroupExampleInput" >USERNAME</label>
  <input type="text" class="form-control"  placeholder="Enter a unique username" name="username">
</div>

<div class="mb-3">
  <label for="formGroupExampleInput" >FULL NAME</label>
  <input type="text" class="form-control"  placeholder="Enter your full name" name="Full_Name">
</div>

<div class="mb-3">
  <label for="formGroupExampleInput" >Date of Birth</label>
  <input type="date" class="form-control"  placeholder="Enter your date of birth" name="DoB">
</div>

<div class="mb-3">
  <label for="formGroupExampleInput" >EMAIL</label>
  <input type="email" class="form-control"  placeholder="Enter your email adrress" name="Email">
</div>

<div class="mb-3">
  <label for="formGroupExampleInput" >PHONE NO.</label>
  <input type="tel" class="form-control"  placeholder="Enter your phone number" name="Phone">
</div>


<div class="mb-3">
  <label for="formGroupExampleInput2" class="form-label">PASSWORD</label>
  <input type="password" class="form-control"  placeholder="Enter your Password" name="Password">
</div>

<button type="submit" class="btn btn-primary w-100">SUBMIT</button>

</form>
</div>

   
  </body>
</html>
