<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Get filter from query parameter (default to 'all')
$filter = $_GET['filter'] ?? 'all';

// Fetch releases based on filter
if ($filter === 'my' && isset($_SESSION['username'])) {
    $todayReleases = getTodayReleasesByPic($_SESSION['username']);
} else {
    $todayReleases = getTodayReleases();
}
?>

<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Today's Releases (<?php echo date('Y-m-d'); ?>)</h1>

    <!-- Filter Selector -->
    <div class="mb-4">
        <form method="GET" class="flex items-center space-x-2">
            <label for="filter" class="text-sm font-medium text-gray-700">Filter Releases:</label>
            <select name="filter" id="filter" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                <option value="all" <?php echo $filter === 'all' ? 'selected' : ''; ?>>All Releases</option>
                <option value="my" <?php echo $filter === 'my' ? 'selected' : ''; ?>>My Releases</option>
            </select>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Model</th>
                    <th class="py-3 px-4 text-left">OLE Version</th>
                    <th class="py-3 px-4 text-left">AP</th>
                    <th class="py-3 px-4 text-left">CP</th>
                    <th class="py-3 px-4 text-left">CSC Version</th>
                    <th class="py-3 px-4 text-left">PIC</th>
                    <th class="py-3 px-4 text-left">Time</th>
                    <th class="py-3 px-4 text-left">Progress Status</th>
                    <th class="py-3 px-4 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($todayReleases)): ?>
                    <tr>
                        <td colspan="9" class="py-6 px-4 text-center text-gray-500">No releases found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($todayReleases as $release): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-4"><?php echo htmlspecialchars($release['model']); ?></td>
                            <td class="py-4 px-4 font-bold text-blue-600"><?php echo htmlspecialchars($release['ole_version']); ?></td>
                            <td class="py-4 px-4"><?php echo htmlspecialchars($release['ap']); ?></td>
                            <td class="py-4 px-4"><?php echo htmlspecialchars($release['cp']); ?></td>
                            <td class="py-4 px-4 font-bold text-green-600"><?php echo htmlspecialchars($release['csc_version_up']); ?></td>
                            <td class="py-4 px-4"><?php echo htmlspecialchars($release['pic']); ?></td>
                            <td class="py-4 px-4"><?php echo date('H:i', strtotime($release['created_at'])); ?></td>
                            <td class="py-4 px-4">
                                <?php if ($release['status'] === 'done'): ?>
                                    <span class="text-green-600 font-normal">Done</span>
                                <?php elseif ($release['status'] === 'in_progress'): ?>
                                    <span class="text-yellow-600 font-normal">In Progress</span>
                                <?php else: ?>
                                    <span class="text-red-600 font-bold bg-red-100 px-2 py-1 rounded">Task Baru</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <a href="view.php?id=<?php echo $release['id']; ?>" class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-md text-sm">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <a href="edit.php?id=<?php echo $release['id']; ?>" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-3 py-1 rounded-md text-sm">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <a href="delete.php?id=<?php echo $release['id']; ?>" 
                                       class="bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1 rounded-md text-sm"
                                       onclick="return confirm('Are you sure you want to delete this release?')">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>