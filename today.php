<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';

$todayReleases = getTodayReleases();
?>

<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Today's Releases (<?php echo date('Y-m-d'); ?>)</h1>
    
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
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($todayReleases)): ?>
                    <tr>
                        <td colspan="7" class="py-6 px-4 text-center text-gray-500">No releases today</td>
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
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>