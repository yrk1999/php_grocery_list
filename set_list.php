<?php 
session_start();
function insertProducts(){
    $con = mysqli_connect("localhost","root","","mysql");
    $x = 0;
    if(count($_POST['item_name']) == 0)
    {
        header('HTTP/1.1 403');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR', 'code' => 1337)));

    }else{
    while($x < count($_POST['item_name']))
    {   
        $name = mysqli_real_escape_string($con,htmlspecialchars($_POST['item_name'][$x]));
        $name =  str_replace(' ', '_', $name);
        $quantity = mysqli_real_escape_string($con,htmlspecialchars($_POST['quantity'][$x]));
        $quantity =  str_replace(' ', '_', $quantity);
        $query = "insert into ". $_SESSION['list_name'] . "_products(item_name,quantity) values ('$name','$quantity')";
        mysqli_query($con,$query);
        $x++;

    }
}
}
insertProducts();
$con->close();
?>
