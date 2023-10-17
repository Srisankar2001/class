<?php
 $con = new mysqli("localhost:4306","root","","class");
 if($con->connect_error){
    die("Connection Error".$con->connect_error);
 }
?>