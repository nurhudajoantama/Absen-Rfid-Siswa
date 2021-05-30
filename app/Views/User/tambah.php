<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <h1><a href="<?= current_url(); ?>" class="text-decoration-none link-dark my-3">Tambah User</a></h1>
    <form action="<?= base_url('user/simpan'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="row">
            <div class="col-12 my-2">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" placeholder="Nama" name="nama" value="<?= old('nama'); ?>" autocomplete="off" required>
                <?php if ($validation->hasError('nama')) : ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-12 my-2">
                <label class="form-label">Username</label>
                <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" placeholder="Username" name="username" value="<?= old('username'); ?>" autocomplete="off" required>
                <?php if ($validation->hasError('username')) : ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('username'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-12 my-2">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input id="password" type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" placeholder="Password" name="password" autocomplete="off" required>
                    <button type="button" class="btn btn-outline-dark" id="showPass"><i class="far fa-eye" id="oEye"></i> <i class="far fa-eye-slash" style="display: none;" id="cEye"></i></button>
                    <?php if ($validation->hasError('password')) : ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('password'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12 my-2">
                <label class="form-label">Akses</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="privileges[]" value="absensi" id="flexCheckDefault">
                    <label class="form-check-label">Absensi</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="privileges[]" value="siswa" id="flexCheckDefault">
                    <label class="form-check-label">Siswa</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="privileges[]" value="alat" id="flexCheckDefault">
                    <label class="form-check-label">Alat</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="privileges[]" value="user" id="flexCheckDefault">
                    <label class="form-check-label">User</label>
                </div>
            </div>
            <div class="col-12 mt-5 d-grid">
                <button type="submit" class="btn btn-outline-success">Tambah</button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $("#showPass").click(function() {
        if ($("#password").attr("type") == "password") {
            $("#password").attr("type", "text")
            $("#oEye").hide()
            $("#cEye").show()
        } else {
            $("#password").attr("type", "password")
            $("#oEye").show()
            $("#cEye").hide()
        }
    })
</script>
<?= $this->endSection(); ?>