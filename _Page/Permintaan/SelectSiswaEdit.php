<?php
    header('Content-Type: application/json');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    date_default_timezone_set("Asia/Jakarta");

    $search = isset($_POST['search']) ? mysqli_real_escape_string($Conn, $_POST['search']) : '';

    $result = [];

    if(empty($search)){
        $qry_siswa = mysqli_query($Conn, "SELECT id_siswa, nis, nama FROM siswa ORDER BY nama ASC LIMIT 10");
    } else {
        $qry_siswa = mysqli_query($Conn, "SELECT id_siswa, nis, nama FROM siswa WHERE nama LIKE '%$search%' OR nis LIKE '%$search%' ORDER BY nama ASC LIMIT 10");
    }

    while ($data_siswa = mysqli_fetch_array($qry_siswa)) {
        $result[] = [
            'id'   => $data_siswa['id_siswa'],
            'text' => $data_siswa['nis'].' - '.$data_siswa['nama']
        ];
    }

    echo json_encode($result);
?>