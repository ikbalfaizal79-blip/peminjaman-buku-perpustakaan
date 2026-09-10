<?php
class Transaksi {
    private $conn;
    private $table_name = "transaksi";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Siswa: Mengajukan peminjaman buku baru
    public function ajukanPinjaman($user_id, $buku_id, $jumlah, $tgl_pinjam, $tgl_kembali) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_id, buku_id, jumlah, tanggal_pinjam, tanggal_rencana_kembali, status) 
                  VALUES (:user_id, :buku_id, :jumlah, :tgl_pinjam, :tgl_kembali, 'pending')";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':user_id'    => $user_id,
            ':buku_id'    => $buku_id,
            ':jumlah'     => $jumlah,
            ':tgl_pinjam' => $tgl_pinjam,
            ':tgl_kembali' => $tgl_kembali
        ]);
    }

    // 2. Admin: Menampilkan daftar transaksi yang butuh persetujuan (Status: pending)
    public function getPending() {
        $query = "SELECT t.*, u.nama AS peminjam, b.nama_buku AS alat 
                  FROM " . $this->table_name . " t 
                  JOIN user u ON t.user_id = u.id 
                  JOIN buku b ON t.buku_id = b.id 
                  WHERE t.status = 'pending' 
                  ORDER BY t.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Admin: Menampilkan daftar transaksi yang sedang dipinjam (Status: dipinjam)
    public function getDipinjam() {
        $query = "SELECT t.*, u.nama AS peminjam, b.nama_buku AS alat 
                  FROM " . $this->table_name . " t 
                  JOIN user u ON t.user_id = u.id 
                  JOIN buku b ON t.buku_id = b.id 
                  WHERE t.status = 'dipinjam' 
                  ORDER BY t.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Siswa: Menampilkan riwayat transaksi per siswa
    public function getByUserId($user_id) {
        $query = "SELECT t.*, b.nama_buku, k.nama_kategori 
                  FROM " . $this->table_name . " t 
                  JOIN buku b ON t.buku_id = b.id 
                  JOIN kategori k ON b.kategori_id = k.id 
                  WHERE t.user_id = :user_id 
                  ORDER BY t.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Admin: Memproses persetujuan (ACC) pinjaman & mengurangi stok buku
    public function setujuiPinjaman($id) {
        try {
            $this->conn->beginTransaction();

            // Ambil data transaksi
            $queryTrx = "SELECT buku_id, jumlah FROM " . $this->table_name . " WHERE id = :id AND status = 'pending'";
            $stmtTrx = $this->conn->prepare($queryTrx);
            $stmtTrx->execute([':id' => $id]);
            $trx = $stmtTrx->fetch(PDO::FETCH_ASSOC);

            if ($trx) {
                // Update status transaksi menjadi 'dipinjam'
                $queryUpdate = "UPDATE " . $this->table_name . " SET status = 'dipinjam' WHERE id = :id";
                $stmtUpdate = $this->conn->prepare($queryUpdate);
                $stmtUpdate->execute([':id' => $id]);

                // Kurangi stok buku
                $queryStok = "UPDATE buku SET stok = stok - :jumlah WHERE id = :buku_id";
                $stmtStok = $this->conn->prepare($queryStok);
                $stmtStok->execute([':jumlah' => $trx['jumlah'], ':buku_id' => $trx['buku_id']]);

                $this->conn->commit();
                return true;
            }
            $this->conn->rollBack();
            return false;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // 6. Admin: Memproses penolakan pinjaman
    public function tolakPinjaman($id) {
        $query = "UPDATE " . $this->table_name . " SET status = 'ditolak' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    // 7. Admin/Siswa: Mengakhiri pinjaman (Pengembalian) & mengembalikan stok buku
    public function akhiriPinjaman($id) {
        try {
            $this->conn->beginTransaction();

            // Ambil data transaksi
            $queryTrx = "SELECT buku_id, jumlah FROM " . $this->table_name . " WHERE id = :id AND status = 'dipinjam'";
            $stmtTrx = $this->conn->prepare($queryTrx);
            $stmtTrx->execute([':id' => $id]);
            $trx = $stmtTrx->fetch(PDO::FETCH_ASSOC);

            if ($trx) {
                $today = date('Y-m-d');
                // Update status menjadi 'dikembalikan' dan isi tanggal_kembali
                $queryUpdate = "UPDATE " . $this->table_name . " 
                                SET status = 'dikembalikan', tanggal_kembali = :tgl_kembali 
                                WHERE id = :id";
                $stmtUpdate = $this->conn->prepare($queryUpdate);
                $stmtUpdate->execute([':tgl_kembali' => $today, ':id' => $id]);

                // Tambahkan kembali stok buku
                $queryStok = "UPDATE buku SET stok = stok + :jumlah WHERE id = :buku_id";
                $stmtStok = $this->conn->prepare($queryStok);
                $stmtStok->execute([':jumlah' => $trx['jumlah'], ':buku_id' => $trx['buku_id']]);

                $this->conn->commit();
                return true;
            }
            $this->conn->rollBack();
            return false;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // 8. Admin: Mengambil rekap jumlah statistik untuk Widget Dashboard
    public function getStatistik() {
        $total = $this->conn->query("SELECT COUNT(*) FROM " . $this->table_name)->fetchColumn();
        $dipinjam = $this->conn->query("SELECT COUNT(*) FROM " . $this->table_name . " WHERE status = 'dipinjam'")->fetchColumn();
        $kembali = $this->conn->query("SELECT COUNT(*) FROM " . $this->table_name . " WHERE status = 'dikembalikan'")->fetchColumn();

        return [
            'total' => $total,
            'dipinjam' => $dipinjam,
            'kembali' => $kembali
        ];
    }
}