<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Multi Role Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" href="https://shop.ikegps.com/cdn/shop/files/new_sp_logo_1_e29d6529-a6ff-4f07-abeb-c7242c72d6d2.jpg?v=1731628628" type="image/x-icon" />
    <style>
        ::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800" x-data="{ sidebarOpen: true }">
    <?php
    $session = session();
    $role = $session->get('role');
    $mail = $session->get('email');
    $firstName = session('first_name');
    $lastName = session('last_name');
    $userRole = strtolower(trim($role));
    ?>

    <!-- Fixed Top Navbar -->
    <header class="fixed top-0 left-0 right-0 bg-gray-100 text-black h-14 flex items-center px-6 shadow-md z-50">
        <button @click="sidebarOpen = !sidebarOpen" class="text-black focus:outline-none mr-4" aria-label="Toggle Sidebar">
            <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <h1 class="text-xl font">SIGN<span class="ml-1 font-bold">PILOT</span></h1>
    </header>

    <!-- Sidebar and Main Content -->
    <div class="flex pt-14 min-h-screen">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-16'"
            class="fixed top-14 bottom-0 left-0 bg-gray-900 text-white flex-shrink-0 overflow-hidden flex flex-col transition-all duration-700 ease-in-out z-40">

            <!-- Sidebar Header with Logo -->
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                <div class="flex items-center space-x-3" x-show="sidebarOpen">
                    <img src="<?= base_url('public/assets/admin.png') ?>" alt="Logo" class="h-8 w-8 rounded-full object-cover" />
                    <div>
                        <div class="text-lg font-bold text-yellow-300 whitespace-nowrap">SignPilot Dashboard</div>
                        <div class="text-white text-sm">
                            <a href="<?= base_url('admin/roles/' . urlencode($role)) ?>" class="flex items-center gap-2 transition-all duration-500 hover:text-blue-400 font-semibold hover:scale-110">
                                <?php if (session()->has('first_name') && session()->has('last_name')): ?>
                                    <?= ucwords(session('first_name') . ' ' . session('last_name') . ' (' . ucfirst(session('role') . ')')) ?>
                                <?php endif; ?>

                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Navigation Links -->
            <nav class="flex flex-col gap-2  flex-1 overflow-auto">
                <?php if ($userRole === 'superadmin'): ?>
                    <a href="<?= base_url('superadmin/dashboard') ?>" class="flex items-center gap-2 transition-all duration-500 hover:text-blue-400 font-bold hover:scale-110 border-b-[0.5px] border-gray-800 hover:border-gray-700 px-4 py-2" :title="sidebarOpen ? '' : 'Dashboard'">Dashboard</a>
                    <a href="<?= base_url('superadmin/add_admin') ?>" class="flex items-center gap-2 transition-all duration-500 hover:text-blue-400 font-bold hover:scale-110 border-b-[0.5px] border-gray-800 hover:border-gray-700 px-4 py-2" :title="sidebarOpen ? '' : 'Add Admin'">Add Admin</a>
                <?php endif; ?>

                <?php if ($userRole === 'admin' || $userRole === 'salessurveyor'): ?>
                    <?php
                    $adminLinks = [
                        ['label' => 'Customers', 'url' => 'manage_customers', 'icon' => 'customers.png'],
                        ['label' => 'Projects', 'url' => 'projects', 'icon' => 'projects.png'],
                        ['label' => 'Teams', 'url' => 'teams', 'icon' => 'teams.png'],
                        ['label' => 'Signs', 'url' => 'signs', 'icon' => 'signs.png'],
                    ];
                    if ($userRole === 'admin') {
                        $adminLinks[] = ['label' => 'Roles', 'url' => 'roles', 'icon' => 'roles.png'];
                        $adminLinks[] = ['label' => 'Permissions', 'url' => 'permissions', 'icon' => 'permissions.png'];
                    }
                    ?>
                    <?php foreach ($adminLinks as $link): ?>
                        <a href="<?= base_url('admin/' . $link['url']) ?>"
                            class="flex items-center gap-2 transition-all duration-500 hover:text-blue-400 font-bold hover:scale-110 border-b-[0.5px] border-gray-800 hover:border-gray-700 px-4 py-2"
                            :title="sidebarOpen ? '' : '<?= $link['label'] ?>'">
                            <img src="<?= base_url('public/assets/' . $link['icon']) ?>" alt="<?= $link['label'] ?> Icon" class="h-8 w-8 flex-shrink-0" />
                            <span x-show="sidebarOpen" class="whitespace-nowrap"><?= $link['label'] ?></span>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if ($userRole === 'surveyorlite'): ?>
                    <a href="<?= base_url('admin/signs') ?>"
                        class="flex items-center gap-2 transition-all duration-500 hover:text-blue-400 font-bold hover:scale-110 border-b-[0.5px] border-gray-800 hover:border-gray-700 px-4 py-2"
                        :title="sidebarOpen ? '' : 'Signs'">
                        <img src="<?= base_url('public/assets/signs.png') ?>" alt="Signs Icon" class="h-8 w-8 flex-shrink-0" />
                        <span x-show="sidebarOpen" class="whitespace-nowrap">Signs</span>
                    </a>
                <?php endif; ?>

                <!-- Logout -->
                <a href="<?= base_url('auth/logout') ?>"
                    class="flex items-center gap-2 transition-all duration-500 text-red-600 hover:text-red-400 font-bold hover:scale-110 px-4 py-2"
                    :title="sidebarOpen ? '' : 'Logout'">
                    <img src="<?= base_url('public/assets/logout.png') ?>" alt="Logout Icon" class="h-8 w-8 flex-shrink-0" />
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Logout</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main :class="sidebarOpen ? 'ml-64' : 'ml-16'" class="transition-all duration-700 ease-in-out flex-1 p-6">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</body>

</html>