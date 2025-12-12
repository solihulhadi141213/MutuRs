<?php
     // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    // Menangkap key
    if(empty($_POST['permintaan_pemeriksaan'])){
        echo '
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="alert alert-danger"><small>Tidak Ada Pencarian Permintaan Pemeriksaan Yang Dipilih</small></div>
                </div>
            </div>
        ';
        exit;
    }

    // Buat Variabel
    $permintaan_pemeriksaan = $_POST['permintaan_pemeriksaan'];

    //Menghitung Jumlah Temuan
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_rad FROM radiologi WHERE permintaan_pemeriksaan='$permintaan_pemeriksaan'"));

    //Jika Tidak Ditemukan
    if(empty($jml_data)){
        echo '
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="alert alert-danger"><small>Permintaan Pemeriksaan Dengan Karakter <b>'.$permintaan_pemeriksaan.'</b> Tersebut Tidak Ditemukan!</small></div>
                </div>
            </div>
        ';
        exit;
    }

    //Jika Ada Maka Buatkan Form nYa
    echo '
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="keyword_find"><small>Kata Kunci</small></label>
                <input type="text" name="keyword_find" id="keyword_find" class="form-control" value="'.$permintaan_pemeriksaan.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="karakter_replikasi"><small>Karakter Replikasi</small></label>
                <input type="text" name="karakter_replikasi" id="karakter_replikasi" class="form-control" value="'.$permintaan_pemeriksaan.'">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <small>Ditemukan <b>'.$jml_data.'</b> Record Untuk Data Tersebut!</small>
                </div>
            </div>
        </div>
    ';
?>