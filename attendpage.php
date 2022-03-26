<?php
require 'config.php';

$select_lectures = "SELECT * FROM lectures";

$select_students = "SELECT * FROM students";

// Getting Attendance data
$select_attendance = "SELECT * FROM attendance";
$attendance_data = array();
foreach ($pdo->query($select_attendance) as $row) {
    $attendance_data[$row['studentid']][$row['lectureid']] = $row['attend'];
}

?>

<html>

<head>
    <title>Attendance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/attendance_style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

    <div class="homepagelink row">
        <a id="homebutton" href="homepage.php">Home</a>
    </div>

    <div class="row">
        <h2>Attendance</h2>
    </div>

    <div class="container">

        <table class="table table-striped table-bordered">
            <thead>
                <?php
                echo "<tr><td>Students / Lectures</td>";
                foreach ($pdo->query($select_lectures) as $col) {
                    echo "<td>$col[1]</td>";
                }
                echo "</tr>";
                ?>
            </thead>
            <?php

            

            foreach ($pdo->query($select_students) as $row) {
                echo "<tr> <td>$row[1]</td>";
                foreach ($pdo->query($select_lectures) as $col) {
                    if(!empty($attendance_data[$row['id']][$col['id']]) && $attendance_data[$row['id']][$col['id']]==1){
                        echo "<td> <input class = \"check\"  type=\"checkbox\" checked data-stdid = \"$row[0]\" data-lecid =\"$col[0]\"> </td>";
                    }
                    else{
                        echo "<td> <input class = \"check\"  type=\"checkbox\" data-stdid = \"$row[0]\" data-lecid =\"$col[0]\"> </td>";
                    }
                }
                echo "</tr>";
            }
            ?>
                        
        </table>
    </div>



    <script>
        $(".check").on('click', function(e) {
            var studentid = $(this).data("stdid");
            var lectureid = $(this).data("lecid");

            if ($(this).is(":checked")) {


                var status = 1;
                // $.ajax({
                //     type: 'POST',
                //     url: 'check_attend.php',
                //     data: {
                //         stdid: studentid,
                //         lecid: lectureid,
                //         ssss: status
                //     },

                // })
                $.post('check_attend.php', {
                    stdid: studentid,
                    lecid: lectureid,
                    ssss: status
                })
            } else {

                var status = 0;
                // $.ajax({
                //     type: 'POST',
                //     url: 'check_attend.php',
                //     data: {
                //         stdid: studentid,
                //         lecid: lectureid,
                //         ssss: status
                //     },

                // })
                $.post('check_attend.php', {
                    stdid: studentid,
                    lecid: lectureid,
                    ssss: status
                })
            }

            
        })
    </script>
</body>

</html>