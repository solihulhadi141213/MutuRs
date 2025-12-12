<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    // Page
    $page = empty($_POST['page']) ? 1 : $_POST['page'];
    $batas = empty($_POST['batas']) ? 10 : $_POST['batas'];
    $posisi = ($page - 1) * $batas;

    // Filter
    $periode_1 = empty($_POST['periode_1']) ? "" : $_POST['periode_1'];
    $periode_2 = empty($_POST['periode_2']) ? "" : $_POST['periode_2'];
    $keyword   = empty($_POST['keyword']) ? "" : $_POST['keyword'];

    //Mempersiapkan isi title
    if(empty($periode_1)||empty($periode_2)){
        $title_table = '
            <b>REKAPITULASI JUMLAH PASIEN BERDASARKAN PERMINTAAN PEMERIKSAAN</b><br>
            <span class="text text-grayish">Semua Periode</span>
        ';
    }else{
        $periode_1_format = date('d F Y', strtotime($periode_1));
        $periode_2_format = date('d F Y', strtotime($periode_2));
        $title_table = '
            <b>REKAPITULASI JUMLAH PASIEN BERDASARKAN PERMINTAAN PEMERIKSAAN</b><br>
            <span class="text text-grayish">Periode '.$periode_1_format.' s/d '.$periode_2_format.'</span>
        ';
    }

    // -------------------------------------------
    // HITUNG TOTAL DATA (PAGINATION)
    // -------------------------------------------
    $sql_count = "
        SELECT COUNT(*) AS jml
        FROM (
            SELECT permintaan_pemeriksaan
            FROM radiologi
            WHERE 1=1
    ";

    // Filter periode
    if (!empty($periode_1) && !empty($periode_2)) {
        $sql_count .= "
            AND STR_TO_DATE(waktu, '%Y-%m-%d') >= STR_TO_DATE('$periode_1', '%Y-%m-%d')
            AND STR_TO_DATE(waktu, '%Y-%m-%d') <= STR_TO_DATE('$periode_2', '%Y-%m-%d')
        ";
    }

    // Filter keyword
    if (!empty($keyword)) {
        $sql_count .= " AND permintaan_pemeriksaan LIKE '%$keyword%' ";
    }

    $sql_count .= "
            GROUP BY permintaan_pemeriksaan
        ) AS t
    ";

    $res_count = mysqli_fetch_assoc(mysqli_query($Conn, $sql_count));
    $jml_data = empty($res_count['jml']) ? 0 : $res_count['jml'];
    $JmlHalaman = ceil($jml_data / $batas);

    // -------------------------------------------
    // JIKA TIDAK ADA DATA
    // -------------------------------------------
    if ($jml_data == 0) {
        echo '
            <tr>
                <td colspan="5" class="text-center">
                    <small>Tidak Ada Data yang Ditampilkan</small>
                </td>
            </tr>
        ';
    } else {

        // -------------------------------------------
        // QUERY DATA UTAMA
        // -------------------------------------------
        $sql = "
            SELECT 
                permintaan_pemeriksaan,
                COUNT(id_rad) AS jumlah_pemeriksaan,
                AVG(
                    TIMESTAMPDIFF(
                        MINUTE,
                        STR_TO_DATE(waktu, '%Y-%m-%d %H:%i:%s'),
                        STR_TO_DATE(selesai, '%Y-%m-%d %H:%i:%s')
                    )
                ) AS rata_rata_durasi
            FROM radiologi
            WHERE 1 = 1
        ";

        // Filter periode
        if (!empty($periode_1) && !empty($periode_2)) {
            $sql .= "
                AND STR_TO_DATE(waktu, '%Y-%m-%d') >= STR_TO_DATE('$periode_1', '%Y-%m-%d')
                AND STR_TO_DATE(waktu, '%Y-%m-%d') <= STR_TO_DATE('$periode_2', '%Y-%m-%d')
            ";
        }

        // Filter keyword
        if (!empty($keyword)) {
            $sql .= " AND permintaan_pemeriksaan LIKE '%$keyword%' ";
        }

        // Grup + order + limit
        $sql .= "
            GROUP BY permintaan_pemeriksaan
            ORDER BY jumlah_pemeriksaan DESC
            LIMIT $posisi, $batas
        ";

        $query = mysqli_query($Conn, $sql);

        $no = 1 + $posisi;

        while ($row = mysqli_fetch_assoc($query)) {

            $permintaan_pemeriksaan = $row['permintaan_pemeriksaan'];
            $jumlah_pemeriksaan     = $row['jumlah_pemeriksaan'];
            $rata_rata_durasi       = round($row['rata_rata_durasi'], 2);

            echo '
                <tr>
                    <td><small>'.$no.'</small></td>
                    <td>
                        <a href="javascript:void(0);" class="show_modal_detail" data-key="'.$permintaan_pemeriksaan.'" data-periode_1="'.$periode_1.'" data-periode_2="'.$periode_2.'">
                            <small class="underscore_doted">'.$permintaan_pemeriksaan.'</small>
                        </a>
                    </td>
                    <td><small>'.$jumlah_pemeriksaan.'</small></td>
                    <td><small>'.$rata_rata_durasi.'</small></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-dark btn-floating" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start"><h6>Option</h6></li>
                            <li>
                                <a class="dropdown-item show_modal_detail" href="javascript:void(0)" data-key="'.$permintaan_pemeriksaan.'" data-periode_1="'.$periode_1.'" data-periode_2="'.$periode_2.'">
                                    <i class="bi bi-info-circle"></i> Detail
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalFind" data-key="'.$permintaan_pemeriksaan.'">
                                    <i class="bi bi-binoculars"></i> Find
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            ';

            $no++;
        }
    }

    echo '
        <script>
            $("#title_rekapitulasi_pemeriksaan").html(' . json_encode($title_table) . ');
        </script>
    ';
?>

<script>
    // Javascript untuk Pagination Info
    $('#page_info_rekap_pemeriksaan').html('<?php echo $page; ?> / <?php echo $JmlHalaman; ?>');

    // Atur tombol prev
    $('#prev_button_rekap_pemeriksaan').prop('disabled', <?php echo ($page == 1 ? 'true' : 'false'); ?>);

    // Atur tombol next
    $('#next_button_rekap_pemeriksaan').prop('disabled', <?php echo ($page >= $JmlHalaman ? 'true' : 'false'); ?>);
</script>
