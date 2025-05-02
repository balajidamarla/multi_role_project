<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Team Members</h3>
        <a href="<?= base_url('admin/teams/create') ?>" class="btn btn-primary">Add</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th> <!-- New column for status -->
                    <th>Assigned Signs</th>
                    <th>Date Added</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($teams)): ?>
                    <?php foreach ($teams as $member): ?>
                        <tr>
                            <td><?= esc($member['first_name']) ?></td>
                            <td><?= esc($member['last_name']) ?></td>
                            <td><?= esc($member['email']) ?></td>
                            <td><?= ucfirst(str_replace('_', ' ', esc($member['role']))) ?></td>
                            <td><?= ucfirst(esc($member['status'])) ?></td> <!-- Displaying status -->
                            <td>0</td> <!-- Placeholder: Replace with real assigned signs count -->
                            <td><?= date('d-m-Y', strtotime($member['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('admin/teams/delete/' . $member['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No team members found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>


</body>

</html>
<?= $this->endSection() ?>