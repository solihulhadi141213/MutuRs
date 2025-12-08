<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // --- Validasi Akses ---
    if (empty($SessionIdAccess)) {
        echo '<div class="alert alert-danger"><small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small></div>';
        exit;
    }

    //Validasi Form Required
    $required = ['id_siswa','tanggal_permintaan','jam_permintaan','kategori','kebutuhan','keterangan_permintaan'];
    foreach($required as $r){
        if(empty($_POST[$r])){
            echo '<div class="alert alert-danger"><small>Field '.htmlspecialchars($r).' wajib diisi!</small></div>';
            exit;
        }
    }

    // Sanitasi input
    $id_siswa               = validateAndSanitizeInput($_POST['id_siswa']);
    $tanggal_permintaan     = validateAndSanitizeInput($_POST['tanggal_permintaan']);
    $jam_permintaan         = validateAndSanitizeInput($_POST['jam_permintaan']);
    $kategori               = validateAndSanitizeInput($_POST['kategori']);
    $kebutuhan              = validateAndSanitizeInput($_POST['kebutuhan']);
    $keterangan_permintaan  = validateAndSanitizeInput($_POST['keterangan_permintaan']);

    //Format tgl_permintaan
    $tgl_permintaan         = "$tanggal_permintaan $jam_permintaan";
    $tgl_selesai            = "";


    //Buka id_kelas
    $id_kelas               = GetDetailData($Conn, 'siswa', 'id_siswa', $id_siswa, 'id_kelas');

    // Insert Data Menggunakan Prepared Statement
    $stmt = $Conn->prepare("INSERT INTO permintaan (id_siswa, id_kelas, tgl_permintaan, tgl_selesai, kategori, kebutuhan, keterangan_permintaan, status, keterangan_pengambilan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssssss",$id_siswa, $id_kelas, $tgl_permintaan, $tgl_selesai, $kategori, $kebutuhan, $keterangan_permintaan, $status, $keterangan_pengambilan);
    $Input = $stmt->execute();
    $stmt->close();

    if($Input){
        echo '<code class="text-success" id="NotifikasiTambahBerhasil">Success</code>';
    }else{
        echo '<div class="alert alert-danger"><small>Terjadi kesalahan pada saat input data kelas</small></div>';
    }
?>