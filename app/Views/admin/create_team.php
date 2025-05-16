<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto mt-10 bg-white text-black p-8 rounded-xl shadow-lg">
    <h3 class="text-2xl font-bold mb-6">Add Team Member</h3>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="mb-6 bg-red-700 text-white p-4 rounded-lg">
            <ul class="list-disc pl-5">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('admin/teams/store') ?>">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block font-medium mb-2">First Name</label>
                <input type="text" name="first_name" class="w-full bg-white border border-gray-400 p-3 rounded-lg focus:ring-2 focus:ring-white" required>
            </div>
            <div>
                <label class="block font-medium mb-2">Last Name</label>
                <input type="text" name="last_name" class="w-full bg-white border border-gray-400 p-3 rounded-lg focus:ring-2 focus:ring-white" required>
            </div>
        </div>

        <div class="mb-6">
            <label class="block font-medium mb-2">Email</label>
            <input type="email" name="email" class="w-full bg-white border border-gray-400 p-3 rounded-lg focus:ring-2 focus:ring-white" required>
        </div>

        <div class="mb-6">
            <label class="block font-medium mb-2">Password</label>
            <input type="password" name="password" class="w-full bg-white border border-gray-400 p-3 rounded-lg focus:ring-2 focus:ring-white" required>
        </div>

        <div class="mb-8">
            <label class="block font-medium mb-2">Role</label>
            <select name="role" class="w-full bg-white border border-gray-400 p-3 rounded-lg focus:ring-2 focus:ring-white" required>
                <option value="">-- Select Role --</option>
                <option value="salessurveyor">Sales Surveyor</option>
                <option value="Surveyor Lite">Surveyor Lite</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 px-6 rounded-lg hover:bg-gray-900 transition">
            Add Member
        </button>
    </form>
</div>

<?= $this->endSection() ?>