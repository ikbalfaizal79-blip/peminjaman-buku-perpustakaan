<?php
class BukuModel {
    private $conn;
    private $table = 'buku';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Mengambil Semua Data Buku
    public function getAllBuku($search = '') {
        $query = "SELECT b.*, k.nama_kategori 
                  FROM " . $this->table . " b 
                  LEFT JOIN kategori k ON b.id_kategori = k.id_kategori";

        if (!empty($search)) {
            $query .= " WHERE b.nama_buku LIKE :search OR k.nama_kategori LIKE :search";
        }

        $query .= " ORDER BY b.id_buku DESC";

        $stmt = $this->conn->prepare($query);

        if (!empty($search)) {
            $searchTerm = "%{$search}%";
            $stmt->bindParam(':search', $searchTerm);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil Detail Buku Berdasarkan ID
    public function getBukuById($id_buku) {
        $query = "SELECT b.*, k.nama_kategori 
                  FROM " . $this->table . " b 
                  LEFT JOIN kategori k ON b.id_kategori = k.id_kategori 
                  WHERE b.id_buku = :id_buku LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_buku', $id_buku);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tambah Buku Baru (Dengan Gambar)
    public function tambahBuku($nama_buku, $id_kategori, $stok, $gambar = null) {
        $query = "INSERT INTO " . $this->table . " (nama_buku, id_kategori, stok, gambar) VALUES (:nama_buku, :id_kategori, :stok, :gambar)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nama_buku', $nama_buku);
        $stmt->bindParam(':id_kategori', $id_kategori);
        $stmt->bindParam(':stok', $stok);
        $stmt->bindParam(':gambar', $gambar);

        return $stmt->execute();
    }

    // Update Buku (Dengan Gambar)
    public function updateBuku($id_buku, $nama_buku, $id_kategori, $stok, $gambar = null) {
        if ($gambar) {
            $query = "UPDATE " . $this->table . " SET nama_buku = :nama_buku, id_kategori = :id_kategori, stok = :stok, gambar = :gambar WHERE id_buku = :id_buku";
        } else {
            $query = "UPDATE " . $this->table . " SET nama_buku = :nama_buku, id_kategori = :id_kategori, stok = :stok WHERE id_buku = :id_buku";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nama_buku', $nama_buku);
        $stmt->bindParam(':id_kategori', $id_kategori);
        $stmt->bindParam(':stok', $stok);
        $stmt->bindParam(':id_buku', $id_buku);

        if ($gambar) {
            $stmt->bindParam(':gambar', $gambar);
        }

        return $stmt->execute();
    }
}