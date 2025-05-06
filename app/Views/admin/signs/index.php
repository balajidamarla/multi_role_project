<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Manage Signs</h3>

    <?php if (!empty($signs)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sign Name</th>
                    <th>Customer Name</th>
                    <th>Assigned To</th>
                    <th>Sign Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($signs as $sign): ?>
                    <tr>
                        <td><?= esc($sign['sign_description']) ?></td>
                        <td><?= esc($sign['customer_name']) ?></td>

                        <!-- Dropdown for re-assign -->
                        <td>
                            <form action="<?= base_url('admin/signs/updateAssignment/' . $sign['id']) ?>" method="post">

                                <?= csrf_field() ?>
                                <select name="assigned_to" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= ($sign['assigned_to'] == $user['id']) ? 'selected' : '' ?>>
                                            <?= esc($user['first_name'] . ' ' . $user['last_name']) ?> (<?= ucfirst($user['role']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </td>

                        <td><?= esc($sign['sign_type']) ?></td>
                        <td><?= esc($sign['progress']) ?></td>
                        <td>
                            <a href="<?= base_url('admin/signs/edit/' . $sign['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('admin/signs/delete/' . $sign['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No signs have been assigned yet.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>