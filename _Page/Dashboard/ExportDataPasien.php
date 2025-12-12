<?php
    // Load Composer
    require "../../vendor/autoload.php";

    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // Validasi keyword
    if (empty($_GET['keyword'])) {
        die("Keyword tidak boleh kosong");
    }

    $keyword   = $_GET['keyword'];
    $periode_1 = empty($_GET['periode_1']) ? "" : $_GET['periode_1'];
    $periode_2 = empty($_GET['periode_2']) ? "" : $_GET['periode_2'];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // =============================
    // 1. HEADER TABEL
    // =============================
    $header = [
        "No", "No.RM", "Nama Pasien", "Asal Kiriman", "Permintaan Pemeriksaan",
        "Alat/Pesawat", "Status", "Metode Pembayaran", "Dokter Pengirim",
        "Dokter Penerima", "Radiografer", "Kesan", "Klinis", "Selesai",
        "KV", "MA", "SEC"
    ];

    $col = "A";
    foreach ($header as $head) {
        $sheet->setCellValue($col . "1", $head);
        $col++;
    }

    // =============================
    // 2. QUERY DATA
    // =============================
    if (empty($periode_1) || empty($periode_2)) {
        $query = mysqli_query($Conn, "
            SELECT * FROM radiologi 
            WHERE permintaan_pemeriksaan='$keyword'
            ORDER BY STR_TO_DATE(waktu, '%Y-%m-%d') ASC
        ");
    } else {
        $query = mysqli_query($Conn, "
            SELECT * FROM radiologi
            WHERE permintaan_pemeriksaan='$keyword'
            AND (
                STR_TO_DATE(waktu, '%Y-%m-%d') >= STR_TO_DATE('$periode_1', '%Y-%m-%d') 
                AND STR_TO_DATE(waktu, '%Y-%m-%d') <= STR_TO_DATE('$periode_2', '%Y-%m-%d')
            )
            ORDER BY STR_TO_DATE(waktu, '%Y-%m-%d') ASC
        ");
    }

    // =============================
    // 3. ISI DATA KE EXCEL
    // =============================
    $row = 2;
    $no  = 1;

    while ($data = mysqli_fetch_array($query)) {

        // Format waktu
        $waktu   = date('d/m/Y H:i', strtotime($data['waktu']));
        $selesai = date('d/m/Y H:i', strtotime($data['selesai']));

        // Hitung durasi
        $start = DateTime::createFromFormat('d/m/Y H:i', $waktu);
        $end   = DateTime::createFromFormat('d/m/Y H:i', $selesai);
        $diff  = $start->diff($end);
        $durasi_menit = ($diff->days * 1440) + ($diff->h * 60) + $diff->i;

        // Ambil tujuan kunjungan
        $tujuan = GetDetailData($Conn, 'kunjungan','id_kunjungan',$data['id_kunjungan'],'tujuan');

        // Isi baris data
        $sheet->setCellValue("A$row", $no);
        $sheet->setCellValue("B$row", $data['id_pasien']);
        $sheet->setCellValue("C$row", $data['nama']);
        $sheet->setCellValue("D$row", $data['asal_kiriman']);
        $sheet->setCellValue("E$row", $data['permintaan_pemeriksaan']);
        $sheet->setCellValue("F$row", $data['alat_pemeriksa']);
        $sheet->setCellValue("G$row", $data['status_pemeriksaan']);
        $sheet->setCellValue("H$row", $data['jenis_pembayaran']);
        $sheet->setCellValue("I$row", $data['dokter_pengirim']);
        $sheet->setCellValue("J$row", $data['dokter_penerima']);
        $sheet->setCellValue("K$row", $data['radiografer']);
        $sheet->setCellValue("L$row", $data['kesan']);
        $sheet->setCellValue("M$row", $data['klinis']);
        $sheet->setCellValue("N$row", $selesai);
        $sheet->setCellValue("O$row", $data['kv']);
        $sheet->setCellValue("P$row", $data['ma']);
        $sheet->setCellValue("Q$row", $data['sec']);

        $row++;
        $no++;
    }

    // =============================
    // 4. STYLE: Border + Auto Width
    // =============================
    $sheet->getStyle("A1:Q1")->getFont()->setBold(true);

    foreach (range('A','Q') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // =============================
    // 5. OUTPUT FILE
    // =============================
    $filename = "Rekap_Radiologi_" . date('Ymd_His') . ".xlsx";
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Cache-Control: max-age=0");

    $writer = new Xlsx($spreadsheet);
    $writer->save("php://output");
    exit;
?>
