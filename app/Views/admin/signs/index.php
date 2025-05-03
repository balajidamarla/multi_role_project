<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Assigned Signs</h3>

    <a href="<?= base_url('admin/signs/create') ?>" class="btn btn-success mb-3">+ Add New Sign</a>

    <?php if (!empty($assignedSigns)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sign Name</th>
                    <th>Type</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($assignedSigns as $sign): ?>
                    <tr>
                        <td><?= esc($sign['sign_name']) ?></td>
                        <td><?= esc($sign['sign_type']) ?></td>
                        <td><?= esc($sign['assigned_to_name']) ?></td>
                        <td><?= esc($sign['status']) ?></td>
                        <td><?= esc($sign['due_date']) ?></td>
                        <td>
                            <a href="<?= base_url('admin/signs/edit/' . $sign['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('admin/signs/delete/' . $sign['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No signs assigned yet.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>