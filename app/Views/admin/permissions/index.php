<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-6 mx-auto max-w-5xl">
    <h2 class="text-3xl font-bold text-gray-800">Permissions List</h2>
    <a href="<?= base_url('admin/permissions/create') ?>" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-md text-sm font-medium transition">
        + Add Permission
    </a>
</div>
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="overflow-x-auto bg-white shadow-md rounded-lg  mx-auto max-w-5xl">
    <table class="w-full divide-y divide-black text-sm text-gray-800">

        <thead class="bg-gray-900 text-white">
            <tr>
                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Label</th>
                <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php 
            $i=1;
            foreach ($permissions as $permission): ?>
                <tr class="hover:bg-gray-100 transition">
                    <td class="px-6 py-4"><?= $i ?></td>
                    <td class="px-6 py-4"><?= esc($permission['name']) ?></td>
                    <td class="px-6 py-4"><?= esc($permission['label']) ?></td>
                    <td class="px-6 py-4 space-x-2 flex">
                        <a href="<?= base_url('admin/permissions/edit/' . $permission['id']) ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-xs font-medium">
                            Edit
                        </a>
                        <a href="<?= base_url('admin/permissions/delete/' . $permission['id']) ?>" onclick="return confirm('Are you sure you want to delete this permission?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-xs font-medium">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php 
        $i++;
        endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>