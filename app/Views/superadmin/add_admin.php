<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mt-5 text-center">Register Admin</h2>

                <!-- Display errors or success messages -->
                <?php if ($errors = session()->get('error')): ?>
                    <div class="alert alert-danger">
                        <?php if (is_array($errors)): ?>
                            <ul class="mb-0 pl-3">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <?= esc($errors) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success = session()->get('success')): ?>
                    <div class="alert alert-success">
                        <?= esc($success) ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('superadmin/create_admin') ?>">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" value="<?= old('name') ?>" placeholder="Enter name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" value="<?= old('email') ?>" placeholder="Enter email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter password" required>
                    </div>

                    <!-- Fixed role as Admin -->
                    <input type="hidden" name="role" value="Admin">

                    <button type="submit" class="btn btn-primary btn-block btn-sm">Register Admin</button>
                </form>

                
            </div>
        </div>
    </div>


</body>

</html>
<?= $this->endSection() ?>
