<?php
    // Load PhpSpreadsheet
    require "../../vendor/autoload.php";

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Border;

    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";

    // Ambil filter
    $periode_1 = empty($_GET['periode_1']) ? "" : $_GET['periode_1'];
    $periode_2 = empty($_GET['periode_2']) ? "" : $_GET['periode_2'];

    // Tentukan title
    if(empty($periode_1) || empty($periode_2)){
        $title = "REKAPITULASI JUMLAH PASIEN BERDASARKAN PERMINTAAN PEMERIKSAAN\nSemua Periode";
    } else {
        $periode_1_format = date('d F Y', strtotime($periode_1));
        $periode_2_format = date('d F Y', strtotime($periode_2));
        $title = "REKAPITULASI JUMLAH PASIEN BERDASARKAN PERMINTAAN PEMERIKSAAN\nPeriode $periode_1_format s/d $periode_2_format";
    }

    // ---------------------------
    // QUERY DATA
    // ---------------------------
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
        WHERE 1=1
    ";

    // Filter periode
    if (!empty($periode_1) && !empty($periode_2)) {
        $sql .= "
            AND STR_TO_DATE(waktu, '%Y-%m-%d') >= STR_TO_DATE('$periode_1', '%Y-%m-%d')
            AND STR_TO_DATE(waktu, '%Y-%m-%d') <= STR_TO_DATE('$periode_2', '%Y-%m-%d')
        ";
    }

    $sql .= "
        GROUP BY permintaan_pemeriksaan
        ORDER BY jumlah_pemeriksaan DESC
    ";

    $query = mysqli_query($Conn, $sql);

    // ---------------------------
    // MULAI BANGUN FILE EXCEL
    // ---------------------------
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Judul
    $sheet->setCellValue('A1', $title);
    $sheet->mergeCells('A1:D1');
    $sheet->getStyle('A1')->getFont()->setBold(true);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    // Header Kolom
    $sheet->setCellValue('A3', 'No');
    $sheet->setCellValue('B3', 'Pemeriksaan');
    $sheet->setCellValue('C3', 'Jumlah Pasien');
    $sheet->setCellValue('D3', 'Rata-rata Durasi Pelayanan (menit)');

    $sheet->getStyle('A3:D3')->getFont()->setBold(true);
    $sheet->getStyle('A3:D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A3:D3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // Isi Data
    $rowNumber = 4;
    $no = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $sheet->setCellValue("A$rowNumber", $no);
        $sheet->setCellValue("B$rowNumber", $row['permintaan_pemeriksaan']);
        $sheet->setCellValue("C$rowNumber", $row['jumlah_pemeriksaan']);
        $sheet->setCellValue("D$rowNumber", round($row['rata_rata_durasi'], 2));

        // Border tiap baris
        $sheet->getStyle("A$rowNumber:D$rowNumber")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle("A$rowNumber")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("C$rowNumber")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D$rowNumber")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $no++;
        $rowNumber++;
    }

    // Auto width kolom
    foreach (range('A','D') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // ---------------------------
    // EXPORT FILE
    // ---------------------------
    $filename = "Rekap_Pemeriksaan_Radiologi.xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

?>
