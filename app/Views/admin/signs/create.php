<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-4">New Sign</h2>

    <form action="<?= base_url('admin/signs/store') ?>" method="post" class="shadow p-4 rounded bg-light">
        <?= csrf_field() ?>
        <input type="hidden" name="project_id" value="<?= esc($project['id']) ?>">
        <input type="hidden" name="customer_id" value="<?= esc($project['customer_id']) ?>">

        <!-- 2.1 Sign Setup -->
        <div class="mb-4 border p-3 rounded">
            <h4 class="mb-3 text-primary">2.1 Sign Setup</h4>

            <!-- Indoor/Outdoor Dropdown -->
            <div class="mb-3">
                <label for="sign_type" class="form-label">Indoor / Outdoor:</label>
                <select name="sign_type" id="sign_type" class="form-select" required>
                    <option value="">Select</option>
                    <option value="Indoor">Indoor</option>
                    <option value="Outdoor">Outdoor</option>
                </select>
            </div>

            <!-- Dynamic Sign Type Dropdown -->
            <div class="mb-3">
                <label for="dynamic_sign_type" class="form-label">Sign Type:</label>
                <select name="dynamic_sign_type" id="dynamic_sign_type" class="form-select" required>
                    <option value="">Select a Sign Type</option>
                    <!-- Options will be populated dynamically based on Indoor/Outdoor selection -->
                </select>
            </div>

            <!-- Sign Name Field -->
            <div class="mb-3">
                <label for="sign_name" class="form-label">Sign Name:</label>
                <input type="text" name="sign_name" id="sign_name" class="form-control" required>
            </div>
        </div>

        <!-- 2.2 Existing Sign Audit -->
        <div class="mb-4 border p-3 rounded">
            <h4 class="mb-3 text-primary">2.2 Existing Sign Audit</h4>

            <!-- Replacement Sign Radio Buttons -->
            <div class="mb-3">
                <label for="replacement" class="form-label">Is this a replacement sign?</label>
                <div class="form-check form-check-inline">
                    <input type="radio" name="replacement" value="yes" id="replacement_yes" class="form-check-input">
                    <label for="replacement_yes" class="form-check-label">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="replacement" value="no" id="replacement_no" checked class="form-check-input">
                    <label for="replacement_no" class="form-check-label">No</label>
                </div>
            </div>

            <!-- Document Sign Condition Heading -->
            <h5 class="mb-3">Document Sign Condition</h5>

            <!-- Removal Scheduled Radio Buttons -->
            <div class="mb-3">
                <label for="removal_scheduled" class="form-label">Removal Scheduled?</label>
                <div class="form-check form-check-inline">
                    <input type="radio" name="removal_scheduled" value="yes" id="removal_scheduled_yes" class="form-check-input">
                    <label for="removal_scheduled_yes" class="form-check-label">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="removal_scheduled" value="no" id="removal_scheduled_no" checked class="form-check-input">
                    <label for="removal_scheduled_no" class="form-check-label">No</label>
                </div>
            </div>
        </div>

        <!-- 2.3 Assign and Save -->
        <div class="mb-4 border p-3 rounded">
            <h4 class="mb-3 text-primary">2.3 Assign and Save</h4>
            <div class="mb-3">
                <label for="sign_description" class="form-label">Sign Description:</label>
                <textarea name="sign_description" id="sign_description" class="form-control"><?= old('sign_description') ?></textarea>
            </div>

            <!-- Assign to Team Dropdown -->
            <div class="mb-3">
                <label for="assigned_to" class="form-label">Assign to Team:</label>
                <select name="assigned_to" id="assigned_to" class="form-select" required>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= esc($user['id']) ?>"><?= esc($user['first_name']) . ' ' . esc($user['last_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Completion Date Field -->
            <div class="mb-3">
                <label for="completion_date" class="form-label">Completion Date:</label>
                <input type="date" name="completion_date" id="completion_date" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script>
    document.getElementById('sign_type').addEventListener('change', function() {
        var signTypeSelect = document.getElementById('dynamic_sign_type');
        signTypeSelect.innerHTML = ''; // Clear existing options

        var signType = this.value;
        if (signType === 'Indoor') {
            var indoorOptions = ['LED', 'Neon', 'Banner'];
            indoorOptions.forEach(function(type) {
                var option = document.createElement('option');
                option.value = type;
                option.textContent = type;
                signTypeSelect.appendChild(option);
            });
        } else if (signType === 'Outdoor') {
            var outdoorOptions = ['Billboard', 'Flag', 'Poster'];
            outdoorOptions.forEach(function(type) {
                var option = document.createElement('option');
                option.value = type;
                option.textContent = type;
                signTypeSelect.appendChild(option);
            });
        }
    });
</script>

<?= $this->endSection() ?>