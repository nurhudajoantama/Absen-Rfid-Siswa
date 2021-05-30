<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid">
    <h1><a href="<?= current_url(); ?>" class="text-decoration-none link-dark">Home</a></h1>
    <div class="row">
        <div class="col">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <!-- NOTIF -->
                <div class="alert alert-<?= session()->getFlashdata('pesan')['status']; ?> alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('pesan')['pesan']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>