<?php

require 'config.php';

if($_POST['id']){
    $id = $_POST['id'];
    $delete_query = "DELETE FROM lectures WHERE id =:id";
    $stmt = $pdo->prepare($delete_query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}

?>