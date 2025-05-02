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
    <h2>Admin Dashboard</h2>
    <p>Welcome, <?= session()->get('email') ?></p>

</body>

</html>
<?= $this->endSection() ?>