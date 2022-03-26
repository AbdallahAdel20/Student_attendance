<?php
require 'config.php';
$std_id =  $_REQUEST['send_id'];
$std_name = $_REQUEST['name_value'];
$std_email = $_REQUEST['email_value'];
$status = '';


try {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newname = $_POST['newname'];
        $newemail = $_POST['newemail'];


        if (empty($newname) || empty($newemail)) {
            $status = 'All failds are empty';
        } else {
            if (strlen($newname) >= 100 || !preg_match("/^[a-zA-Z-'\s]+$/", $newname)) {
                $status = 'Enter valid name';
            } else if (!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
                $status = 'Enter valid email';
            } else {
                $sql = "UPDATE students  SET name=? , email=? WHERE id=?";

                $stmt = $pdo->prepare($sql);

                $stmt->execute([$newname, $newemail, $std_id]);

                $status = "Done";
                $newname = "";
                $newemail = "";
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
    <link href="css/edit_student_style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>
    <div class="homepagelink">
        <a id="homebutton" href="homepage.php">Home</a>
    </div>
    <div class="myform">
        <h2>Enter New Data for <?php echo $std_name; ?></h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="">New Name</label>
                <input class="form-control" type="text" placeholder="Enter new student name" name="newname">
            </div>
            <div class="form-group">
                <label for="">New Email</label>
                <input class="form-control" type="text" placeholder="Enter new student email" name="newemail">
            </div>
            <button type="submit" class="button">Edit</button>


        </form>

        <div class="status">
            <?php echo $status ?>
        </div>
        <p class="end">
            <a href="stdpage.php">View Students</a>
        </p>


    </div>

</body>

</html>