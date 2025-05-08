<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="max-w-6xl mx-auto p-6 bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (!empty($projects)): ?>
    <div class="max-w-6xl mx-auto p-6">
        <h2 class="text-2xl font-semibold text-white mb-4">Project List</h2>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm divide-y divide-gray-200 text-gray-800">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Customer Info</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Project Name</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Assigned To</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Signs</th>
                        <?php if ($role !== 'salessurveyor'): ?>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($projects as $project): ?>
                        <tr class="hover:bg-gray-100 transition">
                            <td class="px-4 py-3 text-sm">
                                <a href="<?= base_url('admin/projects/view/' . $project['id']) ?>" class="text-indigo-600 font-medium hover:underline">
                                    <?= esc($project['customer_name']) ?>
                                </a>
                                <div class="text-gray-600 text-xs">
                                    <?= esc($project['customer_address']) ?><br>
                                    Zip: <?= esc($project['zipcode']) ?><br>
                                    Contact: <?= esc($project['contact_info']) ?><br>
                                    Created: <?= date('Y-m-d', strtotime($project['customer_created_at'])) ?>
                                </div>
                            </td>
                            <td class="px-4 py-3"><?= esc($project['name']) ?></td>
                            <td class="px-4 py-3"><?= esc($project['status']) ?></td>
                            <td class="px-4 py-3"><?= esc($project['assigned_to_name'] ?? 'Unassigned') ?></td>
                            <td class="px-4 py-3">
                                <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                                    <?php
                                    $db = \Config\Database::connect();
                                    $signs = $db->table('signs')->where('project_id', $project['id'])->get()->getResultArray();
                                    foreach ($signs as $sign) {
                                        echo "<li><span class='font-medium'>" . esc($sign['sign_description']) . "</span><br><small>Due: " . esc($sign['due_date']) . "</small></li>";
                                    }
                                    ?>
                                </ul>
                            </td>
                            <?php if ($role !== 'salessurveyor'): ?>
                                <td class="px-4 py-3 space-x-2">
                                    <a href="<?= base_url('admin/projects/edit/' . $project['id']) ?>" class="inline-block px-3 py-1 bg-black text-white text-xs rounded hover:bg-gray-800 transition">Edit</a>
                                    <a href="<?= base_url('admin/projects/delete/' . $project['id']) ?>" onclick="return confirm('Are you sure?')" class="inline-block px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">Delete</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <p class="text-gray-400 text-center mt-6">No projects found.</p>
<?php endif; ?>

<?= $this->endSection() ?>