<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-12 align-middle p-3 ">
            <form action="<?= base_url(); ?>/siswa/<?= $detail['id']; ?>" method="POST" id="formUbah">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="rfidLama" value="<?= $detail['rfid']; ?>">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Nomor Induk</h5>
                        <button class="tombolUbahSiswa border-0 bg-transparent" data-ubah="noInduk">
                            <i class="fas fa-pen align-middle text-dark"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <input name="noInduk" class="form-control bg-transparent border-0 <?= ($validation->hasError('noInduk')) ? 'is-invalid' : ''; ?>" id="noInduk" type="text" placeholder="No Induk" value="<?= (old('noInduk')) ? old('noInduk') : $detail['no_induk']; ?>" autocomplete="off" readonly required>
                        <?php if ($validation->hasError('noInduk')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('noInduk'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Nama</h5>
                        <button class="tombolUbahSiswa border-0 bg-transparent" data-ubah="nama">
                            <i class="fas fa-pen align-middle text-dark"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <input name="nama" class="form-control bg-transparent border-0 <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" type="text" placeholder="Nama" value="<?= (old('nama')) ? old('nama') : $detail['nama']; ?>" autocomplete="off" readonly required>
                        <?php if ($validation->hasError('nama')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Kelas</h5>
                        <button class="tombolUbahSiswa border-0 bg-transparent" data-ubah="kelas">
                            <i class="fas fa-pen align-middle text-dark"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <input name="kelas" class="form-control bg-transparent border-0 <?= ($validation->hasError('kelas')) ? 'is-invalid' : ''; ?>" id="kelas" placeholder="Kelas" type="text" value="<?= (old('kelas')) ? old('kelas') : $detail['kelas']; ?>" autocomplete="off" readonly required>
                        <?php if ($validation->hasError('kelas')) : ?>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kelas'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between">
                        <h5>Id RFID</h5>
                        <button class="tombolUbahSiswa border-0 bg-transparent" data-ubah="idRFID">
                            <i class="fas fa-pen align-middle text-dark"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input name="rfid" id="rfid" class="form-control bg-transparent border-0  <?= ($validation->hasError('rfid')) ? 'is-invalid' : ''; ?>" type="text" value="<?= $detail['rfid']; ?>" data-value="<?= $detail['rfid']; ?>" readonly required>
                                    <button class="btn btn-outline-secondary" id="statusGetRfid" style="display: none;" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm text-danger" id="loadGetRfid" role="status" aria-hidden="true"></span>
                                        <span class="visually-hidden">Loading...</span>
                                        <i class="fas fa-check text-success" id="successGetRfid" style="display: none;"></i>
                                    </button>
                                    <div class="input-group-text bg-transparent border-0" id="time-rfid">Waktu Penambahan RFID</div>
                                    <?php if ($validation->hasError('rfid')) : ?>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('rfid'); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" style="display: none;" id="idAlat">
                                    <option selected disabled>Id Alat</option>
                                    <?php foreach ($dataAlat as $alat) : ?>
                                        <option value="<?= $alat['id_alat']; ?>"><?= $alat['id_alat']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian bawah -->
                <div class="row mt-3">

                    <div class="col-md-11 mx-auto my-3 d-grid">
                        <button type="submit" id="ubahDataSiswa" class="btn btn-outline-success" style="display: none;">Ubah</button>
                    </div>
            </form>


            <div class="col-md-1 my-3">
                <!-- HAPUS -->
                <form action="<?= base_url(); ?>/siswa/<?= $detail['id']; ?>" method="post" id="hapus">
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
    var urlRfidSiswa = "<?= base_url('api/rfid-baru'); ?>";
    $(".tombolUbahSiswa").click(function(e) {
        e.preventDefault()
        let ubah = this.dataset.ubah
        if (ubah == "idRFID") {
            $("#idAlat").fadeIn()
            $('#statusGetRfid').fadeIn()
            loopAjaxRfid($('#rfid').data('value'))
        } else {
            $(`#${ubah}`)
                .removeAttr("readonly")
                .removeClass("bg-transparent border-0")
                .addClass('bg-light')
                .focus()
        }
        $("#ubahDataSiswa").fadeIn()
    })
    warningHapusData(".hapusData", "Menghapus data <?= $detail['nama']; ?>", "#hapus")
    warningUbahData("#ubahDataSiswa", "Mengubah data <?= $detail['nama']; ?>", "#formUbah", "<?= base_url('/siswa'); ?>")
</script>
<?= $this->endSection(); ?>