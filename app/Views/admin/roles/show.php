<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="w-2/3 mx-auto max-h-screen flex items-center justify-center p-10 bg-gray-100 text-black ">



    <form action="<?= base_url('admin/user/update/' . $user['id']) ?>" method="post" class="px-15 w-full max-w-md space-y-6 bg-gray-200 p-6 rounded-lg shadow">
        <?= csrf_field() ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-300 p-3 rounded mb-4">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-300 p-3 rounded mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>



        <h1 class="text-3xl font-medium text-black mb-6">Edit Profile: <?= esc(ucfirst($roleName)) ?></h1>

        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?= set_value('first_name', $user['first_name']) ?>" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" />
            <?php if (isset($validation) && $validation->hasError('first_name')): ?>
                <p class="text-red-500 text-sm mt-1"><?= $validation->getError('first_name') ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?= set_value('last_name', $user['last_name']) ?>" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" />
            <?php if (isset($validation) && $validation->hasError('last_name')): ?>
                <p class="text-red-500 text-sm mt-1"><?= $validation->getError('last_name') ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="<?= set_value('email', $user['email']) ?>" required
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" />
            <?php if (isset($validation) && $validation->hasError('email')): ?>
                <p class="text-red-500 text-sm mt-1"><?= $validation->getError('email') ?></p>
            <?php endif; ?>
        </div>

        <!-- Add more fields if needed -->

        <button type="submit"
            class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded">
            Update Profile
        </button>
    </form>
</div>


<?= $this->endSection() ?>