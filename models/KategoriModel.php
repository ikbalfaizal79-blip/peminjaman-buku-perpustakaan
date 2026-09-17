<?php
class KategoriModel {
    private $conn;
    private $table = 'kategori';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Mengambil semua data kategori
    public function getAllKategori() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id_kategori DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah Kategori
    public function tambahKategori($nama_kategori) {
        $query = "INSERT INTO " . $this->table . " (nama_kategori) VALUES (:nama_kategori)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nama_kategori', $nama_kategori);
        return $stmt->execute();
    }

    // Update Kategori
    public function updateKategori($id_kategori, $nama_kategori) {
        $query = "UPDATE " . $this->table . " SET nama_kategori = :nama_kategori WHERE id_kategori = :id_kategori";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nama_kategori', $nama_kategori);
        $stmt->bindParam(':id_kategori', $id_kategori);
        return $stmt->execute();
    }

    // Hapus Kategori
    public function hapusKategori($id_kategori) {
        $query = "DELETE FROM " . $this->table . " WHERE id_kategori = :id_kategori";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_kategori', $id_kategori);
        return $stmt->execute();
    }
}