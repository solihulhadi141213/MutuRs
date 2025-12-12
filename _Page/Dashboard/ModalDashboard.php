<?php
    // Periode Awal: tanggal 1 bulan sekarang
    $periode_awal = date('Y-m-01');

    // Periode Akhir: tanggal terakhir bulan sekarang
    $periode_akhir = date('Y-m-t');
?>

<div class="modal fade" id="ModalFilterPemeriksaan" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilterPemeriksaan" autocomplete="off">
                <input type="hidden" name="page" id="page_rekap_pemeriksaan" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-filter"></i> Filter Jumlah Pemeriksaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-5"><label for="batas"><small>Batas/Limit</small></label></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6">
                            <select name="batas" id="batas" class="form-control">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5"><label for="periode_1"><small>Periode Awal</small></label></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6"><input type="date" class="form-control" name="periode_1" id="periode_1" value="<?php echo "$periode_awal"; ?>"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5"><label for="periode_2"><small>Periode Akhir</small></label></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6"><input type="date" class="form-control" name="periode_2" id="periode_2" value="<?php echo "$periode_akhir"; ?>"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5"><label for="keyword"><small>Cari Pemeriksaan</small></label></div>
                        <div class="col-1"><small>:</small></div>
                        <div class="col-6"><input type="text" class="form-control" name="keyword" id="keyword"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-check"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDetail" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-list"></i> Detail Pelayanan Pemeriksaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0);" id="ProsesFilterDetail">
                    <input type="hidden" name="page" id="page_detail" value="1">
                    <input type="hidden" name="periode_1" id="periode_1_detail" value="">
                    <input type="hidden" name="periode_2" id="periode_2_detail" value="">
                    <input type="hidden" name="keyword" id="keyword_detail" value="">
                </form>
                <div class="row mb-3">
                    <div class="col-12 text-center" id="title_detail">
                        <b>DATA PELAYANAN</b><br>
                        <span class="text text-grayish">Semua Periode</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                       <div class="table table-responsive">
                            <table class="table table-hover table-striped border-1 border-top">
                                <thead>
                                    <tr>
                                        <td valign="middle"><b><small>No</small></b></td>
                                        <td valign="middle"><b><small>Tanggal</small></b></td>
                                        <td valign="middle"><b><small>No.RM</small></b></td>
                                        <td valign="middle"><b><small>Nama Pasien</small></b></td>
                                        <td valign="middle"><b><small>Tujuan</small></b></td>
                                        <td valign="middle"><b><small>Pembayaran</small></b></td>
                                        <td valign="middle"><b><small>Mulai</small></b></td>
                                        <td valign="middle"><b><small>Selesai</small></b></td>
                                        <td valign="middle"><b><small>Durasi</small></b></td>
                                        <td valign="middle"><b><small>Petugas</small></b></td>
                                        <td valign="middle"><b><small>Opsi</small></b></td>
                                    </tr>
                                </thead>
                                <tbody id="TabelPelayananRadiologi">
                                    <tr>
                                        <td class="text-center" colspan="11">
                                            <small>Tidak ada data kelas yang ditampilkan</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <small id="page_info_detail">
                            0 / 0
                        </small>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_detail">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_detail">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-rounded" id="export_data_pasien">
                    <i class="bi bi-download"></i> Export
                </button>
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDetailPemeriksaan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-list"></i> Detail Pemeriksaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="FormDetailPemeriksaan">
                <!-- Menampilkan Detail Informasi Pemeriksaan -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-rounded kembali_ke_detai">
                    <i class="bi bi-chevron-left"></i> Kembali
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalExportRekap" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="_Page/Dashboard/ExportRekapPemeriksaan.php" method="GET" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-download"></i> Export Rekapitulasi Pemeriksaan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormExportPemeriksaan">
                    <!-- Menampilkan Form Export Pemeriksaan -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalExportDataPasien" tabindex="-1">
    <div class="modal-dialog modal-md ">
        <div class="modal-content">
            <form action="_Page/Dashboard/ExportDataPasien.php" method="GET" target="_blank">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-download"></i> Export Data Pelayanan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormExportDataPasien">
                    <!-- Menampilkan Form Export Data pasien -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-download"></i> Export
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded kembali_ke_detai">
                        <i class="bi bi-chevron-left"></i> Kembali
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalFind" tabindex="-1">
    <div class="modal-dialog modal-md ">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesReplikasi">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-binoculars"></i> Temukan Dan Replikasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="FormReplikasi">
                    <div class="row mb-2">
                        <div class="col-12" id="FormReplikasi">
                            <!-- Menampilkan Form Replikasi Data pasien -->
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12" id="NotifikasiReplikasi">
                            <!-- Menampilkan Notifikasi Replikasi Data pasien -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-layers"></i> Replikasi
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>