<?php
    // Koneksi dan konfigurasi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Keterangan waktu dan zona waktu
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    if (empty($SessionIdAccess)) {
        echo '<small class="text-danger">Sesi Akses Sudah Berakhir, Silahkan Login Ulang!</small>';
    } else {
        if (empty($_POST['nama'])) {
            echo '<small class="text-danger">Nama tidak boleh kosong</small>';
        } elseif (empty($_POST['email'])) {
            echo '<small class="text-danger">Email tidak boleh kosong</small>';
        } else {

            //Buat Variabel Dan Sanitasi
            $nama = validateAndSanitizeInput($_POST['nama']);
            $email = validateAndSanitizeInput($_POST['email']);

            //Ambil Email Lama
            $email_lama = GetDetailData($Conn, 'admin', 'id_admin', $SessionIdAccess, 'admin_email');
                    
            // Cek duplikasi email
            $ValidasiEmailDuplikat = 0;
            if ($email !== $email_lama) {
                $ValidasiEmailDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT id_admin FROM admin WHERE admin_email='$email'"));
            }
            if (!empty($ValidasiEmailDuplikat)) {
                echo '<small class="text-danger">Email yang anda gunakan sudah terdaftar</small>';
            } else {

                //Update Data Ke Database
                try {
                    $UpdateProfil = mysqli_query($Conn,"UPDATE admin SET 
                        admin_email='$email',
                        admin_name='$nama'
                    WHERE id_admin='$SessionIdAccess'") or die(mysqli_error($Conn)); 
                
                    if ($UpdateProfil) {
                        $_SESSION["NotifikasiSwal"] = "Edit Akses Berhasil";
                        echo '<small class="text-success" id="NotifikasiUbahIdentitasProfilBerhasil">Success</small>';
                    } else {
                        echo '<small class="text-danger">Terjadi kesalahan pada saat menyimpan data</small>';
                    }
                } catch (PDOException $e) {
                    echo '<small class="text-danger">Error: ' . $e->getMessage() . '</small>';
                }
            }
        }
    }
?>
