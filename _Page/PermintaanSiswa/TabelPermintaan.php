<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $JmlHalaman=0;
    $page=0;
    //Validasi Akses
    if(empty($SessionIdAccess)){
        echo '
            <tr>
                <td colspan="9" class="text-center">
                    <small class="text-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_permintaan FROM permintaan WHERE id_siswa='$SessionIdAccess'"));
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="7" class="text-center">
                        <small class="text-danger">Tidak Ada Data Permintaan Yang Ditampilkan!</small>
                    </td>
                </tr>
            ';
        }else{
            $no = 1;
            $query = mysqli_query($Conn, "SELECT*FROM permintaan WHERE id_siswa='$SessionIdAccess' ORDER BY id_permintaan DESC");
            while ($data = mysqli_fetch_array($query)) {
                $id_permintaan          = $data['id_permintaan'];
                $id_siswa               = $data['id_siswa'];
                $id_kelas               = $data['id_kelas'];
                $tgl_permintaan         = $data['tgl_permintaan'];
                $tgl_selesai            = $data['tgl_selesai'];
                $kategori               = $data['kategori'];
                $kebutuhan              = $data['kebutuhan'];
                $status                 = $data['status'];

                //Buka nama siswa
                $nama_siswa             = GetDetailData($Conn, 'siswa', 'id_siswa', $id_siswa, 'nama');

                //buka jenjang dan kelas
                $jenjang                = GetDetailData($Conn, 'kelas', 'id_kelas', $id_kelas, 'jenjang');
                $kelas                  = GetDetailData($Conn, 'kelas', 'id_kelas', $id_kelas, 'kelas');
                
                //Format tanggal permintaan
                $label_tgl_permintaan         = date('d/m/Y H:i', strtotime($tgl_permintaan));

                //Riuting tanggal selesai
                if($status!=="Selesai"){
                    $label_tanggal_selesai = '-';
                }else{
                    $label_tanggal_selesai = date('d/m/Y H:i', strtotime($tgl_selesai));
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
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEdit" data-id="'.$id_permintaan .'">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="'.$id_permintaan .'">
                                <i class="bi bi-x"></i> Batalkan
                            </a>
                        </li>
                    ';
                }else{
                    $opsi_lanjutan = '';
                }
               
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="'.$id_permintaan .'">
                                <small class="underscore_doted" data-bs-toggle="tooltip" data-bs-placement="top" title="Click Di Sini Untuk Melihat Detail Permintaan">
                                    '.$kategori.'
                                </small>
                            </a>
                        </td>
                        <td>'.$label_kebutuhan.'</td>
                        <td><small>'.$label_tgl_permintaan.'</small></td>
                        <td><small>'.$label_tanggal_selesai.'</small></td>
                        <td>'.$label_status.'</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-dark btn-floating"  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="'.$id_permintaan .'">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </a>
                                </li>
                                '.$opsi_lanjutan.'
                            </ul>
                        </td>
                    </tr>
                ';
                $no++;
            }
        }
    }
?>
<script>
    //Creat Javascript Variabel
    var jml_data=<?php echo $jml_data; ?>;
  
    //Put Into Pagging Element
    $('#page_info').html('Data Count : '+jml_data+' Record');

</script>