<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-semibold text-white">Manage Customers</h3>
        <a href="<?= base_url('admin/add_customer') ?>" class="bg-black text-white hover:bg-gray-900 px-4 py-2 rounded-md text-sm font-medium transition duration-300">
            Add Customer
        </a>
    </div>

    <?php if (!empty($customers)): ?>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
                <thead class="bg-black text-white">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Company Name</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">First Name</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Last Name</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Date Added</th>
                        <th class="px-4 py-3 text-left font-medium uppercase tracking-wider">Delete</th>
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
                                <a href="<?= base_url('admin/delete_customer/' . $customer['id']) ?>" onclick="return confirm('Are you sure?')" class="bg-red-600 text-white px-3 py-1 rounded-md text-xs hover:bg-red-700 transition">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-400 mt-6">No customers found.</p>
    <?php endif; ?>
</div>


<?= $this->endSection() ?>