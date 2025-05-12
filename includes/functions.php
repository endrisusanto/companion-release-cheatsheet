<?php
require_once __DIR__ . '/../config/database.php';

// Fungsi manajemen session
function startSessionIfNotStarted() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Fungsi autentikasi
function isLoggedIn() {
    startSessionIfNotStarted();
    return isset($_SESSION['user_id']);
}

function loginUser($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        startSessionIfNotStarted();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    
    return false;
}

function registerUser($username, $email, $password) {
    global $pdo;
    
    // Validasi input
    if (empty($username) || empty($email) || empty($password)) {
        return ['status' => false, 'message' => 'All fields are required'];
    }
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        return ['status' => true, 'message' => 'Registration successful'];
    } catch (PDOException $e) {
        return ['status' => false, 'message' => 'Registration failed: ' . $e->getMessage()];
    }
}

function logout() {
    startSessionIfNotStarted();
    session_unset();
    session_destroy();
}

function getCurrentUser() {
    if (isLoggedIn()) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}

// Fungsi CRUD untuk Release Cheat Sheet
function getAllReleases($search = '', $page = 1, $perPage = 10) {
    global $pdo;
    
    $offset = ($page - 1) * $perPage;
    $sql = "SELECT * FROM release_cheatsheets";
    
    if (!empty($search)) {
        $sql .= " WHERE model LIKE :search OR ole_version LIKE :search";
    }
    
    $sql .= " ORDER BY created_at DESC LIMIT :offset, :perPage";
    
    $stmt = $pdo->prepare($sql);
    
    if (!empty($search)) {
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }
    
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getReleaseById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM release_cheatsheets WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createRelease($data) {
    global $pdo;
    
    // Auto-generate fields
    $csc_version_up = convertCscVersion($data['csc']);
    $release_note = generateReleaseNote($data['ap'], $data['cp'], $csc_version_up);
    
    $stmt = $pdo->prepare("INSERT INTO release_cheatsheets 
        (model, ole_version, qb_user, oxm_olm_new_version, ap, cp, csc, 
        qb_csc_user, additional_cl, new_build_xid, qb_csc_user_xid, 
        qb_csc_eng, release_note_format, ap_mapping, cp_mapping, 
        csc_version_up, pic, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
    return $stmt->execute([
        $data['model'],
        $data['ole_version'],
        $data['qb_user'],
        $data['oxm_olm_new_version'],
        $data['ap'],
        $data['cp'],
        $data['csc'],
        $data['qb_csc_user'],
        $data['additional_cl'],
        $data['new_build_xid'],
        $data['qb_csc_user_xid'],
        $data['qb_csc_eng'],
        $release_note,
        $data['ap'],
        $data['cp'],
        $csc_version_up,
        $data['pic']
    ]);
}

function updateRelease($id, $data) {
    global $pdo;
    
    // Auto-generate fields
    $csc_version_up = convertCscVersion($data['csc']);
    $release_note = generateReleaseNote($data['ap'], $data['cp'], $csc_version_up);
    
    $stmt = $pdo->prepare("UPDATE release_cheatsheets SET 
        model = ?, ole_version = ?, qb_user = ?, oxm_olm_new_version = ?, ap = ?, cp = ?, csc = ?, 
        qb_csc_user = ?, additional_cl = ?, new_build_xid = ?, qb_csc_user_xid = ?, qb_csc_eng = ?, 
        release_note_format = ?, ap_mapping = ?, cp_mapping = ?, csc_version_up = ?, pic = ?
        WHERE id = ?");
    
    return $stmt->execute([
        $data['model'],
        $data['ole_version'],
        $data['qb_user'],
        $data['oxm_olm_new_version'],
        $data['ap'],
        $data['cp'],
        $data['csc'],
        $data['qb_csc_user'],
        $data['additional_cl'],
        $data['new_build_xid'],
        $data['qb_csc_user_xid'],
        $data['qb_csc_eng'],
        $release_note,
        $data['ap'],
        $data['cp'],
        $csc_version_up,
        $data['pic'],
        $id
    ]);
}

function deleteRelease($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM release_cheatsheets WHERE id = ?");
    return $stmt->execute([$id]);
}

function convertCscVersion($csc) {
    if (strpos($csc, 'OXM') !== false || strpos($csc, 'OLM') !== false) {
        return str_replace(['OXM', 'OLM'], 'OLE', $csc);
    } elseif (strpos($csc, 'OXT') !== false) {
        return str_replace('OXT', 'OLP', $csc);
    }
    return $csc;
}

function generateReleaseNote($ap, $cp, $csc_version_up) {
    return "Binary Release\n" .
           "AP Mapping to Base -> $ap\n" .
           "CP Mapping to Base -> $cp\n" .
           "CSC Version Up -> $csc_version_up";
}

// ... other functions ...

function getTodayReleases() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, model, ole_version, ap, cp, csc_version_up, pic, created_at, status 
                           FROM release_cheatsheets 
                           WHERE DATE(created_at) = CURDATE() 
                           ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTodayReleasesByPic($pic) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, model, ole_version, ap, cp, csc_version_up, pic, created_at, status 
                           FROM release_cheatsheets 
                           WHERE DATE(created_at) = CURDATE() 
                           AND pic = ? 
                           ORDER BY created_at DESC");
    $stmt->execute([$pic]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ... other functions ...

function countReleases($search = '') {
    global $pdo;
    
    $sql = "SELECT COUNT(*) FROM release_cheatsheets";
    if (!empty($search)) {
        $sql .= " WHERE model LIKE ? OR ole_version LIKE ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["%$search%", "%$search%"]);
    } else {
        $stmt = $pdo->query($sql);
    }
    
    return $stmt->fetchColumn();
}

function countModels() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(DISTINCT model) FROM release_cheatsheets");
    return $stmt->fetchColumn();
}

function countUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    return $stmt->fetchColumn();
}
function updateReleaseStatus($id, $status) {
    global $pdo; // Assuming PDO connection
    $stmt = $pdo->prepare("UPDATE release_cheatsheets SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}
function getReleaseStats() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT 
            COUNT(*) as total_releases,
            COUNT(DISTINCT model) as total_models,
            DATE_FORMAT(created_at, '%Y-%m') as month,
            COUNT(*) as monthly_count
        FROM release_cheatsheets
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY month DESC
        LIMIT 6
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDailyStats() {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT 
            DATE(created_at) as date,
            COUNT(*) as total,
            pic,
            COUNT(*) as pic_count
        FROM release_cheatsheets
        WHERE YEAR(created_at) = YEAR(CURDATE())
            AND MONTH(created_at) = MONTH(CURDATE())
        GROUP BY DATE(created_at), pic
        ORDER BY date
    ");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("getDailyStats Result: " . print_r($result, true));
    return $result;
}

function showAlert($message, $type = 'success') {
    startSessionIfNotStarted();
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

function redirect($url) {
    header("Location: $url");
    exit;
}
function createBulkReleases($bulkData) {
    global $pdo;

    if (empty($bulkData)) {
        return ['status' => false, 'message' => 'No data provided'];
    }

    // Split data into rows
    $rows = array_filter(array_map('trim', explode("\n", $bulkData)));
    if (empty($rows)) {
        return ['status' => false, 'message' => 'No valid rows found'];
    }

    $successCount = 0;
    $errors = [];

    // Begin transaction for atomicity
    $pdo->beginTransaction();

    try {
        $stmt = $pdo->prepare("
            INSERT INTO release_cheatsheets 
            (model, ole_version, qb_user, oxm_olm_new_version, ap, cp, csc, 
            qb_csc_user, additional_cl, new_build_xid, qb_csc_user_xid, 
            qb_csc_eng, release_note_format, ap_mapping, cp_mapping, 
            csc_version_up, pic, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        foreach ($rows as $index => $row) {
            $columns = array_map('trim', explode("\t", $row));
            if (count($columns) !== 6) {
                $errors[] = "Row " . ($index + 1) . ": Invalid number of columns (expected 6, got " . count($columns) . ")";
                continue;
            }

            [$pic, $model, $ap, $cp, $csc, $created_at] = $columns;

            // Validate required fields
            if (empty($pic) || empty($model) || empty($ap) || empty($cp) || empty($csc)) {
                $errors[] = "Row " . ($index + 1) . ": Missing required field(s)";
                continue;
            }

            // Validate date format
            if (!DateTime::createFromFormat('Y-m-d', $created_at)) {
                $errors[] = "Row " . ($index + 1) . ": Invalid date format for created_at (use YYYY-MM-DD)";
                continue;
            }

            // Set default values for other fields
            $ole_version = '';
            $qb_user = '';
            $oxm_olm_new_version = '';
            $qb_csc_user = '';
            $additional_cl = '-';
            $new_build_xid = '';
            $qb_csc_user_xid = '';
            $qb_csc_eng = '';

            // Generate auto fields
            $csc_version_up = convertCscVersion($csc);
            $release_note = generateReleaseNote($ap, $cp, $csc_version_up);

            // Execute insert
            $success = $stmt->execute([
                $model,
                $ole_version,
                $qb_user,
                $oxm_olm_new_version,
                $ap,
                $cp,
                $csc,
                $qb_csc_user,
                $additional_cl,
                $new_build_xid,
                $qb_csc_user_xid,
                $qb_csc_eng,
                $release_note,
                $ap,
                $cp,
                $csc_version_up,
                $pic,
                $created_at
            ]);

            if ($success) {
                $successCount++;
            } else {
                $errors[] = "Row " . ($index + 1) . ": Failed to insert data";
            }
        }

        if ($successCount > 0) {
            $pdo->commit();
            return ['status' => true, 'count' => $successCount, 'message' => "$successCount rows inserted successfully"];
        } else {
            $pdo->rollBack();
            return ['status' => false, 'message' => 'No rows inserted. Errors: ' . implode(', ', $errors)];
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        return ['status' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}
