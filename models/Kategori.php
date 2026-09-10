<?php
class Kategori {
    private $conn;
    private $table_name = "kategori";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Mengambil semua data kategori (digunakan pada form dropdown tambah/edit buku)
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nama_kategori ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil data kategori berdasarkan ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menambah data kategori baru
    public function create($nama_kategori) {
        $query = "INSERT INTO " . $this->table_name . " (nama_kategori) VALUES (:nama_kategori)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':nama_kategori' => $nama_kategori]);
    }

    // Mengubah data kategori
    public function update($id, $nama_kategori) {
        $query = "UPDATE " . $this->table_name . " SET nama_kategori = :nama_kategori WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nama_kategori' => $nama_kategori,
            ':id' => $id
        ]);
    }

    // Menghapus data kategori
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}