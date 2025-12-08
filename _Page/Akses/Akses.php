<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-person"></i> Akses Admin</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Akses Admin</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah halaman pengelolaan data akses admin. 
                    Anda bisa menentukan siapa saja yang bisa melakukan akses pada halaman utama aplikasi sebagai admin. 
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
                            <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="modal" data-bs-placement="top" title="Filter Data Akses" data-bs-target="#ModalFilterAkses">
                                <i class="bi bi-filter"></i>
                            </button>

                            <button type="button" class="btn btn-md btn-primary btn-floating" data-bs-toggle="modal" data-bs-placement="top" title="Tambah Data Akses Baru" data-bs-target="#ModalTambahAkses">
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
                                    <th><b>Nama</b></th>
                                    <th><b>Email</b></th>
                                    <th><b>Password</b></th>
                                    <th><b>Image</b></th>
                                    <th><b>Opsi</b></th>
                                </tr>
                            </thead>
                            <tbody id="TabelAkses">
                                <tr>
                                    <td class="text-center" colspan="6">
                                        <small>Tidak ada data akses yang ditampilkan</small>
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