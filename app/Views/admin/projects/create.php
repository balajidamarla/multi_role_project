<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto bg-white p-6 shadow-md rounded-lg mt-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Create Project</h2>

    <?php if ($role === 'salessurveyor'): ?>
        <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded">
            You do not have permission to create projects. Please contact an admin.
        </div>
    <?php else: ?>
        <form method="post" action="<?= base_url('admin/projects/store') ?>" class="space-y-5">
            <?= csrf_field() ?>

            <!-- Customer -->
            <div>
                <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
                <select name="customer_id" id="customer_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black border-[1px]" required>
                    <option value="">-- Select Customer --</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= $customer['id'] ?>">
                            <?= esc(trim(($customer['first_name'] ?? '') . ' ' . ($customer['last_name'] ?? ''))) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Project Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-black mb-1">Project Name</label>
                <input type="text" name="name" id="name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black border-[1px]" required>
            </div>

            <!-- sign name -->
            <div>
                <label for="sign_name" class="block text-sm font-medium text-black mb-1">Sign Name</label>
                <input type="text" name="sign_name" id="sign_name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black border-[1px]" required>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="4" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black border-[1px]"></textarea>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black border-[1px]">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <!-- Assign To -->
            <div>
                <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-1">Assign To</label>
                <select name="assigned_to" id="assigned_to" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black border-[1px]" required>
                    <option value="">-- Select Team Member --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>">
                            <?= esc($user['name']) ?> (<?= esc($user['role']) ?>)
                        </option>

                    <?php endforeach; ?>
                </select>
            </div>


            <!-- Submit -->
            <div>
                <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">Create</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>