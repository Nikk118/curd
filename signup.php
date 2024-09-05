 <!-- sign Form -->
 <?php
 session_start();
 
    $alert=false;
    $error=false;
    $notnull=false;
    if($_SERVER['REQUEST_METHOD']=='POST'){
        require 'dbcon.php';
        $username=$_POST['username'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
       if($username==!null && $password==!null){
          

          $sql = "SELECT * FROM `notes_login` WHERE `username` = '$username'";
          $result = mysqli_query($conn, $sql);
          $num = mysqli_num_rows($result);

          if($num>0){
            echo"<script>alert('username already exist , Please choose a different username.');</script>";
          }else{

            if(($password===$cpassword)){
              $sql = "INSERT INTO `notes_login` (`username`, `password`, `date`) VALUES ('$username', '$password', current_timestamp())";
              $result = mysqli_query($conn, $sql);
              
              if ($result) {
                // Use mysqli_insert_id($conn) if you want the ID of the inserted record
                $inserted_id = mysqli_insert_id($conn);             
                $alert = true;
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $_POST['username'];
                echo $_SESSION['username'];
                
                $_SESSION['rno'] = $inserted_id;  // Use $inserted_id instead of $row['rno']
                echo $_SESSION['rno'];
              } else {
                $error = "An error occurred: " . mysqli_error($conn);
              }
              
            }
          }
          }else{
            $notnull="please enter the values!";
        }
    }
           ?>

<!doctype html>
<html lang="en">

<head>
     <!-- Required meta tags  -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="login.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>signup page</title>
</head>

<body>
<?php  
  if($alert){
        echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Account created!</strong> You are now loggedin.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
     
      header("location:index.php");
    }
    if($error){
        echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>error</strong> '.$error.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if($notnull){
        echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>error</strong> '.$notnull.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>
  <?php require 'nav.php'?>
    
<!-- Login Form -->
<div class="login-container">
<h5> Welcome to Notify, where your tasks get simplified.</h5>
<hr style="color:white ;opacity:1">
  <h2>Create account!</h2>
  <form action="signup.php" method="post">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>
    </div>
    
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
      <label for="cpassword"> Confirm Password</label>
      <input type="password" id="password" name="cpassword" required>
    </div>
    
    <button type="submit">signup</button>
    
    
    
  </form>
</div>










    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>

</div>

