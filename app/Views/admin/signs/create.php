<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="w-full max-w-4xl mx-auto py-8 px-4">
    <h2 class="text-3xl font-bold text-black mb-6">New Sign</h2>

    <form action="<?= base_url('admin/signs/store') ?>" method="post" class="bg-white text-black p-6 rounded-xl shadow-2xl">
        <?= csrf_field() ?>

        <!-- Instead of dropdown, use hidden inputs -->
        <input type="hidden" name="project_id" value="<?= esc($project['id']) ?>">
        <input type="hidden" name="customer_id" value="<?= esc($project['customer_id']) ?>">


        <!-- Optionally display project & customer info as readonly text -->
        <p><strong>Project:</strong> <?= esc($project['name']) ?></p>
        <p><strong>Customer:</strong> <?= esc($project['first_name'] . ' ' . $project['last_name']) ?></p>



        <!-- Hidden Customer ID field (auto-filled) -->
        <!-- <input type="hidden" name="customer_id" id="customer_id" value=""> -->

        <!-- 2.1 Sign Setup -->
        <div class="mb-8 border border-gray-700 p-6 rounded-lg">
            <h4 class="text-2xl font-semibold mb-4">2.1 Sign Setup</h4>

            <div class="mb-4">
                <label for="sign_type" class="block font-medium mb-2">Main Sign Category</label>
                <select name="sign_type" id="sign_type" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-white" required>
                    <option value="">Select Category</option>
                    <option value="Indoor">Indoor</option>
                    <option value="Outdoor">Outdoor</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="dynamic_sign_type" class="block font-medium mb-2">Sign Type</label>
                <select name="dynamic_sign_type" id="dynamic_sign_type" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-white" required>
                    <option value="">Select a Sign Type</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="sign_name" class="block font-medium mb-2">Sign Name</label>
                <input type="text" name="sign_name" id="sign_name" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-white" required>
            </div>
        </div>

        <!-- 2.2 Existing Sign Audit -->
        <div class="mb-8 border border-gray-700 p-6 rounded-lg">
            <h4 class="text-2xl font-semibold mb-4">2.2 Existing Sign Audit</h4>

            <div class="mb-4">
                <label class="block font-medium mb-2">Is this a replacement sign?</label>
                <div class="flex gap-6">
                    <label class="flex items-center">
                        <input type="radio" name="replacement" value="yes" class="text-white">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="replacement" value="no" checked class="text-white">
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">Removal Scheduled?</label>
                <div class="flex gap-6">
                    <label class="flex items-center">
                        <input type="radio" name="removal_scheduled" value="yes" class="text-white">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="removal_scheduled" value="no" checked class="text-white">
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- 2.3 Assign and Save -->
        <div class="mb-8 border border-gray-700 p-6 rounded-lg">
            <h4 class="text-2xl font-semibold mb-4">2.3 Assign and Save</h4>

            <div class="mb-4">
                <label for="sign_description" class="block font-medium mb-2">Sign Description</label>
                <textarea name="sign_description" id="sign_description" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-white"><?= old('sign_description') ?></textarea>
            </div>

            <div class="mb-4">
                <label for="progress" class="block font-medium mb-2">Progress Status</label>
                <select name="progress" id="progress" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-white" required>
                    <option value="">-- Select Status --</option>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="assigned_to" class="block font-medium mb-2">Assign to Team</label>
                <select name="assigned_to" id="assigned_to" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-white" required>
                    <option value="">-- Select User --</option>
                    <?php
                    $currentUserId = session()->get('user_id');
                    foreach ($surveyors as $user):
                        $isSelf = ((int) $user['id'] === (int) $currentUserId);
                        $displayName = $isSelf ? 'Self' : esc($user['first_name']) . ' ' . esc($user['last_name']);
                    ?>
                        <option value="<?= esc($user['id']) ?>">
                            <?= $displayName ?> (<?= esc($user['role']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>

            <div class="mb-4">
                <label for="due_date" class="block font-medium mb-2">Completion Date</label>
                <input type="date" name="due_date" id="due_date" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-white" required>
            </div>
        </div>

        <button type="submit" class="w-full bg-black text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-900 transition">
            Save
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update dynamic sign types based on main sign type
        document.getElementById('sign_type').addEventListener('change', function() {
            const signTypeSelect = document.getElementById('dynamic_sign_type');
            signTypeSelect.innerHTML = '<option value="">Select a Sign Type</option>';

            const options = this.value === 'Indoor' ? ['LED', 'Neon', 'Banner'] :
                this.value === 'Outdoor' ? ['Billboard', 'Flag', 'Poster'] : [];

            options.forEach(type => {
                const option = document.createElement('option');
                option.value = type;
                option.textContent = type;
                signTypeSelect.appendChild(option);
            });
        });
    });
</script>


<?= $this->endSection() ?>