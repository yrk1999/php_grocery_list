<?php 
session_start();
$con = mysqli_connect("localhost","root","","mysql");
$query = "select list_name from lists";
$result = mysqli_query($con,$query);
$output = mysqli_fetch_all($result,MYSQLI_ASSOC);
echo json_encode($output);
$con->close();
?>
