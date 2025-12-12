<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    if(empty($_POST['keyword'])){
        echo '
            <tr>
                <td colspan="12" class="text-center">
                    <small>Tidak Ada Data yang Ditampilkan</small>
                </td>
            </tr>
        ';
        exit;
    }

    //Variabel Keyword
    $keyword   = $_POST['keyword'];

    // Page
    $page = empty($_POST['page']) ? 1 : $_POST['page'];
    $batas = 10;
    $posisi = ($page - 1) * $batas;

    // Filter
    $periode_1 = empty($_POST['periode_1']) ? "" : $_POST['periode_1'];
    $periode_2 = empty($_POST['periode_2']) ? "" : $_POST['periode_2'];

    //Mempersiapkan isi title
    if(empty($periode_1)||empty($periode_2)){
        $title_table = '
            <b>RINCIAN KUNJUNGAN PEMERIKSAAN </b><br>
            Permintaan Pemeriksaan : <span class="text text-grayish">'.$keyword.'</span> | Periode : <span class="text text-grayish">Semua Periode</span>
        ';
    }else{
        $periode_1_format = date('d/m/Y', strtotime($periode_1));
        $periode_2_format = date('d/m/Y', strtotime($periode_2));
        $title_table = '
            <b>RINCIAN KUNJUNGAN PEMERIKSAAN <span class="text text-grayish">'.$keyword.'</span></b><br>
            Permintaan Pemeriksaan : <span class="text text-grayish">'.$keyword.'</span> | Periode : <span class="text text-grayish">'.$periode_1_format.' S/d '.$periode_2_format.'</span>
        ';
    }

    //Menghitung Jumlah Data
    if(empty($periode_1)||empty($periode_2)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_rad FROM radiologi WHERE permintaan_pemeriksaan='$keyword'"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, " SELECT id_rad FROM radiologi WHERE (permintaan_pemeriksaan='$keyword') AND (STR_TO_DATE(waktu, '%Y-%m-%d') >= STR_TO_DATE('$periode_1', '%Y-%m-%d') AND STR_TO_DATE(waktu, '%Y-%m-%d') <= STR_TO_DATE('$periode_2', '%Y-%m-%d'))"));
    }
    
    //Jika Data Tidak Ada
    if(empty($jml_data)){
        echo '
            <tr>
                <td colspan="12" class="text-center">
                    <small>Tidak Ada Data yang Ditampilkan</small>
                </td>
            </tr>
        ';
        exit;
    }
    
    $JmlHalaman = ceil($jml_data / $batas);
    //Inisiasi Nomor
    $no = 1+$posisi;
    if(empty($periode_1)||empty($periode_2)){
        $query = mysqli_query($Conn, "SELECT * FROM radiologi WHERE permintaan_pemeriksaan='$keyword' ORDER BY STR_TO_DATE(waktu, '%Y-%m-%d') ASC LIMIT $posisi, $batas");
    }else{
        $query = mysqli_query($Conn, "SELECT * FROM radiologi WHERE (permintaan_pemeriksaan='$keyword') AND (STR_TO_DATE(waktu, '%Y-%m-%d') >= STR_TO_DATE('$periode_1', '%Y-%m-%d') AND STR_TO_DATE(waktu, '%Y-%m-%d') <= STR_TO_DATE('$periode_2', '%Y-%m-%d')) ORDER BY STR_TO_DATE(waktu, '%Y-%m-%d') ASC LIMIT $posisi, $batas");
    }
    
    while ($data = mysqli_fetch_array($query)) {
       $id_kunjungan            = $data['id_kunjungan'];
       $id_rad                  = $data['id_rad'];
       $id_pasien               = $data['id_pasien'];
       $nama                    = $data['nama'];
       $waktu                   = $data['waktu'];
       $asal_kiriman            = $data['asal_kiriman'];
       $permintaan_pemeriksaan  = $data['permintaan_pemeriksaan'];
       $jenis_pembayaran        = $data['jenis_pembayaran'];
       $dokter_penerima         = $data['dokter_penerima'];
       $radiografer             = $data['radiografer'];
       $selesai                 = $data['selesai'];

       // Melakukan Format waktu
       $tanggal = date('d/m/Y', strtotime($waktu));
       $waktu   = date('d/m/Y H:i', strtotime($waktu));
       $selesai = date('d/m/Y H:i', strtotime($selesai));

        // Buat objek DateTime
        $start  = DateTime::createFromFormat('d/m/Y H:i', $waktu);
        $end    = DateTime::createFromFormat('d/m/Y H:i', $selesai);

        // Hitung selisih
        $diff = $start->diff($end);

        // Konversi selisih ke menit
        $durasi_menit = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;

       $tujuan = GetDetailData($Conn, 'kunjungan','id_kunjungan',$id_kunjungan,'tujuan');

       $start_format    = date('H:i', strtotime($waktu));
       $end_format      = date('H:i', strtotime($selesai));

       echo '
            <tr>
                <td class="text-center"><small>'.$no.'</small></td>
                <td><small>'.$tanggal.'</small></td>
                <td><small>'.$id_pasien.'</small></td>
                <td><small>'.$nama.'</small></td>
                <td><small>'.$tujuan.'</small></td>
                <td><small>'.$jenis_pembayaran.'</small></td>
                <td><small>'.$start_format.'</small></td>
                <td><small>'.$end_format.'</small></td>
                <td><small>'.$durasi_menit.' Menit</small></td>
                <td><small>'.$radiografer.'</small></td>
                <td>
                    <button class="btn btn-sm btn-floating btn-primary" data-bs-toggle="modal" data-bs-target="#ModalDetailPemeriksaan" data-id="'.$id_rad.'">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </td>
            </tr>
       ';
       $no++;
    }

    echo '
        <script>
            $("#title_detail").html(' . json_encode($title_table) . ');
        </script>
    ';
?>

<script>
    // Javascript untuk Pagination Info
    $('#page_info_detail').html('<?php echo $page; ?> / <?php echo $JmlHalaman; ?>');

    // Atur tombol prev
    $('#prev_button_detail').prop('disabled', <?php echo ($page == 1 ? 'true' : 'false'); ?>);

    // Atur tombol next
    $('#next_button_detail').prop('disabled', <?php echo ($page >= $JmlHalaman ? 'true' : 'false'); ?>);
</script>
