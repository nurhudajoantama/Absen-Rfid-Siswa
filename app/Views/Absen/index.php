<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>

<div class="container-fluid">
    <h1 class="mt-4 mb-3"><a href="<?= current_url(); ?>" class="text-decoration-none link-dark">Absensi</a></h1>
    <?php if (session()->getFlashdata('pesan')) : ?>
        <!-- NOTIF -->
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-link"><?= session()->getFlashdata('pesan')['data']; ?></span> Data. <?= session()->getFlashdata('pesan')['pesan']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="" method="get" id="form-search">
        <input type="hidden" name="tanggal-dari" id="tanggalDari" value="<?= $tanggalDari; ?>">
        <input type="hidden" name="tanggal-sampai" id="tanggalSampai" value="<?= $tanggalSampai; ?>">
        <div class="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-body" type="button" data-bs-toggle="collapse" data-bs-target="#filterPanel">
                        <span class="fw-bold">Filter</span>
                    </button>
                </h2>
                <div class="accordion-collapse collapse show" id="filterPanel">
                    <div class="accordion-body">

                        <div class="row my-2">
                            <div class="col-md-4 my-1">
                                <label class="form-label">No Induk / Nama</label>
                                <input type="text" class="form-control" id="search" name="search" value="<?= $search; ?>" id="" autocomplete="off" placeholder="No Induk / Nama">
                            </div>
                            <div class="col-md-2 my-1">
                                <label class="form-label">kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" value="<?= $kelas; ?>" id="" autocomplete="off" placeholder="Kelas">
                            </div>
                            <div class="col-md-3 my-1">
                                <label class="form-label">Tanggal</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="far fa-calendar"></i></span>
                                    <input type="text" class="form-control" id="daterangepicker" value="<?= $tanggal; ?>" />
                                </div>
                            </div>
                            <div class="col-md-2 my-1">
                                <label class="form-label">Id Alat</label>
                                <select class="form-select" id="idAlat">
                                    <option selected disabled>Id Alat</option>
                                    <?php foreach ($dataAlat as $alat) : ?>
                                        <option class="option-alat" value="<?= $alat['id_alat']; ?>"><?= $alat['id_alat']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1 my-1 d-flex">
                                <button type="submit" id="search-submit" class="btn btn-primary align-self-end">Filter</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- TABLE -->
    <div class="row mt-3">
        <div class="col">
            <p>Terdapat <?= $banyakHasil; ?> Hasil</p>
            <div class="table-responsive-md">
                <table class="table table-borderless table-hover mt-3">
                    <caption class="text-right" style="text-align: right;">Data Siswa</caption>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">No Induk</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Waktu</th>
                            <th scope="col">Id Alat</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        foreach ($absenTables as $table) :
                            $date = CodeIgniter\I18n\Time::Parse($table['date'], 'Asia/Jakarta', 'id')->toLocalizedString('d MMM yyyy');
                        ?>
                            <tr class="data-table">
                                <th class="align-middle" scope="row"><?= $no; ?></th>
                                <td class="align-middle"><?= $table['no_induk']; ?></td>
                                <td class="align-middle"><a href="<?= base_url() . '/siswa/' . $table['id_siswa']; ?>" class=" link-dark"><?= $table['nama']; ?></a></td>
                                <td class=" align-middle"><?= $table['kelas']; ?></td>
                                <td class="align-middle"><?= $date; ?></td>
                                <td class="align-middle"><?= $table['time']; ?></td>
                                <td class="align-middle"><a href="<?= base_url() . '/alat/' . $table['id_alat']; ?>" class=" link-dark"><?= $table['id_alat']; ?></a></td>
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
            <?= $pager->links('absen', 'pagination_absen') ?>
        </div>
    </div>
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
    dateRange("#daterangepicker", "#tanggalDari", "#tanggalSampai")
</script>
<?= $this->endSection(); ?>