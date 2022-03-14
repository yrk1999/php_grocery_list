<?php
session_start();
$con = mysqli_connect("localhost","root","","mysql");
$item_name = mysqli_real_escape_string($con,htmlspecialchars($_POST['item_name']));
$quantity = mysqli_real_escape_string($con,htmlspecialchars($_POST['quantity']));
$query = "delete from " . $_SESSION['old_list_name'] . "_products where item_name='" . $item_name ."' and quantity='" . $quantity . "'";
echo $query;
mysqli_query($con,$query);
$con->close();
?>
