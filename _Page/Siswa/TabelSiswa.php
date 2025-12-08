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
                <td colspan="7" class="text-center">
                    <small class="text-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
    }else{
        //Keyword_by
        if(!empty($_POST['keyword_by'])){
            $keyword_by=$_POST['keyword_by'];
        }else{
            $keyword_by="";
        }
        //keyword
        if(!empty($_POST['keyword'])){
            $keyword=$_POST['keyword'];
        }else{
            $keyword="";
        }
        //batas
        if(!empty($_POST['batas'])){
            $batas=$_POST['batas'];
        }else{
            $batas="10";
        }
        //ShortBy
        if(!empty($_POST['ShortBy'])){
            $ShortBy=$_POST['ShortBy'];
        }else{
            $ShortBy="DESC";
        }
        //OrderBy
        if(!empty($_POST['OrderBy'])){
            $OrderBy=$_POST['OrderBy'];
        }else{
            $OrderBy="id_siswa ";
        }
        //Atur Page
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_siswa FROM siswa"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_siswa FROM siswa WHERE nis like '%$keyword%' OR nama like '%$keyword%' OR gender like '%$keyword%' OR email like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_siswa FROM siswa"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_siswa FROM siswa WHERE $keyword_by like '%$keyword%'"));
            }
        }
        
        //Mengatur Halaman
        $JmlHalaman = ceil($jml_data/$batas); 
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="7" class="text-center">
                        <small class="text-danger">Tidak Ada Data Siswa Yang Ditampilkan!</small>
                    </td>
                </tr>
            ';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
             if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM siswa ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM siswa WHERE nis like '%$keyword%' OR nama like '%$keyword%' OR gender like '%$keyword%' OR email like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM siswa ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM siswa WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_siswa = $data['id_siswa'];
                $id_kelas= $data['id_kelas'];
                $nis= $data['nis'];
                $nama= $data['nama'];
                $gender= $data['gender'];
                $email= $data['email'];

                //Routing Gender
                if($gender=="Laki-Laki"){
                    $gender_label='<span class="badge badge-success"><i class="bi bi-gender-male"></i> Laki-laki</span>';
                }else{
                    if($gender=="Perempuan"){
                        $gender_label='<span class="badge badge-danger"><i class="bi bi-gender-female"></i> Perempuan</span>';
                    }else{
                        $gender_label='<span class="badge badge-dark"><i class="bi bi-x-circle"></i> NONE</span>';
                    }
                }

                //Buka Kelas
                if(empty($data['id_kelas'])){
                    $label_kelas='-';
                }else{
                    $jenjang=GetDetailData($Conn, 'kelas', 'id_kelas', $id_kelas, 'jenjang');
                    $kelas=GetDetailData($Conn, 'kelas', 'id_kelas', $id_kelas, 'kelas');
                    
                    $label_kelas="$jenjang-$kelas";
                }
                
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td>
                            <a href="javascriipt:voiid(0);" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="'.$id_siswa .'">
                                <small class="underscore_doted" data-bs-toggle="tooltip" data-bs-placement="top" title="Click di sini untuk melihat detail siswa">'.$nama.'</small>
                            </a>
                        </td>
                        <td><small>'.$nis.'</small></td>
                        <td><small>'.$gender_label.'</small></td>
                        <td><small>'.$email.'</small></td>
                        <td><small>'.$jenjang.'</small></td>
                        <td><small>'.$kelas.'</small></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-dark btn-floating"  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="'.$id_siswa .'">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEdit" data-id="'.$id_siswa .'">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="'.$id_siswa .'">
                                        <i class="bi bi-x"></i> Hapus
                                    </a>
                                </li>
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
    var page_count=<?php echo $JmlHalaman; ?>;
    var curent_page=<?php echo $page; ?>;
    
    //Put Into Pagging Element
    $('#page_info').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button').prop('disabled', true);
    }else{
        $('#prev_button').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button').prop('disabled', true);
    }else{
        $('#next_button').prop('disabled', false);
    }
</script>