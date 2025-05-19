<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Add New Role</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/roles/store') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-4">
            <label for="role_name" class="block font-medium mb-1">Role Name</label>
            <input type="text" id="role_name" name="role_name" class="w-full border px-3 py-2 rounded" value="<?= old('role_name') ?>" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-2">Assign Permissions</label>
            <div class="grid grid-cols-2 gap-2">
                <?php foreach ($permissions as $perm): ?>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="permissions[]" value="<?= $perm['id'] ?>" class="form-checkbox">
                        <span><?= esc($perm['label']) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-800 transition">Create Role</button>
        
    </form>
</div>

<?= $this->endSection() ?>