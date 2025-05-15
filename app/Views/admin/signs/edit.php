<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded mt-6">
    <h2 class="text-2xl font-semibold text-blue-600 mb-4">Edit Sign</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/signs/update/' . $sign['id']) ?>" method="post" class="space-y-4">
        <?= csrf_field() ?>

        <!-- Sign Name -->
        <div>
            <label for="sign_name" class="block text-sm font-medium text-gray-700">Sign Name</label>
            <input type="text" name="sign_name" id="sign_name" value="<?= esc($sign['sign_name']) ?>" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Description -->
        <div>
            <label for="sign_description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="sign_description" id="sign_description" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"><?= esc($sign['sign_description']) ?></textarea>
        </div>

        <!-- Sign Type -->
        <div>
            <label for="sign_type" class="block text-sm font-medium text-gray-700">Sign Type</label>
            <select name="sign_type" id="sign_type"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="Indoor" <?= $sign['sign_type'] == 'Indoor' ? 'selected' : '' ?>>Indoor</option>
                <option value="Outdoor" <?= $sign['sign_type'] == 'Outdoor' ? 'selected' : '' ?>>Outdoor</option>
            </select>
        </div>


        <!-- Assigned To -->
        <div>
            <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assign To</label>
            <select name="assigned_to" id="assigned_to"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>" <?= $user['id'] == $sign['assigned_to'] ? 'selected' : '' ?>>
                        <?= esc($user['first_name'] . ' ' . $user['last_name']) ?> (<?= esc($user['role']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Progress -->
        <div>
            <label for="progress" class="block text-sm font-medium text-gray-700">Progress</label>
            <select name="progress" id="progress"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="Pending" <?= $sign['progress'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In Progress" <?= $sign['progress'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Completed" <?= $sign['progress'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
            </select>
        </div>

        <!-- Due Date -->
        <div>
            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="<?= esc($sign['due_date']) ?>"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <!-- Buttons -->
        <div class="flex justify-between">
            <button type="submit"
                class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800 transition">
                Update Sign
            </button>

            <a href="<?= base_url('admin/signs') ?>"
                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">Back</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>