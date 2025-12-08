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
        <div class="col-md-12">
            <div class="card" id="card_jam_menarik">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2 text-center" id="image_menarik">
                            <img src="assets/img/<?php echo $app_logo; ?>" width="150px" class="image_menarik">
                        </div>
                        <div class="col-md-9 mb-2 text-end">
                            <h1 class="text text-white"><?php echo $company_name; ?></h1>
                            <div id="tanggal_menarik">Hari, 01 Januari 1900</div><br>
                            <div id="jam_menarik">00:00:00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="ps-3">
                            <b id="put_pasien">00.00</b><br>
                            <small>Pasien</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-building"></i>
                        </div>
                        <div class="ps-3">
                            <b id="put_kunjungan">00.00</b><br>
                            <small>Kunjungan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-send"></i>
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
            <div class="card info-card customers-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-check"></i>
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
</section>
