<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<?php if (function_exists('has_permission') && has_permission('view_customer')): ?>
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-semibold text-black">Manage Customers</h3>
            <?php if (function_exists('has_permission') && has_permission('create_customer')): ?>
                <a href="<?= base_url('admin/add_customer') ?>" class="bg-gray-900 text-white hover:bg-gray-700 px-4 py-2 rounded-md text-sm font-medium transition duration-300">
                    Add Customer
                </a>
            <?php else: ?>
                <span class="text-sm text-gray-600 italic">Add Customer not allowed</span>
            <?php endif; ?>
        </div>

        

        <?php if (!empty($customers)): ?>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="w-full divide-y divide-gray-200 text-sm text-gray-800">
                    <thead class="bg-gray-900 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Company Name</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">First Name</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Last Name</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Date Added</th>
                            <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($customers as $customer): ?>
                            <tr class="hover:bg-gray-100 transition">
                                <td class="px-4 py-3 font-medium text-indigo-600">
                                    <a href="<?= base_url('admin/customers/' . $customer['id']) ?>" class="hover:underline">
                                        <?= esc($customer['company_name']) ?>
                                    </a>
                                </td>
                                <td class="px-4 py-3"><?= esc($customer['first_name']) ?></td>
                                <td class="px-4 py-3"><?= esc($customer['last_name']) ?></td>
                                <td class="px-4 py-3"><?= esc($customer['created_at']) ?></td>
                                <td class="px-4 py-3">
                                    <?php if (function_exists('has_permission') && has_permission('delete_customer')): ?>
                                        <a href="<?= base_url('admin/delete_customer/' . $customer['id']) ?>"
                                            onclick="return confirm('Are you sure you want to delete this customer?')"
                                            class="bg-red-600 text-white px-3 py-1 rounded-md text-xs hover:bg-red-700 transition">
                                            Delete
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic text-xs">Delete not allowed</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-400 mt-6">No customers found...</p>
        <?php endif; ?>
    <?php else: ?>
        <p class="text-red-500 font-semibold">You do not have permission to view customers.</p>
    <?php endif; ?>
    </div>

    <?= $this->endSection() ?>