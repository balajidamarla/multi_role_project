<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>


<div class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-10">Customer Dashboard</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 text-sm text-gray-900">

        <!-- Address -->
        <div>
            <h3 class="font-bold text-gray-700 mb-1">Address</h3>
            <p><?= esc($customer['address1']) ?><br>
                <?= esc($customer['city_state']) ?><br>
                <?= esc($customer['zipcode']) ?></p>
        </div>

        <!-- Contact -->
        <div>
            <h3 class="font-bold text-gray-700 mb-1">Primary Contact</h3>
            <p><?= esc($customer['first_name']) ?> <?= esc($customer['last_name']) ?><br>
                <?= esc($customer['phone']) ?><br>
                <?= esc($customer['email'] ?? 'N/A') ?></p>
        </div>

        <!-- Date Added -->
        <div>
            <h3 class="font-bold text-gray-700 mb-1">Date Added</h3>
            <p><?= date('d-m-Y', strtotime($customer['created_at'])) ?></p>
        </div>

        <!-- Tasks -->
        <div>
            <h3 class="font-bold text-gray-700 mb-1">Tasks</h3>
            <p><?= $signCount ?></p>
        </div>

        <!-- Notes -->
        <div>
            <h3 class="font-bold text-gray-700 mb-1">Notes</h3>
            <p><?= esc($customer['notes'] ?? 'No notes') ?></p>
        </div>

        <!-- Actions -->
        <div class="flex flex-col justify-center gap-2">
            <?php if (!isset($user_role) || $user_role !== 'salessurveyor'): ?>
                <a href="<?= base_url('admin/delete_customer/' . $customer['id']) ?>"
                    class="bg-red-600 text-white text-center py-2 px-4 rounded hover:bg-red-700"
                    onclick="return confirm('Are you sure?')">Delete</a>
            <?php endif; ?>
            <a href="<?= base_url('admin/customers/report/' . $customer['id']) ?>"
                class="bg-blue-600 text-white text-center py-2 px-4 rounded hover:bg-blue-700">Report</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>