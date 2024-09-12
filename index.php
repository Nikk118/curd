<?php
session_start(); // Start the session at the beginning of the script

$alert = false;
$update = false;
$delete = false;

$username = "root";
$servername = "localhost:3307";
$password = "";
$database = "notify";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("No connection to database");
}

// Retrieve the logged-in user's rno from the session
$rno = $_SESSION['rno'] ?? null; // Use null coalescing to handle unset session variable

if ($rno === null) {
    header("location:login.php");
}
// Check if delete operation is requested
if (isset($_GET['delete']) && $rno !== null) {
    $sno = $_GET['delete'];
    // Delete note only if it belongs to the logged-in user
    $sql = "DELETE FROM `notes1` WHERE `sno` = '$sno' AND `rno` = '$rno'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $delete = true;
    }
}

// Check if a POST request is made
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $rno !== null) {
    if (isset($_POST['snoedit'])) {
        $sno = $_POST['snoedit'];
        $title = $_POST['titleedit'];
        $desc = $_POST['descedit'];
        // Update note only if it belongs to the logged-in user
        $sql = "UPDATE `notes1` SET `title` = '$title', `description` = '$desc' WHERE `sno` = '$sno' AND `rno` = '$rno'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        }
    } else {
        // Inserting a new note
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $sql = "INSERT INTO `notes1` (`title`, `description`, `time`, `rno`) VALUES ('$title', '$desc', current_timestamp(), '$rno')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $alert = true;
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Notes </title>
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editmodal">
  Launch  modal
</button> -->

    <!-- Modal -->
    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editmodalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editNoteForm" action="index.php" method="post" class="my-4">
                        <input type="hidden" name="snoedit" id="snoedit">
                        <div class="mb-3">
                            <label for="titleedit" class="form-label">Note title</label>
                            <input type="text" class="form-control" id="titleedit" name="titleedit"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="descedit" class="form-label">Description</label>
                            <textarea class="form-control" id="descedit" name="descedit"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

   <?php require "nav.php"?>
    <?php
if($alert){
  echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>sucess!</strong> note is inserted 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if($update){
  echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>sucess!</strong> note is updated 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if($delete){
  echo'<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>sucess!</strong> note is delete 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>


    <div class="sort-buttons">
        <button id="sort-name active">Name ↕</button>
        <button id="sort-description">Description ↕</button>
        <button id="sort-time">Time ↕</button>
    </div>

    <div id="notes-container">


    <?php
 
 $sql = "SELECT * FROM `notes1` WHERE `rno` = '$rno'";
 $result = mysqli_query($conn, $sql);
 $sno = 1;
 
 while ($row = mysqli_fetch_assoc($result)) {
     echo '
     <div class="dis_container">
         <div class="display">
             <h2 class="display_title">' . htmlspecialchars($row['title']) . '</h2>
             <p class="display_name">' . htmlspecialchars($row['description']) . '</p>
             <div class="btns">
                 <button id="' . $row['sno'] . '" type="button" class="edit btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editmodal">Edit</button>
                 <button type="button" class="delete btn btn-primary btn-sm mx-3" id="d' . $row['sno'] . '">Delete</button>
             </div>
             <p class="time">' . $row['time'] . '</p>
         </div>
     </div>';
     $sno += 1;
 }
?>


    </div>
    <div class="add">

        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="orange" class="bi bi-plus-circle-fill "
            viewBox="0 0 16 16" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
        </svg>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add a new note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <div class="container" style="width:800px"> -->

                    <form action="index.php" method="post" class="my-4">
                        <!-- <h1>Add a new note</h1> -->
                        <div class="mb-3">

                            <label for="title" class="form-label">Note title</label>
                            <input type="text" class="form-control" id="title" name="title"
                                aria-describedby="emailHelp">

                            <div class="mb-3">
                                <label for="desc" class="form-label">description</label>
                                <textarea class="form-control" id="desc" name="desc"></textarea>

                            </div>

                            <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               
            </div>
        </div>
    </div>
    </div>
     <?php require 'footer.php' ?>





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="//cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>

    <script src="script.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>
</html>