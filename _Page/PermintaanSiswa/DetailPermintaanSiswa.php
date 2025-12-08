<?php
    if(empty($_GET['id'])){
        echo '<div class="alert alert-danger">ID Permintaan Tidak Boleh Kosong</div>';
    }else{

        //Buat Variabel Dan Sanitasi
        $id_permintaan = validateAndSanitizeInput($_GET['id']);
        
        //Buka Data Permintaan
        $Qry = $Conn->prepare("SELECT * FROM permintaan WHERE id_permintaan = ?");
        $Qry->bind_param("i", $id_permintaan);
        if (!$Qry->execute()) {
            $error=$Conn->error;
            echo '
                <div class="alert alert-danger">
                    <small>Terjadi kesalahan pada saat membuka data dari database!<br>Keterangan : '.$error.'</small>
                </div>
            ';
        }else{
            $Result = $Qry->get_result();
            $Data = $Result->fetch_assoc();
            $Qry->close();

            //Buat Variabel
            $id_siswa               = $Data['id_siswa'];
            $id_kelas               = $Data['id_kelas'];
            $tgl_permintaan         = $Data['tgl_permintaan'];
            $tgl_selesai            = $Data['tgl_selesai'];
            $kategori               = $Data['kategori'];
            $kebutuhan              = $Data['kebutuhan'];
            $keterangan_permintaan  = $Data['keterangan_permintaan'];
            $status                 = $Data['status'];
            $keterangan_pengambilan = $Data['keterangan_pengambilan'] ?? '-';
            
            //Buka nama siswa
            $nama_siswa             = GetDetailData($Conn, 'siswa', 'id_siswa', $id_siswa, 'nama');
            $nis                    = GetDetailData($Conn, 'siswa', 'id_siswa', $id_siswa, 'nis');

            //buka jenjang dan kelas
            $jenjang                = GetDetailData($Conn, 'kelas', 'id_kelas', $id_kelas, 'jenjang');
            $kelas                  = GetDetailData($Conn, 'kelas', 'id_kelas', $id_kelas, 'kelas');
            
            //Format tanggal permintaan
            $label_tgl_permintaan         = date('d F Y H:i T', strtotime($tgl_permintaan));

            //Riuting tanggal selesai
            if($status!=="Selesai"){
                $label_tanggal_selesai = '-';
            }else{
                $label_tanggal_selesai = date('d F Y H:i T', strtotime($tgl_selesai));
            }

            //Routing Status
            if($status=="Diterima"){
                $label_status = '<span class="badge bg-primary"><i class="bi bi-check"></i> Diterima</span>';
            }else{
                if($status=="Ditolak"){
                    $label_status = '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ditolak</span>';
                }else{
                    if($status=="Proses"){
                        $label_status = '<span class="badge bg-info"><i class="bi bi-three-dots"></i> Proses</span>';
                    }else{
                        if($status=="Selesai"){
                            $label_status = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Selesai</span>';
                        }else{
                            $label_status = '<span class="badge bg-warning"><i class="bi bi-send"></i> Pending</span>';
                        }
                    }
                }
            }

            //Routing kebutuhan
            if($kebutuhan=='Segera'){
                $label_kebutuhan = '<span class="badge border border-danger border-1 text-danger">Segera</span>';
            }else{
                if($kebutuhan=='Penting'){
                    $label_kebutuhan = '<span class="badge border border-primary border-1 text-primary">Penting</span>';
                }else{
                    if($kebutuhan=='Biasa'){
                        $label_kebutuhan = '<span class="badge border border-success border-1 text-success">Biasa</span>';
                    }else{
                        $label_kebutuhan = '<span class="badge border border-dark border-1 text-dark">None</span>';
                    }
                }
            }
            if($status==""){
                $opsi_lanjutan = '
                    <button type="button" class="btn btn-sm btn-outline-dark"  data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i> Option
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                        <li class="dropdown-header text-start">
                            <h6>Option</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEdit" data-id="'.$id_permintaan .'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="'.$id_permintaan .'">
                                <i class="bi bi-x"></i> Hapus
                            </a>
                        </li>
                    </ul>
                ';
            }else{
                $opsi_lanjutan = '';
            }
            
            //Tampilkan Header
            echo '
                <div class="pagetitle">
                    <h1>
                        <a href="">
                            <i class="bi bi-info-circle"></i> Detail Permintaan</a>
                        </a>
                    </h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="index.php?Page=PermintaanSiswa">Permintaan Perbaikan</a></li>
                            <li class="breadcrumb-item active">Detail Permintaan</li>
                        </ol>
                    </nav>
                </div>
            ';

            //Detaiil Permintaan
            echo '
                <input type="hidden" id="put_id_permintaan" value="'.$id_permintaan.'">
                <section class="section dashboard">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <b class="card-title"># Informasi Permintaan</b>
                                        </div>
                                        <div class="col-4 text-end">
                                            <a href="index.php?Page=PermintaanSiswa" class="btn btn-md btn-dark btn-floating" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali ke halaman utama permintaan">
                                                <i class="bi bi-chevron-left"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-5"><small>NIS</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-6">
                                            <small class="text text-grayish">'.$nis.'</small>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small>Nama Siswa</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-6">
                                            <small class="text text-grayish">'.$nama_siswa.'</small>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small>Jenjang / Kelas</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-6">
                                            <small class="text text-grayish">'.$jenjang.' / '.$kelas.'</small>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small>Tanggal Permintaan</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-6">
                                            <small class="text text-grayish">'.$label_tgl_permintaan.'</small>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small>Tanggal Selesai</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-6">
                                            <small class="text text-grayish">'.$label_tanggal_selesai.'</small>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small>Kategori Permintaan</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-6">
                                            <small class="text text-grayish">'.$kategori.'</small>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small>Kategori Kebutuhan</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-6">
                                            <small class="text text-grayish">'.$label_kebutuhan.'</small>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small>Keterangan Permintaan</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-6">
                                            <small class="text text-grayish">'.$keterangan_permintaan.'</small>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small>Status Permintaan</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-6">
                                            <small class="text text-grayish">'.$label_status.'</small>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5"><small>Keterangan Pengambilan</small></div>
                                        <div class="col-1"><small>:</small></div>
                                        <div class="col-6">
                                            <small class="text text-grayish">'.$keterangan_pengambilan.'</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    '.$opsi_lanjutan.'
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            ';
?>
            <div class="card">
                <div class="card-header">
                    <b># Riwayat Status Permintaan</b>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><b>No</b></th>
                                    <th><b>Tanggal</b></th>
                                    <th><b>Jam</b></th>
                                    <th><b>Petugas</b></th>
                                    <th><b>Keterangan</b></th>
                                    <th><b>Foto</b></th>
                                    <th><b>Status</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //Hitung Jumlah Data
                                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_permintaan_status FROM permintaan_status WHERE id_permintaan='$id_permintaan'"));

                                    if(empty($jml_data)){
                                        echo '
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <small class="text-danger">Tidak Ada Riwayat Pembaharuan Untuk Permintaan Ini</small>
                                                </td>
                                            </tr>
                                        ';
                                    }
                                    
                                    //Menampilkan Data permintaan_status
                                    $no=1;
                                    $query_riwayat = mysqli_query($Conn, "SELECT*FROM permintaan_status WHERE id_permintaan='$id_permintaan' ORDER BY tanggal ASC");
                                    while ($data_riwayat = mysqli_fetch_array($query_riwayat)) {
                                        $id_permintaan_status   = $data_riwayat['id_permintaan_status'];
                                        $id_admin               = $data_riwayat['id_admin'];
                                        $tanggal_list           = $data_riwayat['tanggal'];
                                        $keterangan_list        = $data_riwayat['keterangan'];
                                        $foto_list              = $data_riwayat['foto'];
                                        $status_list            = $data_riwayat['status'];

                                        $tanggal_format = date('d F Y', strtotime($tanggal_list));
                                        $jam_format = date('H:i T', strtotime($tanggal_list));

                                        //Nama Admin
                                        $nama_admin = GetDetailData($Conn, 'admin', 'id_admin', $id_admin, 'admin_name');

                                        if(!empty($foto_list)){
                                            $foto_label = '
                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailFoto" data-foto="'.$foto_list .'">
                                                    <span class="badge badge-success">Lihat Foto</span>
                                                </a>
                                            ';
                                        }else{
                                            $foto_label = "-";
                                        }

                                        //Routing Status
                                        if($status_list=="Diterima"){
                                            $label_status2 = '<span class="badge bg-primary"><i class="bi bi-check"></i> Diterima</span>';
                                        }else{
                                            if($status_list=="Ditolak"){
                                                $label_status2 = '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ditolak</span>';
                                            }else{
                                                if($status_list=="Proses"){
                                                    $label_status2 = '<span class="badge bg-info"><i class="bi bi-three-dots"></i> Proses</span>';
                                                }else{
                                                    if($status_list=="Selesai"){
                                                        $label_status2 = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Selesai</span>';
                                                    }else{
                                                        $label_status2 = '<span class="badge bg-warning"><i class="bi bi-send"></i> Pending</span>';
                                                    }
                                                }
                                            }
                                        }

                                        //Tampilkan Data
                                        echo '
                                            <tr>
                                                <td><small>'.$no.'</small></td>
                                                <td><small>'.$tanggal_format.'</small></td>
                                                <td><small>'.$jam_format.'</small></td>
                                                <td><small>'.$nama_admin.'</small></td>
                                                <td><small>'.$keterangan_list.'</small></td>
                                                <td>'.$foto_label.'</td>
                                                <td>'.$label_status2.'</td>
                                            </tr>
                                        ';
                                        $no++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
<?php
        }
    }   
?>