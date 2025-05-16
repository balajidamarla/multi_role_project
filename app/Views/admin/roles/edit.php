<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-2xl font-semibold text-black mb-4">Edit Role - <?= esc($role['name']) ?></h2>

    <!-- Flash Messages go here -->
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

    <form action="<?= base_url('admin/roles/update/' . $role['id']) ?>" method="post" class="bg-white shadow rounded-lg p-6 space-y-4">
        <?= csrf_field() ?>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Role Name</label>
            <input type="text" name="role_name" value="<?= esc($role['name']) ?>"
                class="w-full border border-gray-300 rounded-md px-4 py-2 bg-gray-100 text-gray-700"
                readonly>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-2">Permissions</label>
            <div class="grid grid-cols-2 gap-3">
                <?php foreach ($permissions as $permission): ?>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="<?= $permission['id'] ?>"
                            <?= in_array($permission['id'], $rolePermissions) ? 'checked' : '' ?>
                            class="form-checkbox h-5 w-5 text-black">
                        <span class="ml-2 text-gray-800"><?= esc($permission['name']) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="<?= base_url('admin/roles') ?>" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancel</a>
            <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-800 transition">Update Role</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>