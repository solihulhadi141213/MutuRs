<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Tampilkan Data
    $query = mysqli_query($Conn, "SELECT DISTINCT jenjang FROM kelas ORDER BY jenjang ASC");
    while ($data = mysqli_fetch_array($query)) {
        $class_level= $data['jenjang'];
        echo '<option value="'.$class_level.'">';
    }
?>