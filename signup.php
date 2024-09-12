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
          

          $sql = "SELECT * FROM `note_login` WHERE `username` = '$username'";
          $result = mysqli_query($conn, $sql);
          $num = mysqli_num_rows($result);

          if($num>0){
            echo"<script>alert('username already exist , Please choose a different username.');</script>";
          }else{

            if(($password===$cpassword)){
              $sql = "INSERT INTO `note_login` (`username`, `password`, `date`) VALUES ('$username', '$password', current_timestamp())";
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
<hr>
  <h2>Create account!</h2>
  <form action="signup.php" method="post">
    <div class="form-group">
    
      <input type="text" id="username" placeholder="Username" name="username" required>
      <img src="./icons/person.svg" alt="">
    </div>
    
    <div class="form-group">
      
      <input type="password" id="password" placeholder="Password" class="password-field" name="password" required>
      <img src="./icons/eye-slash-fill.svg" class="icon" alt="">
    </div>
    <div class="form-group">
      
      <input type="password" id="cpassword" placeholder="Confirm Passowrd" class="password-field2" name="cpassword" required>
      <img src="./icons/eye-slash-fill.svg" class="icon2" alt="">
    </div>
    
    <button type="submit">signup</button>
    
    
    
  </form>
</div>
<?php require 'footer.php' ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    
    <script>
   document.addEventListener('DOMContentLoaded', () => {
  const passwordField = document.querySelector('.password-field'); // Select the password input
  const toggleIcon = document.querySelector('.icon'); // Select the toggle icon (image)

  toggleIcon.addEventListener('click', () => {
    // Check the current type of the input field
    if (passwordField.type === 'password') {
      passwordField.type = 'text';  // Change the type to 'text' to unhide the password
      toggleIcon.src = './icons/eye-fill.svg';  // Change the icon to represent 'hidden' state (optional)
    } else {
      passwordField.type = 'password';  // Change the type back to 'password' to hide the password
      toggleIcon.src = './icons/eye-slash-fill.svg';  // Change the icon back to represent 'visible' state (optional)
    }
  });

  const passwordField2 = document.querySelector('.password-field2'); // Select the password input
  const toggleIcon2 = document.querySelector('.icon2'); // Select the toggle icon (image)

  toggleIcon2.addEventListener('click', () => {
    // Check the current type of the input field
    if (passwordField2.type === 'password') {
      passwordField2.type = 'text';  // Change the type to 'text' to unhide the password
      toggleIcon2.src = './icons/eye-fill.svg';  // Change the icon to represent 'hidden' state (optional)
    } else {
      passwordField2.type = 'password';  // Change the type back to 'password' to hide the password
      toggleIcon2.src = './icons/eye-slash-fill.svg';  // Change the icon back to represent 'visible' state (optional)
    }
  });
});


    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>

</div>

