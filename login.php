<?php
session_start(); // Start the session at the beginning

$login = false;
$error = false;
$alert = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'dbcon.php'; // Ensure this file contains the correct database connection

    // Retrieve and escape user inputs to prevent SQL injection
    $username =  $_POST['username'];
    $password =  $_POST['password'];
// echo $username;
    // SQL query to fetch the user's information based on the username
    $sql = "SELECT * FROM `note_login` WHERE `username` = '$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $row = mysqli_fetch_assoc($result); // Fetch the user data

        // Verify the password
        // echo $row['password'];
        // echo $password;
        if ($password===$row['password']) {
            $alert = true;
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            $_SESSION['rno'] = $row['rno'];  // Store the user's rno (user ID) in the session
            header("Location: index.php");
            exit(); // Ensure no further script execution
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "Account doesn't exist";
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

    <title>Login Page</title>
</head>

<body>
<?php  
    if ($alert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> You are now logged in.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($error) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error!</strong> ' . htmlspecialchars($error) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
?>
<?php require 'nav.php'; ?>

<!-- Login Form -->
<div class="login-container">
    <h5>Welcome Back! to Notify, where your tasks get simplified.</h5>
    <hr >
    <!-- <h2>login</h2> -->
    
    <form action="login.php" method="post">
        <div class="form-group">
            <!-- <label for="username">Username</label> -->
            <input type="text" id="username" name="username" placeholder="Username" required>
            
            <img src="./icons/person.svg" alt="">
            
        </div>
        <div class="form-group">
            <!-- <label for="password">Password</label> -->
            <input type="password" id="password" name="password" class="password-field" placeholder="Pawssword" required>
            <img src="./icons/eye-slash-fill.svg" class="icon" alt="">
        </div>
        
        <button type="submit">Login</button>
        
        <div class="form-footer">
            <a href="#">Forgot your password?</a>
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
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
});
;

    </script>
<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
</body>

</html>
