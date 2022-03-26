<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpassword = '';
$dbname = 'attendance_system';

try {
    $dsn = 'mysql:host=' . $dbhost . ';dbname=' . $dbname;
    $pdo = new PDO($dsn, $dbuser, $dbpassword);
    // echo "Connection Done";

} catch (PDOException $e) {
    echo 'Fail to connect : ' . $e;
}
?>