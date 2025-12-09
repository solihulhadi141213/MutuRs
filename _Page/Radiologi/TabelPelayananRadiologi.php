<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    //Menangkap Data Dari Filter
    if(empty($_POST['periode_1'])){
        echo '
            <tr>
                <td class="text-center" colspan="13">
                    <small class="text-danger">Periode Awal Tidak Boleh Kosong</small>
                </td>
            </tr>
        ';
        exit;
    }

    if(empty($_POST['periode_2'])){
        echo '
            <tr>
                <td class="text-center" colspan="13">
                    <small class="text-danger">Periode Akhir Tidak Boleh Kosong</small>
                </td>
            </tr>
        ';
        exit;
    }

    $periode_1 = $_POST['periode_1'];
    $periode_2 = $_POST['periode_2'];

    //Menghitung Jumlah Data
    $jml_data = mysqli_num_rows(mysqli_query($Conn, " SELECT id_rad
        FROM radiologi
        WHERE STR_TO_DATE(waktu, '%Y-%m-%d') >= STR_TO_DATE('$periode_1', '%Y-%m-%d')
        AND STR_TO_DATE(waktu, '%Y-%m-%d') <= STR_TO_DATE('$periode_2', '%Y-%m-%d')"));

    //Jika Data Tidak Ada
    if(empty($jml_data)){
        echo '
            <tr>
                <td class="text-center" colspan="13">
                    <small class="text-danger">Data Tidak Ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }
    
    //Inisiasi Nomor
    $no = 1;
    $query = mysqli_query($Conn, "
        SELECT *
        FROM radiologi
        WHERE STR_TO_DATE(waktu, '%Y-%m-%d') >= STR_TO_DATE('$periode_1', '%Y-%m-%d')
        AND STR_TO_DATE(waktu, '%Y-%m-%d') <= STR_TO_DATE('$periode_2', '%Y-%m-%d')
        ORDER BY STR_TO_DATE(waktu, '%Y-%m-%d') ASC
    ");
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
                <td><small>'.$asal_kiriman.'</small></td>
                <td><small>'.$tujuan.'</small></td>
                <td><small>'.$jenis_pembayaran.'</small></td>
                <td><small>'.$dokter_penerima.'</small></td>
                <td><small>'.$permintaan_pemeriksaan.'</small></td>
                <td><small>'.$start_format.'</small></td>
                <td><small>'.$end_format.'</small></td>
                <td><small>'.$durasi_menit.' Menit</small></td>
                <td><small>'.$radiografer.'</small></td>
            </tr>
       ';
       $no++;
    }
?>