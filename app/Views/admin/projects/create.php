<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="w-full max-w-4xl mx-auto py-8 px-4">
    <h2 class="text-3xl font-bold text-black mb-6">Create Project</h2>


    <form method="post" action="<?= base_url('admin/projects/store') ?>" class="bg-white text-black p-6 rounded-xl shadow-2xl space-y-6">
        <?= csrf_field() ?>

        <!-- Customer -->
        <div>
            <label for="customer_id" class="block font-medium mb-2">Customer</label>
            <select name="customer_id" id="customer_id" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-black" required>
                <option value="">-- Select Customer --</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= $customer['id'] ?>">
                        <?= esc(trim(($customer['first_name'] ?? '') . ' ' . ($customer['last_name'] ?? '') . ' --> (' . ($customer['company_name']) . ')')) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Project Name -->
        <div>
            <label for="name" class="block font-medium mb-2">Project Name</label>
            <input type="text" name="name" id="name" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-black" required>
        </div>

        <!-- Sign Name -->
        <div>
            <label for="sign_name" class="block font-medium mb-2">Sign Name</label>
            <input type="text" name="sign_name" id="sign_name" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-black" required>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block font-medium mb-2">Description</label>
            <textarea name="description" id="description" rows="4" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-black" required></textarea>
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block font-medium mb-2">Status</label>
            <select name="status" id="status" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-black" required>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <!-- Assign To -->
        <div>
            <label for="assigned_to" class="block font-medium mb-2">Assign to Team</label>
            <select name="assigned_to" id="assigned_to" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-black" required>
                <option value="">-- Select User --</option>
                <?php if (empty($users)): ?>
                    <option disabled>No users available</option>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= esc($user['id']) ?>">
                            <?= esc($user['first_name']) ?> (<?= esc($user['role']) ?>)
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- Submit -->
        <div>
            <button type="submit" class="w-full bg-gray-900 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-900 transition">
                Create Project
            </button>
        </div>
    </form>

</div>

<?= $this->endSection() ?>