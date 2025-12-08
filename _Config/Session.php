<?php
    //Menangkap seasson kemudian menampilkannya
    session_start();

    //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    //Jika Session id_akses Tidak ADa
    if(empty($_SESSION["id_akses"])){
        $SessionIdAccess="";
        $SessionLevel="";
        $SessionEmail="";
        $SessionName="";
        $SessionFoto="";
    }else{

        //Membuat Variabel
        $SessionIdAccess    = validateAndSanitizeInput($_SESSION["id_akses"]);
            
        $QryAdmin   = mysqli_query($Conn,"SELECT * FROM akses WHERE id_akses='$SessionIdAccess'")or die(mysqli_error($Conn));
        $DataAdmin  = mysqli_fetch_array($QryAdmin);
        
        //Apabila 'id_admin' tidak ditemukan
        if(empty($DataAdmin['id_akses'])){
            $SessionIdAccess="";
            $SessionLevel="";
            $SessionEmail="";
            $SessionName="";
            $SessionFoto="";
        }else{
            $SessionIdAccess    = $DataAdmin['id_akses'];
            $SessionLevel       = "Admin";
            $SessionEmail       = $DataAdmin['email'];
            $SessionName        = $DataAdmin['nama'];
            $SessionFoto        = "No-Image.png";
        }
    }
?>
