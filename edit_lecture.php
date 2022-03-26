<?php
require 'config.php';
$lec_id =  $_REQUEST['send_id'];
$lec_name = $_REQUEST['name_value'];
$lec_dname = $_REQUEST['dname_value'];
$status = '';


try {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newname = $_POST['newname'];
        $newdname = $_POST['newdname'];


        if (empty($newname) || empty($newdname)) {
            $status = 'All failds are empty';
        } else {
            if (strlen($newname) >= 100 || !preg_match("/^[a-zA-Z-'\s]+$/", $newname)) {
                $status = 'Enter valid name';
            } else if (strlen($newdname) >= 100 || !preg_match("/^[a-zA-Z-'\s]+$/", $newdname)) {
                $status = 'Enter valid doctor name';
            } else {
                $sql = "UPDATE lectures  SET name=? , dname=? WHERE id=?";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([$newname, $newdname, $lec_id]);

                $status = "Done";
                $newname = "";
                $newdname = "";
            }
        }
    }
} catch (PDOException $e) {
    $status = $e;
    // echo $status;
}
?>

<html>

<head>
    <title>Edit Student</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/edit_lecture_style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>
    <div class="homepagelink">
        <a id="homebutton" href="homepage.php">Home</a>
    </div>
    <div class="myform">
        <h2>Enter New Data for <?php echo $lec_name; ?></h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="">New Name</label>
                <input class="form-control" type="text" placeholder="Enter new lecture name" name="newname">
            </div>
            <div class="form-group">
                <label for="">New Doctor name</label>
                <input class="form-control" type="text" placeholder="Enter new doctor name" name="newdname">
            </div>
            <button type="submit" class="button">Edit</button>


        </form>

        <div class="status">
            <?php echo $status ?>
        </div>
        <p class="end">
            <a href="lecpage.php">View lectures</a>
        </p>


    </div>

</body>

</html>