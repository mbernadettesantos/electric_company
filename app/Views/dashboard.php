<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <p class="text-uppercase fw-semibold small mb-2 text-warning">Customer Account Management</p>
                <h1 class="display-5 fw-bold mb-3">Dashboard</h1>
                <p class="lead mb-0">Review customer accounts, update records, and keep service information organized.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?= base_url('account/create') ?>" class="btn btn-primary btn-lg"><i class="fas fa-plus me-2"></i>Add Account</a>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-light-custom">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?><div class="alert alert-danger"><i class="fas fa-circle-exclamation me-2"></i><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>

        <div class="row g-4 mb-5">
            <div class="col-md-6 col-xl-3"><div class="card stat-card management-stat-primary h-100 p-4"><p class="small mb-2">Total Accounts</p><h2 class="display-6 fw-bold mb-0"><?= (int) $total_accounts ?></h2></div></div>
            <div class="col-md-6 col-xl-3"><div class="card stat-card management-stat-success h-100 p-4"><p class="small mb-2">Active</p><h2 class="display-6 fw-bold mb-0"><?= (int) $active_accounts ?></h2></div></div>
            <div class="col-md-6 col-xl-3"><div class="card stat-card management-stat-warning h-100 p-4"><p class="small mb-2">Inactive</p><h2 class="display-6 fw-bold mb-0"><?= (int) $inactive_accounts ?></h2></div></div>
            <div class="col-md-6 col-xl-3"><div class="card stat-card management-stat-danger h-100 p-4"><p class="small mb-2">Suspended</p><h2 class="display-6 fw-bold mb-0"><?= (int) $suspended_accounts ?></h2></div></div>
        </div>

        <div class="card p-4 mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <div><h3 class="h4 text-primary-custom mb-1">Find an account</h3><p class="text-muted mb-0">Search by account number, customer, email, or phone.</p></div>
                <span class="badge bg-primary rounded-pill px-3 py-2">Logged in as <?= esc($username) ?></span>
            </div>
            <form method="get" action="<?= base_url('dashboard') ?>">
                <div class="row g-3">
                    <div class="col-lg-5"><input class="form-control form-control-lg" name="search" value="<?= esc($search_keyword ?? '') ?>" placeholder="Search customer accounts..."></div>
                    <div class="col-md-3 col-lg-2"><select class="form-select form-select-lg" name="status"><option value="">All Status</option><?php foreach (['active','inactive','suspended'] as $s): ?><option value="<?= $s ?>" <?= ($filter_status ?? '') === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option><?php endforeach; ?></select></div>
                    <div class="col-md-3 col-lg-2"><select class="form-select form-select-lg" name="type"><option value="">All Types</option><?php foreach (['residential','commercial','industrial'] as $t): ?><option value="<?= $t ?>" <?= ($filter_type ?? '') === $t ? 'selected' : '' ?>><?= ucfirst($t) ?></option><?php endforeach; ?></select></div>
                    <div class="col-md-6 col-lg-3 d-flex gap-2"><button class="btn btn-primary btn-lg flex-fill"><i class="fas fa-search me-2"></i>Search</button><?php if ($search_keyword || $filter_status || $filter_type): ?><a class="btn btn-outline-secondary btn-lg" href="<?= base_url('dashboard') ?>">Clear</a><?php endif; ?></div>
                </div>
            </form>
        </div>

        <div class="card overflow-hidden">
            <div class="card-header bg-white p-4 border-0"><h3 class="h4 text-primary-custom mb-0">Customer Accounts</h3></div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Account</th><th>Customer</th><th>Contact</th><th>Type</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                    <tbody>
                    <?php if (empty($accounts)): ?>
                        <tr><td colspan="6" class="text-center py-5 text-muted">No customer accounts found.</td></tr>
                    <?php else: foreach ($accounts as $account): ?>
                        <tr>
                            <td><strong><?= esc($account['account_number']) ?></strong><div class="small text-muted"><?= esc($account['meter_number'] ?? '') ?></div></td>
                            <td><?= esc($account['customer_name']) ?><div class="small text-muted"><?= esc($account['address'] ?? '') ?></div></td>
                            <td><div><?= esc($account['email'] ?? '') ?></div><div class="small text-muted"><?= esc($account['phone'] ?? '') ?></div></td>
                            <td><span class="badge bg-info text-dark"><?= ucfirst(esc($account['connection_type'])) ?></span></td>
                            <td><span class="badge <?= $account['status'] === 'active' ? 'bg-success' : ($account['status'] === 'inactive' ? 'bg-secondary' : 'bg-warning text-dark') ?>"><?= ucfirst(esc($account['status'])) ?></span></td>
                            <td class="text-end"><div class="d-flex justify-content-end gap-2 flex-wrap"><a class="btn btn-sm btn-outline-primary" href="<?= base_url('account/' . $account['id']) ?>"><i class="fas fa-eye me-1"></i>View</a><a class="btn btn-sm btn-outline-warning" href="<?= base_url('account/' . $account['id'] . '/edit') ?>"><i class="fas fa-pen me-1"></i>Edit</a><form method="post" action="<?= base_url('account/' . $account['id'] . '/delete') ?>" onsubmit="return confirm('Delete this customer account?');"><?= csrf_field() ?><button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash me-1"></i>Delete</button></form></div></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($pager && $pager->getPageCount() > 1): ?>
                <?php
                    $pageCount = $pager->getPageCount();
                    $current = (int) ($current_page ?? 1);
                    $query = $_GET;
                    $pageUrl = static function (int $page) use ($query): string { $query['page'] = $page; return base_url('dashboard') . '?' . http_build_query($query); };
                ?>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-4 border-top">
                    <span class="text-muted">Page <?= $current ?> of <?= $pageCount ?></span>
                    <div class="d-flex gap-2 flex-wrap pagination-controls">
                        <a class="btn btn-sm btn-outline-primary <?= $current <= 1 ? 'disabled' : '' ?>" href="<?= $current > 1 ? $pageUrl(1) : '#' ?>"><i class="fas fa-angles-left"></i></a>
                        <a class="btn btn-sm btn-outline-primary <?= $current <= 1 ? 'disabled' : '' ?>" href="<?= $current > 1 ? $pageUrl($current - 1) : '#' ?>"><i class="fas fa-angle-left"></i></a>
                        <?php for ($i = 1; $i <= $pageCount; $i++): ?><a class="btn btn-sm <?= $i === $current ? 'btn-primary' : 'btn-outline-primary' ?>" href="<?= $pageUrl($i) ?>"><?= $i ?></a><?php endfor; ?>
                        <a class="btn btn-sm btn-outline-primary <?= $current >= $pageCount ? 'disabled' : '' ?>" href="<?= $current < $pageCount ? $pageUrl($current + 1) : '#' ?>"><i class="fas fa-angle-right"></i></a>
                        <a class="btn btn-sm btn-outline-primary <?= $current >= $pageCount ? 'disabled' : '' ?>" href="<?= $current < $pageCount ? $pageUrl($pageCount) : '#' ?>"><i class="fas fa-angles-right"></i></a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
