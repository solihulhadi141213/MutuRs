<?php
    // Ambil data utama Anda di sini
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    //Menangkap Data Dari Filter
    if(empty($_POST['periode_1'])){
        echo '<small class="text-danger">Periode Awal Tidak Boleh Kosong</small>';
        exit;
    }

    if(empty($_POST['periode_2'])){
        echo '<small class="text-danger">Periode Akhir Tidak Boleh Kosong</small>';
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
        echo '<small class="text-danger">Data Tidak Ditemukan</small>';
        exit;
    }

    // ================================
    // 1. QUERY DATA ANDA (silakan ganti)
    // ================================
    $query = mysqli_query($Conn, "
        SELECT *
        FROM radiologi
        WHERE STR_TO_DATE(waktu, '%Y-%m-%d') >= STR_TO_DATE('$periode_1', '%Y-%m-%d')
        AND STR_TO_DATE(waktu, '%Y-%m-%d') <= STR_TO_DATE('$periode_2', '%Y-%m-%d')
        ORDER BY STR_TO_DATE(waktu, '%Y-%m-%d') ASC
    ");

    // ================================
    // 2. LOAD PHPSPREADSHEET
    // ================================
    require "../../vendor/autoload.php";

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // Buat objek spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // ================================
    // 3. SET HEADER KOLOM
    // ================================
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Tanggal');
    $sheet->setCellValue('C1', 'No.RM');
    $sheet->setCellValue('D1', 'Nama Pasien');
    $sheet->setCellValue('E1', 'Asal Kiriman');
    $sheet->setCellValue('F1', 'Kunjungan');
    $sheet->setCellValue('G1', 'Pembayaran');
    $sheet->setCellValue('H1', 'Dokter');
    $sheet->setCellValue('I1', 'Pemeriksaan');
    $sheet->setCellValue('J1', 'Mulai');
    $sheet->setCellValue('K1', 'Selesai');
    $sheet->setCellValue('L1', 'Durasi');
    $sheet->setCellValue('M1', 'Petugas');

    // Bold + border header
    $sheet->getStyle('A1:M1')->getFont()->setBold(true);
    $sheet->getStyle('A1:M1')->getBorders()->getAllBorders()->setBorderStyle(
        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
    );

    // ================================
    // 4. ISI DATA DARI QUERY
    // ================================
    $no = 1;
    $row = 2;
    while ($data = mysqli_fetch_assoc($query)) {

        // Jika Anda ingin menghitung durasi:
        $tanggal    = date('d/m/Y', strtotime($data['waktu']));
        $waktu_mulai  = strtotime($data['waktu']);
        $waktu_selesai = strtotime($data['selesai']);
        $durasi_menit = round(($waktu_selesai - $waktu_mulai) / 60);

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

        $tujuan = GetDetailData($Conn, 'kunjungan','id_kunjungan',$id_kunjungan,'tujuan');

        $start_format    = date('H:i', strtotime($waktu));
        $end_format      = date('H:i', strtotime($selesai));

        $sheet->setCellValue('A'.$row, $no);
        $sheet->setCellValue('B'.$row, $tanggal);
        $sheet->setCellValue('C'.$row, $data['id_rad']);
        $sheet->setCellValue('D'.$row, $data['nama']);
        $sheet->setCellValue('E'.$row, $data['asal_kiriman']);
        $sheet->setCellValue('F'.$row, $tujuan);
        $sheet->setCellValue('G'.$row, $data['jenis_pembayaran']);
        $sheet->setCellValue('H'.$row, $data['dokter_penerima']);
        $sheet->setCellValue('I'.$row, $data['permintaan_pemeriksaan']);
        $sheet->setCellValue('J'.$row, $start_format);
        $sheet->setCellValue('K'.$row, $end_format);
        $sheet->setCellValue('L'.$row, $durasi_menit);
        $sheet->setCellValue('M'.$row, $radiografer);

        // Border tiap baris
        $sheet->getStyle('A'.$row.':M'.$row)->getBorders()->getAllBorders()->setBorderStyle(
            \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        );

        $no++;
        $row++;
    }

    // Auto Width
    foreach (range('A','M') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // ================================
    // 5. OUTPUTKAN FILE UNTUK DIDOWNLOAD
    // ================================
    $filename = "Data_Radiologi_".date('Ymd_His').".xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
?>
