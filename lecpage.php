<?php

require 'config.php';

$status = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $dname = $_POST['dname'];

    if (empty($name) || empty($dname)) {
        $status = 'All failds are empty';
    } else {
        if (strlen($name) >= 100 || !preg_match("/^[a-zA-Z-'\s]+$/", $name)) {
            $status = 'Enter valid name';
        } else if (strlen($dname) >= 100 || !preg_match("/^[a-zA-Z-'\s]+$/", $dname)) {
            $status = 'Enter valid doctor name';
        } else {
            $sql = "INSERT INTO lectures (name, dname) VALUES (:name, :dname)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute(['name' => $name, 'dname' => $dname]);

            $status = "Done";
            $name = "";
            $email = "";
        }
    }
}

$selectData = 'SELECT * FROM lectures';
?>

<html>

<head>
    <title>Lectures</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/lecpage_style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <div class="homepagelink">
        <a id="homebutton" href="homepage.php">Home</a>
    </div>

    <div class="myform">
        <h1>Add Lecture</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="">lectur name</label>
                <input class="form-control" type="text" placeholder="Enter lecture name" name="name">
            </div>
            <div class="form-group">
                <label for="">doctor name</label>
                <input class="form-control" type="text" placeholder="Enter doctor name of lecture" name="dname">
            </div>

            <button type="submit" class="button">Add</button>

        </form>
        <div class="status">
            <?php echo $status ?>
        </div>
    </div>

    <table class="table table-striped table-bordered">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Doctor name</th>
            <th>Actions</th>
        </tr>
        <?php
        foreach ($pdo->query($selectData) as $row) {
            echo "<tr> 
                    <td>$row[id]</td>
                    <td>$row[name]</td>
                    <td>$row[dname]</td>
                    <td> 
                        <a class =\"edit\" href=\"edit_lecture.php?send_id=$row[id]&name_value=$row[name]&dname_value=$row[dname]\" >Edit</a>
                        <a class =\"delete\" id=\"$row[id]\" href=\"\">Delete</a>
                    </td>
                    </tr>";
        }
        ?>

    </table>

    <script>
        $(".table").on('click', '.delete', function(e) {
            e.preventDefault();
            var row_id = $(this).attr("id");
            if (confirm('Are you sure you want to delete this?')) {
                var row_id = $(this).attr("id");
                var parent = $(this).parent().parent();
                $.ajax({
                    type: "POST",
                    url: "delete_lecture.php",
                    data: {
                        id: row_id
                    },
                    success: function() {
                        parent.remove();
                    }
                })
            }
        })
    </script>
</body>

</html>