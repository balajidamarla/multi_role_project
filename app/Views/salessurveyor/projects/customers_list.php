<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<h2>Customer List</h2>

<?php if (!empty($customers)): ?>
    <div class="list-group">
        <?php foreach ($customers as $customer): ?>
            <a href="<?= base_url('salessurveyor/projects/by_customer/' . $customer['id']) ?>" class="list-group-item list-group-item-action">
                <strong><?= esc($customer['company_name']) ?></strong><br>
                <?= esc($customer['address1']) ?>, <?= esc($customer['zipcode']) ?><br>
                Contact: <?= esc($customer['first_name'] . ' ' . $customer['last_name']) ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="text-muted">No customers found.</p>
<?php endif; ?>

<?= $this->endSection() ?>