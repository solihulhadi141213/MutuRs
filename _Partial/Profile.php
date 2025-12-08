<li class="nav-item dropdown pe-3">
    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <?php
            if($SessionLevel=="Admin"){
                echo '<img src="image_proxy.php?dir=User&filename='.$SessionFoto.'" alt="Profile" class="rounded-circle">';
                echo '<span class="d-none d-md-block dropdown-toggle ps-2 text-white">'.$SessionName.'</span>';
            }else{
                echo '<img src="image_proxy.php?dir=Siswa&filename='.$SessionFoto.'" alt="Profile" class="rounded-circle">';
                echo '<span class="d-none d-md-block dropdown-toggle ps-2 text-white">'.$SessionName.'</span>';
            }
        ?>
    </a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <?php
            echo '
                <li class="dropdown-header">
                    <h6>'.$SessionName.'</h6>
                    <span>'.$SessionLevel.'</span>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="index.php?Page=MyProfile">
                        <i class="bi bi-person"></i>
                        <span>Profil Saya</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalLogout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar</span>
                    </a>
                </li>
            ';
        ?>
    </ul>
</li>