<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto py-8 px-4">
    <h2 class="text-3xl font-semibold text-black mb-6">Edit Sign</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/signs/update/' . $sign['id']) ?>" method="post" class="bg-white text-black p-6 rounded-xl shadow-xl space-y-8" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Hidden Inputs -->
        <input type="hidden" name="project_id" value="<?= esc($sign['project_id']) ?>">
        <input type="hidden" name="customer_id" value="<?= esc($sign['customer_id']) ?>">

        <!-- 2.1 Sign Setup -->
        <div class="border border-gray-300 p-6 rounded-lg shadow-sm">
            <h4 class="text-2xl font-semibold mb-4 text-gray-800">2.1 Sign Setup</h4>

            <div class="mb-4">
                <label for="sign_type" class="block font-medium text-gray-700 mb-2">Main Sign Category</label>
                <select name="sign_type" id="sign_type" class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Select Category</option>
                    <option value="Indoor" <?= $sign['sign_type'] == 'Indoor' ? 'selected' : '' ?>>Indoor</option>
                    <option value="Outdoor" <?= $sign['sign_type'] == 'Outdoor' ? 'selected' : '' ?>>Outdoor</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="dynamic_sign_type" class="block font-medium text-gray-700 mb-2">Sign Type</label>
                <select name="dynamic_sign_type" id="dynamic_sign_type" class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Select a Sign Type</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="sign_name" class="block font-medium text-gray-700 mb-2">Sign Name</label>
                <input type="text" name="sign_name" id="sign_name" value="<?= esc($sign['sign_name']) ?>" class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" required>
            </div>
        </div>

        <!-- 2.2 Existing Sign Audit -->
        <div class="border border-gray-300 p-6 rounded-lg shadow-sm">
            <h4 class="text-2xl font-semibold mb-4 text-gray-800">2.2 Existing Sign Audit</h4>

            <!-- Replacement -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-2">Is this a replacement sign?</label>
                <div class="flex gap-6">
                    <label class="flex items-center">
                        <input type="radio" name="replacement" value="yes" <?= $sign['replacement'] == 'yes' ? 'checked' : '' ?> class="text-blue-600">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="replacement" value="no" <?= $sign['replacement'] == 'no' ? 'checked' : '' ?> class="text-blue-600">
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>

            <!-- Removal Scheduled -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-2">Removal Scheduled?</label>
                <div class="flex gap-6">
                    <label class="flex items-center">
                        <input type="radio" name="removal_scheduled" value="yes" <?= $sign['removal_scheduled'] == 'yes' ? 'checked' : '' ?> class="text-blue-600">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="removal_scheduled" value="no" <?= $sign['removal_scheduled'] == 'no' ? 'checked' : '' ?> class="text-blue-600">
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>

            <!-- Textareas -->
            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/2">
                    <label for="todo" class="block font-medium text-gray-700 mb-2">To Do / Punch List</label>
                    <textarea id="todo" name="todo" maxlength="150" rows="5" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" oninput="updateCharCount('todo')"><?= esc($sign['todo']) ?></textarea>
                    <div class="text-sm text-gray-600 text-right mt-1" id="todo-count">0/150</div>
                </div>
                <div class="w-full md:w-1/2">
                    <label for="summary" class="block font-medium text-gray-700 mb-2">Summary Notes</label>
                    <textarea id="summary" name="summary" maxlength="150" rows="5" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" oninput="updateCharCount('summary')"><?= esc($sign['summary']) ?></textarea>
                    <div class="text-sm text-gray-600 text-right mt-1" id="summary-count">0/150</div>
                </div>
            </div>
        </div>

        <!-- 2.3 Permitting Assessment -->
        <div class="border border-gray-300 p-6 rounded-lg shadow-sm">
            <h4 class="text-2xl font-semibold mb-4 text-gray-800">2.3 Permitting Assessment</h4>

            <!-- Permit Required -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700 mb-2">Permit required?</label>
                <div class="flex gap-6">
                    <label class="flex items-center">
                        <input type="radio" name="permit_required" value="yes" <?= $sign['permit_required'] == 'yes' ? 'checked' : '' ?> class="text-blue-600">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="permit_required" value="no" <?= $sign['permit_required'] == 'no' ? 'checked' : '' ?> class="text-blue-600">
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>

            <!-- Textareas -->
            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/2">
                    <label for="todo_permit" class="block font-medium text-gray-700 mb-2">To Do / Punch List</label>
                    <textarea id="todo_permit" name="todo_permit" maxlength="150" rows="5" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" oninput="updateCharCount('todo_permit')"><?= esc($sign['todo_permit']) ?></textarea>
                    <div class="text-sm text-gray-600 text-right mt-1" id="todo_permit-count">0/150</div>
                </div>
                <div class="w-full md:w-1/2">
                    <label for="summary_permit" class="block font-medium text-gray-700 mb-2">Summary Notes</label>
                    <textarea id="summary_permit" name="summary_permit" maxlength="150" rows="5" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" oninput="updateCharCount('summary_permit')"><?= esc($sign['summary_permit']) ?></textarea>
                    <div class="text-sm text-gray-600 text-right mt-1" id="summary_permit-count">0/150</div>
                </div>
            </div>
        </div>

        <!-- 2.4 Special Instructions -->
        <div class="border border-gray-300 p-6 rounded-lg shadow-sm">
            <h4 class="text-2xl font-semibold mb-4 text-gray-800">2.4 Special Instructions & Surveyor Kit</h4>

            <div class="mb-4">
                <label for="existing_sign_audit" class="block font-medium text-gray-700 mb-2">Existing Sign Audit</label>
                <input type="text" id="existing_sign_audit" name="existing_sign_audit" value="<?= esc($sign['existing_sign_audit']) ?>" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div class="mb-4">
                <label for="permitting_assessment" class="block font-medium text-gray-700 mb-2">Permitting Assessment</label>
                <input type="text" id="permitting_assessment" name="permitting_assessment" value="<?= esc($sign['permitting_assessment']) ?>" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div class="mb-4">
                <label for="surveyor_kit" class="block font-medium text-gray-700 mb-2">Surveyor Kit (essential items to bring)</label>
                <input type="text" id="surveyor_kit" name="surveyor_kit" value="<?= esc($sign['surveyor_kit']) ?>" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
            </div>
        </div>

        <!-- Added Fields: Description, Assigned To, Progress, Due Date -->
        <div class="border border-gray-300 p-6 rounded-lg shadow-sm">
            <h4 class="text-2xl font-semibold mb-4 text-gray-800">Additional Details</h4>

            <!-- Description -->
            <div class="mb-6">
                <label for="sign_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="sign_description" id="sign_description" rows="3" maxlength="500"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"><?= esc($sign['sign_description']) ?></textarea>
                <p class="text-sm text-gray-500 mt-1">
                    <span id="charCount"><?= strlen($sign['sign_description']) ?></span>/500 characters
                </p>
            </div>

            <!-- Assigned To -->
            <div class="mb-6">
                <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-1">Assign To</label>
                <select name="assigned_to" id="assigned_to"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>" <?= $user['id'] == $sign['assigned_to'] ? 'selected' : '' ?>>
                            <?= $user['id'] == $currentUserId
                                ? 'Self'
                                : esc($user['first_name'] . ' ' . $user['last_name']) . ' (' . esc($user['role']) . ')' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Upload Image -->
            <div class="mb-6">
                <label for="sign_image" class="block text-sm font-medium text-gray-700 mb-1">Upload Image</label>
                <?php if (!empty($sign['sign_image'])): ?>
                    <div class="mb-2">
                        <img src="<?= base_url('public/assets/' . esc($sign['sign_image'])) ?>" alt="Sign Image" class="h-32 object-cover border rounded">
                    </div>
                <?php endif; ?>
                <input type="file" name="sign_image" id="sign_image"
                    class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Progress -->
            <div class="mb-6">
                <label for="progress" class="block text-sm font-medium text-gray-700 mb-1">Progress</label>
                <select name="progress" id="progress"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="Pending" <?= $sign['progress'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="In Progress" <?= $sign['progress'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="Completed" <?= $sign['progress'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>

            <!-- Due Date -->
            <div class="mb-6">
                <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                <input type="date" name="due_date" id="due_date" value="<?= esc($sign['due_date']) ?>"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="<?= base_url('admin/signs') ?>"
                class="inline-block px-6 py-2 text-sm font-semibold rounded bg-gray-300 hover:bg-gray-400 text-gray-800">Cancel</a>
            <button type="submit"
                class="inline-block px-6 py-2 text-sm font-semibold rounded bg-black hover:bg-gray-800 text-white">Update Sign</button>
        </div>
    </form>
</div>

<script>
    // Update character count for description field
    const description = document.getElementById('sign_description');
    const charCount = document.getElementById('charCount');

    description.addEventListener('input', () => {
        charCount.textContent = description.value.length;
    });

    // These values come from your PHP sign data
    const selectedMainType = "<?= esc($sign['sign_type']) ?>";
    const selectedDynamicType = "<?= esc($sign['sign_type']) ?>";

    function populateDynamicSignTypes(mainType, selected = '') {
        const signTypeSelect = document.getElementById('dynamic_sign_type');
        signTypeSelect.innerHTML = '<option value="">Select a Sign Type</option>';

        const options = mainType === 'Indoor' ? ['LED', 'Neon', 'Banner'] :
            mainType === 'Outdoor' ? ['Billboard', 'Flag', 'Poster'] : [];

        options.forEach(type => {
            const option = document.createElement('option');
            option.value = type;
            option.textContent = type;
            if (type === selected) {
                option.selected = true;
            }
            signTypeSelect.appendChild(option);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const mainTypeSelect = document.getElementById('sign_type');
        const dynamicSelect = document.getElementById('dynamic_sign_type');

        // Initial load
        populateDynamicSignTypes(selectedMainType, selectedDynamicType);

        // On change of main type
        mainTypeSelect.addEventListener('change', function() {
            populateDynamicSignTypes(this.value);
        });
    });

    // Initialize counts for existing textareas with counters
    function updateCharCount(id) {
        const textarea = document.getElementById(id);
        const countDisplay = document.getElementById(id + '-count');
        if (textarea && countDisplay) {
            countDisplay.textContent = textarea.value.length + '/150';
        }
    }

    // Run once on load to update counts for punch list and summary fields
    ['todo', 'summary', 'todo_permit', 'summary_permit'].forEach(updateCharCount);

    // Your existing dynamic sign type JS here if any...
</script>

<?= $this->endSection() ?>