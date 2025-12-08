<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    //Zona Waktu
    date_default_timezone_set("Asia/Jakarta");

    //Session Akses
    if(empty($SessionIdAccess)){
        echo '
            <tr>
                <td colspan="6" class="text-center">
                    <small class="text-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }

    //Hitung Jumlah Data
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kelas FROM kelas"));

    //Jika Tidak Ada Data Kelas
    if(empty($jml_data)){
        echo '
            <tr>
                <td colspan="6" class="text-center">
                    <small class="text-danger">Tidak ada data <b>Kelas</b> yang ditemukan</small>
                </td>
            </tr>
        ';
        exit;
    }

    //Tampilkan Data Level
    $no_level=1;
    $jumlah_level=0;
    $query_level = mysqli_query($Conn, "SELECT DISTINCT jenjang FROM kelas ORDER BY jenjang ASC");
    while ($data_level = mysqli_fetch_array($query_level)) {
        $class_level = $data_level['jenjang'];

        //Hitung Jumlah Level
        $jumlah_level=$jumlah_level+1;
        echo '
            <tr>
                <td align="left" class="bg bg-body-secondary"><b>'.$no_level.'</b></td>
                <td colspan="4" class="bg bg-body-secondary"><b>'.$class_level.'</b></td>
                <td class="bg bg-body-secondary" align="right">
                    <button type="button" class="btn btn-sm btn-primary btn-floating" data-bs-toggle="modal" data-bs-target="#ModalTambah" data-id="'.$class_level.'" title="Tambah Rombel Kelas">
                        <i class="bi bi-plus"></i>
                    </button>
                </td>
            </tr>
        ';
        //Menampilkan List Kelas
        $no_kelas=1;
        $query_kelas = mysqli_query($Conn, "SELECT id_kelas, kelas FROM kelas WHERE jenjang='$class_level' ORDER BY kelas ASC");
        while ($data_kelas = mysqli_fetch_array($query_kelas)) {
            $id_kelas   = $data_kelas['id_kelas'];
            $kelas = $data_kelas['kelas'];

            //Hitung Jumlah Siswa Pada Tabel 'siswa'
            $jumlah_siswa=mysqli_num_rows(mysqli_query($Conn, "SELECT id_siswa FROM siswa WHERE id_kelas='$id_kelas'"));

            //Hitung permintaan Pada Tabel 'permintaan'
            $jumlah_permintaan=mysqli_num_rows(mysqli_query($Conn, "SELECT id_permintaan FROM permintaan WHERE id_kelas='$id_kelas'"));

            
            echo '
            <tr>
                <td align="left"></td>
                <td>
                    <small class="text text-grayish">
                        '.$no_level.'.'.$no_kelas.'
                    </small>
                </td>
                <td>
                    <small class="text text-grayish">'.$kelas.'</small>
                </td>
                <td>
                    <small class="text text-grayish">'.$jumlah_siswa.' Orang</small>
                </td>
                <td>
                    <small class="text text-grayish">'.$jumlah_permintaan.' Permintaan</small>
                </td>
                <td align="right">
                    <button type="button" class="btn btn-sm btn-outline-dark btn-floating"  data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow bg-body-secondary" style="">
                        <li class="dropdown-header text-center">
                            <h6>Option</h6>
                        </li>
                        <li><hr class="dropdown-divider border-1 border-bottom"></li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEdit" data-id="'.$id_kelas .'">
                                <i class="bi bi-pencil"></i> Edit Kelas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="'.$id_kelas .'">
                                <i class="bi bi-x"></i> Hapus Kelas
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        ';
        }

        $no_level++;
    }
?>

<script>
    //Creat Javascript Variabel
    var jml_data=<?php echo $jml_data; ?>;
    var jumlah_level=<?php echo $jumlah_level; ?>;
    
    //Put Into Pagging Element
    $('#put_jumlah_data').html(' '+jumlah_level+' / '+jml_data+'');

    
    
</script>