<?php
     $username="root";
     $servername="localhost:3307";
     $password="";
     $database="notify";
 
     $conn=mysqli_connect($servername,$username,$password,$database);
    if(!$conn){
        echo"no coonnection to database";
    }

?>