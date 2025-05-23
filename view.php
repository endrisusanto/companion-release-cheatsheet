<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$release = getReleaseById($id);

if (!$release) {
    header('Location: index.php');
    exit;
}

// Update status to 'in_progress' only if it's still 'new'
if ($release['status'] === 'new') {
    updateReleaseStatus($id, 'in_progress');
    // Refresh release data to reflect updated status
    $release = getReleaseById($id);
}
?>

<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Release Details: <?php echo htmlspecialchars($release['model']); ?></h1>
        <div class="flex space-x-2">
            <a href="edit.php?id=<?php echo $release['id']; ?>" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-3 py-1 rounded-md">
                <i class="fas fa-edit mr-1"></i>Edit
            </a>
            <?php if ($release['status'] !== 'done'): ?>
                <form action="update_status.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $release['id']; ?>">
                    <input type="hidden" name="status" value="done">
                    <button type="submit" class="bg-green-100 hover:bg-green-200 text-green-800 px-3 py-1 rounded-md">
                        <i class="fas fa-check mr-1"></i>Mark as Done
                    </button>
                </form>
            <?php endif; ?>
            <a href="index.php" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-md">
                <i class="fas fa-list mr-1"></i>View All
            </a>
        </div>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Status</h2>
        <div>
            <span class="font-medium">Progress Status: </span>
            <?php if ($release['status'] === 'done'): ?>
                <span class="text-green-600 font-normal">Done</span>
            <?php elseif ($release['status'] === 'in_progress'): ?>
                <span class="text-yellow-600 font-normal">In Progress</span>
            <?php else: ?>
                <span class="text-red-600 font-bold bg-red-100 px-2 py-1 rounded">Task Baru</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Basic Information</h2>
            <div class="space-y-3">
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">Model</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['model']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">OLE Version</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['ole_version']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">QB User</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['qb_user']); ?></span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Base New Version Information</h2>
            <div class="space-y-3">
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">AP</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['ap']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">CP</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['cp']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">CSC</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['csc']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">QB CSC User</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['qb_csc_user']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Additional Information</h2>
            <div class="space-y-3">
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">Additional CL</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['additional_cl']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">New Build XID</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['new_build_xid']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">QB CSC User (XID)</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['qb_csc_user_xid']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">QB CSC Eng</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['qb_csc_eng']); ?></span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Mapping Information</h2>
            <div class="space-y-3">
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">AP Mapping to Base</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['ap_mapping']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">CP Mapping to Base</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['cp_mapping']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">CSC Version Up</span>
                    <span class="col-span-2 relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['csc_version_up']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Release Note Format</h2>
        <div class="bg-white p-4 rounded border border-gray-200">
            <pre class="whitespace-pre-wrap font-mono text-sm relative copyable cursor-pointer" data-tooltip="Click to copy"><?php echo htmlspecialchars($release['release_note_format']); ?></pre>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="index.php" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>
</div>

<script>
    document.querySelectorAll('.copyable').forEach(element => {
        element.addEventListener('click', () => {
            const text = element.textContent.trim();
            navigator.clipboard.writeText(text).then(() => {
                // Apply background highlight
                element.classList.add('bg-yellow-200');
                setTimeout(() => element.classList.remove('bg-yellow-200'), 1500);

                // Show tooltip
                const tooltip = document.createElement('div');
                tooltip.textContent = 'Copied!';
                tooltip.className = 'absolute bg-gray-800 text-white text-xs rounded px-2 py-1 -top-8 left-1/2 transform -translate-x-1/2';
                element.appendChild(tooltip);
                setTimeout(() => tooltip.remove(), 1500);
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        });
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>