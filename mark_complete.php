<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'database.php';
$db = new Database();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $task = $db->getTaskById($task_id);

    if ($task['user_id'] == $user_id) {
        $completed = !$task['completed'];
        $db->editTask($task_id, $task['nom'], $task['priorite'], $task['categorie'], $task['dateDebut'], $task['dateFin'], $completed);
    }
}

header('Location: dashboard.php');
exit();
