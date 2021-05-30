<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <h1 class="mt-4 mb-3"><a href="<?= current_url(); ?>" class="text-decoration-none link-dark">Data User</a></h1>
    <?php if (session()->getFlashdata('pesan')) : ?>
        <!-- NOTIF -->
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data <span class="alert-link"><?= session()->getFlashdata('pesan')['data']; ?></span>. <?= session()->getFlashdata('pesan')['pesan']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col d-flex justify-content-end">
            <div class="align-self-end">
                <a href="<?= base_url('user/tambah'); ?>" class="btn btn-outline-success">Tambah</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Username</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                    foreach ($tableUser as $table) :
                    ?>
                        <tr>
                            <th scope="row"><?= $no; ?></th>
                            <td><?= $table['username']; ?></td>
                            <td><?= $table['nama']; ?></td>
                            <td><?php if ($table['id'] != "1") : ?>
                                    <button type="button" class="btn btn-success privilegesBtn" data-bs-toggle="modal" data-bs-target="#privilegesModal" data-id="<?= $table['id']; ?>">
                                        <i class="fs-6 fa fa-pen"></i>
                                    </button>
                                <?php endif; ?>
                            </td>

                        </tr>

                    <?php $no++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $pager->links('user', 'pagination_absen') ?>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="privilegesModal" tabindex="-1" aria-labelledby="privilegesTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="text-center m-5" id="loadPrivileges">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title" id="privilegesTitle">Ubah Akses User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="bodyPrivilegesModal">
                    <div class="modal-body">
                        <form class="formPrivileges" id="formUbah" action="" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="patch">
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <p>Nama : <span id="privilegesNama"></span></p>
                                </div>
                                <div class="col-12">
                                    <p>Username : <span id="privilegesUsername"></span></p>
                                </div>
                                <div class="col-12 my-2">
                                    <label class="form-label">Akses</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="privileges[]" value="absensi" id="privilegesAbsensi">
                                        <label class="form-check-label">Absensi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="privileges[]" value="siswa" id="privilegesSiswa">
                                        <label class="form-check-label">Siswa</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="privileges[]" value="alat" id="privilegesAlat">
                                        <label class="form-check-label">Alat</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="privileges[]" value="user" id="privilegesUser">
                                        <label class="form-check-label">User</label>
                                    </div>
                                </div>
                                <div class="col-12 mt-5 d-grid">
                                    <button type="submit" class="btn btn-outline-success" id="ubahBtn">Ubah</button>
                                </div>
                            </div>
                        </form>

                        <div class="mt-2">
                            <form class="formPrivileges" id="formHapus" action="" method="post">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="delete">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-outline-danger" id="hapusBtn">
                                        <i class="hapusData fas fa-trash"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
    var baseUrl = "<?= base_url(); ?>"
    $(".privilegesBtn").click(function() {
        $("#loadPrivileges").show()
        $("#bodyPrivilegesModal").hide()
        $("#privilegesAbsensi").removeAttr("checked")
        $("#privilegesSiswa").removeAttr("checked")
        $("#privilegesAlat").removeAttr("checked")
        $("#privilegesUser").removeAttr("checked")
        $.ajax({
            url: baseUrl + '/api/get-privileges',
            method: 'get',
            data: {
                'id': this.dataset.id,
            },
        }).done(function(data) {
            let privileges = data.data.privileges
            var nama = data.data.nama
            $('#privilegesNama').html(data.data.nama)
            $('#privilegesUsername').html(data.data.username)
            $('.formPrivileges').attr("action", baseUrl + '/user/' + data.data.id)
            if (privileges.includes("absensi")) {
                $("#privilegesAbsensi").attr("checked", true)
            }
            if (privileges.includes("siswa")) {
                $("#privilegesSiswa").attr("checked", true)
            }
            if (privileges.includes("alat")) {
                $("#privilegesAlat").attr("checked", true)
            }
            if (privileges.includes("user")) {
                $("#privilegesUser").attr("checked", true)
            }
            $("#loadPrivileges").hide()
            $("#bodyPrivilegesModal").show()
        }).fail(function(data) {
            window.location.reload()
        })
    })
    warningHapusData("#hapusBtn", "Menghapus user", "#formHapus")
    warningUbahData("#ubahBtn", "Mengubah data", "#formUbah", "<?= base_url('/user'); ?>")
</script>
<?= $this->endSection(); ?>