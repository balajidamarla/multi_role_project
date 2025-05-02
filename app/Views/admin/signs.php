<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Assigned Signs</h3>
            <a href="<?= base_url('admin/signs/create') ?>" class="btn btn-primary">Assign Sign</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Project</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Start</th>
                    <th>Complete</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($signs as $sign): ?>
                    <tr>
                        <td><?= esc($sign['project_id']) ?></td>
                        <td><?= esc($sign['sign_description']) ?></td>
                        <td><?= esc($sign['sign_type']) ?></td>
                        <td><?= esc($sign['status']) ?></td>
                        <td><?= esc($sign['start_date']) ?></td>
                        <td><?= esc($sign['completion_date']) ?></td>
                        <td>
                            <a href="<?= base_url('admin/signs/delete/' . $sign['id']) ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
<?= $this->endSection() ?>