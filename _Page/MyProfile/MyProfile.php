<div class="pagetitle">
    <h1>
        <a href="">
            <i class="bi bi-person-circle"></i> Profil Saya</a>
        </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active"> Profil Saya</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row mb-3">
        <div class="col-md-12">
            <?php
                echo '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <small>
                            Berikut ini adalah halaman profil yang digunakan untuk mengelola informasi akses anda. 
                        </small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                ';
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
                if($SessionLevel=="Admin"){
                    include "_Page/MyProfile/ProfileAdmin.php";
                }else{
                    include "_Page/MyProfile/ProfilSiswa.php";
                }
            ?>
        </div>
    </div>
</section>
