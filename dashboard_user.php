<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'database.php';
$db = new Database();
$user_id = $_SESSION['user_id'];
$tasks = $db->readTasks($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $keyword = filter_var($_POST['keyword'], FILTER_SANITIZE_STRING);
    $tasks = $db->searchTasks($user_id, $keyword);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        th:nth-child(1) {
            width: 20%;
        }

        th:nth-child(2) {
            width: 15%;
        }

        tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Task Dashboard</h2>
    <form action="dashboard.php" method="post">
        <input type="text" name="keyword" placeholder="Search tasks...">
        <button type="submit" name="search">Search</button>
    </form>
    <a href="ajouter.php">Add New Task</a>
    <?php if (count($tasks) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nom de la tâche</th>
                    <th>Priorité</th>
                    <th>Catégorie</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Completed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo strtoupper($task['nom']); ?></td>
                        <td><?php echo strtoupper($task['priorite']); ?></td>
                        <td><?php echo strtoupper($task['categorie']); ?></td>
                        <td><?php echo $task['dateDebut']; ?></td>
                        <td><?php echo $task['dateFin']; ?></td>
                        <td><?php echo $task['completed'] ? 'Yes' : 'No'; ?></td>
                        <td>
                          
                            <form action="mark_complete.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                <button type="submit"><?php echo $task['completed'] ? 'Mark Incomplete' : 'Mark Complete'; ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>
</body>
</html>
