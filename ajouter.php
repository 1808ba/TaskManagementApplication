<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'database.php';
$db = new Database();
$user_id = $_SESSION['user_id'];

$error = '';
if (isset($_POST['submit'])) {
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $priorite = filter_var($_POST['priorite'], FILTER_SANITIZE_STRING);
    $categorie = filter_var($_POST['categorie'], FILTER_SANITIZE_STRING);
    $dateDebut = filter_var($_POST['dateDebut'], FILTER_SANITIZE_STRING);
    $dateFin = filter_var($_POST['dateFin'], FILTER_SANITIZE_STRING);

    if (empty($nom) || empty($priorite) || empty($categorie) || empty($dateDebut) || empty($dateFin)) {
        $error = "Please fill all fields";
    } else {
        $result = $db->insertTask($user_id, $nom, $priorite, $categorie, $dateDebut, $dateFin);

        if ($result) {
            echo "Task added successfully!";
        } else {
            $error = "Failed to add task. Please try again.";
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
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>
        <label for="priorite">Priorité:</label>
        <input type="text" id="priorite" name="priorite" required>
        <label for="categorie">Catégorie:</label>
        <input type="text" id="categorie" name="categorie" required>
        <label for="dateDebut">Date de début:</label>
        <input type="date" id="dateDebut" name="dateDebut" required>
        <label for="dateFin">Date de fin:</label>
        <input type="date" id="dateFin" name="dateFin" required>
        <button type="submit" name="submit">Add Task</button>
    </form>
</body>
</html>
