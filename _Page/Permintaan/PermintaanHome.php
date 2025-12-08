<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-send"></i> Permintaan Perbaikan</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Permintaan Perbaikan</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah halaman pengelolaan data permintaan perbaikan fasilitas dan prasarana pendidikan yang dikiriim siswa. 
                    Anda bisa menentukan dan update status permintaan tersebut. 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </small>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-placement="top" title="Filter Data Permintaan" data-bs-target="#ModalFilter">
                                <i class="bi bi-filter"></i>
                            </button>

                            <button type="button" class="btn btn-md btn-primary btn-floating" data-bs-toggle="modal" data-bs-placement="top" title="Tambah Permintaan" data-bs-target="#ModalTambah">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><b>No</b></th>
                                    <th><b>Siswa</b></th>
                                    <th><b>Kelas</b></th>
                                    <th><b>Kategori</b></th>
                                    <th><b>Kebutuhan</b></th>
                                    <th><b>Tgl.Permintaan</b></th>
                                    <th><b>Tgl.Selesai</b></th>
                                    <th><b>Status</b></th>
                                    <th><b>Opsi</b></th>
                                </tr>
                            </thead>
                            <tbody id="TabelPermintaan">
                                <tr>
                                    <td class="text-center" colspan="7">
                                        <small>Loading...</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <small id="page_info">
                                Page 1 Of 100
                            </small>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>