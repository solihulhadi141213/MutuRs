<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Time Zone
    date_default_timezone_set('Asia/Jakarta');

    //Time Now Tmp
    $now=date('Y-m-d H:i:s');

    //Validasi Sesi Akses
    if (empty($SessionIdAccess)) {
        echo '
            <div class="alert alert-danger">
                <small>
                    Sesi akses sudah berakhir. Silahkan <b>login</b> ulang!
                </small>
            </div>
        ';
        exit;
    }
    //Tangkap id_permintaan
    if(empty($_POST['id_permintaan'])){
         echo '
            <div class="alert alert-danger">
                <small>
                    ID Permintaan Tidak Boleh Kosong!
                </small>
            </div>
        ';
        exit;
    }

    //Buat variabel
    $id_permintaan=validateAndSanitizeInput($_POST['id_permintaan']);
    
    //Proses hapus data
    $HapusPermintaan = mysqli_query($Conn, "DELETE FROM permintaan WHERE id_permintaan='$id_permintaan'") or die(mysqli_error($Conn));
    if ($HapusPermintaan) {
        echo '<span class="text-success" id="NotifikasiHapusPermintaanBerhasil">Success</span>';
    }else{

        //Jika menghapus gagal
        echo '
            <div class="alert alert-danger">
                <small>
                    Terjadi kesalahan pada saat menghapus data!
                </small>
            </div>
        ';
    }
?>