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
            $OrderBy="id_admin ";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_admin FROM admin"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_admin FROM admin WHERE admin_name like '%$keyword%' OR admin_email like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_admin FROM admin"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_admin FROM admin WHERE $keyword_by like '%$keyword%'"));
            }
        }
        //Mengatur Halaman
        $JmlHalaman = ceil($jml_data/$batas); 
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="4" class="text-center">
                        <small class="text-danger">Tidak Ada Data Akses Admin Yang Ditampilkan!</small>
                    </td>
                </tr>
            ';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
            if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM admin ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM admin WHERE admin_name like '%$keyword%' OR admin_email like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM admin ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM admin WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_admin       = $data['id_admin'];
                $admin_name     = $data['admin_name'];
                $admin_email    = $data['admin_email'];
                if(empty($data['admin_image'])){
                    $label_foto = '
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalUbahFotoAkses" data-id="'.$id_admin .'">
                            <span class="badge badge-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Click di sini untuk upload foto profil">
                                <i class="bi bi-upload"></i> Upload Foto
                            </span>
                        </a>
                    ';
                }else{
                    $label_foto = '
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetailAkses" data-id="'.$id_admin .'">
                            <span class="badge badge-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Click di sini untuk meliihat foto profil">
                                <i class="bi bi-image"></i> Lihat Foto
                            </span>
                        </a>
                    ';
                }
               
                echo '
                    <tr>
                        <td><small>'.$no.'</small></td>
                        <td>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalEditAkses" data-id="'.$id_admin .'">
                                <small class="underscore_doted" data-bs-toggle="tooltip" data-bs-placement="top" title="Click untuk mengubah nama dan email">'.$admin_name.'</small>
                            </a>
                        </td>
                         <td>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalEditAkses" data-id="'.$id_admin .'">
                                <small class="underscore_doted" data-bs-toggle="tooltip" data-bs-placement="top" title="Click untuk mengubah nama dan email">'.$admin_email.'</small>
                            </a>
                        </td>
                        <td>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalUbahPassword" data-id="'.$id_admin .'">
                                <span class="badge badge-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Click di sini untuk mengubah password">
                                    <i class="bi bi-lock"></i> * * * * *
                                </span>
                            </a>
                        </td>
                        <td>'.$label_foto.'</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-dark btn-floating"  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetailAkses" data-id="'.$id_admin .'">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEditAkses" data-id="'.$id_admin .'">
                                        <i class="bi bi-pencil"></i> Ubah Akses
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahPassword" data-id="'.$id_admin .'">
                                        <i class="bi bi-key"></i> Ubah Password
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalUbahFotoAkses" data-id="'.$id_admin .'">
                                        <i class="bi bi-image"></i> Ubah Foto
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapusAkses" data-id="'.$id_admin .'">
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