<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Set timezone
    date_default_timezone_set("Asia/Jakarta");

    // Tangkap tahun dari GET, jika kosong pakai tahun berjalan
    $tahun = isset($_GET['tahun']) && is_numeric($_GET['tahun'])
        ? (int)$_GET['tahun']
        : (int)date("Y");

    // Nama bulan
    $bulanNama = ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];

    // Siapkan array hasil awal (semua 0)
    $data = [];
    foreach ($bulanNama as $bln) {
        $data[] = ["x" => $bln, "y" => 0];
    }

    // Query jumlah pemeriksaan radiologi per bulan
    $sql = "
        SELECT 
            MONTH(waktu) AS bulan,
            COUNT(id_rad) AS jumlah
        FROM radiologi
        WHERE LEFT(waktu,4) = ?
        GROUP BY MONTH(waktu)
    ";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("s", $tahun);
    $stmt->execute();
    $result = $stmt->get_result();

    // Isi data hasil
    while ($row = $result->fetch_assoc()) {
        $index = (int)$row['bulan'] - 1;
        $data[$index]['y'] = (int)$row['jumlah'];
    }

    $stmt->close();

    // Output JSON
    header('Content-Type: application/json');
    echo json_encode($data);

?>
