<?php
    //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

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
    //Tangkap id_organization_class
    if(empty($_POST['id_student'])){
         echo '
            <div class="alert alert-danger">
                <small>
                    ID Siswa Tidak Boleh Kosong!
                </small>
            </div>
        ';
        exit;
    }

    //Buat variabel
    $id_student=validateAndSanitizeInput($_POST['id_student']);

    //Buka Data sISWA
    $Qry = $Conn->prepare("SELECT * FROM siswa WHERE id_siswa = ?");
    $Qry->bind_param("i", $id_student);
    if (!$Qry->execute()) {
        $error=$Conn->error;
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan pada saat membuka data dari database!<br>Keterangan : '.$error.'</small>
            </div>
        ';
    }else{
        $Result = $Qry->get_result();
        $Data = $Result->fetch_assoc();
        $Qry->close();

        //Buat Variabel
        $id_kelas   = $Data['id_kelas'];
        $nis        = $Data['nis'];
        $nama       = $Data['nama'];
        $gender     = $Data['gender'];
        $email      = $Data['email'];
        $foto_siswa = $Data['foto_siswa'];

        //Routing foto
        if(empty($Data['foto_siswa'])){
            $foto_siswa = "No-Image.png";
        }else{
            $foto_siswa = $Data['foto_siswa'];
        }

        //Tampilkan Data
        echo '
            <div class="row mb-3" id="foto_siswa_place">
                <div class="col-12 mb-3 text-center">
                    <img src="'.$app_base_url.'/image_proxy.php?dir=Siswa&filename='.$foto_siswa.'" alt="'.$foto_siswa.'" width="70%" class="rounded-circle">
                </div>
            </div>
        ';
        echo '
            <div class="row mb-2">
                <div class="col-4"><small>Nama</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text text-grayish">'.$nama.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>NIS</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text text-grayish">'.$nis.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Gender</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text text-grayish">'.$gender.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Email</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text text-grayish">'.$email.'</small>
                </div>
            </div>
        ';
    }
?>