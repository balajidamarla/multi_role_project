<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="mx-auto max-w-5xl">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Permissions List</h2>
        <a href="<?= base_url('admin/permissions/create') ?>" class="bg-gray-900 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow">
            + Add Permission
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded mb-4 shadow">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="w-full divide-y divide-gray-200 text-sm text-gray-800">
            <thead class="bg-gray-900 text-white">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Label</th>
                    <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($permissions as $index => $permission): ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-600">
                            <?= esc($index + 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage()) ?>
                        </td>
                        <td class="px-6 py-4"><?= esc($permission['name']) ?></td>
                        <td class="px-6 py-4"><?= esc($permission['label']) ?></td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="<?= base_url('admin/permissions/edit/' . $permission['id']) ?>" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-xs font-semibold transition">
                                Edit
                            </a>
                            <a href="<?= base_url('admin/permissions/delete/' . $permission['id']) ?>" onclick="return confirm('Are you sure you want to delete this permission?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs font-semibold transition">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Stylish Pagination -->
    <div class="mt-6 flex justify-center">
        <?= $pager->links('default', 'tailwind_full') ?>
    </div>
</div>

<?= $this->endSection() ?>