<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Role Project</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .nav-link-hover:hover {
            text-decoration: underline;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .text-bright-red {
            color: #ff4d4d !important;
            /* Brighter red */
        }

        .navbar-brand span {
            font-weight: bold;
            color: #f39c12;
            /* Adding a vibrant yellow */
        }

        .navbar-nav .nav-link {
            font-weight: bold;
            font-size: 1.2rem;
            /* Adjusting font size */
        }

        .navbar-nav .nav-link:hover {
            background-color: #2c3e50;
            /* Slightly darkens on hover */
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <!--  Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <?php
            $role = session()->get('role'); // get the logged-in user role
            $dashboardLink = '#';
            $panelLabel = '';

            switch ($role) {
                case 'superadmin':
                    $dashboardLink = base_url('superadmin/dashboard');
                    $panelLabel = 'Super Admin Panel';
                    break;
                case 'admin':
                    $dashboardLink = base_url('admin/dashboard');
                    $panelLabel = 'Admin Panel';
                    break;
                case 'sales_surveyor':
                    $dashboardLink = base_url('sales/dashboard');
                    $panelLabel = 'Sales Surveyor Panel';
                    break;
                case 'surveyor_lite':
                    $dashboardLink = base_url('lite/dashboard');
                    $panelLabel = 'Surveyor Lite Panel';
                    break;
            }
            ?>

            <a class="navbar-brand" href="<?= $dashboardLink ?>">
                SignPilot Dashboard // <span><?= esc($panelLabel) ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">

                    <!-- Dashboard (Visible to All Except Admin) -->
                    <?php if ($role !== 'admin'): ?>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white nav-link-hover" href="<?= $dashboardLink ?>">Dashboard</a>
                        </li>
                    <?php endif; ?>

                    <!-- Super Admin only -->
                    <?php if ($role === 'superadmin'): ?>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white nav-link-hover" href="<?= base_url('superadmin/add_admin') ?>">Add Admin</a>
                        </li>
                    <?php endif; ?>

                    <!-- Admin only -->
                    <?php if ($role === 'admin'): ?>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white nav-link-hover" href="<?= base_url('admin/manage_customers') ?>">Customers</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white nav-link-hover" href="<?= base_url('admin/manage_projects') ?>">Projects</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white nav-link-hover" href="<?= base_url('admin/teams') ?>">Teams</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white nav-link-hover" href="<?= base_url('admin/signs/create') ?>">Assign Sign</a>
                        </li>

                    <?php endif; ?>

                    <!-- Sales Surveyor only -->
                    <?php if ($role === 'sales_surveyor'): ?>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white nav-link-hover" href="<?= base_url('sales/assigned_tasks') ?>">Assigned Tasks</a>
                        </li>
                    <?php endif; ?>

                    <!-- Surveyor Lite only -->
                    <?php if ($role === 'surveyor_lite'): ?>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-white nav-link-hover" href="<?= base_url('lite/tasks') ?>">My Tasks</a>
                        </li>
                    <?php endif; ?>

                    <!-- Logout (Visible to All) -->
                    <li class="nav-item mx-2">
                        <a class="nav-link text-danger nav-link-hover" href="<?= base_url('auth/logout') ?>">Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!--  Navbar End -->

    <!-- Content Section Start -->
    <div class="container mt-5">
        <?= $this->renderSection('content') ?>
    </div>
    <!-- Content Section End -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>