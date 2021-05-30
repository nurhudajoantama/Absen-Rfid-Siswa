<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <h1><a href="<?= current_url(); ?>" class="text-decoration-none link-dark my-3">Pengaturan Akun</a></h1>
    <?php if (session()->getFlashdata('pesan')) : ?>
        <!-- NOTIF -->
        <div class="alert alert-<?= session()->getFlashdata('pesan')['status']; ?> alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('pesan')['pesan']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <form action="<?= base_url('pengaturan-akun/simpan'); ?>" id="formUbahData" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" name="_method" value="patch">
        <input type="hidden" name="id" value="<?= old('id') ? old('id') : $user['id']; ?>">
        <input type="hidden" name="usernameLama" value="<?= old('usernameLama') ? old('usernameLama') : $user['username']; ?>">
        <div class="row">
            <div class="col-12 my-2">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" placeholder="Nama" name="nama" value="<?= old('nama') ? old('nama') : $user['nama']; ?>" autocomplete="off" required>
                <?php if ($validation->hasError('nama')) : ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-12 my-2">
                <label class="form-label">Username</label>
                <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" placeholder="Username" name="username" value="<?= old('username') ? old('username') : $user['username']; ?>" autocomplete="off" required>
                <?php if ($validation->hasError('username')) : ?>
                    <div class="invalid-feedback">
                        <?= $validation->getError('username'); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-12 my-2 d-grid">
                <button type="submit" id="btnUbahData" class="btn btn-outline-success">Ubah</button>
            </div>
        </div>
    </form>
    <form action="<?= base_url('pengaturan-akun/ubah-password'); ?>" id="formUbahPassword" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" name="_method" value="patch">
        <input type="hidden" name="id" value="<?= old('id') ? old('id') : $user['id']; ?>">
        <div class="mt-5">
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Ubah Password
            </button>
            <div class="collapse mt-1" id="collapseExample">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Password lama</label>
                            <div class="input-group">
                                <input id="passwordLama" type="password" class="form-control <?= ($validation->hasError('passwordLama')) ? 'is-invalid' : ''; ?>" placeholder="Password lama" name="passwordLama" autocomplete="off" required>
                                <button type="button" class="btn btn-outline-dark" id="showPassLama"><i class="far fa-eye" id="oEyeLama"></i> <i class="far fa-eye-slash" style="display: none;" id="cEyeLama"></i></button>
                                <?php if ($validation->hasError('passwordLama')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('passwordLama') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="form-label">Password Baru</label>
                            <div class="input-group">
                                <input id="passwordBaru" type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" placeholder="Password baru" name="password" autocomplete="off" required>
                                <button type="button" class="btn btn-outline-dark" id="showPassBaru"><i class="far fa-eye" id="oEyeBaru"></i> <i class="far fa-eye-slash" style="display: none;" id="cEyeBaru"></i></button>
                                <?php if ($validation->hasError('password')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 my-3 d-grid">
                            <button type="submit" id="btnUbahPassword" class="btn btn-outline-success">Ubah Password</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    $("#showPassLama").click(function() {
        if ($("#passwordLama").attr("type") == "password") {
            $("#passwordLama").attr("type", "text")
            $("#oEyeLama").hide()
            $("#cEyeLama").show()
        } else {
            $("#passwordLama").attr("type", "password")
            $("#oEyeLama").show()
            $("#cEyeLama").hide()
        }
    })
    $("#showPassBaru").click(function() {
        if ($("#passwordBaru").attr("type") == "password") {
            $("#passwordBaru").attr("type", "text")
            $("#oEyeBaru").hide()
            $("#cEyeBaru").show()
        } else {
            $("#passwordBaru").attr("type", "password")
            $("#oEyeBaru").show()
            $("#cEyeBaru").hide()
        }
    })
    warningUbahData("#btnUbahData", "Mengubah data <?= $user['nama']; ?>", "#formUbahData", "<?= base_url(); ?>")
    warningUbahData("#btnUbahPassword", "Mengubah password <?= $user['nama']; ?>", "#formUbahPassword", "<?= base_url(); ?>")
</script>
<?= $this->endSection(); ?>