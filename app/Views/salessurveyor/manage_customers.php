<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Manage Customers</h3>
    <a href="<?= base_url('admin/add_customer') ?>" class="btn btn-primary mb-3">Add Customer</a>

    <?php if (!empty($customers)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date Added</th>
                    <!-- <th>Delete</th> -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td>
                            <a href="<?= base_url('salessurveyor/customers/' . $customer['id']) ?>">
                                <?= esc($customer['company_name']) ?>
                            </a>
                        </td>
                        <td><?= esc($customer['first_name']) ?></td>
                        <td><?= esc($customer['last_name']) ?></td>
                        <td><?= esc($customer['created_at']) ?></td>
                       
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">No customers found.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>