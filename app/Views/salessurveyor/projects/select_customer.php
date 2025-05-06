<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<h2>Select a Customer to View Projects</h2>

<table class="table">
    <thead>
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= esc($customer['company_name']) ?></td>
                <td><?= esc($customer['first_name']) ?> <?= esc($customer['last_name']) ?></td>
                <td><?= esc($customer['address1']) ?> <?= esc($customer['zipcode']) ?></td>
                <td>
                    <a href="<?= base_url('salessurveyor/customers/show/' . $customer['id']) ?>" class="btn btn-primary">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>