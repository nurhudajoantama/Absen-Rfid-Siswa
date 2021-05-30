<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Tambah Alat</h1>
            <!-- Form -->
            <form action="<?= base_url('alat/simpan'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6 my-3">
                        <label class="form-label">Id Alat</label>
                        <input type="text" class="form-control <?= ($validation->hasError('idAlat')) ? 'is-invalid' : ''; ?>" placeholder="Id Alat" name="idAlat" autocomplete="off" value="<?= old('idAlat'); ?>" required>
                        <?php if ($validation->hasError('idAlat')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('idAlat'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 my-3">
                        <label class="form-label">Token</label>
                        <div class="input-group">
                            <input type="text" class="form-control <?= ($validation->hasError('token')) ? 'is-invalid' : ''; ?>" value="<?= old('token'); ?>" placeholder="Token" name="token" autocomplete="off" id="token" aria-describedby="tokenHelp" required>
                            <button class="btn btn-outline-secondary" type="button" id="random">Random</button>
                            <?php if ($validation->hasError('token')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('token'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-auto">
                            <span id="tokenHelp" class="form-text">
                                8 Karakter dengan huruf dan angka
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 my-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" value="<?= old('lokasi'); ?>" class="form-control <?= ($validation->hasError('lokasi')) ? 'is-invalid' : ''; ?>" placeholder="Lokasi" name="lokasi" autocomplete="off" required>
                        <?php if ($validation->hasError('lokasi')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('lokasi'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 my-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option disabled>Status</option>
                            <option value="tidak digunakan" selected>tidak digunakan</option>
                            <option value="penambahan">penambahan</option>
                            <option value="digunakan">digunakan</option>
                        </select>
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
    $(document).ready(function() {
        $('#random').click(function() {
            $("#token").val(getRandomString(8));
        })
    })
</script>
<?= $this->endSection(); ?>