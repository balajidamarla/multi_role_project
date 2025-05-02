<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <div class="container mt-4">
        <h3>Assign New Sign</h3>
        <form method="post" action="<?= base_url('admin/signs/store') ?>">
            <?= csrf_field() ?>

            <div class="form-group mb-2">
                <label>Project</label>
                <select name="project_id" class="form-control" required>
                    <?php foreach ($projects as $project): ?>
                        <option value="<?= $project['id'] ?>"><?= esc($project['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group mb-2">
                <label>Assign To</label>
                <select name="assigned_to" class="form-control" required>
                    <?php foreach ($teamMembers as $member): ?>
                        <option value="<?= $member['id'] ?>">
                            <?= esc($member['first_name'] . ' ' . $member['last_name']) ?> (<?= esc($member['role']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group mb-2">
                <label>Sign Description</label>
                <textarea name="sign_description" class="form-control" required></textarea>
            </div>

            <div class="form-group mb-2">
                <label>Sign Type</label>
                <input type="text" name="sign_type" class="form-control" required>
            </div>

            <div class="form-group mb-2">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="form-group mb-2">
                <label>Completion Date</label>
                <input type="date" name="completion_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Assign Sign</button>
        </form>
    </div>
</body>

</html>
<?= $this->endSection() ?>