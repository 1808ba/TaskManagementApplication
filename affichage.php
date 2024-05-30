<?php 
require_once 'database.php'; 
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
    <?php 
    $db = new Database(); 
    $tasks = $db->read("tache1"); 
    if (count($tasks) > 0): 
    ?>
    <table>
        <thead>
            <tr>
                <th>Nom de la tâche</th>
                <th>Priorité</th>
                <th>Catégorie</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $row): ?>
            <tr>
                <td><?php echo strtoupper($row['nom']); ?></td>
                <td><?php echo strtoupper($row['priorite']); ?></td>
                <td><?php echo strtoupper($row['categorie']); ?></td>
                <td><?php echo strtoupper($row['dateDebut']); ?></td>
                <td><?php echo strtoupper($row['dateFin']); ?></td>
                <td>
                   <a href="delet.php?id=<?php echo $row['id']; ?>"><button>Supprimer</button></a>
                   <a href="edit.php?id=<?php echo $row['id']; ?>"><button>Modifier</button></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Aucune tâche trouvée.</p>
    <?php endif; ?>
</body>
</html>
