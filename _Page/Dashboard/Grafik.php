<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Set timezone
    date_default_timezone_set("Asia/Jakarta");

    // Tahun sekarang
    $tahun = date("Y");

    // Nama bulan
    $bulanNama = ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];

    // Siapkan array hasil awal
    $data = [];
    foreach($bulanNama as $bln){
        $data[] = ["x" => $bln, "y" => 0];
    }

    // Query jumlah permintaan per bulan
    $sql = "
        SELECT MONTH(tgl_permintaan) AS bulan, COUNT(id_permintaan) AS jumlah
        FROM permintaan
        WHERE YEAR(tgl_permintaan) = ?
        GROUP BY MONTH(tgl_permintaan)
    ";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $tahun);
    $stmt->execute();
    $result = $stmt->get_result();

    // Isi data ke array
    while($row = $result->fetch_assoc()){
        $index = (int)$row['bulan'] - 1;
        $data[$index]['y'] = (int)$row['jumlah'];
    }

    $stmt->close();

    // Output JSON
    header('Content-Type: application/json');
    echo json_encode($data);
?>
