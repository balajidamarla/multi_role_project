<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Add New Permission</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('admin/permissions/store') ?>">
        <?= csrf_field() ?>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Permission Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" value="<?= old('name') ?>" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-2">Label</label>
            <input type="text" name="label" class="w-full border p-2 rounded" value="<?= old('label') ?>" required>
        </div>

        <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-800">
            Save Permission
        </button>
    </form>
</div>

<?= $this->endSection() ?>