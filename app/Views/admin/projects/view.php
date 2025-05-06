<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">Project Detail</h2>

<?php if ($user_role !== 'salessurveyor'): ?>
    <a href="<?= base_url('admin/signs/create/' . $project['id']) ?>" class="btn btn-primary mb-3">Add Sign</a>
<?php endif; ?>

<div class="card p-4 mb-4">
    <h4 class="mb-3">Customer Information</h4>
    <p><strong>Company Name:</strong> <?= esc($project['company_name']) ?></p>
    <p><strong>Name:</strong> <?= esc($project['first_name'] . ' ' . $project['last_name']) ?></p>
    <p><strong>Address:</strong> <?= esc($project['address1'] . ', ' . $project['address2'] . ', ' . $project['city_state']) ?></p>
    <p><strong>Zipcode:</strong> <?= esc($project['zipcode']) ?></p>
    <p><strong>Phone:</strong> <?= esc($project['phone']) ?></p>
    <p><strong>Email:</strong> <?= esc($project['email']) ?></p>
    <p><strong>Created At:</strong> <?= date('Y-m-d', strtotime($project['created_at'])) ?></p>
</div>

<?php if (!empty($signs)): ?>
    <h4>Signs for this Project</h4>
    <ul>
        <?php foreach ($signs as $sign): ?>
            <li><?= esc($sign['sign_description']) ?> (<?= esc($sign['sign_type']) ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="text-muted">No signs have been added for this project yet.</p>
<?php endif; ?>

<?= $this->endSection() ?>