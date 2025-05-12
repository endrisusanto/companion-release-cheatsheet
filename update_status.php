<?php
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($id && $status === 'done') {
        updateReleaseStatus($id, 'done');
    }
}

// Redirect back to view.php to reflect the updated status
header('Location: view.php?id=' . urlencode($id));
exit;
?>