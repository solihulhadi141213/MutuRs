<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //tangkap id_rad
    if(empty($_POST['id_rad'])){
        echo '
            <div class="alert alert-danger">
                <small>ID Pemeriksaan Tidak Boleh Kosong</small>
            </dv>
        ';
        exit;
    }

    $id_rad = validateAndSanitizeInput($_POST['id_rad']);

    //Buka Data access
    $Qry = $Conn->prepare("SELECT * FROM radiologi WHERE id_rad = ?");
    $Qry->bind_param("i", $id_rad);
    if (!$Qry->execute()) {
        $error=$Conn->error;
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan pada saat membuka data dari database!<br>Keterangan : '.$error.'</small>
            </div>
        ';
        exit;
    }
    $Result = $Qry->get_result();
    $Data = $Result->fetch_assoc();
    $Qry->close();

    //Buat Variabel
    $id_pasien              = $Data['id_pasien'];
    $id_kunjungan           = $Data['id_kunjungan'];
    $nama                   = $Data['nama'];
    $waktu                  = $Data['waktu'];
    $asal_kiriman           = $Data['asal_kiriman'];
    $permintaan_pemeriksaan = $Data['permintaan_pemeriksaan'];
    $alat_pemeriksa         = $Data['alat_pemeriksa'];
    $status_pemeriksaan     = $Data['status_pemeriksaan'];
    $jenis_pembayaran       = $Data['jenis_pembayaran'];
    $dokter_pengirim        = $Data['dokter_pengirim'];
    $dokter_penerima        = $Data['dokter_penerima'];
    $radiografer            = $Data['radiografer'];
    $kesan                  = $Data['kesan'];
    $klinis                 = $Data['klinis'];
    $selesai                = $Data['selesai'];
    $kv                     = $Data['kv'];
    $ma                     = $Data['ma'];
    $sec                    = $Data['sec'];

    //Tampilkan Data
    echo '
        <div class="row mb-2">
            <div class="col-5"><small>No.RM</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$id_pasien.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>No.REG</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$id_kunjungan.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$nama.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Asal Kiriman</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$asal_kiriman.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Permintaan Pemeriksaan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$permintaan_pemeriksaan.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Alat/Pesawat</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$alat_pemeriksa.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Status Pemeriksaan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$status_pemeriksaan.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Pembayaran</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$jenis_pembayaran.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Dokter Pengirim</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$dokter_pengirim.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Dokter Penerima</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$dokter_penerima.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Kesan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$kesan.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Klinis</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$klinis.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Mulai</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$waktu.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Selesai</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$selesai.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>KV</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$kv.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>MA</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$ma.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>SEC</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$sec.'</small></div>
        </div>
    ';
?>