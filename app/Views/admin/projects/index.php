<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<?php if (function_exists('has_permission') && has_permission('view_project')): ?>

    <div class="max-w-6xl mx-auto p-6 flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-black mb-4">Project List</h2>
        <?php if (has_permission('create_project')): ?>
            <a href="<?= base_url('admin/projects/create') ?>" class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-800 text-sm font-medium transition">
                + Add Project
            </a>
        <?php else: ?>
            <span class="text-gray-600 text-sm">Create not allowed</span>
        <?php endif; ?>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="max-w-6xl mx-auto p-6 bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($projects)): ?>
        <div class="max-w-6xl mx-auto px-6">
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="w-[100%] text-sm divide-y divide-gray-200 text-gray-800">
                    <thead class="bg-gray-900 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Customer Info</th>
                            <!-- <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Company Name</th> -->
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Project Name</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Assigned To</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Signs</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Actions</th>
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
                                        Created: <?= date('d-m-Y', strtotime($project['customer_created_at'])) ?>
                                    </div>
                                </td>


                                <td class="px-4 py-3"><?= esc($project['name']) ?></td>

                                <td class="px-4 py-3">
                                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                                        <?php if (!empty($signsByProject[$project['id']])): ?>
                                            <?php foreach ($signsByProject[$project['id']] as $sign): ?>
                                                <li>
                                                    <small>Status:</small>
                                                    <span class="font-medium">
                                                        <?= esc($sign['progress']) ?>
                                                    </span>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li><em>No signs assigned</em></li>
                                        <?php endif; ?>
                                    </ul>
                                </td>


                                <td class="px-4 py-3">
                                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                                        <?php if (!empty($signsByProject[$project['id']])): ?>
                                            <?php foreach ($signsByProject[$project['id']] as $sign): ?>
                                                <li>
                                                    <small>Assigned to : </small>
                                                    <span class="font-medium">
                                                        <?php
                                                        $assignedUserId = $sign['assigned_to'];
                                                        // echo 'Assigned User ID: ' . $assignedUserId . '<br>';
                                                        // echo 'Logged-in User ID: ' . $user_id . '<br>';

                                                        // Check if the assigned user is the logged-in user
                                                        if ($assignedUserId == $user_id) {
                                                            echo 'Self';  // Display "Self" if the assigned user is the logged-in user
                                                        } else {
                                                            echo esc($sign['assigned_to_name']);  // Display the assigned name if different
                                                        }
                                                        ?>
                                                    </span>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li><em>No signs assigned</em></li>
                                        <?php endif; ?>
                                    </ul>
                                </td>



                                <td class="px-4 py-3">
                                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                                        <?php if (!empty($signsByProject[$project['id']])): ?>
                                            <?php foreach ($signsByProject[$project['id']] as $sign): ?>
                                                <li>
                                                    <span class="font-medium"><?= esc($sign['sign_description']) ?></span><br>
                                                    <small>Due Date: <?= date('d-m-Y', strtotime($sign['due_date'])) ?></small>

                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li><em>No signs found</em></li>
                                        <?php endif; ?>
                                    </ul>
                                </td>
                                <td class="px-4 py-3 space-x-2">
                                    <?php if (has_permission('update_project')): ?>
                                        <a href="<?= base_url('admin/projects/edit/' . $project['id']) ?>" class="inline-block px-3 py-1 bg-yellow-400 text-white text-xs rounded hover:bg-yellow-500 transition">
                                            Edit
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-xs">Edit not allowed</span>
                                    <?php endif; ?>

                                    <?php if (has_permission('delete_project')): ?>
                                        <a href="<?= base_url('admin/projects/delete/' . $project['id']) ?>" onclick="return confirm('Are you sure?')" class="inline-block px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">
                                            Delete
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-xs">Delete not allowed</span>
                                    <?php endif; ?>


                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <p class="max-w-6xl mx-auto p-6 flex justify-between mb-4">No projects found.</p>
    <?php endif; ?>
<?php else: ?>
    <p class="max-w-6xl mx-auto p-6 text-red-500 font-semibold">You do not have permission to view projects.</p>
<?php endif; ?>

<?= $this->endSection() ?>