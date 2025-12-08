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
    //Tangkap id_organization_class
    if(empty($_POST['id_student'])){
         echo '
            <div class="alert alert-danger">
                <small>
                    ID sISWA Tidak Boleh Kosong!
                </small>
            </div>
        ';
        exit;
    }

    //Buat variabel
    $id_student=validateAndSanitizeInput($_POST['id_student']);

    //Buka Data sISWA
    $Qry = $Conn->prepare("SELECT * FROM siswa WHERE id_siswa = ?");
    $Qry->bind_param("i", $id_student);
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
        $id_kelas   = $Data['id_kelas'];
        $nis        = $Data['nis'];
        $nama       = $Data['nama'];
        $gender     = $Data['gender'];
        $email      = $Data['email'];
        $foto_siswa = $Data['foto_siswa'];


        //Tampilkan Data
        echo '
            <input type="hidden" name="id_student" value="'.$id_student.'">
        ';
?>
    <div class="row mb-3">
        <div class="col-4">
            <label for="student_nis_edit">
                <small>Nomor Induk Siswa (NIS)</small>
            </label>
        </div>
        <div class="col-8">
            <input type="text" name="student_nis" id="student_nis_edit" class="form-control" required value="<?php echo "$nis"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-4">
            <label for="student_name_edit">
                <small>Nama Lengkap</small>
            </label>
        </div>
        <div class="col-8">
            <input type="text" name="student_name" id="student_name_edit" class="form-control" required value="<?php echo "$nama"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-4">
            <label for="student_gender_edit">
                <small>Gender (Jenis Kelamin)</small>
            </label>
        </div>
        <div class="col-8">
            <select name="student_gender" id="student_gender_edit" class="form-control" required>
                <option value="">Pilih</option>
                <option <?php if($gender=="Laki-laki"){echo "selected";} ?> value="Laki-laki">Laki-laki</option>
                <option <?php if($gender=="Perempuan"){echo "selected";} ?> value="Perempuan">Perempuan</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-4">
            <label for="id_kelas_edit">
                <small>Kelas (Rombel)</small>
            </label>
        </div>
        <div class="col-8">
            <select name="id_kelas" id="id_kelas_edit" class="form-control" required>
                <option value="">Pilih</option>
                <?php
                    //Tampilkan Level
                    $query_level = mysqli_query($Conn, "SELECT DISTINCT jenjang FROM kelas ORDER BY jenjang ASC");
                    while ($data_level = mysqli_fetch_array($query_level)) {
                        $class_level = $data_level['jenjang'];
                        echo '<optgroup label="'.$class_level.'">';

                        //Tampilkan Kelas
                        $query_kelas = mysqli_query($Conn, "SELECT id_kelas, kelas FROM kelas WHERE jenjang='$class_level' ORDER BY kelas ASC");
                        while ($data_kelas = mysqli_fetch_array($query_kelas)) {
                            $id_organization_class = $data_kelas['id_kelas'];
                            $class_name = $data_kelas['kelas'];
                            if($id_kelas==$id_organization_class){
                                echo '<option selected value="'.$id_organization_class.'">'.$class_level.'-'.$class_name.'</option>';
                            }else{  
                                echo '<option value="'.$id_organization_class.'">'.$class_level.'-'.$class_name.'</option>';
                            }
                        }
                        echo '</optgroup>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-4">
            <label for="student_email_edit">
                <small>Alamat Email</small>
            </label>
        </div>
        <div class="col-8">
            <input type="email" name="student_email" id="student_email_edit" class="form-control" placeholder="alamat_email@domain.com" value="<?php echo "$email"; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-4">
            <label for="password_siswa_edit">
                <small>Password</small>
            </label>
        </div>
        <div class="col-8">
            <input type="password" name="password_siswa" id="password_siswa_edit" class="form-control">
            <small>
                Isi form ini untuk mengubah password siiswa.
            </small>
            <small class="text-dark">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Tampilkan" id="TampilkanPassword_edit" name="TampilkanPassword_edit">
                    <label class="form-check-label" for="TampilkanPassword_edit">
                        <small class="text text-dark">Tampilkan Password</small>
                    </label>
                </div>
            </small>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-4">
            <label for="student_foto">
                <small>Foto Profil</small>
            </label>
        </div>
        <div class="col-8">
            <input type="file" name="student_foto" id="student_foto" class="form-control">
            <small>
                <small class="text text-grayish">Maximum 2 Mb (File Type: PNG, JPG, GIF)</small>
            </small>
        </div>
    </div>

<?php } ?>