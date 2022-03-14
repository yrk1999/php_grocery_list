<?php
session_start();
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset='utf-8' />
    <link rel='stylesheet' href='main.css' />
    <script src="jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .btn {
            float: right;
            padding-right: 5px;
            visibility: hidden;
        }

        .container_p:hover .btn {
            visibility: visible;
        }
    </style>
    <script>
        function deleteElements(btn) {
            var list_name = btn.parentNode.textContent;
            var xhr = new XMLHttpRequest();
            xhr.open('GET','deleteList.php?name='+list_name,true);
            xhr.onload = function(){
                if(this.status == 200)
                {
                    btn.parentNode.remove();
                }
            }
            xhr.send();
        }

        function loadLists() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_list.php', true);
            var output = '';
            xhr.onload = function() {
                if (this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    for (x in data) {
                        output += "<p class='container_p'><a style='text-decoration:none;' href='loadList.php?name=" + data[x].list_name + "'>";
                        output += data[x].list_name;
                        output += "</a>";
                        output += "<a title='Delete row' onclick='deleteElements(this);' class='btn'><i class='fa fa-trash' aria-hidden='true'></i></a>";
                        output += "</p>";
                    }
                    document.getElementById('grocery_list').innerHTML += output;
                }
            }
            xhr.send();
        }

        function reCalculate(operation) {
            var cols = document.getElementsByClassName('container_p');
            //1 is when the sidenav is opened
            if (operation == 1) {
                for (i = 0; i < cols.length; i++) {
                    cols[i].style.width = "calc(95% - 150px)";
                }
            } // 2 when sidenav is closed 
            else if (operation == 2) {
                for (i = 0; i < cols.length; i++) {
                    cols[i].style.width = "95%";
                }
            }
        }

        function openNav() {
            document.getElementById("mySidenav").style.width = "150px";
            document.getElementById("main").style.marginLeft = "150px";
            document.getElementById("content").style.marginLeft = "150px";
            reCalculate(1);
            document.getElementById("drawer").setAttribute("onclick", "closeNav()");
            document.getElementById("drawer").innerHTML = "&times;";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
            document.getElementById("content").style.marginLeft = "0";
            document.getElementById("drawer").setAttribute("onclick", "openNav()");
            document.getElementById("drawer").innerHTML = "&#9776;";
            reCalculate(2);
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

    <div class="content" id="content">
        <div class="grocery_list" id='grocery_list' style='font-size:30px'>Your Lists:</div>

    </div>

    <a href="form1.php"><i id='button' class="fa fa-plus-circle custombtn" style="font-size:65px"></i></a>
    <script>
        window.onload = loadLists;
    </script>

</body>

</html>