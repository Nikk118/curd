<?php
  $alert=false;
  $update=false;
  $delete=false;

     $username="root";
     $servername="localhost:3307";
     $password="";
     $database="notify";
 
     $conn=mysqli_connect($servername,$username,$password,$database);
    if(!$conn){
        echo"no coonnection to database";
    }
    if(isset($_GET['delete'])){
      $sno=$_GET['delete'];
      $sql = "DELETE FROM `notes` WHERE `sno` = '$sno'"; 
      $result=mysqli_query($conn,$sql);
      if($delete){
        $update=true;
      }
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
      if(isset($_POST['snoedit'])){
        $sno=$_POST['snoedit'];
        $title=$_POST['titleedit'];
        $desc=$_POST['descedit'];
        $sql = "UPDATE `notes` SET `title` = '$title',`description`='$desc' WHERE `notes`.`sno` = '$sno'"; 
        $result=mysqli_query($conn,$sql);
        if($result){
          $update=true;
        }
      }else{
        $title=$_POST['title'];
        $desc=$_POST['desc'];
        $sql = "INSERT INTO `notes` ( `title`, `description`, `time`) VALUES ('$title', '$desc', current_timestamp())";
        $result=mysqli_query($conn,$sql);
        if($result){
          $alert=true;
          // echo"success";
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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Notify</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>


                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
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
if($update){
  echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>sucess!</strong> note is delete 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>

    <div class="container" style="width:800px">

        <form action="index.php" method="post" class="my-4">
            <h1>Add a new note</h1>
            <div class="mb-3">

                <label for="title" class="form-label">Note title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">

                <div class="mb-3">
                    <label for="desc" class="form-label">description</label>
                    <textarea class="form-control" id="desc" name="desc"></textarea>

                </div>

                <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>

    <table class="table" id="myTable">
        <thead>
            <tr>
                <th scope="col">sno</th>
                <th scope="col">title</th>
                <th scope="col">decsription</th>
                <th scope="col">actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
    $sql="SELECT * FROM `notes`";
    $result=mysqli_query($conn,$sql);
    $sno=1;
    while($row=mysqli_fetch_assoc($result)){
        echo"<tr>
      <th scope='row'>".$sno."</th>
      <td>".$row['title']."</td>
      <td>".$row['description']."</td>
      <td><button id=".$row['sno']."  type='button' class=' edit btn btn-primary btn-sm'>edit</button><button type='button' class=' delete btn btn-primary btn-sm mx-3' id=d".$row['sno'].">delete</button></td>
    </tr>";
       $sno+=1;
    }
    ?>


        </tbody>
    </table>
    <hr>




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="//cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>
    <script>
    // Get all elements with the class name 'edit'
    document.addEventListener('DOMContentLoaded', () => {
        const edits = document.getElementsByClassName('edit');

        Array.from(edits).forEach((element) => {
            element.addEventListener('click', (e) => {
                const tr = e.target.closest('tr');

                if (tr) {
                    const title = tr.getElementsByTagName('td')[0].textContent.trim();
                    const desc = tr.getElementsByTagName('td')[1].textContent.trim();
                    const sno = tr.getElementsByTagName('td')[2].textContent.trim();

                    // Update the modal fields with the current note's data
                    document.getElementById('titleedit').value = title;
                    document.getElementById('descedit').value = desc;
                    document.getElementById('snoedit').value = e.target.id;
                    console.log(e.target.id)

                    // Show the modal
                    const editModal = new bootstrap.Modal(document.getElementById('editmodal'));
                    editModal.show();
                }
            });
        });
        const deletes = document.getElementsByClassName('delete');

Array.from(deletes).forEach((element) => {
    element.addEventListener('click', (e) => {
        const tr = e.target.closest('tr');

        if (tr) {
          sno=e.target.id.substr(1,)

            // Update the modal fields with the current note's data
           if(confirm("delete this node")){
            console.log("yes")
            window.location=`/curd/index.php?delete=${sno}`;
          }else{
             console.log("no")

           }
        }
    });
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