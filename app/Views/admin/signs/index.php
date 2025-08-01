make it responsive without changing any thing"<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body>


    <?php if (function_exists('has_permission') && has_permission('view_signs')): ?>
        <div class="max-w-7xl mx-auto p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-semibold text-black">Manage Signs</h3>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4" role="alert">
                    <strong class="font-bold">Success! </strong>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php
            $session = session();
            $role = $session->get('role'); // Ensure 'role' is set in session
            $userId = $session->get('user_id'); // Used to limit visibility to assigned signs
            ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($signs)): ?>
                <div class="flex flex-wrap gap-4 mb-4">
                    <!-- Project Name Input -->
                    <div class="relative w-[20%] min-w-[200px] max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <img src="<?= base_url('public/assets/filter.png') ?>" alt="Filter" class="h-5 w-5 opacity-50" />
                        </div>
                        <input
                            type="search"
                            id="searchInput"
                            placeholder="Search Sign Name..."
                            class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-indigo-500" />

                    </div>

                    <!-- Assigned To Input -->
                    <!-- <div class="relative w-[20%] min-w-[200px] max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <img src="<//?= base_url('public/assets/filter.png') ?>" alt="Filter" class="h-5 w-5 opacity-50" />
                        </div>
                        <input
                            type="search"
                            id="searchAssigned"
                            placeholder="Assigned to..."
                            class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-indigo-500" />
                    </div> -->
                </div>

                <div class="overflow-x-auto bg-white shadow-md rounded-lg">

                    <table class="w-[100%] divide-y divide-gray-200 text-sm text-gray-800">
                        <thead class="bg-gray-900 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Sign Name</th>
                                <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Customer</th>
                                <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Project</th>
                                <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Assigned To</th>
                                <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">In / Out</th>
                                <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Due Date</th>

                                <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Status</th>
                                <?php if (in_array($role, ['admin', 'salessurveyor'])): ?>
                                    <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Actions</th>
                                <?php endif; ?>
                                <?php if (in_array($role, ['surveyorlite'])): ?>
                                    <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Actions</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody id="signsTableBody" class="divide-y divide-gray-200">
                            <?php foreach ($signs as $sign): ?>
                                <?php
                                // Allow access if the user is assigned OR is an admin/manager/salessurveyor
                                if ($sign['assigned_to'] == $userId || in_array($role, ['admin', 'salessurveyor'])):
                                ?>
                                    <tr class="hover:bg-gray-100 transition">
                                        <td class="px-4 py-3"><?= esc($sign['sign_name']) ?></td>
                                        <td class="px-4 py-3"><?= esc($sign['customer_name']) ?></td>
                                        <td class="px-4 py-3"><?= esc($sign['project_name']) ?></td>

                                        <td class="px-4 py-3">
                                            <?php
                                            $assignedUser = array_filter($users, fn($u) => $u['id'] == $sign['assigned_to']);
                                            $assignedUser = reset($assignedUser);

                                            $isSelf = $assignedUser && (int) $assignedUser['id'] === (int) $userId;
                                            $displayName = $isSelf
                                                ? 'Self'
                                                : ($assignedUser
                                                    ? esc($assignedUser['first_name'] . ' ' . $assignedUser['last_name']) . ' (' . ucfirst($assignedUser['role']) . ')'
                                                    : 'Unassigned');
                                            ?>

                                            <?php if (in_array($role, ['admin', 'salessurveyor'])): ?>
                                                <form action="<?= base_url('admin/signs/updateAssignment/' . $sign['id']) ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <select name="assigned_to" class="form-select form-select-sm px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500" onchange="this.form.submit()">
                                                        <?php foreach ($users as $user): ?>
                                                            <?php
                                                            $isSelected = $user['id'] == $sign['assigned_to'];
                                                            $label = ((int) $user['id'] === (int) $userId) ? 'Self' : esc($user['first_name'] . ' ' . $user['last_name']) . ' (' . ucfirst($user['role']) . ')';
                                                            ?>
                                                            <option value="<?= $user['id'] ?>" <?= $isSelected ? 'selected' : '' ?>>
                                                                <?= $label ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </form>
                                            <?php else: ?>
                                                <?= $displayName ?>
                                            <?php endif; ?>
                                        </td>



                                        <td class="px-4 py-3"><?= esc($sign['sign_type']) ?></td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <img src="<?= base_url('public/assets/due date.png') ?>" alt="Calendar Icon" class="w-4 h-4">

                                                <?php if (has_permission('add_due_date')): ?>
                                                    <form method="post" action="<?= site_url('signs/setDueDate') ?>" style="display: inline;" id="dueDateForm-<?= $sign['id'] ?>">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="sign_id" value="<?= esc($sign['id']) ?>">

                                                        <span
                                                            style="cursor: pointer; color: <?= empty($sign['due_date']) ? 'red' : 'gray-700' ?>;"
                                                            onclick="document.getElementById('datePicker-<?= $sign['id'] ?>').showPicker()"
                                                            title="Click to select/change due date">
                                                            <?= !empty($sign['due_date']) ? esc(date('d/m/Y', strtotime($sign['due_date']))) : 'No Date' ?>
                                                        </span>

                                                        <input
                                                            type="date"
                                                            name="due_date"
                                                            id="datePicker-<?= $sign['id'] ?>"
                                                            style="width: 1px; height: 1px; opacity: 0; border: none; padding: 0; margin: 0; cursor: pointer;"
                                                            value="<?= !empty($sign['due_date']) ? date('Y-m-d', strtotime($sign['due_date'])) : '' ?>"
                                                            onchange="document.getElementById('dueDateForm-<?= $sign['id'] ?>').submit()">
                                                    </form>
                                                <?php else: ?>
                                                    <?php if (!empty($sign['due_date'])): ?>
                                                        <?= esc(date('d/m/Y', strtotime($sign['due_date']))) ?>
                                                    <?php else: ?>
                                                        <span style="color: gray;">No Date</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>



                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <img src="<?= base_url('public/assets/status.png') ?>" alt="Progress Icon" class="w-4 h-4">
                                                <?= esc($sign['progress'] ?? 'Pending') ?: 'Pending' ?>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3 space-x-2 flex">
                                            <?php if ($role === 'surveyorlite'): ?>
                                                <a href="<?= base_url('admin/signs/view/' . $sign['id']) ?>"
                                                    class="bg-blue-600 text-white px-3 py-1 rounded-md text-xs hover:bg-blue-700 transition">
                                                    View
                                                </a>
                                            <?php else: ?>
                                                <?php if ($role === 'admin' || has_permission('edit_sign')): ?>


                                                    <a href="<?= base_url('admin/signs/edit/' . $sign['id']) ?>"
                                                        class="inline-flex items-center justify-center p-1 hover:opacity-80 transition"
                                                        title="edit">
                                                        <img src="<?= base_url('public/assets/edit.png') ?>" alt="edit" class="w-5 h-5">
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-gray-500 text-xs">Edit not allowed</span>
                                                <?php endif; ?>

                                                <?php if ($role === 'admin' || has_permission('delete_sign')): ?>


                                                    <a href="<?= base_url('admin/signs/delete/' . $sign['id']) ?>"
                                                        onclick="return confirm('Are you sure you want to delete this sign')"
                                                        class="inline-flex items-center justify-center p-1 hover:opacity-80 transition"
                                                        title="Delete">
                                                        <img src="<?= base_url('public/assets/delete.png') ?>" alt="Delete" class="w-5 h-5">
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-gray-500 text-xs">Delete not allowed</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>


                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
                <div class="mt-6 flex justify-center">
                    <?= $pager->links('default', 'tailwind_full') ?>
                </div>
            <?php else: ?>
                <p class="text-gray-400 mt-6">No signs have been assigned yet.</p>
            <?php endif; ?>
        <?php else: ?>
            <p class="max-w-6xl mx-auto text-red-500 font-semibold">You do not have permission to view signs.</p>
        <?php endif; ?>
        </div>
</body>


<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const query = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('#signsTableBody tr');

        rows.forEach(row => {
            const signNameCell = row.querySelector('td');
            const signName = signNameCell ? signNameCell.textContent.toLowerCase() : '';
            row.style.display = signName.includes(query) ? '' : 'none';
        });
    });
</script>

</html>

<?= $this->endSection() ?>