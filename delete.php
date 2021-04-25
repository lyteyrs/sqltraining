<?php

//making connection to the database
require_once 'server.php';

$id = $_POST['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare('DELETE FROM register_course WHERE id = :id');

$statement->bindValue(':id', $id);
$statement->execute();

header('Location: index.php');
