<!-- isikan semua url dengan base url -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= $judul; ?></title>

    <link rel="shortcut icon" href="<?= base_url('img/icon.png'); ?>" type="image/x-icon">

    <!-- Simple Sidebar and Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('css/simplesidebar.css'); ?>">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- daterangepicker CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('css/style.css'); ?>">

</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <?php
        $privileges = session()->get('privileges') ? session()->get('privileges') : [];
        ?>
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Absensi</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('/')) ? 'active' : ''; ?>" href="<?= base_url(); ?>">Dashboard</a>
                <?php if (in_array('absensi', $privileges)) : ?>
                    <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('absen*')) ? 'active' : ''; ?>" data-bs-toggle="collapse" href="#collapseAbsensi" role="button">Absensi</a>
                    <div class="collapse ms-2" id="collapseAbsensi">
                        <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('absen')) ? 'active' : ''; ?>" href="<?= base_url('absen'); ?>">Data Absensi</a>
                        <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('absen/export-excel')) ? 'active' : ''; ?>" href="<?= base_url('absen/export-excel'); ?>">Export Excel</a>
                        <a class="list-group-item list-group-item-action list-group-item-danger p-3 <?= (url_is('absen/hapus')) ? 'active' : ''; ?>" href="<?= base_url('absen/hapus'); ?>">Hapus Data Absensi</a>
                    </div>
                <?php endif; ?>
                <?php if (in_array('siswa', $privileges)) : ?>
                    <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('siswa*')) ? 'active' : ''; ?>" data-bs-toggle="collapse" href="#collapseSiswa" role="button">Siswa</a>
                    <div class="collapse ms-2" id="collapseSiswa">
                        <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('siswa')) ? 'active' : ''; ?>" href="<?= base_url('siswa'); ?>">Daftar Siswa</a>
                        <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('siswa/tambah')) ? 'active' : ''; ?>" href="<?= base_url('siswa/tambah'); ?>">Tambah Siswa</a>
                    </div>
                <?php endif; ?>
                <?php if (in_array('alat', $privileges)) : ?>
                    <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('alat*')) ? 'active' : ''; ?>" data-bs-toggle="collapse" href="#collapseAlat" role="button">Alat</a>
                    <div class="collapse ms-2" id="collapseAlat">
                        <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('alat')) ? 'active' : ''; ?>" href="<?= base_url('alat'); ?>">Daftar Alat</a>
                        <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('alat/tambah')) ? 'active' : ''; ?>" href="<?= base_url('alat/tambah'); ?>">Tambah Alat</a>
                    </div>
                <?php endif; ?>
                <?php if (in_array('user', $privileges)) : ?>
                    <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('user*')) ? 'active' : ''; ?>" data-bs-toggle="collapse" href="#collapseUser" role="button">User</a>
                    <div class="collapse ms-2" id="collapseUser">
                        <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('user')) ? 'active' : ''; ?>" href="<?= base_url('user'); ?>">Daftar User</a>
                        <a class="list-group-item list-group-item-action list-group-item-primary p-3 <?= (url_is('user/tambah')) ? 'active' : ''; ?>" href="<?= base_url('user/tambah'); ?>">Tambah User</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-light bg-light" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 me-5 mt-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= session()->get('username') ? session()->get('username') : 'belom'; ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li><a class="dropdown-item" href="<?= base_url('pengaturan-akun'); ?>">Pengaturan</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('logout'); ?>">Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <div class="px-5 py-3">
                <?= $this->renderSection('content'); ?>
            </div>
        </div>
    </div>


    <!-- Jquery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="<?= base_url('js/bootstrap.js'); ?>"></script>

    <!-- SweetAlert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- moment -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- daterangepicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Simple sidebar -->
    <script src="<?= base_url('js/simplesidebar.js'); ?>"></script>

    <!-- Custom JS -->
    <script src="<?= base_url('js/script.js'); ?>"></script>

    <!-- Script Halaman -->
    <?= $this->renderSection('script'); ?>


</body>

</html>