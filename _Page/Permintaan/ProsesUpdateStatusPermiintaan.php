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
    $required = ['id_permintaan','status','tanggal','jam'];
    foreach($required as $r){
        if(empty($_POST[$r])){
            echo '<div class="alert alert-danger"><small>Field '.htmlspecialchars($r).' wajib diisi!</small></div>';
            exit;
        }
    }

    // Sanitasi input
    $id_permintaan  = validateAndSanitizeInput($_POST['id_permintaan']);
    $id_admin       = $SessionIdAccess;
    $status         = validateAndSanitizeInput($_POST['status']);
    $tanggal        = validateAndSanitizeInput($_POST['tanggal']);
    $jam            = validateAndSanitizeInput($_POST['jam']);

    //Keterangan
    if(!empty($_POST['keterangan'])){
        $keterangan = $_POST['keterangan'];
    }else{
        $keterangan = "";
    }

    //Format tgl_permintaan
    $tanggal_update = "$tanggal $jam";

    //Jika status selesai
    if($status=="Selesai"){
        $keterangan_pengambilan = $keterangan;
        $tgl_selesai = $tanggal_update;
    }else{
        $keterangan_pengambilan = "";
        $tgl_selesai = "";
    }

    // Upload Foto (opsional)
    $namabaru = "";
    if(!empty($_FILES['foto']['name'])){
        $nama_gambar=$_FILES['foto']['name'];
        $ukuran_gambar=$_FILES['foto']['size'];
        $tipe_gambar=$_FILES['foto']['type'];
        $tmp_gambar=$_FILES['foto']['tmp_name'];

        $ext = pathinfo($nama_gambar, PATHINFO_EXTENSION);
        $nama_baru=generateRandomString(36);
        $namabaru =''.$nama_baru.'.'.$ext.'';
        $path="../../assets/img/Permintaan/".$namabaru;

        if(in_array($tipe_gambar, ["image/jpeg","image/jpg","image/png","image/gif"])){
            if($ukuran_gambar < 2000000){
                if(!move_uploaded_file($tmp_gambar, $path)){
                    echo '<div class="alert alert-danger"><small>Upload file gagal!</small></div>';
                    exit;
                }
            }else{
                echo '<div class="alert alert-danger"><small>File gambar maksimal 2MB!</small></div>';
                exit;
            }
        }else{
            echo '<div class="alert alert-danger"><small>Tipe file tidak valid!</small></div>';
            exit;
        }
    }

    //Insert ke permintaan_status
    $stmt = $Conn->prepare("INSERT INTO permintaan_status (id_permintaan, id_admin, tanggal, keterangan, foto, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss",$id_permintaan, $id_admin, $tanggal_update, $keterangan, $namabaru, $status);
    $Input = $stmt->execute();
    $stmt->close();

    if($Input){
        
        //Jika Berhasil Lanjutkan Update
        $UpdateData = mysqli_query($Conn,"UPDATE permintaan SET 
            tgl_selesai='$tgl_selesai',
            keterangan_pengambilan='$keterangan_pengambilan',
            status='$status'
        WHERE id_permintaan='$id_permintaan'") or die(mysqli_error($Conn)); 
        if($UpdateData){
            echo '<code class="text-success" id="NotifikasiUpdateStatusPermiintaanBerhasil">Success</code>';
        }else{
            echo '<div class="alert alert-danger"><small>Terjadi kesalahan pada saat input data kelas</small></div>';
        }
    }else{
        echo '<div class="alert alert-danger"><small>Terjadi kesalahan pada saat input data status permintaan</small></div>';
    }
?>