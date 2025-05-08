<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto p-6 text-gray-800">
    <h2 class="text-3xl font-semibold text-white mb-6">Project Detail</h2>

    <a href="<?= base_url('admin/signs/create/' . $project['id']) ?>" class="inline-block mb-5 px-5 py-2.5 bg-black text-white rounded-full text-sm font-medium hover:bg-gray-800 transition">
        + Add Sign
    </a>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h4 class="text-xl font-semibold mb-4 border-b pb-2">Customer Information</h4>
        <div class="space-y-2 text-sm text-gray-700">
            <p><strong>Company Name:</strong> <?= esc($project['company_name']) ?></p>
            <p><strong>Name:</strong> <?= esc($project['first_name'] . ' ' . $project['last_name']) ?></p>
            <p><strong>Address:</strong> <?= esc($project['address1'] . ', ' . $project['address2'] . ', ' . $project['city_state']) ?></p>
            <p><strong>Zipcode:</strong> <?= esc($project['zipcode']) ?></p>
            <p><strong>Phone:</strong> <?= esc($project['phone']) ?></p>
            <p><strong>Email:</strong> <?= esc($project['email']) ?></p>
            <p><strong>Created At:</strong> <?= date('Y-m-d', strtotime($project['created_at'])) ?></p>
        </div>
    </div>

    <?php if (!empty($signs)): ?>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h4 class="text-xl font-semibold mb-4 border-b pb-2">Signs for this Project</h4>
            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                <?php foreach ($signs as $sign): ?>
                    <li><?= esc($sign['sign_description']) ?> <span class="text-xs text-gray-500">(<?= esc($sign['sign_type']) ?>)</span></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <p class="text-gray-400 text-sm mt-4">No signs have been added for this project yet.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>