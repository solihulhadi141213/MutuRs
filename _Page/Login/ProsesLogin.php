<?php
    session_start();
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    
    // Set header agar selalu mengembalikan JSON
    header('Content-Type: application/json');

    // Tambahkan beberapa header keamanan
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');

    // Tetapkan zona waktu
    date_default_timezone_set('Asia/Jakarta');

    // Timestamp sekarang
    $timestamp_now = date('Y-m-d H:i:s');

    // Atur waktu login
    $expired_seconds = 60 * 60; // 1 hour
    $date_expired = date('Y-m-d H:i:s', strtotime($timestamp_now) + $expired_seconds);

    // Fungsi untuk memvalidasi input
    function validateAndSanitizeInputNew($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Inisialisasi respon default
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan.'
    ];

    // Validasi input Tidak Boleh Kosong
    $email = isset($_POST["email"]) ? filter_var(validateAndSanitizeInputNew($_POST["email"]), FILTER_VALIDATE_EMAIL) : null;
    $password = isset($_POST["password"]) ? validateAndSanitizeInputNew($_POST["password"]) : null;

    if (!$email) {
        $response['message'] = 'Email tidak valid atau kosong.';
    } elseif (empty($password)) {
        $response['message'] = 'Password tidak boleh kosong.';
    } else {
        
        $stmt = $Conn->prepare("SELECT * FROM akses WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $DataAkses = $stmt->get_result()->fetch_assoc();

        //Validasi Password
        if ($DataAkses["password"]==$password) {
            $id_akses = $DataAkses["id_akses"];
            
            //Jika Valid Buatkan Session
            $_SESSION["level_access"]   = "Admin";
            $_SESSION["id_akses"]      = $id_akses;
            $_SESSION["NotifikasiSwal"] = "Login Berhasil";

            //Buat response
            $response['status']     = 'success';
            $response['message']    = 'Login berhasil.';
        } else {
            $response['message'] = 'Kombinasi email dan password admin tidak valid.';
        }
    }

    // Output respon sebagai JSON
    echo json_encode($response);
?>
