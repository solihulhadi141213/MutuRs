<?php
    include "_Page/Logout/ModalLogout.php";
    include "_Page/Dashboard/ModalDashboard.php";
    if(!empty($_GET['Page'])){
        $Page=$_GET['Page'];
        
        // Daftar halaman dan modal yang terkait
        $modals = [
            "MyProfile" => "_Page/MyProfile/ModalMyProfile.php",
            "Radiologi" => "_Page/Radiologi/ModalRadiologi.php"
        ];

        // Cek apakah halaman memiliki modal terkait dan sertakan file modalnya
        if (!empty($_GET['Page']) && isset($modals[$_GET['Page']])) {
            include $modals[$_GET['Page']];
        }
    }
?>