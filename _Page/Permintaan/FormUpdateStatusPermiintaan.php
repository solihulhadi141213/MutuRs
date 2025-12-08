<?php
    //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SettingGeneral.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Validasi Sesi Akses
    if (empty($SessionIdAccess)) {
        echo '
            <div class="alert alert-danger">
                <small>
                    Sesi akses sudah berakhir. Silahkan <b>login</b> ulang!
                </small>
            </div>
        ';
        exit;
    }
    //Tangkap id_permintaan
    if(empty($_POST['id_permintaan'])){
         echo '
            <div class="alert alert-danger">
                <small>
                    ID Permintaan Tidak Boleh Kosong!
                </small>
            </div>
        ';
        exit;
    }

    //Buat variabel
    $id_permintaan = validateAndSanitizeInput($_POST['id_permintaan']);

    //Buka Data access
    $Qry = $Conn->prepare("SELECT * FROM permintaan WHERE id_permintaan = ?");
    $Qry->bind_param("i", $id_permintaan);
    if (!$Qry->execute()) {
        $error=$Conn->error;
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan pada saat membuka data dari database!<br>Keterangan : '.$error.'</small>
            </div>
        ';
    }else{
        $Result = $Qry->get_result();
        $Data = $Result->fetch_assoc();
        $Qry->close();

        //Buat Variabel
        $id_siswa               = $Data['id_siswa'];
        $id_kelas               = $Data['id_kelas'];
        $tgl_permintaan         = $Data['tgl_permintaan'];
        $tgl_selesai            = $Data['tgl_selesai'];
        $kategori               = $Data['kategori'];
        $kebutuhan              = $Data['kebutuhan'];
        $keterangan_permintaan  = $Data['keterangan_permintaan'];
        $status                 = $Data['status'];
        $keterangan_pengambilan = $Data['keterangan_pengambilan'] ?? '-';

        //Format tanggal permintaan
        $label_tgl_permintaan         = date('d F Y H:i T', strtotime($tgl_permintaan));

        
        //Form Hide
        echo '
            <input type="hidden" name="id_permintaan" value="'.$id_permintaan.'">
            <input type="hidden" id="status_put" value="'.$status.'">
            <div class="row mb-2">
                <div class="col-5"><small>Tanggal Permintaan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish">'.$label_tgl_permintaan.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Kategori Permintaan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish">'.$kategori.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Kategori Kebutuhan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish">'.$kebutuhan.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Keterangan Permintaan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish">'.$keterangan_permintaan.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12 mb-2 border-1 border-bottom"></div>
            </div>
        ';
        if($status!=="Ditolak"&&$status!=="Selesai"){
            echo '
                 <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="tanggal_update_permintaan">
                            <small>Tanggal</small>
                        </label>
                        <input type="date" name="tanggal" id="tanggal_update_permintaan" class="form-control" value="'.date('Y-m-d').'" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jam_update_permintaan">
                            <small>Jam</small>
                        </label>
                        <input type="time" name="jam" id="jam_update_permintaan" class="form-control" value="'.date('H:i').'" required>
                    </div>
                </div>
            ';
        }
        //Routing Form berdasarkan Status
        if($status=="Ditolak"){
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                       <div class="alert alert-danger">
                        <small>Permintaan yang sudah ditolak tidak dapat diperbaharui kembali.</small>
                       </div>
                    </div>
                </div>
            ';
        }
        if($status=="Selesai"){
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                       <div class="alert alert-danger">
                        <small>Permintaan yang sudah Selesai tidak dapat diperbaharui kembali.</small>
                       </div>
                    </div>
                </div>
            ';
        }
        if($status==""){
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="status"><small>Status Permintaan</small></label>
                        <select class="form-control" id="status" name="status">
                            <option value="">--Pilih--</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>
            ';
        }
        if($status=="Diterima"){
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="status"><small>Status Permintaan</small></label>
                        <select class="form-control" id="status" name="status">
                            <option value="">--Pilih--</option>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
            ';
        }
        if($status=="Proses"){
            echo '
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="status"><small>Status Permintaan</small></label>
                        <select class="form-control" id="status" name="status">
                            <option value="">--Pilih--</option>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
            ';
        }
        
    }
?>