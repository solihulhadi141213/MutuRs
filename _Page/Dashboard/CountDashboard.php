<?php
    // Koneksi
    include "../../_Config/Connection.php";

    // Set header JSON
    header('Content-Type: application/json');

    // Siapkan variabel default
    $response = [
        "siswa" => 0,
        "kelas" => 0,
        "permintaan" => 0,
        "selesai" => 0
    ];

    // Hitung jumlah siswa
    $qSiswa = $Conn->query("SELECT COUNT(*) AS total FROM siswa");
    if ($qSiswa) {
        $dSiswa = $qSiswa->fetch_assoc();
        $response['siswa'] = (int)$dSiswa['total'];
    }

    // Hitung jumlah kelas
    $QryKelas = $Conn->query("SELECT COUNT(*) AS total FROM kelas");
    if ($QryKelas) {
        $DataKelas = $QryKelas->fetch_assoc();
        $response['kelas'] = (int)$DataKelas['total'];
    }

    // Hitung Permintaan
    $QryPermintaan = $Conn->query("SELECT COUNT(*) AS total FROM permintaan");
    if ($QryPermintaan) {
        $DataPermintaan = $QryPermintaan->fetch_assoc();
        $response['permintaan'] = (int)$DataPermintaan['total'];
    }

     // Hitung Permintaan Selesai
    $QryPermintaanSelesai = $Conn->query("SELECT COUNT(*) AS total FROM permintaan WHERE status='Selesai'");
    if ($QryPermintaanSelesai) {
        $DataPermintaanSelesai = $QryPermintaanSelesai->fetch_assoc();
        $response['selesai'] = (int)$DataPermintaanSelesai['total'];
    }

    // Output JSON
    echo json_encode($response);

?>