<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='main.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        table {
            border-collapse: collapse;
            margin-top: 5px;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<script>
    function sendData() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'set_list.php', true);

        var formdata = new FormData(document.getElementById('preview_form'));
        xhr.onload = function() {
            if(this.status == 200)
            {
            alert('Created');
            }
        }
        xhr.send(formdata);
    }

    function loadDate() {
        var field = document.querySelector('#deadline');
        var date = new Date();

        // Set the date
        field.value = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
            '-' + date.getDate().toString().padStart(2, 0);
        field.min = field.value;
    }

    function remove() {
        var data = new FormData();
        data.append('list_name', document.getElementById('list_name').value);
        data.append('deadline', document.getElementById('deadline').value);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'getNewData.php', true);
        xhr.onload = function() {
            if (this.status == 200) {
                document.getElementById('namedate').innerHTML = this.responseText;
                document.getElementById('preview_form').style.visibility = 'visible';
                var btn = document.getElementById('remove');
                btn.setAttribute("onClick", "updateTable()");
                btn.innerHTML = "Insert";
            }
        }
        xhr.send(data);

    }

    function updateTable() {
        //update preview table
        var table = document.getElementById("preview");
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "<input type='text' value='" + document.getElementById('item_name').value + "' name='item_name[]" + "' >";
        cell2.innerHTML = "<input type='text' value='" + document.getElementById('quantity').value + "' name='quantity[]" + "'>";
        document.getElementById('item_name').value = "";
        document.getElementById('quantity').value = "";
        document.getElementById('item_name').focus();
    }
</script>

<body id='body'>
    <div class="heading">
        <a style='text-decoration: none;color:white;' href="index.php">Grocery List</a>

    </div>
    <div class='form_area' id="add_list">
        <form id='item_list'>
            <table id='namedate'>
                <tr>
                    <td>
                        List Name:
                    </td>
                    <td>
                        <input type='text' name='list_name' id='list_name' placeholder='List Name' /><br />
                    </td>
                </tr>
                <tr>
                    <td>
                        Deadline:
                    </td>
                    <td>

                        <input type="date" name='deadline' id="deadline">
                    </td>
                </tr>
                <tr style='border:0'>
                    <td rowspan="2" style='border:0'>
                        <button id='remove' onclick='remove()'>Create</button>
                    </td>
                </tr>
            </table>



        </form>
        <form method="POST" id='preview_form' action='set_list.php' style='visibility:hidden'>
            <table id='preview' class='preview'>

            </table>
            <a onclick="sendData()" title="Submit"><i id='button' class="fa fa-check-circle custombtn" style="font-size:65px"></i></a>
        </form>
    </div>


    <script>
        window.onload = loadDate;
        var element = document.getElementById('item_list');
        element.addEventListener("submit", function(evt) {
            evt.preventDefault();
        }, true);
        var element = document.getElementById('preview_form');
        element.addEventListener("submit", function(evt) {
            evt.preventDefault();
        }, true);
        
    </script>
</body>

</html>