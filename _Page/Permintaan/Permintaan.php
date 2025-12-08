<?php
    if(empty($_GET['Sub'])){
        include "_Page/Permintaan/PermintaanHome.php";
    }else{
        $Sub = $_GET['Sub'];

        if($Sub=="DetailPermintaan"){
            include "_Page/Permintaan/DetailPermintaan.php";
        }else{
            include "_Page/Permintaan/PermintaanHome.php";
        }
    }
?>