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
?>

<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Release Details: <?php echo htmlspecialchars($release['model']); ?></h1>
        <div class="flex space-x-2">
            <a href="edit.php?id=<?php echo $release['id']; ?>" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-3 py-1 rounded-md">
                <i class="fas fa-edit mr-1"></i>Edit
            </a>
            <a href="index.php" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-md">
                <i class="fas fa-list mr-1"></i>View All
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Basic Information</h2>
            <div class="space-y-3">
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">Model</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['model']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">OLE VERSION</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['ole_version']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">QB USER</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['qb_user']); ?></span>
                </div>
                <!-- <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">OXM/OLM NEW VERSION</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['oxm_olm_new_version']); ?></span>
                </div> -->
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Base New Version Information</h2>
            <div class="space-y-3">
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">AP</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['ap']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">CP</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['cp']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">CSC</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['csc']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">QB CSC USER</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['qb_csc_user']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Additional Information</h2>
            <div class="space-y-3">
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">ADDITIONAL CL</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['additional_cl']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">NEW BUILD XID</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['new_build_xid']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">QB CSC USER (XID)</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['qb_csc_user_xid']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">QB CSC ENG</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['qb_csc_eng']); ?></span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Mapping Information</h2>
            <div class="space-y-3">
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">AP Mapping to Base</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['ap_mapping']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">CP Mapping to Base</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['cp_mapping']); ?></span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-gray-600 font-medium">CSC Version Up</span>
                    <span class="col-span-2"><?php echo htmlspecialchars($release['csc_version_up']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Release Note Format</h2>
        <div class="bg-white p-4 rounded border border-gray-200">
            <pre class="whitespace-pre-wrap font-mono text-sm"><?php echo htmlspecialchars($release['release_note_format']); ?></pre>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="index.php" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>