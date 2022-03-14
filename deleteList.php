<?php 
session_start();

$con = mysqli_connect("localhost","root","","mysql");
$list_name = mysqli_real_escape_string($con,htmlspecialchars($_GET['name']));
$query = "delete from lists where list_name='" . $list_name . "'";
$res = mysqli_query($con,$query);
if($res)
{
    $query = "drop table " . $list_name . "_products"; 
    mysqli_query($con,$query);
}
?>
