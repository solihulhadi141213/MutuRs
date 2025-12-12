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
    $query_pasien = $Conn->query("SELECT COUNT(DISTINCT id_pasien) AS total FROM radiologi");
    if ($query_pasien) {
        $dPasien = $query_pasien->fetch_assoc();
        $response['pasien'] = (int)$dPasien['total'];
    }

    // Hitung jumlah kunjungan
    $QryKunjungan = $Conn->query("SELECT COUNT(id_rad) AS total FROM radiologi");
    if ($QryKunjungan) {
        $DataKunjungan = $QryKunjungan->fetch_assoc();
        $response['kunjungan'] = (int)$DataKunjungan['total'];
    }

    // Hitung Ranap
    $query_ranap = "SELECT COUNT(id_rad) AS total FROM radiologi r JOIN kunjungan k ON r.id_kunjungan = k.id_kunjungan WHERE k.tujuan = 'Ranap'";
    $result_ranap = mysqli_query($Conn, $query_ranap);
    $data_ranap   = mysqli_fetch_assoc($result_ranap);
    if(empty($data_ranap['total'])){
        $jumlah_ranap = 0;
    }else{
        $jumlah_ranap = $data_ranap['total'];
    }
    $response['ranap'] = (int)$jumlah_ranap;

    // Hitung Rajal
    $query_rajal = "SELECT COUNT(id_rad) AS total FROM radiologi r JOIN kunjungan k ON r.id_kunjungan = k.id_kunjungan WHERE k.tujuan = 'Rajal'";
    $result_rajal = mysqli_query($Conn, $query_rajal);
    $data_rajal   = mysqli_fetch_assoc($result_rajal);
    if(empty($data_rajal['total'])){
        $jumlah_rajal = 0;
    }else{
        $jumlah_rajal = $data_rajal['total'];
    }
    $response['rajal'] = (int)$jumlah_rajal;

    // Output JSON
    echo json_encode($response);

?>