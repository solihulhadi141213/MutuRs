<?php
    // Koneksi & dependensi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    // --- Validasi sesi ---
    if (empty($SessionIdAccess)) {
        echo '<div class="alert alert-danger"><small>Sesi akses sudah berakhir! Silahkan login ulang!</small></div>';
        exit;
    }

    // --- Validasi input wajib ---
    $required = ['id_access','nama_akses','email_akses'];
    foreach($required as $r){
        if(empty($_POST[$r])){
            echo '<div class="alert alert-danger"><small>Field '.htmlspecialchars($r).' wajib diisi!</small></div>';
            exit;
        }
    }

    // --- Sanitasi input ---
    $id_access          = validateAndSanitizeInput($_POST['id_access']);
    $access_name        = validateAndSanitizeInput($_POST['nama_akses']);
    $access_email       = validateAndSanitizeInput($_POST['email_akses']);

    // --- Update data access ---
    $sql = "UPDATE admin SET admin_name=?, admin_email=? WHERE id_admin=?";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("ssi", $access_name, $access_email, $id_access);

    if ($stmt->execute()) {

        echo '<small class="text-success" id="NotifikasiEditAksesBerhasil">Success</small>';

    } else {
        echo '<div class="alert alert-danger"><small>Gagal update data akses!</small></div>';
    }

    $stmt->close();
?>
