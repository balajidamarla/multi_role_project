<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>

<!-- <a href="<?= base_url('admin/signs') ?>" class="mt-6 inline-block text-blue-600 hover:underline">← Back to Sign List</a> -->
<h1 class="text-2xl font-bold rounded-xl p-6 space-y-4 max-w-4xl mx-auto">Sign Details</h1>

<div class="bg-white text-black shadow-2xl rounded-xl p-6 space-y-6 max-w-4xl mx-auto">

    <!-- Basic Info -->
    <h2 class="text-xl font-semibold bg-blue-100 text-blue-800 px-4 py-2 rounded">Basic Information</h2>
    <table class="w-full text-left mt-2">
        <thead>
            <tr>
                <th class="px-4 py-2 w-1/3">Key</th>
                <th class="px-4 py-2">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-4 py-2">ID</td>
                <td class="px-4 py-2"><?= esc($sign['id']) ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Project</td>
                <td class="px-4 py-2"><?= esc($sign['project_name'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Customer</td>
                <td class="px-4 py-2"><?= esc($sign['first_name'] . ' ' . $sign['last_name'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Sign Type</td>
                <td class="px-4 py-2"><?= esc($sign['sign_type'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Sign Name</td>
                <td class="px-4 py-2"><?= esc($sign['sign_name'] ?? 'N/A') ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Existing Sign Audit -->
    <h2 class="text-xl font-semibold bg-blue-100 text-blue-800 px-4 py-2 rounded">Existing Sign Audit</h2>
    <table class="w-full text-left mt-2">
        <thead>
            <tr>
                <th class="px-4 py-2 w-1/3">Key</th>
                <th class="px-4 py-2">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-4 py-2">Replacement Sign</td>
                <td class="px-4 py-2"><?= esc(ucfirst($sign['replacement'] ?? 'no')) ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Removal Scheduled</td>
                <td class="px-4 py-2"><?= esc(ucfirst($sign['removal_scheduled'] ?? 'no')) ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">To Do</td>
                <td class="px-4 py-2"><?= esc($sign['todo'] ?? '-') ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Summary</td>
                <td class="px-4 py-2"><?= esc($sign['summary'] ?? '-') ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Permitting Assessment -->
    <h2 class="text-xl font-semibold bg-blue-100 text-blue-800 px-4 py-2 rounded">Permitting Assessment</h2>
    <table class="w-full text-left mt-2">
        <thead>
            <tr>
                <th class="px-4 py-2 w-1/3">Key</th>
                <th class="px-4 py-2">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-4 py-2">Permit Required</td>
                <td class="px-4 py-2"><?= esc(ucfirst($sign['permit_required'] ?? 'no')) ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Permit To Do</td>
                <td class="px-4 py-2"><?= esc($sign['todo_permit'] ?? '-') ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Permit Summary</td>
                <td class="px-4 py-2"><?= esc($sign['summary_permit'] ?? '-') ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Special Instructions -->
    <h2 class="text-xl font-semibold bg-blue-100 text-blue-800 px-4 py-2 rounded">Special Instructions</h2>
    <table class="w-full text-left mt-2">
        <thead>
            <tr>
                <th class="px-4 py-2 w-1/3">Key</th>
                <th class="px-4 py-2">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-4 py-2">Existing Sign Audit</td>
                <td class="px-4 py-2"><?= esc($sign['existing_sign_audit'] ?? '-') ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Permitting Assessment</td>
                <td class="px-4 py-2"><?= esc($sign['permitting_assessment'] ?? '-') ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Surveyor Kit -->
    <h2 class="text-xl font-semibold bg-blue-100 text-blue-800 px-4 py-2 rounded">Surveyor Kit</h2>
    <table class="w-full text-left mt-2">
        <thead>
            <tr>
                <th class="px-4 py-2 w-1/3">Key</th>
                <th class="px-4 py-2">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-4 py-2">Items to Bring</td>
                <td class="px-4 py-2"><?= esc($sign['surveyor_kit'] ?? '-') ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Assignment -->
    <h2 class="text-xl font-semibold bg-blue-100 text-blue-800 px-4 py-2 rounded">Assignment</h2>
    <table class="w-full text-left mt-2">
        <thead>
            <tr>
                <th class="px-4 py-2 w-1/3">Key</th>
                <th class="px-4 py-2">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-4 py-2">Assigned To (User ID)</td>
                <td class="px-4 py-2"><?= esc($sign['assigned_to']) ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Sign Description</td>
                <td class="px-4 py-2"><?= esc($sign['sign_description'] ?? '-') ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Completion Date</td>
                <td class="px-4 py-2"><?= esc($sign['due_date'] ?? 'Not set') ?></td>
            </tr>
            <tr>
                <td class="px-4 py-2">Image</td>
                <td class="px-4 py-2">
                    <?php if (!empty($sign['sign_image'])): ?>
                        <img src="<?= base_url('public/assets/' . $sign['sign_image']) ?>"
                            alt="Sign Image"
                            class="w-32 h-auto rounded shadow cursor-pointer"
                            onclick="openImageModal(this.src)">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
            </tr>
            <!-- <tr>
                <td class="px-4 py-2">Status</td>
                <td class="px-4 py-2"><?= esc($sign['status'] ?? 'Pending') ?></td>
            </tr> -->
            <tr>
                <td class="px-4 py-2 font-medium">Status</td>
                <td class="px-4 py-2">
                    <form action="<?= base_url('admin/signs/update/' . $sign['id']) ?>" method="post" enctype="multipart/form-data" id="statusForm">
                        <?= csrf_field() ?>
                        <select name="progress" id="statusDropdown" class="border rounded p-2" onchange="document.getElementById('statusForm').submit()">
                            <option value="Pending" <?= $sign['progress'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="In Progress" <?= $sign['progress'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="Completed" <?= $sign['progress'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                        </select>
                    </form>
                </td>
            </tr>

            <tr>
                <td class="px-4 py-2">Created At</td>
                <td class="px-4 py-2"><?= esc($sign['created_at'] ?? 'N/A') ?></td>
            </tr>
            <!-- <tr>
                <td class="px-4 py-2">Updated At</td>
                <td class="px-4 py-2"><?= esc($sign['updated_at'] ?? 'N/A') ?></td>
            </tr> -->
        </tbody>
    </table>
</div>
<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden" onclick="closeImageModal()">
    <img id="modalImage" src="" class="max-w-4xl max-h-[90vh] rounded shadow-lg">
</div>
<script>
    function openImageModal(src) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modalImg.src = src;
        modal.classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }
    document.getElementById('statusDropdown').addEventListener('change', function() {
        document.getElementById('statusForm').submit();
    });
</script>

<?= $this->endSection() ?>