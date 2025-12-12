<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-grid"></i> Dashboard
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12" id="notifikasi_proses">
            <!-- Kejadian Kegagalan Menampilkan Data Akan Ditampilkan Disini -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <b id="put_pasien">00.00</b><br>
                            <small>Pasien Radiologi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card info-card transsaction-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ri ri-phone-camera-line"></i>
                        </div>
                        <div class="ps-3">
                            <b id="put_kunjungan">00.00</b><br>
                            <small>Pemeriksaan Radiologi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ri ri-hotel-bed-line"></i>
                        </div>
                        <div class="ps-3">
                            <b id="put_ranap">00.00</b><br>
                            <small>Rawat Inap</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ri ri-hospital-line"></i>
                        </div>
                        <div class="ps-3">
                            <b id="put_rajal">00.00</b><br>
                            <small>Rawat Jalan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body" id="chart">
                           <!-- Menampilkan Grafik Disini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalFilterPemeriksaan" title="Filter Data Pemeriksaan">
                        <i class="bi bi-filter"></i>
                    </button>
                    <button type="button" class="btn btn-md btn-outline-primary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalExportRekap" title="Export Data Pemeriksaan">
                        <i class="bi bi-download"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12 text-center" id="title_rekapitulasi_pemeriksaan">
                            <b>REKAPITULASI JUMLAH PASIEN BERDASARKAN PERMINTAAN PEMERIKSAAN</b><br>
                            <span class="text text-grayish">Semua Periode</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="table table-responsive">
                                <table class="table table-hover table-striped border-1 border-top">
                                    <thead>
                                        <tr>
                                            <th><b><small>No</small></b></th>
                                            <th><b><small>Pemeriksaan</small></b></th>
                                            <th><b><small>Jumlah Pasien</small></b></th>
                                            <th><b><small>Durasi Rata-Rata</small></b></th>
                                            <th><b><small>Opsi</small></b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel_rekap_pemeriksaan">
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <small>No Data</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <small id="page_info_rekap_pemeriksaan">
                                0 / 0
                            </small>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_rekap_pemeriksaan">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_rekap_pemeriksaan">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
