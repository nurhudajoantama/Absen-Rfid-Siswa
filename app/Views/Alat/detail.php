<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Tambah Alat</h1>
            <!-- Form -->
            <form action="<?= base_url(); ?>/alat/<?= $detail['id']; ?>" method="post" id="formUbah">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="idAlatLama" value="<?= $detail['id_alat']; ?>">
                <div class="row">
                    <div class="col-md-6 my-3">
                        <label class="form-label">Id Alat</label>
                        <?= (old('idAlat')) ? old('idAlat') : $detail['id_alat']; ?>
                        <input value="<?= (old('idAlat')) ? old('idAlat') : $detail['id_alat']; ?>" type="text" class="form-control <?= ($validation->hasError('idAlat')) ? 'is-invalid' : ''; ?>" placeholder="Id Alat" name="idAlat" autocomplete="off" required>
                        <?php if ($validation->hasError('idAlat')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('idAlat'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 my-3">
                        <label class="form-label">Token</label>
                        <div class="input-group">
                            <input value="<?= (old('token')) ? old('token') : $detail['token']; ?>" type="text" class="form-control <?= ($validation->hasError('token')) ? 'is-invalid' : ''; ?>" placeholder="Token" name="token" id="token" autocomplete="off" required>
                            <button class="btn btn-outline-secondary" type="button" id="random">Random</button>
                            <?php if ($validation->hasError('token')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('token'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 my-3">
                        <label class="form-label">Lokasi</label>
                        <input value="<?= (old('lokasi')) ? old('lokasi') : $detail['lokasi']; ?>" type="text" class="form-control <?= ($validation->hasError('lokasi')) ? 'is-invalid' : ''; ?>" placeholder="Lokasi" name="lokasi" autocomplete="off" required>
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
                            <option value="tidak digunakan" <?= ($detail['status'] == 'tidak digunakan') ? 'selected' : ''; ?>>tidak digunakan</option>
                            <option value="penambahan" <?= ($detail['status'] == 'penambahan') ? 'selected' : ''; ?>>penambahan</option>
                            <option value="digunakan" <?= ($detail['status'] == 'digunakan') ? 'selected' : ''; ?>>digunakan</option>
                        </select>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="d-grid col-md-6 mx-auto my-3" id="ubahData">
                    <button type="submit" class="btn btn-outline-success">Ubah</button>
                </div>
                <div class="col-md-1 my-3">
                    <!-- HAPUS -->
                    <form action="<?= base_url(); ?>/alat/<?= $detail['id']; ?>" method="post" id="hapus">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="delete">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-danger hapusData">
                                <i class="hapusData fas fa-trash"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    warningHapusData(".hapusData", "Menghapus data alat <?= $detail['id_alat']; ?>", "#hapus")
    $(".tombolUbah").click(function(e) {
        e.preventDefault()
        let ubah = this.dataset.ubah
        if (ubah == "idRFID") {
            $("#idAlat").fadeIn()
        } else {
            $(`#${ubah}`)
                .removeAttr("readonly")
                .removeClass("bg-transparent border-0")
                .addClass('bg-light')
                .focus()
                .attr('autocomplete', 'off')
        }
        $("#ubahData").fadeIn()
    })
    warningUbahData("#ubahData", "Mengubah data <?= $detail['id_alat']; ?>", "#formUbah", "<?= base_url('alat'); ?>")
    $('#random').click(function() {
        $("#token").val(getRandomString(8));
    })
</script>
<?= $this->endSection(); ?>