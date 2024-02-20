<?php
require_once("koneksi.php");

if (isset($_POST['submit'])) {
    
      // Ambil data dari formulir
      $id = $_POST['id'];
      $judul = $_POST['judul'];
      $penulis = $_POST['penulis'];
      $penerbit = $_POST['penerbit'];
      $tahun_terbit = $_POST['tahun_terbit'];
      $genre = $_POST['genre'];
  
      // Pengecekan nilai variabel
      echo "Data dari formulir:<br>";
      echo "ID: " . $id . "<br>";
      echo "Judul: " . $judul . "<br>";
      echo "Penulis: " . $penulis . "<br>";
      echo "Penerbit: " . $penerbit . "<br>";
      echo "Tahun Terbit: " . $tahun_terbit . "<br>";
      echo "Genre: " . $genre . "<br>";

    

    // Periksa apakah file PDF baru diunggah
    if ($_FILES['pdf']['name'] != "") {
        $pdf_name = $_FILES['pdf']['name'];
        $pdf_tmp_name = $_FILES['pdf']['tmp_name'];
        $pdf_dest = "uploads/" . $pdf_name;
        move_uploaded_file($pdf_tmp_name, $pdf_dest);

        // Update lokasi file PDF di database
        $sql_update_pdf = "UPDATE buku SET PDF = :pdf WHERE BukuID = :id";
        $stmt_update_pdf = $db->prepare($sql_update_pdf);
        $stmt_update_pdf->bindParam(':pdf', $pdf_dest);
        $stmt_update_pdf->bindParam(':id', $id);
        $stmt_update_pdf->execute();
    }

    // Update informasi buku di database
    $sql_update_info = "UPDATE buku SET Judul = :judul, Penulis = :penulis, Penerbit = :penerbit, TahunTerbit = :tahun_terbit WHERE BukuID = :id";
    $stmt_update_info = $db->prepare($sql_update_info);
    $stmt_update_info->bindParam(':judul', $judul);
    $stmt_update_info->bindParam(':penulis', $penulis);
    $stmt_update_info->bindParam(':penerbit', $penerbit);
    $stmt_update_info->bindParam(':tahun_terbit', $tahun_terbit);
    $stmt_update_info->bindParam(':id', $id);
    
    // Ambil data genre dari formulir
    $genre = $_POST['genre'];

    // Perbarui informasi genre di tabel kategoribuku_relasi
    $sql_update_genre = "UPDATE kategoribuku_relasi SET KategoriID = :genre WHERE BukuID = :id";
    $stmt_update_genre = $db->prepare($sql_update_genre);
    $stmt_update_genre->bindParam(':genre', $genre);
    $stmt_update_genre->bindParam(':id', $id);

    // Eksekusi query untuk memperbarui genre
    if ($stmt_update_genre->execute()) {
        echo "Genre diperbarui dengan sukses.<br>";
    } else {
        echo "Gagal memperbarui genre.<br>";
    }


// Kemudian lanjutkan dengan memperbarui informasi buku
if ($stmt_update_info->execute()) {
    header("Location: admin_home.php");
    exit();
} else {
    echo "Failed to update book information.";
}
}
?>