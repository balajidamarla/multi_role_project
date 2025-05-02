<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">Manage Projects</h2>

<a href="<?= base_url('admin/projects/create') ?>" class="btn btn-success mb-3">Add Project</a>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (!empty($projects)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Project Name</th>
                <th>Customer</th>
                <th>Assigned To</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= esc($project['name']) ?></td>
                    <td><?= esc($project['customer_name']) ?></td>
                    <td><?= esc($project['assigned_to_name'] ?? 'Unassigned') ?></td>
                    <td><?= esc(ucfirst($project['status'])) ?></td>
                    <td><?= date('d-m-Y', strtotime($project['created_at'])) ?></td>
                    <td>
                        <a href="<?= base_url('admin/projects/delete/' . $project['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-muted">No projects found.</p>
<?php endif; ?>

<?= $this->endSection() ?>