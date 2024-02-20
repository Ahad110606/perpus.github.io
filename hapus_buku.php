<?php
require_once("koneksi.php");

// Tangani penghapusan buku
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Mulai transaksi
        $db->beginTransaction();

        // Hapus entri terkait dari tabel kategoribuku_relasi
        $sql_delete_relasi = "DELETE FROM kategoribuku_relasi WHERE BukuID = :id";
        $stmt_delete_relasi = $db->prepare($sql_delete_relasi);
        $stmt_delete_relasi->bindParam(':id', $id);
        $stmt_delete_relasi->execute();

        // Hapus entri dari tabel buku
        $sql_delete_buku = "DELETE FROM buku WHERE BukuID = :id";
        $stmt_delete_buku = $db->prepare($sql_delete_buku);
        $stmt_delete_buku->bindParam(':id', $id);
        $stmt_delete_buku->execute();

        // Commit transaksi
        $db->commit();

        header("Location: admin_home.php");
        exit();
    } catch (PDOException $e) {
        // Jika terjadi kesalahan, rollback transaksi dan tampilkan pesan kesalahan
        $db->rollBack();
        echo "Gagal menghapus buku: " . $e->getMessage();
    }
}
?>