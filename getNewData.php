<?php
session_start();
$con = mysqli_connect("localhost","root","","mysql");
$list_name = mysqli_real_escape_string($con,htmlspecialchars($_POST['list_name']));
$list_name =  str_replace(' ', '_', $list_name);
$deadline = mysqli_real_escape_string($con,htmlspecialchars($_POST['deadline']));
$query = "select * from lists where list_name='" . $list_name . "'";
$res = mysqli_query($con,$query);
if(mysqli_num_rows($res) == 0){
$query = "insert into lists(list_name,deadline) values('$list_name','$deadline')";
$res = mysqli_query($con,$query);
$_SESSION['list_name'] = "$list_name";

$query = "create table " .$list_name . "_products(pid int primary key auto_increment,item_name varchar(1000),quantity varchar(200))";
$res = mysqli_query($con,$query);
    echo
    "<tr>
        <th>Item Name</th>
        <th>Quantity</th>
    </tr>
    <tr>
        <td>
            Item name:
        </td>
        <td>
            <input type='text' name='item_name' id='item_name'><br>
        </td>
    </tr>
    <tr>
        <td>
            Quantity
        </td>
        <td>
            <input type='text' name='quantity' id='quantity'><br>
        </td>
    </tr>
    
    ";
}
else{
    echo "List name in use!!";
}
$con->close();
?>
