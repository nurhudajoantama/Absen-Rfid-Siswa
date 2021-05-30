<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<div class="container-fluid">

    <h1 class="mt-4 mb-3"><a href="<?= current_url(); ?>" class="text-decoration-none link-dark">Siswa</a></h1>
    <?php if (session()->getFlashdata('pesan')) : ?>
        <!-- NOTIF -->
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data <span class="alert-link"><?= session()->getFlashdata('pesan')['data']; ?></span>. <?= session()->getFlashdata('pesan')['pesan']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- DATA -->
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card border-success mb-3" style="max-width: 18rem;">
                <div class="card-header">Jumlah Siswa</div>
                <div class="card-body">
                    <h5 class="card-title fs-1 d-inline-block"><?= $jumlahSiswa; ?></h5>
                    <span>Siswa</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <form action="" method="get" id="form-search">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">No Induk / Nama</label>
                        <input type="text" class="form-control" id="search" name="search" value="<?= $search; ?>" placeholder="No Induk / Nama" autocomplete="off" />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" value="<?= $kelas; ?>" placeholder="Kelas" autocomplete="off" />
                    </div>
                    <div class="col-md-2 d-flex">
                        <button type="submit" id="search-submit" class="btn btn-primary align-self-end">Cari</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-2 d-flex justify-content-end">
            <div class="align-self-end">
                <a href="siswa/tambah" class="btn btn-outline-success">Tambah</a>
            </div>
        </div>
    </div>
    <!-- TABLE -->
    <div class="row mt-3">
        <div class="col-md">
            <div class="table-responsive-md">
                <table class="table table-borderless table-hover mt-3">
                    <caption class="text-right" style="text-align: right;">Data Siswa</caption>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">No Induk</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        $class = '';
                        foreach ($SiswaTables as $table) :
                        ?>
                            <tr class="data-table">
                                <th class="align-middle" scope="row"><?= $no; ?></th>
                                <td class="align-middle"><?= $table['no_induk']; ?></td>
                                <td class="align-middle"><?= $table['nama']; ?></td>
                                <td class="align-middle"><?= $table['kelas']; ?></td>
                                <td class="align-middle p-1">
                                    <div class="col-md-6">
                                        <a href="siswa/<?= $table['id']; ?>" class="d-grid btn btn-outline-info btn-sm m-1 hvr-white"><em class="fas fa-info-circle mx-auto"></em></a>
                                    </div>
                                </td>
                            </tr>

                        <?php $no++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $pager->links('siswa', 'pagination_absen') ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $(document).ready(function() {
        $("#search-submit").click(function(e) {
            e.preventDefault();
            if (!($("#search").val())) {
                $("#search").removeAttr("name")
            }
            if (!($("#kelas").val())) {
                $("#kelas").removeAttr("name")
            }
            $("#form-search").submit()
        })
    })
</script>
<?= $this->endSection(); ?>