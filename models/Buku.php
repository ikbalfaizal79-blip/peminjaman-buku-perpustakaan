<?php
class Buku {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function getAllBuku() {
        $query = "SELECT b.*, k.nama_kategori FROM buku b JOIN kategori k ON b.kategori_id = k.id";
        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nama_buku, $kategori_id, $stok) {
        $query = "INSERT INTO buku (nama_buku, kategori_id, stok) VALUES (:nama, :kategori, :stok)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':nama' => $nama_buku, ':kategori' => $kategori_id, ':stok' => $stok]);
    }
    public function updateStok($id, $stok) {
    $query = "UPDATE " . $this->table_name . " SET stok = :stok WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([
        ':stok' => $stok,
        ':id'   => $id
    ]);
}
}