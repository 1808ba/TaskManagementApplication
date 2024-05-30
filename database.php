<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'task';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function registerUser($username, $password, $role) {
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $role);
        return $stmt->execute();
    }
    
    
    

    public function loginUser($username) {
        $sql = "SELECT id, username, role, password FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function getUserById($id) {
        $sql = "SELECT id, username, role FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    

    public function insertTask($user_id, $nom, $priorite, $categorie, $dateDebut, $dateFin) {
        $sql = "INSERT INTO tasks (user_id, nom, priorite, categorie, dateDebut, dateFin) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssss", $user_id, $nom, $priorite, $categorie, $dateDebut, $dateFin);
        return $stmt->execute();
    }

    public function readTasks($user_id) {
        $sql = "SELECT * FROM tasks WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTaskById($id) {
        $sql = "SELECT * FROM tasks WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function editTask($id, $nom, $priorite, $categorie, $dateDebut, $dateFin, $completed) {
        $sql = "UPDATE tasks SET nom = ?, priorite = ?, categorie = ?, dateDebut = ?, dateFin = ?, completed = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssi", $nom, $priorite, $categorie, $dateDebut, $dateFin, $completed, $id);
        return $stmt->execute();
    }

    public function deleteTask($id) {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function searchTasks($user_id, $keyword) {
        $sql = "SELECT * FROM tasks WHERE user_id = ? AND (nom LIKE ? OR priorite LIKE ? OR categorie LIKE ?)";
        $keyword = "%" . $keyword . "%";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isss", $user_id, $keyword, $keyword, $keyword);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

?>
