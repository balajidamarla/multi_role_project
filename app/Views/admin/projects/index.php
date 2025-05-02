<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Projects</h3>
    <a href="<?= base_url('admin/projects/create') ?>" class="btn btn-primary mb-3">Add Project</a>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($projects)): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Assigned To</th>
                    <th>Created By</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><?= esc($project['id']) ?></td>
                        <td><?= esc($project['customer_id']) ?></td> <!-- You can join customer data here if needed -->
                        <td><?= esc($project['name']) ?></td>
                        <td><?= esc($project['description']) ?></td>
                        <td><?= esc($project['status']) ?></td>
                        <td><?= esc($project['assigned_to']) ?></td>
                        <td><?= esc($project['created_by']) ?></td>
                        <td><?= esc($project['created_at']) ?></td>
                        <td>
                            <a href="<?= base_url('admin/projects/delete/' . $project['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="mt-3 text-muted">No projects found.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
