<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<h2 class="mb-3">Customer Dashboard</h2>

<div class="container-fluid p-0">
    <div class="row border mb-5" style="margin-left: 0; margin-right: 0;">
        <div class="col-md-2">
            <strong>Address</strong><br>
            <?= esc($customer['address1']) ?><br>
            <?= esc($customer['city_state']) ?><br>
            <?= esc($customer['zipcode']) ?>

        </div>
        <div class="col-md-2">
            <strong>Primary Contact</strong><br>
            <?= esc($customer['first_name']) ?> <?= esc($customer['last_name']) ?><br>
            <?= esc($customer['phone']) ?><br>
            <?= esc($customer['email'] ?? 'N/A') ?>
        </div>
        <div class="col-md-2">
            <strong>Date Added</strong><br>
            <?= date('d-m-Y', strtotime($customer['created_at'])) ?>
        </div>
        <div class="col-md-2">
            <strong>Tasks:</strong><br>
            <?= $signCount ?>
        </div>
        <div class="col-md-2">
            <strong>Notes</strong><br>
            <?= esc($customer['notes'] ?? 'No notes') ?>
        </div>
        <div class="col-md-2 d-flex align-items-center">
            <!-- Flexbox ensures buttons stay on the same line -->
           
            <a href="<?= base_url('admin/customers/report/' . $customer['id']) ?>" class="btn btn-primary btn-sm">Report</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>