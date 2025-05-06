<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (!empty($projects)): ?>
    <h2>Project List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Info</th>
                <th>Project Name</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Signs</th>
                <?php if ($role !== 'salessurveyor'): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td>
                        <a href="<?= base_url('admin/projects/view/' . $project['id']) ?>">
                            <strong><?= esc($project['customer_name']) ?></strong><br>
                            <?= esc($project['customer_address']) ?>
                        </a><br>
                        Zip: <?= esc($project['zipcode']) ?><br>
                        Contact: <?= esc($project['contact_info']) ?><br>
                        Created: <?= date('Y-m-d', strtotime($project['customer_created_at'])) ?>
                    </td>
                    <td><?= esc($project['name']) ?></td>
                    <td><?= esc($project['status']) ?></td>
                    <td><?= esc($project['assigned_to_name'] ?? 'Unassigned') ?></td>
                    <td>
                        <ul>
                            <?php
                            $db = \Config\Database::connect();
                            $signs = $db->table('signs')->where('project_id', $project['id'])->get()->getResultArray();
                            foreach ($signs as $sign) {
                                echo "<li><strong>" . esc($sign['sign_description']) . "</strong><br><small>Due: " . esc($sign['due_date']) . "</small></li>";
                            }
                            ?>
                        </ul>
                    </td>
                    <?php if ($role !== 'salessurveyor'): ?>
                        <td>
                            <a href="<?= base_url('admin/projects/edit/' . $project['id']) ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="<?= base_url('admin/projects/delete/' . $project['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-muted">No projects found.</p>
<?php endif; ?>

<?= $this->endSection() ?>