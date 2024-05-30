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

    if ($task['user_id'] != $user_id) {
        header('Location: dashboard.php');
        exit();
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $task_id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $priorite = filter_var($_POST['priorite'], FILTER_SANITIZE_STRING);
    $categorie = filter_var($_POST['categorie'], FILTER_SANITIZE_STRING);
    $dateDebut = filter_var($_POST['dateDebut'], FILTER_SANITIZE_STRING);
    $dateFin = filter_var($_POST['dateFin'], FILTER_SANITIZE_STRING);
    $completed = isset($_POST['completed']) ? 1 : 0;

    if (empty($nom) || empty($priorite) || empty($categorie) || empty($dateDebut) || empty($dateFin)) {
        $error = "Please fill all fields";
    } else {
        $result = $db->editTask($task_id, $nom, $priorite, $categorie, $dateDebut, $dateFin, $completed);

        if ($result) {
            echo "Task updated successfully!";
        } else {
            $error = "Failed to update task. Please try again.";
        }
    }
}

if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Add your styling here */
    </style>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo $task['nom']; ?>" required>
        <label for="priorite">Priorité:</label>
        <input type="text" id="priorite" name="priorite" value="<?php echo $task['priorite']; ?>" required>
        <label for="categorie">Catégorie:</label>
        <input type="text" id="categorie" name="categorie" value="<?php echo $task['categorie']; ?>" required>
        <label for="dateDebut">Date de début:</label>
        <input type="date" id="dateDebut" name="dateDebut" value="<?php echo $task['dateDebut']; ?>" required>
        <label for="dateFin">Date de fin:</label>
        <input type="date" id="dateFin" name="dateFin" value="<?php echo $task['dateFin']; ?>" required>
        <label for="completed">Completed:</label>
        <input type="checkbox" id="completed" name="completed" <?php if ($task['completed']) echo 'checked'; ?>>
        <button type="submit" name="submit">Update Task</button>
    </form>
</body>
</html>
