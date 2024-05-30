<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'database.php';
$db = new Database();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $task_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $task = $db->getTaskById($task_id);

    if ($task['user_id'] == $user_id) {
        $db->deleteTask($task_id);
    }
}

header('Location: dashboard.php');
exit();
