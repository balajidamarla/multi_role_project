<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Manage Signs</h3>

    <?php
    $session = session();
    $role = $session->get('role'); // Ensure 'role' is set in session
    $userId = $session->get('id'); // Used to limit visibility to assigned signs
    ?>

    <?php if (!empty($signs)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sign Name</th>
                    <th>Customer Name</th>
                    <th>Assigned To</th>
                    <th>Sign Type</th>
                    <th>Status</th>
                    <?php if (in_array($role, ['admin', 'manager'])): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($signs as $sign): ?>
                    <?php
                    // Allow access if the user is assigned OR is an admin/manager
                    if ($sign['assigned_to'] == $userId || in_array($role, ['admin', 'manager'])):
                    ?>
                        <tr>
                            <td><?= esc($sign['sign_description']) ?></td>
                            <td><?= esc($sign['customer_name']) ?></td>

                            <td>
                                <?php if (in_array($role, ['admin', 'manager'])): ?>
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
                                <?php else: ?>
                                    <?php
                                    $assignedUser = array_filter($users, fn($u) => $u['id'] == $sign['assigned_to']);
                                    $assignedUser = reset($assignedUser);

                                    // Show "Self" if current user is assigned
                                    $displayName = ($assignedUser && $assignedUser['id'] == $userId)
                                        ? 'Self'
                                        : esc($assignedUser['first_name'] . ' ' . $assignedUser['last_name']) . ' (' . ucfirst($assignedUser['role']) . ')';
                                    ?>
                                    <?= $displayName ?>
                                <?php endif; ?>
                            </td>

                            <td><?= esc($sign['sign_type']) ?></td>
                            <td><?= esc($sign['progress']) ?></td>

                            <?php if (in_array($role, ['admin', 'manager'])): ?>
                                <td>
                                    <a href="<?= base_url('admin/signs/edit/' . $sign['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="<?= base_url('admin/signs/delete/' . $sign['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>

            </tbody>
        </table>
    <?php else: ?>
        <p>No signs have been assigned yet.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>