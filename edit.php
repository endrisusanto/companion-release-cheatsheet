<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$id = $_GET['id'] ?? null;

if (!$id) {
    redirect('index.php');
}

$release = getReleaseById($id);

if (!$release) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'model' => $_POST['model'] ?? '',
        'ole_version' => $_POST['ole_version'] ?? '',
        'qb_user' => $_POST['qb_user'] ?? '',
        'oxm_olm_new_version' => $_POST['oxm_olm_new_version'] ?? '',
        'ap' => $_POST['ap'] ?? '',
        'cp' => $_POST['cp'] ?? '',
        'csc' => $_POST['csc'] ?? '',
        'qb_csc_user' => $_POST['qb_csc_user'] ?? '',
        'additional_cl' => $_POST['additional_cl'] ?? '-',
        'new_build_xid' => $_POST['new_build_xid'] ?? '',
        'qb_csc_user_xid' => $_POST['qb_csc_user_xid'] ?? '',
        'qb_csc_eng' => $_POST['qb_csc_eng'] ?? '',
        'pic' => $_POST['pic'] ?? '',
        'release_note_format' => $_POST['release_note_format'] ?? '',
        'ap_mapping' => $_POST['ap_mapping'] ?? '',
        'cp_mapping' => $_POST['cp_mapping'] ?? '',
        'csc_version_up' => $_POST['csc_version_up'] ?? ''
    ];

    if (updateRelease($id, $data)) {
        showAlert('Release data updated successfully!', 'success');
        redirect('view.php?id='.$id);
    } else {
        showAlert('Failed to update release data!', 'error');
    }
}
?>

<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Release: <?php echo htmlspecialchars($release['model']); ?></h1>
    
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="mb-4 p-4 bg-<?php echo $_SESSION['flash_type'] === 'error' ? 'red' : 'green'; ?>-100 border border-<?php echo $_SESSION['flash_type'] === 'error' ? 'red' : 'green'; ?>-400 text-<?php echo $_SESSION['flash_type'] === 'error' ? 'red' : 'green'; ?>-700 rounded">
            <?php echo htmlspecialchars($_SESSION['flash_message']); ?>
            <?php unset($_SESSION['flash_message']); unset($_SESSION['flash_type']); ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                <input type="text" id="model" name="model" required
                       value="<?php echo htmlspecialchars($release['model']); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="ole_version" class="block text-sm font-medium text-gray-700">OLE VERSION</label>
                <input type="text" id="ole_version" name="ole_version" required
                       value="<?php echo htmlspecialchars($release['ole_version']); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="qb_user" class="block text-sm font-medium text-gray-700">QB USER</label>
                <input type="text" id="qb_user" name="qb_user" required
                       value="<?php echo htmlspecialchars($release['qb_user']); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">OXM/OLM NEW VERSION</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="ap" class="block text-sm font-medium text-gray-700">AP</label>
                        <input type="text" id="ap" name="ap" required
                               value="<?php echo htmlspecialchars($release['ap']); ?>"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="cp" class="block text-sm font-medium text-gray-700">CP</label>
                        <input type="text" id="cp" name="cp" required
                               value="<?php echo htmlspecialchars($release['cp']); ?>"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="csc" class="block text-sm font-medium text-gray-700">CSC</label>
                        <input type="text" id="csc" name="csc" required
                               value="<?php echo htmlspecialchars($release['csc']); ?>"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
            
            <div>
                <label for="qb_csc_user" class="block text-sm font-medium text-gray-700">QB CSC USER</label>
                <input type="text" id="qb_csc_user" name="qb_csc_user" required
                       value="<?php echo htmlspecialchars($release['qb_csc_user']); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="additional_cl" class="block text-sm font-medium text-gray-700">ADDITIONAL CL</label>
                <input type="text" id="additional_cl" name="additional_cl"
                       value="<?php echo htmlspecialchars($release['additional_cl']); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div class="md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">NEW BUILD XID</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="qb_csc_user_xid" class="block text-sm font-medium text-gray-700">QB CSC USER (XID)</label>
                        <input type="text" id="qb_csc_user_xid" name="qb_csc_user_xid" required
                               value="<?php echo htmlspecialchars($release['qb_csc_user_xid']); ?>"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="qb_csc_eng" class="block text-sm font-medium text-gray-700">QB CSC ENG</label>
                        <input type="text" id="qb_csc_eng" name="qb_csc_eng" required
                               value="<?php echo htmlspecialchars($release['qb_csc_eng']); ?>"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>
            
            <div>
                <label for="pic" class="block text-sm font-medium text-gray-700">PIC</label>
                <input type="text" id="pic" name="pic" required
                       value="<?php echo htmlspecialchars($release['pic']); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="release_note_format" class="block text-sm font-medium text-gray-700">Release Note Format</label>
                <input readonly type="text" id="release_note_format" name="release_note_format"
                       value="<?php echo htmlspecialchars($release['release_note_format']); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="ap_mapping" class="block text-sm font-medium text-gray-700">AP Mapping</label>
                <input readonly type="text" id="ap_mapping" name="ap_mapping"
                       value="<?php echo htmlspecialchars($release['ap_mapping']); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="cp_mapping" class="block text-sm font-medium text-gray-700">CP Mapping</label>
                <input readonly type="text" id="cp_mapping" name="cp_mapping"
                       value="<?php echo htmlspecialchars($release['cp_mapping']); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="csc_version_up" class="block text-sm font-medium text-gray-700">CSC Version Up</label>
                <input readonly type="text" id="csc_version_up" name="csc_version_up"
                       value="<?php echo htmlspecialchars($release['csc_version_up']); ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        
        <div class="flex justify-between pt-4">
            <a href="view.php?id=<?php echo $release['id']; ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md">
                <i class="fas fa-arrow-left mr-2"></i>Cancel
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-save mr-2"></i>Update
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>