<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    if(empty($_POST['keyword'])){
        echo '
            <tr>
                <td colspan="12" class="text-center">
                    <small>Tidak Ada Data yang Ditampilkan</small>
                </td>
            </tr>
        ';
        exit;
    }

    //Variabel Keyword
    $keyword   = $_POST['keyword'];

    // Filter
    $periode_1 = empty($_POST['periode_1']) ? "" : $_POST['periode_1'];
    $periode_2 = empty($_POST['periode_2']) ? "" : $_POST['periode_2'];

    echo '

    ';

?>
<div class="row mb-2">
    <div class="col-5"><small>Nama Pemeriksaan</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <input type="text" class="form-control" readonly name="keyword" value="<?php echo "$keyword"; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Periode Awal</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <input type="date" class="form-control" name="periode_1" value="<?php echo "$periode_1"; ?>">
    </div>
</div>
<div class="row mb-2">
    <div class="col-5"><small>Periode Akhir</small></div>
    <div class="col-1"><small>:</small></div>
    <div class="col-6">
        <input type="date" class="form-control" name="periode_2" value="<?php echo "$periode_2"; ?>">
    </div>
</div>