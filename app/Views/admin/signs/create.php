<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Create New Sign</h3>

    <form action="<?= base_url('admin/signs/store') ?>" method="post">
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">1. Sign Setup</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="sign_name" class="form-label">Sign Name</label>
                    <input type="text" name="sign_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="project_id" class="form-label">Project</label>
                    <select name="project_id" class="form-select" required>
                        <?php foreach ($projects as $project): ?>
                            <option value="<?= $project['id'] ?>"><?= $project['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="customer_id" class="form-label">Customer</label>
                    <select name="customer_id" class="form-select" required>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?= $customer['id'] ?>"><?= $customer['first_name'] . ' ' . $customer['last_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="assigned_to" class="form-label">Assign To</label>
                    <select name="assigned_to" class="form-select" required>
                        <?php foreach ($surveyors as $user): ?>
                            <option value="<?= $user['id'] ?>"><?= $user['email'] ?> (<?= $user['role'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="sign_type" class="form-label">Sign Type</label>
                    <select name="sign_type" class="form-select" required>
                        <option value="Physical Sign">Physical Sign</option>
                        <option value="Survey">Survey</option>
                        <option value="Digital Sign">Digital Sign</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="sign_description" class="form-label">Sign Description</label>
                    <textarea name="sign_description" class="form-control" required></textarea>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-dark text-white">2. Sign Details</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Assigned">Assigned</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" name="due_date" class="form-control" required>
                </div>
                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" class="form-control" required></textarea>
                </div>
            </div>
        </div>

        <div class="text-end mb-5">
            <button type="submit" class="btn btn-primary">Create Sign</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>