<?php
    //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";

    // Ambil protokol (http/https)
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' 
            || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    // Ambil host (domain atau IP + port)
    $host = $_SERVER['HTTP_HOST'];

    // Ambil folder root project (level pertama setelah domain)
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $projectRoot = explode('/', trim($scriptName, '/'))[0]; // "PaySiswa"

    // Satukan jadi base URL root project
    $base_url_with_path = rtrim($protocol . $host . '/' . $projectRoot, '/');

    if(empty($_POST['foto'])){
        echo '<div class="alert alert-danger">Tidak Ada File Foto</div>';
        exit;
    }
    $foto = $_POST['foto'];
    $image_url= ''.$base_url_with_path.'/image_proxy.php?dir=Permintaan&filename='.$foto;
    echo '
        <div class="row mb-3">
            <div class="col-12 mb-3 text-center">
                <img src="'.$image_url.'" alt="'.$foto.'" width="70%">
            </div>
        </div>
    ';
?>