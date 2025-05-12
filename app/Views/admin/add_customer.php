<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-lg">
    <h3 class="text-xl font-bold mb-6">Add Customer</h3>
    <form method="post" action="<?= base_url('admin/store_customer') ?>" class="space-y-6">
        <?= csrf_field() ?>

        <!-- Company Name -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Company Name</label>
            <input type="text" name="company_name" class="w-full border border-gray-300 rounded px-3 py-2 " required>
        </div>

        <!-- First & Last Name -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">First Name</label>
                <input type="text" name="first_name" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Last Name</label>
                <input type="text" name="last_name" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
        </div>

        <!-- Email & Phone -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Phone</label>
                <input type="text" name="phone" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
        </div>

        <!-- Address -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Address 1</label>
                <input type="text" name="address1" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">Address 2</label>
                <input type="text" name="address2" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>
        </div>

        <!-- Zip & City/State -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Zipcode</label>
                <input type="text" name="zipcode" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-1">City / State</label>
                <input type="text" name="city" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
        </div>

        <!-- Submit -->
        <div class="text-right">
            <button type="submit" class="w-full bg-black text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-900 transition">
                Add Customer
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>