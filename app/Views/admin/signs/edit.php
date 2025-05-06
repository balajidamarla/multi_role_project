<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<h2>Edit Sign</h2>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form action="<?= base_url('admin/signs/update/' . $sign['id']) ?>" method="post">
    <div class="mb-3">
        <label for="sign_name" class="form-label">Sign Name</label>
        <input type="text" class="form-control" name="sign_name" value="<?= esc($sign['sign_name']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="sign_description" class="form-label">Description</label>
        <textarea class="form-control" name="sign_description"><?= esc($sign['sign_description']) ?></textarea>
    </div>

    <div class="mb-3">
        <label for="sign_type" class="form-label">Sign Type</label>
        <input type="text" class="form-control" name="sign_type" value="<?= esc($sign['sign_type']) ?>">
    </div>

    <div class="mb-3">
        <label for="assigned_to" class="form-label">Assign To</label>
        <select name="assigned_to" class="form-control">
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>" <?= $user['id'] == $sign['assigned_to'] ? 'selected' : '' ?>>
                    <?= esc($user['first_name'] . ' ' . $user['last_name']) ?> (<?= esc($user['role']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="progress" class="form-label">Progress</label>
        <select name="progress" class="form-control">
            <option value="pending" <?= $sign['progress'] === 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="in_progress" <?= $sign['progress'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
            <option value="completed" <?= $sign['progress'] === 'completed' ? 'selected' : '' ?>>Completed</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="due_date" class="form-label">Due Date</label>
        <input type="date" class="form-control" name="due_date" value="<?= esc($sign['due_date']) ?>">
    </div>

    <button type="submit" class="btn btn-primary">Update Sign</button>
</form>

<?= $this->endSection() ?>