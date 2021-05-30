<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= $judul; ?></title>

    <link rel="shortcut icon" href="<?= base_url('img/icon.png'); ?>" type="image/x-icon">

    <!-- Simple Sidebar and Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('css/simplesidebar.css'); ?>">


    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="<?= base_url('css/signin.css'); ?>">
</head>

<body class="text-center">
    <main class="form-signin">

        <img class="mb-4" src="<?= base_url('img/icon.png'); ?>" alt="" width=" 100" height="auto">
        <h1 class="h3 mb-5 fw-normal">Sign In Absen</h1>

        <?php if (session()->getFlashdata('pesan')) : ?>
            <!-- NOTIF -->
            <div class="alert alert-<?= session()->getFlashdata('pesan')['status']; ?> alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('pesan')['pesan']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <form action="<?= base_url('auth'); ?>" method="post">
            <?= csrf_field(); ?>

            <div class="form-floating">
                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <div class="mt-3">
                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            </div>
        </form>
    </main>

</body>

</html>