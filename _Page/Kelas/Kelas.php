<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-building"></i> Kelas</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Kelas</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <small>
                    Berikut ini adalah halaman pengelolaan data kelas. 
                    Silahkan tambahkan daftar kelas yang tersedia.
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
                        <div class="col-xl-3 col-lg-4 col-md-8 col-sx-8 col-8"></div>
                        <div class="col-xl-9 col-lg-8 col-md-4 col-sx-4 col-4 text-end">
                            <button type="button" class="btn btn-md btn-primary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalTambah" title="Tambah Data Kelas">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td valign="middle"><b>No</b></td>
                                    <td valign="middle"><b>Jenjang</b></td>
                                    <td valign="middle"><b>Kelas/Rombel</b></td>
                                    <td valign="middle"><b>Siswa</b></td>
                                    <td valign="middle"><b>Permintaan</b></td>
                                    <td valign="middle" align="right"><b>Opsi</b></td>
                                </tr>
                            </thead>
                            <tbody id="TabelKelas">
                                <tr>
                                    <td class="text-center" colspan="6">
                                        <small>Tidak ada data kelas yang ditampilkan</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
