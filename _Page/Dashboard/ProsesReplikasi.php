<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    // Validasi 'keyword_find'
    if (empty($_POST['keyword_find'])) {
        echo json_encode([
            "status" => "Error",
            "message" => "Parameter 'keyword_find' tidak boleh kosong"
        ]);
        exit;
    }

    // Validasi 'karakter_replikasi'
    if (empty($_POST['karakter_replikasi'])) {
        echo json_encode([
            "status" => "Error",
            "message" => "Parameter 'karakter_replikasi' tidak boleh kosong"
        ]);
        exit;
    }

    $keyword_find        = $_POST['keyword_find'];        // Nilai baru
    $karakter_replikasi  = trim($_POST['karakter_replikasi']);  // Nilai yang diganti

    // Query perbaikan (tanpa koma sebelum WHERE)
    $sql = "UPDATE radiologi SET permintaan_pemeriksaan=? WHERE permintaan_pemeriksaan=?";
    $stmt = $Conn->prepare($sql);

    if (!$stmt) {
        echo json_encode([
            "status" => "Error",
            "message" => "Query tidak valid: " . $Conn->error
        ]);
        exit;
    }

    $stmt->bind_param("ss", $keyword_find, $karakter_replikasi);
    $stmt->execute();

    // Mengecek perubahan data
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "status" => "Success",
            "message" => "Replikasi berhasil. Jumlah baris diperbarui: " . $stmt->affected_rows
        ]);
    } else {
        echo json_encode([
            "status" => "Error",
            "message" => "Tidak ada data yang cocok atau tidak ada perubahan yang dilakukan"
        ]);
    }

    $stmt->close();
?>
