<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">

    <h1 class="mt-3"><a href="<?= current_url(); ?>" class="text-decoration-none link-dark">Alat RFID</a></h1>
    <?php if (session()->getFlashdata('pesan')) : ?>
        <!-- NOTIF -->
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Alat id <span class="alert-link"><?= session()->getFlashdata('pesan')['data']; ?></span>. <?= session()->getFlashdata('pesan')['pesan']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row mt-3">
        <h5>Filter</h5>
        <div class="col-lg-10">
            <form action="" method="get" id="form-search">
                <div class="row">
                    <div class="col-md-5">
                        <label class="form-label">Id Alat / Lokasi</label>
                        <input type="text" class="form-control" id="search" name="search" value="<?= $search; ?>" placeholder="Id Alat / Lokasi" autocomplete="off" />
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="">All</option>
                            <option class="bg-success text-white" value="digunakan" <?= ($status == 'digunakan') ? 'selected' : ''; ?>>Digunakan</option>
                            <option class="bg-primary text white" value="penambahan" <?= ($status == 'penambahan') ? 'selected' : ''; ?>>Penambahan</option>
                            <option class="bg-danger text-white" value="tidak digunakan" <?= ($status == 'tidak digunakan') ? 'selected' : ''; ?>>Tidak digunakan</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex">
                        <button type="submit" id="search-submit" class="btn btn-primary align-self-end">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-2 d-flex justify-content-end">
            <div class="align-self-end">
                <a href="alat/tambah" class="btn btn-outline-success">Tambah</a>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md">
            <div class="table-responsive-md">
                <table class="table table-borderless table-hover mt-3">
                    <caption class="text-right" style="text-align: right;">Data alat</caption>
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Id Alat</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $no = 1;
                        foreach ($alatTables as $table) :
                        ?>
                            <tr class="data-table">
                                <th class="align-middle" scope="row"><?= $no; ?></th>
                                <td class="align-middle"><?= $table['id_alat']; ?></td>
                                <td class="align-middle"><?= $table['lokasi']; ?></td>
                                <td class="align-middle">
                                    <form action="alat/ubah-status/<?= $table['id']; ?>" method="post" id="ubah-status-<?= $table['id']; ?>">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="patch">

                                        <div class="btn-group">
                                            <input type="radio" class="btn-check" name="status" value="digunakan" id="digunakan-<?= $table['id']; ?>"" <?= ($table['status'] == 'digunakan') ? 'checked' : ''; ?>>
                                            <label class=" btn btn-outline-success status-btn" for="digunakan-<?= $table['id']; ?>" data-id="<?= $table['id']; ?>">Digunakan</label>

                                            <input type="radio" class="btn-check" name="status" value="penambahan" id="penambahan-<?= $table['id']; ?>" <?= ($table['status'] == 'penambahan') ? 'checked' : ''; ?>>
                                            <label class="btn btn-outline-primary status-btn" for="penambahan-<?= $table['id']; ?>" data-id="<?= $table['id']; ?>">Penambahan</label>

                                            <input type="radio" class="btn-check" name="status" value="tidak digunakan" id="tdigunakan-<?= $table['id']; ?>" <?= ($table['status'] == 'tidak digunakan') ? 'checked' : ''; ?>>
                                            <label class="btn btn-outline-danger status-btn" for="tdigunakan-<?= $table['id']; ?>" data-id="<?= $table['id']; ?>">Tidak Digunakan</label>
                                        </div>

                                    </form>
                                </td>
                                <td class="align-middle p-1">
                                    <div class="col-md-12">
                                        <a href="alat/<?= $table['id']; ?>" class="d-grid hvr-white btn btn-outline-info btn-sm m-1"><i class="fas fa-pen mx-auto"></i></a>
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
            <?= $pager->links('alat', 'pagination_absen') ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $('.status-btn').click(function() {
        let id = this.dataset.id
        setTimeout(function() {
            $(`#ubah-status-${id}`).submit()
        }, 1)
    })
    $("#search-submit").click(function(e) {
        e.preventDefault();
        if (!($("#search").val())) {
            $("#search").removeAttr("name")
        }
        if (!($("#status").val())) {
            $("#status").removeAttr("name")
        }
        $("#form-search").submit()
    })
</script>
<?= $this->endSection(); ?>