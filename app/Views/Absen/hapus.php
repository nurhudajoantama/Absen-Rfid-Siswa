<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1><a href="<?= current_url(); ?>" class="text-decoration-none link-dark">Hapus Data Absensi</a></h1>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <div class="border border-warning m-1 p-2">
                Hapus data absen jika sudah terBackup atau tidak dibutuhkan lagi
                <div class="text-danger">Hati-hati dalam melakukan penghapusan data yang dihapus tidak dapat dikembalikan</div>
            </div>
        </div>
    </div>
    <form action="" method="get" id="form-search">
        <div class="row my-2">
            <input type="hidden" name="tanggal-dari" id="tanggalDari" value="<?= $tanggalDari; ?>">
            <input type="hidden" name="tanggal-sampai" id="tanggalSampai" value="<?= $tanggalSampai; ?>">

            <div class="col-md-5 my-1">
                <label class="form-label">No Induk / Nama</label>
                <input type="text" class="form-control" id="search" name="search" value="<?= $search; ?>" id="" autocomplete="off" placeholder="No Induk / Nama">
            </div>
            <div class="col-md-2 my-1">
                <label class="form-label">kelas</label>
                <input type="text" class="form-control" id="kelas" name="kelas" value="<?= $kelas; ?>" id="" autocomplete="off" placeholder="Kelas">
            </div>
            <div class="col-md-4 my-1">
                <label class="form-label">Tanggal</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="far fa-calendar"></i></span>
                    <input type="text" class="form-control" id="daterangepicker" value="<?= $tanggal; ?>" />
                </div>
            </div>
            <div class="col-md-1 my-1 d-flex">
                <button type="submit" id="search-submit" class="btn btn-primary align-self-end">Filter</button>
            </div>
        </div>
    </form>
    <?php if ($absen) : ?>
        <div class="row">
            <p>Terdapat <?= $banyakHasil; ?> Hasil</p>
            <?php foreach ($absen as $a) : ?>
                <div class="col-md-3 border m-2"><?= $a['nama']; ?> <br> <?= $a['kelas']; ?> | <?= $a['date']; ?> </div>
            <?php endforeach; ?>
        </div>
        <form action="<?= base_url('absen/hapus'); ?>" method="post" id="form-hapus-data">
            <input type="hidden" name="_method" value="delete">
            <?= csrf_field(); ?>
            <input type="hidden" name="tanggal-dari" value="<?= $tanggalDari; ?>">
            <input type="hidden" name="tanggal-sampai" value="<?= $tanggalSampai; ?>">
            <input type="hidden" name="search" value="<?= $search; ?>">
            <input type="hidden" name="kelas" value="<?= $kelas; ?>">
            <div class="row my-3">
                <div class="col d-grid">
                    <button type="submit" id="hapus-data" class="btn btn-danger">HAPUS DATA DIATAS</button>
                </div>
            </div>
        </form>

    <?php endif; ?>
    <hr class="mt-5" />
    <form action="<?= base_url('absen/truncate'); ?>" method="post" id="form-truncate">
        <input type="hidden" name="_method" value="delete">
        <?= csrf_field(); ?>
        <div class="row my-2">
            <div class="col">
                <div class="input-group d-flex justify-content-end">
                    <button type="button" id="info-truncate" class="input-group-text btn btn-danger border-0"><i class="fas fa-info text-white"></i></button>
                    <button type="submit" id="button-truncate" class="btn btn-danger">HAPUS SEMUA DATA</button>
                </div>
            </div>
        </div>
    </form>
</div>



<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $("#search-submit").click(function(e) {
        e.preventDefault();
        if (!($("#search").val())) {
            $("#search").removeAttr("name")
        }
        if (!($("#tanggalDari").val() || $("#tanggalSampai").val())) {
            $("#tanggalDari").removeAttr("name")
            $("#tanggalSampai").removeAttr("name")
        }
        if (!($("#kelas").val())) {
            $("#kelas").removeAttr("name")
        }
        $("#form-search").submit()
    })
    $("#info-truncate").click(function() {
        Swal.fire(
            'HAPUS SEMUA DATA',
            'Ini akan menghapus semua data absensi dan memulainya kembali dari awal <br> Jika hanya ingin menghapus beberapa data filter dahulu data',
            'info'
        )
    })
    dateRange("#daterangepicker", "#tanggalDari", "#tanggalSampai")
    warningHapusData("#button-truncate", "Semua data akan dihapus", "#form-truncate")
    warningHapusData("#hapus-data", "Beberapa data akan dihapus", "#form-hapus-data")
</script>
<?= $this->endSection(); ?>