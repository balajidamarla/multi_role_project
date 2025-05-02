<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Add New Project</h3>
    <form method="post" action="<?= base_url('admin/projects/store') ?>">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label for="customer_id">Customer</label>
            <select name="customer_id" class="form-control" required>
                <option value="">Select Customer</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?= esc($customer['id']) ?>"><?= esc($customer['company_name']) ?> - <?= esc($customer['first_name']) ?> <?= esc($customer['last_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="name">Project Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>

        <div class="form-group">
            <label for="assigned_to">Assigned To</label>
            <input type="text" name="assigned_to" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success mt-2">Add Project</button>
    </form>
</div>

<?= $this->endSection() ?>
