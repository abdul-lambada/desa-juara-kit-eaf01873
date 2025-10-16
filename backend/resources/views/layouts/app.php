<?php
/** @var string $content */
/** @var array $breadcrumbs */
/** @var string $title */
?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= isset($title) ? htmlspecialchars($title) . ' | ' : '' ?>Desa Juara Admin</title>

    <link href="/sb-admin-2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">

        <?php require __DIR__ . '/../partials/sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php if (is_file(__DIR__ . '/../partials/topbar.php')) {require __DIR__ . '/../partials/topbar.php';} ?>

                <div class="container-fluid">

                    <?php require __DIR__ . '/../partials/flash.php'; ?>

                    <?php if (!empty($breadcrumbs)): ?>
                        <nav aria-label="breadcrumb" class="mb-3">
                            <ol class="breadcrumb">
                                <?php foreach ($breadcrumbs as $crumb): ?>
                                    <?php if (!empty($crumb['url'])): ?>
                                        <li class="breadcrumb-item"><a href="<?= htmlspecialchars($crumb['url']) ?>"><?= htmlspecialchars($crumb['label']) ?></a></li>
                                    <?php else: ?>
                                        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($crumb['label']) ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ol>
                        </nav>
                    <?php endif; ?>

                    <?= $content ?>

                </div>

            </div>

            <?php require __DIR__ . '/../partials/footer.php'; ?>

        </div>

    </div>

    <script src="/sb-admin-2/vendor/jquery/jquery.min.js"></script>
    <script src="/sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/sb-admin-2/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/sb-admin-2/js/sb-admin-2.min.js"></script>

</body>

</html>
