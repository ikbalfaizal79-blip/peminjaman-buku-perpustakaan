<?php
class User {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function login($email, $password) {
        $query = "SELECT * FROM user WHERE email = :email AND password = :password";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':email' => $email, ':password' => $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        return $this->conn->query("SELECT * FROM user")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nama, $email, $password, $role = 'siswa') {
        $query = "INSERT INTO user (nama, email, password, role) VALUES (:nama, :email, :password, :role)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':nama' => $nama, ':email' => $email, ':password' => $password, ':role' => $role]);
    }
}