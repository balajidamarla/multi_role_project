<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>

<body>
    <div class="container mt-4">
        <h4 class="mt-4">Admins Accounts View</h4>

        <?php if (!empty($admins)): ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th> <!-- Toggle Button Column -->
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?= esc($admin['id']) ?></td>
                            <td><?= esc($admin['first_name']) ?></td>
                            <td><?= esc($admin['email']) ?></td>
                            <td><?= esc($admin['role']) ?></td>
                            <td>
                                <span class="badge badge-<?= $admin['status'] === 'Active' ? 'success' : 'secondary' ?>">
                                    <?= esc($admin['status']) ?>
                                </span>
                            </td>
                            <td>
                                <form action="<?= base_url('superadmin/toggle_status/' . $admin['id']) ?>" method="post" style="display:inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm <?= $admin['status'] === 'Active' ? 'btn-danger' : 'btn-success' ?>">
                                        <?= $admin['status'] === 'Active' ? 'Deactivate' : 'Activate' ?>
                                    </button>
                                </form>
                            </td>
                            <td><?= esc($admin['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="mt-3 text-muted">No admins registered yet.</p>
        <?php endif; ?>
    </div>

</body>

</html>

<?= $this->endSection() ?>