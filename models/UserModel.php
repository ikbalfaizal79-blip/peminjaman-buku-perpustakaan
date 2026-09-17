<?php
class UserModel {
    private $conn;
    private $table = 'user';

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Fungsi Login untuk Admin & Siswa
    public function login($email, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // 2. Registrasi / Tambah User Baru (Ditambah $nis dan $kelas)
    public function register($nama, $email, $password, $role = 'siswa', $nis = null, $kelas = null) {
        if ($this->getUserByEmail($email)) {
            return false;
        }

        $query = "INSERT INTO " . $this->table . " (nama, email, nis, kelas, password, role) VALUES (:nama, :email, :nis, :kelas, :password, :role)";
        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nis', $nis);
        $stmt->bindParam(':kelas', $kelas);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    // 3. Mengambil Semua Data User (Ditambah nis dan kelas)
    public function getAllUsers() {
        $query = "SELECT id_user, nama, email, nis, kelas, role FROM " . $this->table . " ORDER BY id_user DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Mengambil Detail User berdasarkan ID (Ditambah nis dan kelas)
    public function getUserById($id_user) {
        $query = "SELECT id_user, nama, email, nis, kelas, role FROM " . $this->table . " WHERE id_user = :id_user LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 5. Mengambil Detail User berdasarkan Email
    public function getUserByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 6. Update Data User (Ditambah $nis dan $kelas)
    public function updateUser($id_user, $nama, $email, $role, $nis = null, $kelas = null, $password = null) {
        if (!empty($password)) {
            $query = "UPDATE " . $this->table . " SET nama = :nama, email = :email, nis = :nis, kelas = :kelas, role = :role, password = :password WHERE id_user = :id_user";
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', $hashedPassword);
        } else {
            $query = "UPDATE " . $this->table . " SET nama = :nama, email = :email, nis = :nis, kelas = :kelas, role = :role WHERE id_user = :id_user";
            $stmt = $this->conn->prepare($query);
        }

        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nis', $nis);
        $stmt->bindParam(':kelas', $kelas);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id_user', $id_user);

        return $stmt->execute();
    }

    // 7. Hapus User
    public function deleteUser($id_user) {
        $query = "DELETE FROM " . $this->table . " WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $id_user);

        return $stmt->execute();
    }

    // 8. Menghitung Total User
    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'];
    }
}