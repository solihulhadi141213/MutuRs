<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    $now = date('Y-m-d H:i:s');

    //Validasi Akses
    if (empty($SessionIdAccess)) {
        echo '<div class="alert alert-danger"><small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small></div>';
        exit;
    }

    //Validasi Form Required
    $required = ['student_nis','student_name','student_gender','id_kelas','student_email','password_siswa'];
    foreach($required as $r){
        if(empty($_POST[$r])){
            echo '<div class="alert alert-danger"><small>Field '.htmlspecialchars($r).' wajib diisi!</small></div>';
            exit;
        }
    }

    //Buat Variabel
    $student_nis        = validateAndSanitizeInput($_POST['student_nis']);
    $student_name       = validateAndSanitizeInput($_POST['student_name']);
    $student_gender     = validateAndSanitizeInput($_POST['student_gender']);
    $id_kelas           = validateAndSanitizeInput($_POST['id_kelas']);
    $student_email      = validateAndSanitizeInput($_POST['student_email']);
    $password_siswa      = validateAndSanitizeInput($_POST['password_siswa']);

    //Validasi Password
    if(strlen($password_siswa) < 6 || strlen($password_siswa) > 20 || !preg_match("/^[a-zA-Z0-9]*$/", $password_siswa)){
        echo '<div class="alert alert-danger"><small>Password harus 6-20 karakter huruf/angka!</small></div>';
        exit;
    }

    // Hash password
    $password = password_hash($password_siswa, PASSWORD_DEFAULT);

    //Validasi NIS harus unik
    $stmt = $Conn->prepare("SELECT COUNT(*) FROM siswa WHERE nis=?");
    $stmt->bind_param("s", $student_nis);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo '<div class="alert alert-danger"><small>NIS yang anda masukan sudah terdaftar</small></div>';
        exit;
    }

    //Validasi File Foto Jika Ada
    $student_foto = "";
    $input_foto = "Valid";
    if(!empty($_FILES['student_foto']['name'])){
        $nama_gambar    =$_FILES['student_foto']['name'];
        $ukuran_gambar  =$_FILES['student_foto']['size'];
        $tipe_gambar    =$_FILES['student_foto']['type'];
        $tmp_gambar     =$_FILES['student_foto']['tmp_name'];

        $ext            = pathinfo($nama_gambar, PATHINFO_EXTENSION);
        $nama_baru      = generateRandomString(36);
        $student_foto   =''.$nama_baru.'.'.$ext.'';
        $path           ="../../assets/img/Siswa/".$student_foto;

        if(in_array($tipe_gambar, ["image/jpeg","image/jpg","image/png","image/gif"])){
            if($ukuran_gambar < 2000000){
                if(!move_uploaded_file($tmp_gambar, $path)){
                    $input_foto = "Upload file gagal!";
                }else{
                    $input_foto = "Valid";
                }
            }else{
                $input_foto = "File gambar maksimal 2MB!";
            }
        }else{
            $input_foto = "Tipe file tidak valid!";
        }
    }

    if($input_foto!=="Valid"){
        echo '<div class="alert alert-danger"><small>'.$input_foto.'</small></div>';
        exit;
    }
    
    
    // Menggunakan Prepared Statement
    $stmt = $Conn->prepare("INSERT INTO siswa (
    id_kelas, 
    nis, 
    nama, 
    gender,  
    email, 
    password, 
    foto_siswa
    ) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", 
        $id_kelas, 
        $student_nis, 
        $student_name, 
        $student_gender, 
        $student_email, 
        $password, 
        $student_foto
    );
    $Input = $stmt->execute();
    $stmt->close();

    if($Input){
       echo '<code class="text-success" id="NotifikasiTambahBerhasil">Success</code>';
    }else{
        echo '<div class="alert alert-danger"><small>Terjadi kesalahan pada saat menyimpan data</small></div>';
    }
?>