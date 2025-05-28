<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
</head>

<body>

    <?php if (!empty($admins)): ?>
        <div class="max-w-6xl mx-auto p-6">
            <h2 class="text-2xl font-semibold text-black mb-4">Admin Accounts</h2>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full text-sm divide-y divide-gray-200 text-gray-800">
                    <thead class="bg-gray-900 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">FIRST NAME</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">LAST NAME</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Role</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Action</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Created At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php  $i = 1; foreach ($admins as $admin): ?>
                            <tr class="hover:bg-gray-100 transition">
                                <td class="px-4 py-3"><?= $i ?></td>
                                <td class="px-4 py-3"><?= esc($admin['first_name']) ?></td>
                                <td class="px-4 py-3"><?= esc($admin['last_name']) ?></td>

                                <td class="px-4 py-3"><?= esc($admin['email']) ?></td>
                                <td class="px-4 py-3"><?= esc($admin['role']) ?></td>
                                <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full <?= $admin['status'] === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' ?>">
                                        <?= esc($admin['status']) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <form action="<?= base_url('superadmin/toggle_status/' . $admin['id']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="inline-block px-3 py-1 text-xs rounded font-medium transition <?= $admin['status'] === 'Active' ? 'bg-red-600 text-white hover:bg-red-700' : 'bg-green-600 text-white hover:bg-green-700' ?>">
                                            <?= $admin['status'] === 'Active' ? 'Deactivate' : 'Activate' ?>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3"><?= esc($admin['created_at']) ?></td>
                                
                            </tr>

                        <?php $i++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <p class="text-gray-500 text-center mt-6">No admins registered yet.</p>
    <?php endif; ?>

</body>

</html>
<?= $this->endSection() ?>