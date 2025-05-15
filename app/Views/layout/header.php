<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Role Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
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
    <nav class="bg-gray-900 text-white" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <?php
                $role = session()->get('role');
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
                    case 'salessurveyor':
                         $dashboardLink = base_url('admin/dashboard'); // shared dashboard
                        $panelLabel = 'Sales Surveyor Panel';
                        break;
                    case 'surveyor_lite':
                        $dashboardLink = base_url('lite/dashboard');
                        $panelLabel = 'Surveyor Lite Panel';
                        break;
                }
                ?>

                <!-- Logo / Brand -->
                <div class="flex-shrink-0">
                    <a href="<?= $dashboardLink ?>" class="text-lg font-bold text-white hover:text-blue-400 transition-all duration-200">
                        SignPilot Dashboard //<span class="text-yellow-300"> <?= esc($panelLabel) ?></span>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="open = !open" type="button" class="text-gray-400 hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Desktop Nav -->
                <div class="hidden md:flex md:items-center md:space-x-6">
                    <?php $role = strtolower(trim($role)); ?>

                    <?php if ($role === 'superadmin'): ?>
                        <a href="<?= base_url('superadmin/dashboard') ?>" class="transition-all duration-200 hover:text-blue-400 font-bold hover:scale-105">Dashboard</a>
                        <a href="<?= base_url('superadmin/add_admin') ?>" class="transition-all duration-200 hover:text-blue-400 font-bold hover:scale-105">Add Admin</a>
                    <?php endif; ?>

                    <?php if ($role === 'admin'): ?>
                        <a href="<?= base_url('admin/manage_customers') ?>" class="transition-all duration-200 hover:text-blue-400 font-bold hover:scale-105">Customers</a>
                        <a href="<?= base_url('admin/projects') ?>" class="transition-all duration-200 hover:text-blue-400 font-bold hover:scale-105">Projects</a>
                        <a href="<?= base_url('admin/teams') ?>" class="transition-all duration-200 hover:text-blue-400 font-bold hover:scale-105">Teams</a>
                        <a href="<?= base_url('admin/signs') ?>" class="transition-all duration-200 hover:text-blue-400 font-bold hover:scale-105">Signs</a>
                    <?php endif; ?>

                    <?php if ($role === 'salessurveyor'): ?>
                        <a href="<?= base_url('admin/manage_customers') ?>" class="transition-all duration-200 hover:text-blue-400 font-bold hover:underline hover:scale-105">Customers</a>
                        <a href="<?= base_url('admin/projects') ?>" class="transition-all duration-200 hover:text-blue-400 font-bold hover:underline hover:scale-105">Projects</a>
                        <a href="<?= base_url('admin/teams') ?>" class="transition-all duration-200 hover:text-blue-400 font-bold hover:underline hover:scale-105">Teams</a>
                        <a href="<?= base_url('admin/signs') ?>" class="transition-all duration-200 hover:text-blue-400 font-bold hover:underline hover:scale-105">Signs</a>
                    <?php endif; ?>

                    <?php if ($role === 'surveyor lite'): ?>
                        <a href="<?= base_url('lite/tasks') ?>" class="transition-all duration-200 hover:text-blue-400 hover:underline hover:scale-105">My Tasks</a>
                    <?php endif; ?>

                    <a href="<?= base_url('auth/logout') ?>" class="text-red-500 transition-all duration-200 hover:text-red-400 hover:underline hover:scale-105">Logout</a>
                </div>
            </div>
        </div>

        <!-- Mobile Nav -->
        <div x-show="open" class="md:hidden px-4 pb-4 space-y-2">
            <?php if ($role === 'superadmin'): ?>
                <a href="<?= base_url('superadmin/add_admin') ?>" class="block transition-all duration-200 hover:text-blue-400 hover:underline hover:scale-105">Add Admin</a>
            <?php endif; ?>

            <?php if ($role === 'admin'): ?>
                <a href="<?= base_url('admin/manage_customers') ?>" class="block transition-all duration-200 hover:text-blue-400 hover:underline hover:scale-105">Customers</a>
                <a href="<?= base_url('admin/projects') ?>" class="block transition-all duration-200 hover:text-blue-400 hover:underline hover:scale-105">Projects</a>
                <a href="<?= base_url('admin/teams') ?>" class="block transition-all duration-200 hover:text-blue-400 hover:underline hover:scale-105">Teams</a>
                <a href="<?= base_url('admin/signs') ?>" class="block transition-all duration-200 hover:text-blue-400 hover:underline hover:scale-105">Signs</a>
            <?php endif; ?>

            <?php if ($role === 'salessurveyor'): ?>
                <a href="<?= base_url('salessurveyor/manage_customers') ?>" class="block transition-all duration-200 hover:text-blue-400 hover:underline hover:scale-105">Customers</a>
                <a href="<?= base_url('salessurveyor/projects') ?>" class="block transition-all duration-200 hover:text-blue-400 hover:underline hover:scale-105">Projects</a>
                <a href="<?= base_url('salessurveyor/teams') ?>" class="block transition-all duration-200 hover:text-blue-400 hover:underline hover:scale-105">Teams</a>
                <a href="<?= base_url('salessurveyor/signs') ?>" class="block transition-all duration-200 hover:text-blue-400 hover:underline hover:scale-105">Signs</a>
            <?php endif; ?>

            <?php if ($role === 'surveyor_lite'): ?>
                <a href="<?= base_url('lite/tasks') ?>" class="block transition-all duration-200 hover:text-blue-400 hover:underline hover:scale-105">My Tasks</a>
            <?php endif; ?>

            <a href="<?= base_url('auth/logout') ?>" class="block text-red-500 transition-all duration-200 hover:text-red-400 hover:underline hover:scale-105">Logout</a>
        </div>
    </nav>


    <!--  Navbar End -->

    <!-- Content Section Start -->
    <div class="container mt-5 mx-auto">
        <?= $this->renderSection('content') ?>
    </div>
    <!-- Content Section End -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->

</body>

</html>