<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<section class="hero-section py-5"><div class="container"><div class="row text-center"><div class="col-lg-8 mx-auto"><h1 class="display-5 fw-bold mb-3"><?= esc($title) ?></h1><p class="lead mb-0">Customer Account Management - Puihaha Electric</p></div></div></div></section>
<section class="section-padding bg-light-custom"><div class="container"><div class="row"><div class="col-xl-9 mx-auto"><div class="card shadow-lg"><div class="card-body p-4 p-lg-5">
<?php if (session()->getFlashdata('errors')): ?><div class="alert alert-danger"><strong>Please check the form.</strong><ul class="mb-0 mt-2"><?php foreach (session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<?php $a = $account ?? []; ?>
<form method="post" action="<?= $action ?>"><?= csrf_field() ?>
<div class="row g-4">
<div class="col-md-6"><label class="form-label fw-semibold">Account Number *</label><input class="form-control form-control-lg" name="account_number" value="<?= esc(old('account_number', $a['account_number'] ?? '')) ?>" required></div>
<div class="col-md-6"><label class="form-label fw-semibold">Customer Name *</label><input class="form-control form-control-lg" name="customer_name" value="<?= esc(old('customer_name', $a['customer_name'] ?? '')) ?>" required></div>
<div class="col-12"><label class="form-label fw-semibold">Address</label><input class="form-control form-control-lg" name="address" value="<?= esc(old('address', $a['address'] ?? '')) ?>"></div>
<div class="col-md-6"><label class="form-label fw-semibold">Phone</label><input class="form-control form-control-lg" name="phone" value="<?= esc(old('phone', $a['phone'] ?? '')) ?>"></div>
<div class="col-md-6"><label class="form-label fw-semibold">Email</label><input type="email" class="form-control form-control-lg" name="email" value="<?= esc(old('email', $a['email'] ?? '')) ?>"></div>
<div class="col-md-4"><label class="form-label fw-semibold">Meter Number</label><input class="form-control form-control-lg" name="meter_number" value="<?= esc(old('meter_number', $a['meter_number'] ?? '')) ?>"></div>
<div class="col-md-4"><label class="form-label fw-semibold">Connection Type *</label><select class="form-select form-select-lg" name="connection_type" required><?php $v = old('connection_type', $a['connection_type'] ?? 'residential'); foreach (['residential','commercial','industrial'] as $x): ?><option value="<?= $x ?>" <?= $v === $x ? 'selected' : '' ?>><?= ucfirst($x) ?></option><?php endforeach; ?></select></div>
<div class="col-md-4"><label class="form-label fw-semibold">Status *</label><select class="form-select form-select-lg" name="status" required><?php $v = old('status', $a['status'] ?? 'active'); foreach (['active','inactive','suspended'] as $x): ?><option value="<?= $x ?>" <?= $v === $x ? 'selected' : '' ?>><?= ucfirst($x) ?></option><?php endforeach; ?></select></div>
</div>
<div class="d-flex flex-wrap gap-2 mt-4"><button class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Save Account</button><a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary btn-lg">Cancel</a></div>
</form></div></div></div></div></div>
</section>
<?= $this->endSection() ?>
