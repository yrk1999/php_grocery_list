<?php 
session_start();

$con = mysqli_connect("localhost","root","","mysql");
$query = "select * from lists where list_name='". $_SESSION['old_list_name']. "'";
$list_name = mysqli_real_escape_string($con,htmlspecialchars($_POST['list_name']));
$list_name =  str_replace(' ', '_', $list_name);
$deadline = mysqli_real_escape_string($con,htmlspecialchars($_POST['deadline']));

$res = mysqli_query($con,$query);

if(mysqli_num_rows($res) == 1)
{
    if($_SESSION['old_list_name'] !== $list_name){
    $query = "update lists set list_name='" . $list_name . "',deadline='" . $deadline . "' where list_name = '" . $_SESSION['old_list_name'] . "'";
    $res = mysqli_query($con,$query);
    $query = "rename table " . $_SESSION['old_list_name'] . "_products to " . $list_name . "_products";
    $res = mysqli_query($con,$query);
    }

    $query = "update lists set deadline='" .$deadline. "' where list_name = '" . $list_name . "'";
    $res = mysqli_query($con,$query);
    $query = "truncate " . $list_name . "_products";
    $res = mysqli_query($con,$query);
    $x = 0;
    while($x < count($_POST['item_name']))
    {   
        $name = mysqli_real_escape_string($con,htmlspecialchars($_POST['item_name'][$x]));
        $name =  str_replace(' ', '_', $name);
        $quantity = mysqli_real_escape_string($con,htmlspecialchars($_POST['quantity'][$x]));
        $quantity =  str_replace(' ', '_', $quantity);
        $query = "insert into ". $list_name . "_products(item_name,quantity) values ('$name','$quantity')";
        mysqli_query($con,$query);
        $x++;
    }
}
$con->close();
?>
