<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='main.css'>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title><?php echo htmlspecialchars($_GET['name']); ?></title>
    <style>
        input[type='text'] {
            text-align: center;
        }

        .btn {
            cursor: pointer;
            margin: 5px;

        }

        form#change tr td a.btn {
            visibility: hidden;
        }

        form#change tr:hover td a.btn {
            visibility: visible;
        }

        th {
            text-align: center;
        }

        td,
        th,
        tr {
            width: 100%;
        }
    </style>
    <script>
        function addElements(x) {
            var mainTable = x.parentNode.parentNode.parentNode;
            mainTable.insertRow(-1);
            document.getElementById('add_row').remove();
            mainTable.lastChild.innerHTML = "<td><input type='text' name='item_name[]'></td>";
            mainTable.lastChild.innerHTML += "<td><input type='text' name='quantity[]'></td>";
            mainTable.lastChild.innerHTML += "<td><a title='Delete row' onclick='deleteElements(this);' class='btn'><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
            mainTable.lastChild.innerHTML += "<td><a id='add_row' title='Add row' onclick='addElements(this);' class='btn'><i class='fa fa-plus' aria-hidden='true'></i></a></td>";
        }

        function deleteElements(x) {
            x.childNodes[0].className = "fa fa-spinner fa-pulse";
            var td = x.parentNode;
            var tr = td.parentNode;
            var data = new FormData();
            data.append('item_name', td.parentNode.childNodes[0].childNodes[0].value);
            data.append('quantity', td.parentNode.childNodes[1].childNodes[0].value);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'removeListItems.php', true);
            xhr.onload = function() {
                if (this.status == 200) {
                    console.log(this.responseText);
                    x.childNodes[0].className = "fa fa-check";
                    tr.addEventListener("mouseout", function() {
                        tr.remove();
                    });
                }
            }
            xhr.send(data);
        }

        function updateList() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_list.php', true);
            var data = new FormData(document.getElementById("change"));
            xhr.onload = function() {
                if (this.status == 200) {
                    alert('Updated');
                }
            }
            xhr.send(data);
        }

        function openNav() {
            document.getElementById("mySidenav").style.width = "150px";
            document.getElementById("main").style.marginLeft = "150px";
            document.getElementById("content").style.marginLeft = "150px";

            document.getElementById("drawer").setAttribute("onclick", "closeNav()");
            document.getElementById("drawer").innerHTML = "&times;";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
            document.getElementById("content").style.marginLeft = "0";

            document.getElementById("drawer").setAttribute("onclick", "openNav()");
            document.getElementById("drawer").innerHTML = "&#9776;";
        }
    </script>

</head>

<body>
    <div class="heading">
        <div id="mySidenav" class="sidenav">

            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Clients</a>
            <a href="#">Contact</a>
        </div>

        <div id="main">
            <a style='text-decoration: none;color:white;text-align:center' href="index.php">Grocery List</a>
            <span style="float:left;font-size:30px;cursor:pointer;padding-left: 5px;" onclick="openNav()" id="drawer">&#9776;</span>
        </div>


    </div>
    <div style="top:15%;position:fixed;text-align:center;transition:0.3s" id="content">
        <form id="change">
            <?php
            $op = "";
            $con = mysqli_connect("localhost", "root", "", "mysql");
            $list_name = mysqli_real_escape_string($con, htmlspecialchars($_GET['name']));
            $res = mysqli_query($con, "select list_name,deadline from lists where list_name='" . $list_name . "'");
            $res = mysqli_fetch_assoc($res);
            $_SESSION['old_list_name'] = "$list_name";
            $op .= "<table cellspacing='0' style='border:1px solid black'>";
            $op .= "<tr>";
            $op .= "<th>List Name</th>";
            $op .= "<th>Deadline</th>";
            $op .= "</tr>";
            $op .= "<tr>";
            $op .= "<td><input type='text' value='" . $res['list_name'] . "' name='list_name'></td>";
            $op .= "<td><input type='date' value='" . $res['deadline'] . "' name='deadline'></td>";
            $op .= "</tr>";
            $query = "select quantity,item_name from lists," . $list_name . "_products where list_name='$list_name'";
            $res = mysqli_query($con, $query);

            $op .= "<tr><th>" . "Item Name" . "</th><th>Quantity</th></tr>";
            $row_count = mysqli_num_rows($res);
            $iteration = 0;
            while ($row = mysqli_fetch_assoc($res)) {
                $op .= "<tr>";
                $op .= "<td><input type='text' name='item_name[]' value='" . $row['item_name'] . "'></td>";
                $op .= "<td><input type='text' name='quantity[]' value='" . $row['quantity'] . "'></td>";
                $op .= "<td><a title='Delete row' onclick='deleteElements(this);' class='btn'><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
                if($iteration+1 === $row_count){
                $op .= "<td><a id='add_row' title='Add row' onclick='addElements(this);' class='btn'><i class='fa fa-plus' aria-hidden='true'></i></a></td>";
                }
                $op .= "</tr>";
                $iteration++;
            }
            $op .= "</table>";
            echo $op;
            ?>
            <a onclick="updateList()" title="Update"><i id='button' class="fa fa-check-circle custombtn" style="font-size:65px"></i></a>
        </form>
    </div>
    <script>
        var element = document.getElementById('change');
        element.addEventListener("submit", function(evt) {
            evt.preventDefault();
        }, true);
    </script>
</body>

</html>
