<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

// Include dashboard at the top
include __DIR__ . '/dashboard.php';

// Rest of your existing index.php code...
$search = $_GET['search'] ?? '';
$page = max(1, $_GET['page'] ?? 1);
$perPage = 10;

$releases = getAllReleases($search, $page, $perPage);
$totalItems = countReleases($search);
$totalPages = ceil($totalItems / $perPage);
?>

<!-- Rest of your index.php content... -->

<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Release Cheat Sheets</h1>
        <a href="create.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md mt-4 md:mt-0">
            <i class="fas fa-plus mr-2"></i>Add New
        </a>
    </div>

    <div class="mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <input type="text" name="search" class="flex-grow px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                   placeholder="Search by model or OLE version..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-search mr-2"></i>Search
            </button>
            <a href="index.php" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-center">
                <i class="fas fa-sync-alt mr-2"></i>Reset
            </a>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Model</th>
                    <th class="py-3 px-4 text-left">OLE Version</th>
                    <th class="py-3 px-4 text-left">AP Version</th>
                    <th class="py-3 px-4 text-left">CP Version</th>
                    <th class="py-3 px-4 text-left">CSC Version</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($releases)): ?>
                    <tr>
                        <td colspan="6" class="py-6 px-4 text-center text-gray-500">No release data found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($releases as $release): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-4"><?php echo htmlspecialchars($release['model']); ?></td>
                            <td class="py-4 px-4"><?php echo htmlspecialchars($release['ole_version']); ?></td>
                            <td class="py-4 px-4"><?php echo htmlspecialchars($release['ap']); ?></td>
                            <td class="py-4 px-4"><?php echo htmlspecialchars($release['cp']); ?></td>
                            <td class="py-4 px-4"><?php echo htmlspecialchars($release['csc']); ?></td>
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

    <?php if ($totalPages > 1): ?>
    <div class="flex justify-center mt-6">
        <nav class="inline-flex rounded-md shadow">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                    <i class="fas fa-chevron-left mr-1"></i>Previous
                </a>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="<?php echo $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-500 hover:bg-gray-50'; ?> px-3 py-2 border-t border-b border-gray-300">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            
            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>" class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                    Next<i class="fas fa-chevron-right ml-1"></i>
                </a>
            <?php endif; ?>
        </nav>
    </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>