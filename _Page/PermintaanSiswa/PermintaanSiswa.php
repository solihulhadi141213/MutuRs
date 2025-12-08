<?php
    if(empty($_GET['Sub'])){
        include "_Page/PermintaanSiswa/PermintaanSiswaHome.php";
    }else{
        $Sub = $_GET['Sub'];

        if($Sub=="DetailPermintaan"){
            include "_Page/PermintaanSiswa/DetailPermintaanSiswa.php";
        }else{
            include "_Page/PermintaanSiswa/PermintaanSiswaHome.php";
        }
    }
?>