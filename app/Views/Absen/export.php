<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <h1><a href="<?= current_url(); ?>" class="text-decoration-none link-dark">Export Absen to Excel</a></h1>

    <form action="" method="get">
        <div class="row mt-5">
            <div class="col-12 my-2">
                <label class="form-label">Pilih Bulan</label>
                <select class="form-select" aria-valuetext="<?= $bulan; ?>" name="bulan" required>
                    <option value="01" <?= $bulan == '01' ? 'selected' : ''; ?>>Januari</option>
                    <option value="02" <?= $bulan == '02' ? 'selected' : ''; ?>>Februari</option>
                    <option value="03" <?= $bulan == '03' ? 'selected' : ''; ?>>Maret</option>
                    <option value="04" <?= $bulan == '04' ? 'selected' : ''; ?>>April</option>
                    <option value="05" <?= $bulan == '05' ? 'selected' : ''; ?>>Mei</option>
                    <option value="06" <?= $bulan == '06' ? 'selected' : ''; ?>>Juni</option>
                    <option value="07" <?= $bulan == '07' ? 'selected' : ''; ?>>Juli</option>
                    <option value="08" <?= $bulan == '08' ? 'selected' : ''; ?>>Agustus</option>
                    <option value="09" <?= $bulan == '09' ? 'selected' : ''; ?>>September</option>
                    <option value="10" <?= $bulan == '10' ? 'selected' : ''; ?>>Oktober</option>
                    <option value="11" <?= $bulan == '11' ? 'selected' : ''; ?>>November</option>
                    <option value="12" <?= $bulan == '12' ? 'selected' : ''; ?>>Desember</option>
                </select>
            </div>
            <div class="col-12 my-2">
                <label class="form-label">Tahun</label>
                <input type="text" class="form-control" name="tahun" value="<?= $tahun; ?>" placeholder="Masukkan tahun" autocomplete="off" required>
            </div>
            <div class="col-12 my-2 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-3">Pilih</button>
            </div>
        </div>
    </form>
    <hr class="mt-1 mb-3 p-0">
    <?php if ($absen) : ?>
        <form action="<?= base_url('absen/get-excel'); ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="bulan" value="<?= $bulan; ?>">
            <input type="hidden" name="tahun" value="<?= $tahun; ?>">
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Export to Excel</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="text-secondary">Diurutkan dari absen terakhir | Terdapat <?= $banyakHasil; ?> hasil</div>
            <?php foreach ($absen as $a) : ?>
                <div class="col-md-3 border m-1 p-1">
                    <?= $a['nama']; ?><br>
                    <?= $a['no_induk']; ?> | <?= $a['date']; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>



<?= $this->endSection(); ?>