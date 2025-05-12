<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-semibold text-white">Manage Signs</h3>
    </div>

    <?php
    $session = session();
    $role = $session->get('role'); // Ensure 'role' is set in session
    $userId = $session->get('id'); // Used to limit visibility to assigned signs
    ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($signs)): ?>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Sign Name</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Customer Name</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Cumpany Name</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Assigned To</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Sign Type</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Status</th>
                        <?php if (in_array($role, ['admin'])): ?>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($signs as $sign): ?>
                        <?php
                        // Allow access if the user is assigned OR is an admin/manager
                        if ($sign['assigned_to'] == $userId || in_array($role, ['admin', 'manager'])):
                        ?>
                            <tr class="hover:bg-gray-100 transition">
                                <td class="px-4 py-3"><?= esc($sign['sign_description']) ?></td>
                                <td class="px-4 py-3"><?= esc($sign['customer_name']) ?></td>
                                <td class="px-4 py-3"><?= esc($sign['customer']) ?></td>

                                <td class="px-4 py-3">
                                    <?php if (in_array($role, ['admin'])): ?>
                                        <form action="<?= base_url('admin/signs/updateAssignment/' . $sign['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <select name="assigned_to" class="form-select form-select-sm px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                                                <?php foreach ($users as $user): ?>
                                                    <option value="<?= $user['id'] ?>" <?= $user['id'] == $sign['assigned_to'] ? 'selected' : '' ?>>
                                                        <?= esc($user['first_name'] . ' ' . $user['last_name']) ?> (<?= esc($user['role']) ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>
                                    <?php else: ?>
                                        <?php
                                        $assignedUser = array_filter($users, fn($u) => $u['id'] == $sign['assigned_to']);
                                        $assignedUser = reset($assignedUser); // Get the matched user

                                        if ($assignedUser):
                                            $displayName = ($assignedUser['id'] == $currentUserId)
                                                ? 'Self'
                                                : esc($assignedUser['first_name'] . ' ' . $assignedUser['last_name']) . ' (' . ucfirst($assignedUser['role']) . ')';
                                        else:
                                            $displayName = 'Unassigned';
                                        endif;
                                        ?>
                                        <?= $displayName ?>
                                    <?php endif; ?>
                                </td>

                                <td class="px-4 py-3"><?= esc($sign['sign_type']) ?></td>
                                <td class="px-4 py-3"><?= esc($sign['progress']) ?></td>

                                <?php if (in_array($role, ['admin', 'manager'])): ?>
                                    <td class="px-4 py-3 space-x-2">
                                        <a href="<?= base_url('admin/signs/edit/' . $sign['id']) ?>" class="bg-yellow-600 text-white px-3 py-1 rounded-md text-xs hover:bg-yellow-700 transition">
                                            Edit
                                        </a>
                                        <a href="<?= base_url('admin/signs/delete/' . $sign['id']) ?>" onclick="return confirm('Are you sure you want to delete this sign?')" class="bg-red-600 text-white px-3 py-1 rounded-md text-xs hover:bg-red-700 transition">
                                            Delete
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-400 mt-6">No signs have been assigned yet.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>