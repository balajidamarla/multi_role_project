<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-2xl font-semibold text-black mb-4">Edit Permission - <?= esc($permission['name']) ?></h2>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('admin/permissions/update/' . $permission['id']) ?>" class="bg-white shadow rounded-lg p-6 space-y-4">
        <?= csrf_field() ?>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Permission Name</label>
            <input type="text" name="name" class="w-full border border-gray-300 rounded-md px-4 py-2 bg-gray-100 text-gray-700" value="<?= esc($permission['name']) ?>" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Label</label>
            <input type="text" name="label" class="w-full border border-gray-300 rounded-md px-4 py-2 text-gray-700" value="<?= esc($permission['label']) ?>" required>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="<?= base_url('admin/permissions') ?>" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancel</a>
            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-800 transition">Update Permission</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>