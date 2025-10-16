<?php
/** @var array $errors */
/** @var array $credentials */
/** @var string $formAction */
?>
<div class="row">
    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
    <div class="col-lg-6">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Selamat Datang Kembali!</h1>
                <p class="mb-4">Silakan masuk untuk mengelola panel admin Desa Juara.</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (session()->hasFlash('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars(session()->flash('error') ?? '') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->hasFlash('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars(session()->flash('success') ?? '') ?>
                </div>
            <?php endif; ?>

            <form class="user" action="<?= htmlspecialchars($formAction) ?>" method="POST">
                <div class="form-group">
                    <input type="email" class="form-control form-control-user" name="email" aria-label="Email" placeholder="Alamat Email" value="<?= htmlspecialchars($credentials['email'] ?? session()->old('email', '')) ?>" required autofocus>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control form-control-user" name="password" aria-label="Password" placeholder="Kata Sandi" required>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Masuk
                </button>
            </form>

            <hr>

            <div class="text-center">
                <a class="small" href="/">&larr; Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
