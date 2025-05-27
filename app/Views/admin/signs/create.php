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
            <!-- Added side-by-side text areas -->
            <div class="flex gap-6">
                <div class="w-1/2">
                    <label for="todo" class="block font-medium mb-2">To Do / Punch List</label>
                    <textarea id="todo" name="todo" maxlength="150" rows="5" class="w-full p-2 border border-gray-300 rounded" oninput="updateCharCount('todo')"></textarea>
                    <div class="text-sm text-gray-600 text-right mt-1" id="todo-count">0/150</div>
                </div>
                <div class="w-1/2">
                    <label for="summary" class="block font-medium mb-2">Summary Notes</label>
                    <textarea id="summary" name="summary" maxlength="150" rows="5" class="w-full p-2 border border-gray-300 rounded" oninput="updateCharCount('summary')"></textarea>
                    <div class="text-sm text-gray-600 text-right mt-1" id="summary-count">0/150</div>
                </div>
            </div>
        </div>
        <!-- 2.3 Permitting Assessment -->
        <div class="mb-8 border border-gray-700 p-6 rounded-lg">
            <h4 class="text-2xl font-semibold mb-4">2.3 Permitting Assessment</h4>

            <div class="mb-4">
                <label class="block font-medium mb-2">Permit required?</label>
                <div class="flex gap-6">
                    <label class="flex items-center">
                        <input type="radio" name="permit_required" value="yes" class="text-white">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="permit_required" value="no" checked class="text-white">
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-6">
                <div class="w-1/2">
                    <label for="todo_permit" class="block font-medium mb-2">To Do / Punch List</label>
                    <textarea id="todo_permit" name="todo_permit" maxlength="150" rows="5"
                        class="w-full p-2 border border-gray-300 rounded"
                        oninput="updateCharCount('todo_permit')"></textarea>
                    <div class="text-sm text-gray-600 text-right mt-1" id="todo_permit-count">0/150</div>
                </div>
                <div class="w-1/2">
                    <label for="summary_permit" class="block font-medium mb-2">Summary Notes</label>
                    <textarea id="summary_permit" name="summary_permit" maxlength="150" rows="5"
                        class="w-full p-2 border border-gray-300 rounded"
                        oninput="updateCharCount('summary_permit')"></textarea>
                    <div class="text-sm text-gray-600 text-right mt-1" id="summary_permit-count">0/150</div>
                </div>
            </div>
        </div>



        <!-- 2.4 Special Instructions and Recommended Tool Bag -->
        <div class="mb-8 border border-gray-700 p-6 rounded-lg">
            <h4 class="text-2xl font-semibold mb-4">2.4 Special Instructions and Recommended Tool Bag</h4>

            <!-- Special Instructions -->
            <h5 class="text-xl font-semibold mb-2">Special Instructions</h5>
            <div class="mb-4">
                <label for="existing_sign_audit" class="block font-medium mb-2">Existing Sign Audit</label>
                <input type="text" id="existing_sign_audit" name="existing_sign_audit"
                    class="w-full p-2 border border-gray-300 rounded" />
            </div>

            <div class="mb-4">
                <label for="permitting_assessment" class="block font-medium mb-2">Permitting Assessment</label>
                <input type="text" id="permitting_assessment" name="permitting_assessment"
                    class="w-full p-2 border border-gray-300 rounded" />
            </div>

            <!-- Surveyor Kit -->
            <h5 class="text-xl font-semibold mb-2">Your Surveyor Kit – Important Items to Bring</h5>
            <div class="mb-4">
                <label for="surveyor_kit" class="block font-medium mb-2">Your Surveyor Kit (essential items to bring)</label>
                <input type="text" id="surveyor_kit" name="surveyor_kit"
                    class="w-full p-2 border border-gray-300 rounded" />
            </div>

            <!-- Assign and Save -->
            <h5 class="text-xl font-semibold mb-2">Assign and Save</h5>
            <div class="mb-4">
                <div class="mb-4">
                    <label for="sign_description" class="block font-medium mb-2">Sign Description</label>
                    <textarea
                        name="sign_description" id="sign_description" maxlength="150" oninput="updateCharCount('sign_description')"
                        class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-white"><?= old('sign_description') ?></textarea>
                    <div class="text-sm text-gray-600 text-right mt-1" id="sign_description-count">0/150</div>
                </div>
                <label for="assign_to_team" class="block font-medium mb-2">Assign to Team</label>
                <select name="assigned_to" id="assigned_to" class="w-full bg-white border border-gray text-black p-2 rounded-lg focus:ring-2 focus:ring-white" required>
                    <option value="">-- Select Team --</option>
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

    function updateCharCount(id) {
        const textarea = document.getElementById(id);
        const counter = document.getElementById(id + '-count');
        if (textarea && counter) {
            counter.textContent = `${textarea.value.length}/150`;
        }
    }

    // Initialize all counts on page load
    window.addEventListener('DOMContentLoaded', () => {
        updateCharCount('todo');
        updateCharCount('summary');
        updateCharCount('todo_permit');
        updateCharCount('summary_permit');
        updateCharCount('sign_description');
    });
</script>


<?= $this->endSection() ?>