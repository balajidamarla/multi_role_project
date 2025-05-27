<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<?php helper('permission'); // load helper once 
?>

<div class="max-w-7xl mx-auto p-6">

    <!-- Show current user role from session -->
    <p class="mb-4 font-medium text-gray-700">Current Role: <?= esc(session()->get('role')) ?></p>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-black">Roles List</h2>

        <?php if (has_permission('create_role')): ?>
            <a href="<?= base_url('admin/roles/create') ?>" class="bg-gray-900 text-white font-bold px-4 py-2 rounded-md text-sm hover:bg-gray-800 transition">
                + Add Role
            </a>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="w-full divide-y divide-black text-sm text-gray-800">
            <thead class="bg-gray-900 text-white">
                <tr>
                    <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Role Name</th>
                    <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Permissions</th>
                    <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (!empty($roles)): $i = 1; ?>

                    <?php foreach ($roles as $role): ?>
                        <tr class="hover:bg-gray-100 transition">
                            <td class="px-4 py-3"><?= $i ?></td>
                            <td class="px-4 py-3 font-semibold"><?= esc($role['name']) ?></td>
                            <td class="px-4 py-3"><?= esc($role['permissions']) ?></td>
                            <td class="px-4 py-3 space-x-2 flex">
                                <?php if (has_permission('edit_role')): ?>
                                    

                                    <a href="<?= base_url('admin/roles/edit/' . $role['id']) ?>"
                                        class="inline-flex items-center justify-center p-1 hover:opacity-80 transition"
                                        title="edit">
                                        <img src="<?= base_url('public/assets/edit.png') ?>" alt="edit" class="w-5 h-5">
                                    </a>
                                <?php endif; ?>

                                <?php if (has_permission('delete_role')): ?>
                                    

                                    <a href="<?= base_url('admin/roles/delete/' . $role['id']) ?>"
                                        onclick="return confirm('Are you sure you want to delete this role?')"
                                        class="inline-flex items-center justify-center p-1 hover:opacity-80 transition"
                                        title="Delete">
                                        <img src="<?= base_url('public/assets/delete.png') ?>" alt="Delete" class="w-5 h-5">
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php $i++;
                    endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-gray-500 text-center">No roles found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>