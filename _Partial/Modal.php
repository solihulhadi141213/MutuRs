<?php
    include "_Page/Logout/ModalLogout.php";
    if(!empty($_GET['Page'])){
        $Page=$_GET['Page'];
        
        // Daftar halaman dan modal yang terkait
        $modals = [
            "MyProfile"             => "_Page/MyProfile/ModalMyProfile.php",
            "Akses"                 => "_Page/Akses/ModalAkses.php",
            "Kelas"                 => "_Page/Kelas/ModalKelas.php",
            "Siswa"                 => "_Page/Siswa/ModalSiswa.php",
            "Permintaan"            => "_Page/Permintaan/ModalPermintaan.php",
            "PermintaanSiswa"       => "_Page/PermintaanSiswa/ModalPermintaanSiswa.php",
            "SettingEmail"          => "_Page/SettingEmail/ModalSettingEmail.php",
            "Bantuan"               => "_Page/Bantuan/ModalBantuan.php"
        ];

        // Cek apakah halaman memiliki modal terkait dan sertakan file modalnya
        if (!empty($_GET['Page']) && isset($modals[$_GET['Page']])) {
            include $modals[$_GET['Page']];
        }
    }
?>