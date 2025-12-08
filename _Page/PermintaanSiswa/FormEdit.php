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
        $tanggal    = date('Y-m-d', strtotime($tgl_permintaan));
        $jam        = date('H:i', strtotime($tgl_permintaan));

        //Riuting tanggal selesai
        if($status!=="Selesai"){
            $label_tanggal_selesai = '-';
        }else{
            $label_tanggal_selesai = date('d F Y H:i T', strtotime($tgl_selesai));
        }

        
        //Form Hide
        echo '
            <input type="hidden" name="id_permintaan" value="'.$id_permintaan.'">
            <input type="hidden" name="id_siswa" value="'.$id_siswa.'">
        ';
?>
        <div class="row mb-2">
            <div class="col-md-6">
                <label for="tanggal_permintaan_edit">
                    <small>Tanggal</small>
                </label>
                <input type="date" name="tanggal_permintaan" id="tanggal_permintaan_edit" class="form-control" value="<?php echo $tanggal; ?>" required>
            </div>
            <div class="col-md-6">
                <label for="jam_permintaan_edit">
                    <small>Jam</small>
                </label>
                <input type="time" name="jam_permintaan" id="jam_permintaan_edit" class="form-control" value="<?php echo $jam; ?>" required>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <label for="kategori">
                    <small>Kategori Permintaan</small>
                </label>
                <select id="kategori" name="kategori" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option <?php if($kategori=="Pembelian"){echo "selected";} ?> value="Pembelian">Pembelian</option>
                    <option <?php if($kategori=="Pemeliharaan Rutin"){echo "selected";} ?> value="Pemeliharaan Rutin">Pemeliharaan Rutin</option>
                    <option <?php if($kategori=="Perbaikan"){echo "selected";} ?> value="Perbaikan">Perbaikan</option>
                    <option <?php if($kategori=="Isi Ulang"){echo "selected";} ?> value="Isi Ulang">Isi Ulang</option>
                </select>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <label for="kebutuhan">
                    <small>Kategori Kebutuhan</small>
                </label>
                <select id="kebutuhan" name="kebutuhan" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option <?php if($kebutuhan=="Segera"){echo "selected";} ?> value="Segera">Segera</option>
                    <option <?php if($kebutuhan=="Penting"){echo "selected";} ?> value="Penting">Penting</option>
                    <option <?php if($kebutuhan=="Biasa"){echo "selected";} ?> value="Biasa">Biasa</option>
                </select>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <label for="keterangan_permintaan">
                    <small>Keterangan Permintaan</small>
                </label>
                <textarea class="form-control" name="keterangan_permintaan" id="keterangan_permintaan" required><?php echo $keterangan_permintaan; ?></textarea>
                <small>
                    <small>Diisi dengan nama barang dan penjelasan yang perlu dilakukan</small>
                </small>
            </div>
        </div>

<?php
    }
?>