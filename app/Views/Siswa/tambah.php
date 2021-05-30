<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Tambah Data</h1>
            <!-- Form -->
            <form action="<?= base_url('siswa/simpan'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-md-2">
                        <select class="form-select my-3 option-alat" aria-label="Default select example" id="idAlat">
                            <option selected disabled>Id Alat</option>
                            <?php foreach ($dataAlat as $alat) : ?>
                                <option class="option-alat" value="<?= $alat['id_alat']; ?>"><?= $alat['id_alat']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-10">
                        <div class="input-group mt-3">
                            <input class="form-control <?= ($validation->hasError('rfid')) ? 'is-invalid' : ''; ?>" type="text" placeholder="RFID Card" name="rfid" id="rfid" readonly required>
                            <button class="btn btn-outline-secondary" type="button" disabled>
                                <span class="spinner-border spinner-border-sm text-danger" id="loadGetRfid" role="status" aria-hidden="true"></span>
                                <span class="visually-hidden">Loading...</span>
                                <i class="fas fa-check text-success" id="successGetRfid" style="display: none;"></i>
                            </button>
                            <div class="input-group-text" id="time-rfid">Waktu Penambahan RFID</div>
                            <?php if ($validation->hasError('rfid')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('rfid'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <hr class="mt-3 mb-1">
                <div class="row">
                    <div class="col-md-6 my-3">
                        <label class="form-label">No Induk</label>
                        <input type="text" class="form-control <?= ($validation->hasError('noInduk')) ? 'is-invalid' : ''; ?>" placeholder="No Induk" name="noInduk" autocomplete="off" value="<?= old('noInduk'); ?>" required>
                        <?php if ($validation->hasError('noInduk')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('noInduk'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 my-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" placeholder="Nama" name="nama" value="<?= old('nama'); ?>" autocomplete="off" required>
                        <?php if ($validation->hasError('nama')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6 my-3">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control <?= ($validation->hasError('kelas')) ? 'is-invalid' : ''; ?>" placeholder="Kelas" name="kelas" autocomplete="off" value="<?= old('kelas'); ?>" required>
                            <?php if ($validation->hasError('kelas')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kelas'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-grid col-md-6 mx-auto my-3">
                            <button type="submit" class="btn btn-outline-success">Tambah</button>
                        </div>
                    </div>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    var urlRfidSiswa = "<?= base_url('api/rfid-baru'); ?>"
    $(document).ready(loopAjaxRfid())
</script>
<?= $this->endSection(); ?>