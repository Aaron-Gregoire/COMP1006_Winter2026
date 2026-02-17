<?php
//only takes post requests, deletes task from db using id, goes back to index
require_once 'config/connect.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

//getting task id from the form
$taskId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

//if the id is invalid back to main
if ($taskId <= 0) {
    header("Location: index.php");
    exit;
}

// try to delete task
try {
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$taskId]);
    header("Location: index.php");
    exit;
} catch (PDOException $e) {
    //db error back to main
    header("Location: index.php");
    exit;
}