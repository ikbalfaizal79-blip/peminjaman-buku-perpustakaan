<?php
class PinjamModel {
    private $conn;
    private $table = 'peminjaman';

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Menambahkan Pengajuan Pinjaman Baru oleh Siswa
    public function tambahPinjaman($id_user, $id_buku, $jumlah, $tgl_kembali) {
        $query = "INSERT INTO " . $this->table . " 
                  (id_user, id_buku, jumlah, tgl_pinjam, tgl_kembali, status) 
                  VALUES (:id_user, :id_buku, :jumlah, CURDATE(), :tgl_kembali, 'menunggu')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_buku', $id_buku);
        $stmt->bindParam(':jumlah', $jumlah);
        $stmt->bindParam(':tgl_kembali', $tgl_kembali);

        return $stmt->execute();
    }

    // 2. Mengambil Riwayat Pinjaman Berdasarkan ID Siswa
    public function getPinjamanByUserId($id_user) {
    // Ambil data peminjaman beserta detail buku
    $query = "SELECT p.*, b.nama_buku 
              FROM " . $this->table . " p 
              JOIN buku b ON p.id_buku = b.id_buku 
              WHERE p.id_user = :id_user 
              ORDER BY p.id_pinjam DESC";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // 3. Mengambil Semua Pengajuan yang Menunggu Persetujuan (Halaman Admin)
    public function getPendingPinjaman($search = '') {
        $query = "SELECT p.*, u.nama AS nama_siswa, b.nama_buku 
                  FROM " . $this->table . " p 
                  JOIN user u ON p.id_user = u.id_user 
                  JOIN buku b ON p.id_buku = b.id_buku 
                  WHERE p.status = 'menunggu'";

        if (!empty($search)) {
            $query .= " AND (u.nama LIKE :search OR b.nama_buku LIKE :search)";
        }

        $query .= " ORDER BY p.id_pinjam DESC";

        $stmt = $this->conn->prepare($query);
        if (!empty($search)) {
            $searchTerm = "%{$search}%";
            $stmt->bindParam(':search', $searchTerm);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Mengambil Semua Pinjaman yang Sedang Dipinjam / Aktif (Halaman Akhiri Pinjaman Admin)
    public function getActivePinjaman($search = '') {
    $query = "SELECT p.*, b.nama_buku, u.nama AS nama_siswa 
              FROM " . $this->table . " p
              JOIN buku b ON p.id_buku = b.id_buku
              JOIN user u ON p.id_user = u.id_user
              WHERE p.status = 'dipinjam'";

    if (!empty($search)) {
        $query .= " AND (u.nama LIKE :search OR b.nama_buku LIKE :search)";
    }

    $query .= " ORDER BY p.id_pinjam DESC";

    $stmt = $this->conn->prepare($query);
    if (!empty($search)) {
        $searchParam = "%{$search}%";
        $stmt->bindParam(':search', $searchParam);
    }
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    // 5. Mengubah Status Menjadi 'dipinjam' (Disetujui Admin) dan Mengurangi Stok Buku
    public function setujuiPinjaman($id_pinjam) {
        $this->conn->beginTransaction();

        try {
            // Ambil data pinjaman untuk mengurangi stok
            $queryGet = "SELECT id_buku, jumlah FROM " . $this->table . " WHERE id_pinjam = :id_pinjam LIMIT 1";
            $stmtGet = $this->conn->prepare($queryGet);
            $stmtGet->bindParam(':id_pinjam', $id_pinjam);
            $stmtGet->execute();
            $pinjam = $stmtGet->fetch(PDO::FETCH_ASSOC);

            if (!$pinjam) {
                $this->conn->rollBack();
                return false;
            }

            // Update status pinjam
            $queryUpdate = "UPDATE " . $this->table . " SET status = 'dipinjam' WHERE id_pinjam = :id_pinjam";
            $stmtUpdate = $this->conn->prepare($queryUpdate);
            $stmtUpdate->bindParam(':id_pinjam', $id_pinjam);
            $stmtUpdate->execute();

            // Kurangi stok buku
            $queryStok = "UPDATE buku SET stok = stok - :jumlah WHERE id_buku = :id_buku";
            $stmtStok = $this->conn->prepare($queryStok);
            $stmtStok->bindParam(':jumlah', $pinjam['jumlah']);
            $stmtStok->bindParam(':id_buku', $pinjam['id_buku']);
            $stmtStok->execute();

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // 6. Mengubah Status Menjadi 'selesai' (Diakhiri Admin) dan Mengembalikan Stok Buku
  public function akhiriPinjaman($id_pinjam) {
    // Ambil data peminjaman
    $query = "SELECT * FROM " . $this->table . " WHERE id_pinjam = :id_pinjam LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_pinjam', $id_pinjam);
    $stmt->execute();
    $pinjam = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pinjam) {
        return false;
    }

    // Hitung Keterlambatan dan Denda (10.000 / hari)
    $denda = 0;
    if (!empty($pinjam['tgl_kembali'])) {
        $tgl_kembali = new DateTime($pinjam['tgl_kembali']);
        $tgl_sekarang = new DateTime(date('Y-m-d'));

        if ($tgl_sekarang > $tgl_kembali) {
            $selisih = $tgl_sekarang->diff($tgl_kembali);
            $hari_terlambat = $selisih->days;
            $denda = $hari_terlambat * 10000;
        }
    }

    // Update status menjadi selesai dan simpan nominal denda
    $queryUpdate = "UPDATE " . $this->table . " 
                    SET status = 'selesai', denda = :denda 
                    WHERE id_pinjam = :id_pinjam";
    $stmtUpdate = $this->conn->prepare($queryUpdate);
    $stmtUpdate->bindParam(':denda', $denda);
    $stmtUpdate->bindParam(':id_pinjam', $id_pinjam);

    return $stmtUpdate->execute();
}

    // 7. Menolak Pengajuan Pinjaman
    public function tolakPinjaman($id_pinjam) {
        $query = "UPDATE " . $this->table . " SET status = 'ditolak' WHERE id_pinjam = :id_pinjam";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_pinjam', $id_pinjam);

        return $stmt->execute();
    }
    // Mengubah status menjadi 'selesai' oleh siswa dan mengembalikan stok buku
public function kembalikanBuku($id_pinjam, $id_user) {
    $this->conn->beginTransaction();

    try {
        // Ambil data pinjaman untuk memastikan ID pinjam milik user yang bersangkutan
        $queryGet = "SELECT id_buku, jumlah FROM " . $this->table . " WHERE id_pinjam = :id_pinjam AND id_user = :id_user AND status = 'dipinjam' LIMIT 1";
        $stmtGet = $this->conn->prepare($queryGet);
        $stmtGet->bindParam(':id_pinjam', $id_pinjam);
        $stmtGet->bindParam(':id_user', $id_user);
        $stmtGet->execute();
        $pinjam = $stmtGet->fetch(PDO::FETCH_ASSOC);

        if (!$pinjam) {
            $this->conn->rollBack();
            return false;
        }

        // Update status pinjam menjadi selesai
        $queryUpdate = "UPDATE " . $this->table . " SET status = 'selesai' WHERE id_pinjam = :id_pinjam";
        $stmtUpdate = $this->conn->prepare($queryUpdate);
        $stmtUpdate->bindParam(':id_pinjam', $id_pinjam);
        $stmtUpdate->execute();

        // Kembalikan jumlah stok buku
        $queryStok = "UPDATE buku SET stok = stok + :jumlah WHERE id_buku = :id_buku";
        $stmtStok = $this->conn->prepare($queryStok);
        $stmtStok->bindParam(':jumlah', $pinjam['jumlah']);
        $stmtStok->bindParam(':id_buku', $pinjam['id_buku']);
        $stmtStok->execute();

        $this->conn->commit();
        return true;
    } catch (Exception $e) {
        $this->conn->rollBack();
        return false;
    }
}
public function getRiwayatPinjaman($search = '') {
    $query = "SELECT p.*, b.nama_buku, u.nama AS nama_siswa, u.kelas 
              FROM " . $this->table . " p
              JOIN buku b ON p.id_buku = b.id_buku
              JOIN user u ON p.id_user = u.id_user
              WHERE p.status IN ('selesai', 'ditolak')";

    if (!empty($search)) {
        $query .= " AND (u.nama LIKE :search OR b.nama_buku LIKE :search)";
    }

    $query .= " ORDER BY p.id_pinjam DESC";

    $stmt = $this->conn->prepare($query);
    if (!empty($search)) {
        $searchParam = "%{$search}%";
        $stmt->bindParam(':search', $searchParam);
    }
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}