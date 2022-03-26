<?php

require 'config.php';

$status = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (empty($name) || empty($email)) {
        $status = 'All failds are empty';
    } else {
        if (strlen($name) >= 100 || !preg_match("/^[a-zA-Z-'\s]+$/", $name)) {
            $status = 'Enter valid name';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $status = 'Enter valid email';
        } else {
            $sql = "INSERT INTO students (name, email) VALUES (:name, :email)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute(['name' => $name, 'email' => $email]);

            $status = "Done";
            $name = "";
            $email = "";
        }
    }
}

$selectData = 'SELECT * FROM students';




?>


<html>

<head>
    <title>Students</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/stdpage_style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <div class="homepagelink">
        <a id="homebutton" href="homepage.php">Home</a>
    </div>

    <div class="myform">

        <h1>Add Student</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="">Name</label>
                <input class="form-control" type="text" placeholder="Enter student name" name="name">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input class="form-control" type="text" placeholder="Enter student email" name="email">
            </div>
            <!-- <input type="submit" value="Add"><br> -->
            <button type="submit" class="button">Add</button>

        </form>
        <div class="status">
            <?php echo $status ?>
        </div>

        <!-- <a href="display_students.php" >View Students</a> -->
    </div>


    <table class="table table-striped table-bordered">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php
        foreach ($pdo->query($selectData) as $row) {
            echo "<tr> 
                    <td>$row[id]</td>
                    <td>$row[name]</td>
                    <td>$row[email]</td>
                    <td> 
                        <a class =\"edit\" href=\"editstudent.php?send_id=$row[id]&name_value=$row[name]&email_value=$row[email]\" >Edit</a>
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
                    url: "del_student.php",
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


<!-- editstudent.php?send_id=$row[id]&name_value=$row[name]&email_value=$row[email] -->
<!-- deletestudent.php?send_id=$row[id]&name_value=$row[name]&email_value=$row[email] -->




<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width:60%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Report customization</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="ModelBodyHTML">
                    <div class="row">
                        <div class="col-md-6 panel panel-primary customer-details medium-capped-width">
                            <div class="panel-body">
                                <div id="clusterSummary" class="text-primary aml-panel-title text-bold">
                                </div>
                                <div class="labelValueRows">
                                    <div class="labelValueRow">
                                        <div class="text-label text-bold">Pick columns for the grid</div>
                                        <div id="columngrid"></div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div id="customerDetails" class="col-md-6 panel panel-primary customer-details medium-capped-width">
                            <div class="panel-body">
                                <div id="clusterSummary" class="text-primary aml-panel-title text-bold">
                                </div>
                                <div class="labelValueRows">
                                    <div class="labelValueRow">
                                        <div class="text-label text-bold">pick column for the chart</div>
                                        <div id="columnchart"></div>


                                    </div>

                                </div>

                            </div>
                        </div>


                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit" data-toggle="modal" data-target="#yesOrno" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <button class="tablebtn" type="button" id="ModelBTN" data-toggle="modal" value="@T[" TABLE_SCHEMA"].ToString().@T["TABLE_NAME"].ToString()" data-target="#exampleModal">
        Select
    </button> -->