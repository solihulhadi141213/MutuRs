<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Set header JSON
    header('Content-Type: application/json');

    // Siapkan variabel default
    $response = [
        "pasien" => 0,
        "kunjungan" => 0,
        "ranap" => 0,
        "rajal" => 0
    ];

    // Hitung jumlah Pasien
    $qpasien = $Conn->query("SELECT COUNT(*) AS total FROM pasien");
    if ($qpasien) {
        $dPasien = $qpasien->fetch_assoc();
        $response['pasien'] = (int)$dPasien['total'];
    }

    // Hitung jumlah kunjungan
    $QryKunjungan = $Conn->query("SELECT COUNT(*) AS total FROM kunjungan");
    if ($QryKunjungan) {
        $DataKunjungan = $QryKunjungan->fetch_assoc();
        $response['kunjungan'] = (int)$DataKunjungan['total'];
    }

    // Hitung Ranap
    $QryRanap = $Conn->query("SELECT COUNT(*) AS total FROM kunjungan WHERE tujuan='Ranap'");
    if ($QryRanap) {
        $DataRanap = $QryRanap->fetch_assoc();
        $response['ranap'] = (int)$DataRanap['total'];
    }

     // Hitung Rajal
    $QryRajal = $Conn->query("SELECT COUNT(*) AS total FROM kunjungan WHERE tujuan='Rajal'");
    if ($QryRajal) {
        $DataRajal = $QryRajal->fetch_assoc();
        $response['rajal'] = (int)$DataRajal['total'];
    }

    // Output JSON
    echo json_encode($response);

?>