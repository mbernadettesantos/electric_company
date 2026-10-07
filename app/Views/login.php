<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Login - Puihaha Electric') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/loginview.css') ?>" rel="stylesheet">
<style>
/* Puihaha Electric staff login - matches the demoElectric blue/orange design */
:root {
    --login-blue: #1e40af;
    --login-blue-dark: #172554;
    --login-orange: #f59e0b;
    --login-orange-dark: #d97706;
    --login-ink: #1f2937;
    --login-muted: #6b7280;
    --login-line: #e5e7eb;
    --login-bg: #f8fafc;
}

body.login-page {
    margin: 0;
    min-height: 100vh;
    background: var(--login-bg);
    color: var(--login-ink);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.login-wrapper {
    min-height: 100vh;
    display: grid;
    grid-template-columns: minmax(0, 1.08fr) minmax(420px, .92fr);
}

.login-brand-panel {
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding: clamp(48px, 7vw, 110px);
    color: #fff;
    background: linear-gradient(135deg, var(--login-blue) 0%, var(--login-blue-dark) 100%);
}

.login-brand-panel::after {
    content: '';
    position: absolute;
    width: 430px;
    height: 430px;
    right: -180px;
    bottom: -180px;
    border: 70px solid rgba(255,255,255,.045);
    border-radius: 50%;
}

.login-brand-icon {
    width: 68px;
    height: 68px;
    display: grid;
    place-items: center;
    border-radius: 18px;
    margin-bottom: 24px;
    background: var(--login-orange);
    color: #fff;
    font-size: 30px;
    box-shadow: 0 14px 35px rgba(0,0,0,.18);
}

.login-brand-panel > * { position: relative; z-index: 1; }
.login-brand-panel h1 { max-width: 680px; margin-bottom: 18px; line-height: 1.08; }
.login-brand-panel .lead { max-width: 650px; margin-bottom: 34px; }
.login-feature { display: flex; align-items: center; gap: 12px; margin: 10px 0; font-weight: 500; }
.login-feature i { width: 34px; height: 34px; display: grid; place-items: center; border-radius: 9px; color: var(--login-orange); background: rgba(255,255,255,.1); }

.login-form-panel {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px;
    background: radial-gradient(circle at top right, rgba(245,158,11,.10), transparent 30%), #f8fafc;
}

.login-card {
    width: min(480px, 100%);
    padding: 42px;
    background: #fff;
    border: 1px solid #eef2f7;
    border-radius: 22px;
    box-shadow: 0 24px 60px rgba(15,23,42,.12);
}

.login-card:hover { transform: none; }
.login-card .input-group { flex-wrap: nowrap; }
.login-card .input-group-text { width: 52px; justify-content: center; border-radius: 12px 0 0 12px; }
.login-card .form-control { min-width: 0; border-radius: 0; }
.login-card .input-group .btn { width: 52px; padding: 0; border-radius: 0 12px 12px 0; }
.login-card .form-control:focus { position: relative; z-index: 3; }
.login-card .btn-primary {
    min-height: 52px;
    border-radius: 12px;
    background: var(--login-orange);
    border-color: var(--login-orange);
    box-shadow: 0 10px 24px rgba(245,158,11,.24);
}
.login-card .btn-primary:hover { background: var(--login-orange-dark); border-color: var(--login-orange-dark); }

@media (max-width: 960px) {
    .login-wrapper { grid-template-columns: 1fr; }
    .login-brand-panel { display: none; }
    .login-form-panel { min-height: 100vh; padding: 28px 20px; }
}

@media (max-width: 520px) {
    .login-card { padding: 28px 22px; border-radius: 18px; }
    .login-card h2 { font-size: 1.65rem; }
}

</style>
</head>
<body class="login-page">
    <div class="login-wrapper">
        <div class="login-brand-panel">
            <div class="login-brand-icon"><i class="fas fa-bolt"></i></div>
            <p class="text-uppercase fw-semibold small mb-2">Puihaha Electric Company</p>
            <h1 class="display-5 fw-bold">Powering your work with a simpler dashboard.</h1>
            <p class="lead opacity-75">Manage customer accounts, review statuses, and keep electrical service information organized in one place.</p>
            <div class="login-feature"><i class="fas fa-shield-halved"></i><span>Secure staff access</span></div>
            <div class="login-feature"><i class="fas fa-users"></i><span>Customer account management</span></div>
            <div class="login-feature"><i class="fas fa-chart-column"></i><span>Quick account overview</span></div>
        </div>

        <div class="login-form-panel">
            <div class="login-card">
                <div class="d-flex align-items-center gap-2 mb-4 text-primary-custom fw-bold">
                    <i class="fas fa-bolt text-warning"></i> Puihaha Electric
                </div>
                <p class="text-secondary-custom text-uppercase fw-bold small mb-2">Welcome back</p>
                <h2 class="fw-bold mb-2">Sign in to the dashboard</h2>
                <p class="text-muted mb-4">Use your staff account to continue.</p>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><i class="fas fa-circle-exclamation me-2"></i><?= esc(session()->getFlashdata('error')) ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><i class="fas fa-circle-check me-2"></i><?= esc(session()->getFlashdata('success')) ?></div>
                <?php endif; ?>

                <form action="<?= base_url('login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white"><i class="far fa-user text-primary-custom"></i></span>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" value="<?= esc(old('username')) ?>" required autofocus>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white"><i class="fas fa-lock text-primary-custom"></i></span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Show or hide password"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">Log In <i class="fas fa-arrow-right ms-2"></i></button>
                </form>
                <div class="text-center mt-4">
                    <a href="<?= base_url() ?>" class="text-primary-custom text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Back to website</a>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/js_login.js') ?>"></script>
</body>
</html>
