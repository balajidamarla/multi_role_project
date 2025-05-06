<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<h2>Projects for <?= esc($customer['company_name']) ?></h2>
<p><?= esc($customer['address1']) ?>, <?= esc($customer['zipcode']) ?></p>

<?php if (!empty($projects)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Project Name</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= esc($project['name']) ?></td>
                    <td><?= esc($project['status']) ?></td>
                    <td><?= esc($project['assigned_to'] ?? 'Unassigned') ?></td>
                    <td>
                        <a href="<?= base_url('salessurveyor/projects/view/' . $project['id']) ?>" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No projects found for this customer.</p>
<?php endif; ?>

<?= $this->endSection() ?>