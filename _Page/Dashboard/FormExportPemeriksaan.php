<?php
    //Mengnakap periode_1
    if(empty($_POST['periode_1'])){
        $periode_1 = "";
    }else{
        $periode_1 = $_POST['periode_1'];
    }

    //Mengnakap periode_2
    if(empty($_POST['periode_2'])){
        $periode_2 = "";
    }else{
        $periode_2 = $_POST['periode_2'];
    }
?>
<div class="row mb-2">
    <div class="col-4">
        <label for="periode_1"><small>Periode Awal</small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="date" name="periode_1" id="periode_1" class="form-control" value="<?php echo "$periode_1";?>">
    </div>
</div>

<div class="row mb-2">
    <div class="col-4">
        <label for="periode_2"><small>Periode Akhir</small></label>
    </div>
    <div class="col-1"><small>:</small></div>
    <div class="col-7">
        <input type="date" name="periode_2" id="periode_2" class="form-control" value="<?php echo "$periode_2";?>">
    </div>
</div>

<div class="row mb-2">
    <div class="col-12 text-center">
        <div class="alert alert-info">
            <small>
                Semakin besar data, maka sistem akan membutuhkan waktu lebih lama.<br>
                <b>Apakah anda yakin akan melanjutkan export data?</b>
            </small>
        </div>
    </div>
</div>