<?php
    //Validasi Sesi Akses
    if (!empty($_POST['status'])) {
       $status = $_POST['status'];

        //Routing Form Berdasarkan status
        if($status=="Diterima"){
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="keterangan"><small>Keterangan</small></label>
                        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                        <small><small>Contoh : Pengajuan diterima, tunggu update beriikutnya</small></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="foto"><small>Lampiran / Foto</small></label>
                        <input type="file" name="foto" id="foto" class="form-control">
                        <small><small>Maksimal 2 mb (Tipe File : JPG, PNG, GIF)</small></small>
                    </div>
                </div>
            ';
        }
        if($status=="Ditolak"){
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="keterangan"><small>Alasan Penolakan</small></label>
                        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                        <small><small>Contoh : Barang masih dapat digunakan dengan baik</small></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="foto"><small>Lampiran / Foto</small></label>
                        <input type="file" name="foto" id="foto" class="form-control">
                        <small><small>Maksimal 2 mb (Tipe File : JPG, PNG, GIF)</small></small>
                    </div>
                </div>
            ';
        }
        if($status=="Proses"){
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="keterangan"><small>Keterangan Proses</small></label>
                        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                        <small><small>Contoh : Barang dalam proses perbaikan</small></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="foto"><small>Lampiran / Foto</small></label>
                        <input type="file" name="foto" id="foto" class="form-control">
                        <small><small>Maksimal 2 mb (Tipe File : JPG, PNG, GIF)</small></small>
                    </div>
                </div>
            ';
        }
        if($status=="Selesai"){
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="keterangan"><small>Keterangan Pengambilan</small></label>
                        <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                        <small><small>Contoh : Barang sudah selesai, silahkan ambil di bagian sarana & prasarana</small></small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="foto"><small>Lampiran / Foto</small></label>
                        <input type="file" name="foto" id="foto" class="form-control">
                        <small><small>Maksimal 2 mb (Tipe File : JPG, PNG, GIF)</small></small>
                    </div>
                </div>
            ';
        }
    }
?>