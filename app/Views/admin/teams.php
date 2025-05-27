<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<?php if (function_exists('has_permission') && has_permission('view_teams')): ?>
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-semibold text-black">Manage Team Members</h3>
            <?php if (has_permission('create_team')): ?>
                <a href="<?= base_url('admin/teams/create') ?>" class="bg-gray-900 text-white hover:bg-gray-900 px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                    + Add Member
                </a>
            <?php else: ?>
                <span class="text-sm text-gray-600 italic">Add Member not allowed</span>
            <?php endif; ?>

        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($teams)): ?>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
                    <thead class="bg-gray-900 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">First Name</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Last Name</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Role</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Assigned Signs</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Date Added</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($teams as $member): ?>
                            <tr class="hover:bg-gray-100 transition">
                                <td class="px-4 py-3"><?= esc($member['first_name']) ?></td>
                                <td class="px-4 py-3"><?= esc($member['last_name']) ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <img src="<?= base_url('public/assets/mail.png') ?>" alt="Email Icon" class="w-4 h-4">
                                        <?= esc($member['email']) ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3"><?= ucfirst(str_replace('_', ' ', esc($member['role']))) ?></td>
                                <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded
                                    <?= esc($member['status']) === 'active' ? 'bg-green-200 text-green-800' : 'bg-gray-300 text-gray-700' ?>">
                                        <?= ucfirst(esc($member['status'])) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3">0</td> <!-- TODO: Replace with actual count -->
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <img src="<?= base_url('public/assets/calendar.png') ?>" alt="Calendar Icon" class="w-4 h-4">
                                        <?= date('d-m-Y', strtotime($member['created_at'])) ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if (has_permission('delete_team')): ?>

                                        <a href="<?= base_url('admin/teams/delete/' . $member['id']) ?>"
                                            onclick="return confirm('Are you sure you want to delete this team member?')"
                                            class="inline-flex items-center justify-center p-1 hover:opacity-80 transition"
                                            title="Delete">
                                            <img src="<?= base_url('public/assets/delete.png') ?>" alt="Delete" class="w-5 h-5">
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-500 text-xs">Delete not allowed</span>
                                    <?php endif; ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-400 mt-6">No team members found.</p>
        <?php endif; ?>
    <?php else: ?>
        <p class="max-w-1xl mx-auto  text-red-500 font-semibold">You do not have permission to view Teams.</p>
    <?php endif; ?>
    </div>

    <?= $this->endSection() ?>