<?php
require 'config.php';
// print_r($_POST);
// print_r($_SERVER["REQUEST_METHOD"]);die;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentid = $_POST["stdid"];
    $lectureid = $_POST["lecid"];
    $status = $_POST["ssss"];

    // print_r($_POST);
    // $search_query = "SELECT studentid FROM attendance WHERE studentid=:studentid";
    // $stmt = $pdo->prepare($search_query);
    // $stmt->bindParam(':studentid', $studentid, PDO::PARAM_INT);
    // $stmt->execute();

    $existing_data_query = "SELECT studentid FROM attendance WHERE studentid=".$studentid." and lectureid=".$lectureid;
    

    $existing_data = $pdo->query($existing_data_query)->fetchAll();
    // if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
    if (empty($existing_data)) {
        // die("1");
        $insert_query = "INSERT INTO attendance (studentid , lectureid , attend) VALUES (:studentid , :lectureid , :attend)";
        $insert = $pdo->prepare($insert_query);
        $insert->execute(['studentid' => $studentid, 'lectureid' => $lectureid, 'attend' => $status]);
    } else {
        // die("2");
        $update_query = "UPDATE attendance  SET attend=? WHERE studentid=? and lectureid=?";

        $update = $pdo->prepare($update_query);

        $update->execute([$status, $studentid,$lectureid]);
    }
}


// die();
