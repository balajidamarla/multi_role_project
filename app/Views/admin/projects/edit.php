<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<?php $currentUserId = session()->get('user_id'); ?>
<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded mt-6">
    <h2 class="text-2xl font-semibold text-blue-600 mb-4">Edit Project</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/projects/update/' . $project['id']) ?>" method="post" class="space-y-4">
        <?= csrf_field() ?>

        <!-- Project Name -->
        <div>
            <label for="project_name" class="block text-sm font-medium text-gray-700">Project Name</label>
            <input type="text" name="name" id="project_name" value="<?= esc($project['name']) ?>" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status"
                class="mt-1 w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="Pending" <?= $project['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In Progress" <?= $project['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Completed" <?= $project['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
            </select>
        </div>

        <!-- Assigned To -->
        <div>
            <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assigned To</label>
            <select name="assigned_to" id="assigned_to"
                class="mt-1 w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>" <?= $user['id'] == $project['assigned_to'] ? 'selected' : '' ?>>
                        <?php if ($user['id'] == $currentUserId): ?>
                            Self (<?= esc($user['role']) ?>)
                        <?php else: ?>
                            <?= esc($user['first_name'] . ' ' . $user['last_name']) ?> (<?= esc($user['role']) ?>)
                        <?php endif; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Customer Info -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Customer Name</label>
            <input type="text" value="<?= esc($project['customer_name']) ?>" readonly
                class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md p-2 text-gray-700">
        </div>

        <!-- Buttons -->
        <div class="flex justify-between">
            <button type="submit"
                class="px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-800 transition">Update Project</button>
            <a href="<?= base_url('admin/projects') ?>"
                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">Cancel</a>
        </div>
    </form>
</div>

<!-- Select2 Assets -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#status').select2({
            width: '100%'
        });
        $('#assigned_to').select2({
            width: '100%'
        });
    });
</script>

<?= $this->endSection() ?>