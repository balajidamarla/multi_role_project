<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<h2 class="mb-4">Create Project</h2>

<?php if ($user_role === 'salessurveyor'): ?>
    <div class="alert alert-warning">
        You do not have permission to create projects. Please contact an admin.
    </div>
<?php else: ?>
    <form method="post" action="<?= base_url('admin/projects/store') ?>">
        <?= csrf_field() ?> <!-- CSRF token for security -->

        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" id="customer_id" class="form-select" required>
                <option value="">-- Select Customer --</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= $customer['id'] ?>">
                        <?= esc($customer['name']) ?> <!-- Now using the 'name' field -->
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Project Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <!-- Team Member Dropdown -->
        <div class="mb-3">
            <label for="assigned_to" class="form-label">Assign To</label>
            <select name="assigned_to" id="assigned_to" class="form-select" required>
                <option value="">-- Select Team Member --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>"><?= esc($user['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
<?php endif; ?>

<?= $this->endSection() ?>