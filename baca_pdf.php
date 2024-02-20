<?php

include_once('koneksi.php');


function bacaPDF($pdf) {
    global $db;

    
    $sql = "SELECT pdf FROM buku WHERE pdf = :pdf";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':pdf', $pdf);
    $stmt->execute();
    $result = $stmt->fetch();

    
    if ($result) {
        $pdfContent = $result['pdf'];
        header('Content-type: application/pdf');
        echo $pdfContent;
    } else {
      
        echo "File PDF tidak ditemukan.";
        
    }
}


if (isset($_GET['pdf'])) {
    $pdf = $_GET['pdf'];
    bacaPDF($pdf);
} else {
    
    echo "BukuID tidak ditemukan.";
    
}
?>
