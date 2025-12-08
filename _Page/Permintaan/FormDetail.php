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
        
        //Buka nama siswa
        $nama_siswa             = GetDetailData($Conn, 'siswa', 'id_siswa', $id_siswa, 'nama');
        $nis                    = GetDetailData($Conn, 'siswa', 'id_siswa', $id_siswa, 'nis');

        //buka jenjang dan kelas
        $jenjang                = GetDetailData($Conn, 'kelas', 'id_kelas', $id_kelas, 'jenjang');
        $kelas                  = GetDetailData($Conn, 'kelas', 'id_kelas', $id_kelas, 'kelas');
        
        //Format tanggal permintaan
        $label_tgl_permintaan         = date('d F Y H:i T', strtotime($tgl_permintaan));

        //Riuting tanggal selesai
        if($status!=="Selesai"){
            $label_tanggal_selesai = '-';
        }else{
            $label_tanggal_selesai = date('d F Y H:i T', strtotime($tgl_selesai));
        }

        //Routing Status
        if($status=="Diterima"){
            $label_status = '<span class="badge bg-primary"><i class="bi bi-check"></i> Diterima</span>';
        }else{
            if($status=="Ditolak"){
                $label_status = '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ditolak</span>';
            }else{
                if($status=="Proses"){
                    $label_status = '<span class="badge bg-info"><i class="bi bi-three-dots"></i> Proses</span>';
                }else{
                    if($status=="Selesai"){
                        $label_status = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Selesai</span>';
                    }else{
                        $label_status = '<span class="badge bg-warning"><i class="bi bi-send"></i> Pending</span>';
                    }
                }
            }
        }

        //Routing kebutuhan
        if($kebutuhan=='Segera'){
            $label_kebutuhan = '<span class="badge border border-danger border-1 text-danger">Segera</span>';
        }else{
            if($kebutuhan=='Penting'){
                $label_kebutuhan = '<span class="badge border border-primary border-1 text-primary">Penting</span>';
            }else{
                if($kebutuhan=='Biasa'){
                    $label_kebutuhan = '<span class="badge border border-success border-1 text-success">Biasa</span>';
                }else{
                    $label_kebutuhan = '<span class="badge border border-dark border-1 text-dark">None</span>';
                }
            }
        }
        //Form Hide
        echo '
            <input type="hidden" name="Page" value="Permintaan">
            <input type="hidden" name="Sub" value="DetailPermintaan">
            <input type="hidden" name="id" value="'.$id_permintaan.'">
        ';
        //Tampilkan Data
        echo '
            <div class="row mb-2">
                <div class="col-5"><small>NIS</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish">'.$nis.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Nama Siswa</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish">'.$nama_siswa.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Jenjang / Kelas</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish">'.$jenjang.' / '.$kelas.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Tanggal Permintaan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish">'.$label_tgl_permintaan.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Tanggal Selesai</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish">'.$label_tanggal_selesai.'</small>
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
                    <small class="text text-grayish">'.$label_kebutuhan.'</small>
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
                <div class="col-5"><small>Status Permintaan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish">'.$label_status.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Keterangan Pengambilan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish">'.$keterangan_pengambilan.'</small>
                </div>
            </div>
        ';
    }
?>