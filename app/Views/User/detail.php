<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <h1><a href="<?= current_url(); ?>" class="text-decoration-none link-dark my-3">Ubah Akses User <?= $user['nama']; ?></a></h1>
    <form action="<?= base_url('user/simpan'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="row">
            <div class="col-12 mt-2">
                <p>Nama : <?= $user['nama']; ?></p>
            </div>
            <div class="col-12">
                <p>Username : <?= $user['username']; ?></p>
            </div>
            <div class="col-12 my-2">
                <label class="form-label">Akses</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="privileges[]" value="absensi" id="flexCheckDefault" <?= in_array("absensi", $privileges) ? "checked" : ''; ?>>
                    <label class="form-check-label">Absensi</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="privileges[]" value="siswa" id="flexCheckDefault" <?= in_array("siswa", $privileges) ? "checked" : ''; ?>>
                    <label class="form-check-label">Siswa</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="privileges[]" value="alat" id="flexCheckDefault" <?= in_array("alat", $privileges) ? "checked" : ''; ?>>
                    <label class="form-check-label">Alat</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="privileges[]" value="user" id="flexCheckDefault" <?= in_array("user", $privileges) ? "checked" : ''; ?>>
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
</script>
<?= $this->endSection(); ?>