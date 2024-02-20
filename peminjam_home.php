<?php
include_once('koneksi.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <title>HOME PEMINJAM</title>
    <!-- notifikasi pesan berhasil -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    // Fungsi untuk menampilkan notifikasi
    function showNotification(message, type) {
        var notification = document.getElementById('notification');
        notification.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
            '</div>';
    }

    // Fungsi untuk mengirim permintaan AJAX saat tombol pinjam diklik
    function pinjamBuku(BukuID) {
        // Kirim permintaan AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Tanggapan sukses dari server
                    showNotification(xhr.responseText, 'success');
                } else {
                    // Tanggapan gagal dari server
                    showNotification('Terjadi kesalahan saat memproses permintaan.', 'danger');
                }
            }
        };
        xhr.open('GET', 'pinjam_buku.php?BukuID=' + BukuID, true);
        xhr.send();
    }
    </script>


</head>

<body>
    <div id="notification"></div>
    <!--navbar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Halaman user</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto ml-2">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="keranjang.php">keranjang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-16">
            <br/>
            <table class="table table-hover table-bordered" style="margin-top: 20px">
                <tr class="success">
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Nama Buku</th>
                <th style="text-align: center;">Penulis</th>
                <th style="text-align: center;">Penerbit</th>
                <th style="text-align: center;">Tahun Terbit</th>
                <th style="text-align: center;">PDF</th>
                <th style="text-align: center;">Action</th>
                
                    
                </tr>
                    <?php
                        $sql = "SELECT * FROM buku";
                        $row = $db->prepare($sql);
                        $row->execute();
                        $hasil = $row->fetchALL();
                        $a =1;
                        foreach($hasil as $isi){
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $a ?></td>
                        <td style="text-align: center;"><?php echo $isi['Judul'];?></td>
                        <td style="text-align: center;"><?php echo $isi['Penulis'];?></td>
                        <td style="text-align: center;"><?php echo $isi['Penerbit'];?></td>
                        <td style="text-align: center;"><?php echo $isi['TahunTerbit'];?></td>
                        <td style="text-align: center;"><?php echo $isi['pdf'];?></td>
                        </td>
                        <td style="text-align: center;">
                        <a href="baca_pdf.php?pdf=<?php echo $isi['pdf']; ?>" class="btn btn-primary" target="_blank">Baca</a>
                    </td>
					</tr>
					<?php
						$a++;
						}
					?>
				 </table>
			  </div>
			</div>
		</div>
        <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
	</body>
</html>
    



    <!--akhir content-->

    <!-- Bootstrap JavaScript (Popper.js and Bootstrap.js) -->
    <script src="bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>