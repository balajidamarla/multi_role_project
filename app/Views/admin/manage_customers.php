<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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

            <div class="mb-4 relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <img src="<?= base_url('public/assets/filter.png') ?>" alt="Search" class="h-5 w-5 opacity-50" />
                </div>
                <input
                    type="search"
                    id="searchInput"
                    placeholder="Search customers..."
                    class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-indigo-500" />
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
                                    <td class="px-4 py-3 flex items-center gap-2">
                                        <img src="<?= base_url('public/assets/calendar.png') ?>" alt="Created At" class="w-4 h-4">
                                        <?= esc($customer['created_at']) ?>
                                    </td>
                                    <td class="px-4 py-3">

                                        <?php if (function_exists('has_permission') && has_permission('delete_customer')): ?>
                                            <a href="<?= base_url('admin/delete_customer/' . $customer['id']) ?>"
                                                onclick="return confirm('Are you sure you want to delete this customer?')"
                                                class="inline-flex items-center justify-center p-1 hover:opacity-80 transition"
                                                title="Delete">
                                                <img src="<?= base_url('public/assets/delete.png') ?>" alt="Delete" class="w-5 h-5">
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
</body>
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const query = this.value;

        fetch(`<?= base_url('admin/search_customers') ?>?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('tbody');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-gray-500 py-4">No customers found.</td></tr>';
                    return;
                }

                data.forEach(customer => {
                    tbody.innerHTML += `
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-4 py-3 font-medium text-indigo-600">
                            <a href="<?= base_url('admin/customers') ?>/${customer.id}" class="hover:underline">
                                ${customer.company_name}
                            </a>
                        </td>
                        <td class="px-4 py-3">${customer.first_name}</td>
                        <td class="px-4 py-3">${customer.last_name}</td>
                        <td class="px-4 py-3 flex items-center gap-2">
                            <img src="<?= base_url('public/assets/calendar.png') ?>" class="w-4 h-4">
                            ${customer.created_at}
                        </td>
                        <td class="px-4 py-3">
                            <?php if (function_exists('has_permission') && has_permission('delete_customer')): ?>
                                <a href="<?= base_url('admin/delete_customer') ?>/${customer.id}" 
                                   onclick="return confirm('Are you sure?')" 
                                   class="inline-flex items-center justify-center p-1 hover:opacity-80 transition"
                                   title="Delete">
                                   <img src="<?= base_url('public/assets/delete.png') ?>" class="w-5 h-5">
                                </a>
                            <?php else: ?>
                                <span class="text-gray-400 italic text-xs">Delete not allowed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                `;
                });
            });
    });
</script>

</html>


<?= $this->endSection() ?>