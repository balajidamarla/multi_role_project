<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="w-2/3 mx-auto max-h-screen flex items-center justify-center p-10 bg-gray-100 text-black ">
    <div class="w-full max-w-md bg-white border border-gray rounded-xl p-8 shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Register Admin</h2>

        <!-- Error messages -->
        <?php if ($errors = session()->get('error')): ?>
            <div class="mb-4 bg-red-700 text-white p-4 rounded-lg">
                <?php if (is_array($errors)): ?>
                    <ul class="list-disc pl-5">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <?= esc($errors) ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Success message -->
        <?php if ($success = session()->get('success')): ?>
            <div class="mb-4 bg-green-700 text-white p-4 rounded-lg">
                <?= esc($success) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('superadmin/create_admin') ?>" class="space-y-4">
            <?= csrf_field() ?>

            <div>
                <label for="name" class="block text-sm font-medium mb-1">First Name</label>
                <input type="text" id="name" name="first_name" value="<?= old('name') ?>" placeholder="Enter name"
                    class="w-full p-2 rounded-lg bg-white border border-gray-400 focus:ring-2 focus:ring-white" required>
            </div>
            <div>
                <label for="name" class="block text-sm font-medium mb-1">Last Name</label>
                <input type="text" id="name" name="last_name" value="<?= old('name') ?>" placeholder="Enter name"
                    class="w-full p-2 rounded-lg bg-white border border-gray-400 focus:ring-2 focus:ring-white" required>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium mb-1">Email Address</label>
                <input type="email" id="email" name="email" value="<?= old('email') ?>" placeholder="Enter email"
                    class="w-full p-2 rounded-lg bg-white border border-gray-400 focus:ring-2 focus:ring-white" required>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium mb-1">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password"
                    class="w-full p-2 rounded-lg bg-white border border-gray-400 focus:ring-2 focus:ring-white" required>
            </div>

            <input type="hidden" name="role" value="Admin">

            <button type="submit"
                class="w-full bg-black text-white font-bold py-2 rounded-lg hover:bg-gray-800 transition">
                Register Admin
            </button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>