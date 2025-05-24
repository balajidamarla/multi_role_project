<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<h1 class="text-xl font-bold mb-4">Sign Details</h1>

<div class="bg-white shadow rounded-lg p-4 space-y-2">
    <p><strong>ID:</strong> <?= esc($sign['id']) ?></p>
    <p><strong>Assigned To (User ID):</strong> <?= esc($sign['assigned_to']) ?></p>
    <p><strong>Sign Type:</strong> <?= esc($sign['type'] ?? 'N/A') ?></p>
    <p><strong>Status:</strong> <?php
                                $currentStatus = $sign['status'] ?? 'Pending';
                                $statuses = ['Pending', 'In Progress', 'Completed'];
                                ?>

        <select name="status" id="status" class="border border-gray-300 rounded p-2">
            <?php foreach ($statuses as $status): ?>
                <option value="<?= esc($status) ?>" <?= $status === $currentStatus ? 'selected' : '' ?>>
                    <?= esc($status) ?>
                </option>
            <?php endforeach; ?>
        </select>
    <p><strong>Location:</strong> <?= esc($sign['location'] ?? 'Unknown') ?></p>
    <p><strong>Installation Date:</strong> <?= esc($sign['installation_date'] ?? 'Not set') ?></p>
    <p><strong>Notes:</strong> <?= esc($sign['notes'] ?? 'None') ?></p>
    <p><strong>Created At:</strong> <?= esc($sign['created_at'] ?? 'N/A') ?></p>
    <p><strong>Updated At:</strong> <?= esc($sign['updated_at'] ?? 'N/A') ?></p>
</div>

<a href="<?= base_url('admin/signs') ?>" class="mt-4 inline-block text-blue-600 hover:underline">← Back to list</a>





<?= $this->endSection() ?>