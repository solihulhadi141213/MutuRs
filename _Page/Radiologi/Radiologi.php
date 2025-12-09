<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-building"></i> Radiologi</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Radiologi</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah halaman laporan mutu Radiologi.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form action="_Page/Radiologi/ProsesExportPelayanan.php" method="POST" target="_blank" id="FilterPelayanan">
                        <div class="row">
                            <div class="col-md-4">
                                <b class="card-title"># Durasi Pelayanan</b>
                            </div>
                            <div class="col-md-2">
                                <label for="periode_1"><small>Periode Awal</small></label>
                                <input type="date" class="form-control" name="periode_1" id="periode_1">
                            </div>
                            <div class="col-md-2">
                                <label for="periode_2"><small>Periode Akhir</small></label>
                                <input type="date" class="form-control" name="periode_2" id="periode_2">
                            </div>
                            <div class="col-md-2">
                                <label><small><br></small></label>
                                <button type="button" id="filter_pelayanan" class="btn btn-block btn-primary">
                                    <i class="bi bi-search"></i> Tampilkan
                                </button>
                            </div>
                            <div class="col-md-2">
                                <label><small><br></small></label>
                                <button type="submit" id="submit" class="btn btn-block btn-secondary">
                                    <i class="bi bi-download"></i> Export
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <b>DATA MUTU PELAYANAN RADIOLOGI</b>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="table table-responsive">
                                <table class="table table-hover border-1 border-top">
                                    <thead>
                                        <tr>
                                            <td valign="middle"><b><small>No</small></b></td>
                                            <td valign="middle"><b><small>Tanggal</small></b></td>
                                            <td valign="middle"><b><small>No.RM</small></b></td>
                                            <td valign="middle"><b><small>Nama Pasien</small></b></td>
                                            <td valign="middle"><b><small>Asal</small></b></td>
                                            <td valign="middle"><b><small>Kunjungan</small></b></td>
                                            <td valign="middle"><b><small>Pembayaran</small></b></td>
                                            <td valign="middle"><b><small>Dokter</small></b></td>
                                            <td valign="middle"><b><small>Pemeriksaan</small></b></td>
                                            <td valign="middle"><b><small>Mulai</small></b></td>
                                            <td valign="middle"><b><small>Selesai</small></b></td>
                                            <td valign="middle"><b><small>Durasi</small></b></td>
                                            <td valign="middle"><b><small>Petugas</small></b></td>
                                        </tr>
                                    </thead>
                                    <tbody id="TabelPelayananRadiologi">
                                        <tr>
                                            <td class="text-center" colspan="13">
                                                <small>Tidak ada data kelas yang ditampilkan</small>
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
                        <div class="col-12">
                            <small>
                                Level/Kelas : <span id="put_jumlah_data">0/0</span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
