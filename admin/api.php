<?php
/**
 * GREEN HORIZON — Admin REST API
 * Handles all backend actions: Content saving, Media/Video upload, Photo management
 */

require_once __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? '';

// 1. PUBLIC ACTIONS
if ($action === 'login') {
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    $password = $input['password'] ?? '';
    $hash = gh_get_password_hash();

    if (password_verify($password, $hash)) {
        $_SESSION['gh_admin_logged_in'] = true;
        $_SESSION['gh_admin_time'] = time();
        echo json_encode([
            'success' => true,
            'csrf_token' => gh_get_csrf_token()
        ]);
    } else {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'error' => 'Incorrect password. Default is: greenhorizon2026'
        ]);
    }
    exit;
}

if ($action === 'logout') {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    echo json_encode(['success' => true]);
    exit;
}

// 2. PROTECTED ACTIONS (Require Authentication)
gh_require_auth();

// Verify CSRF for mutation requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($_POST['csrf_token'] ?? '');
    if (!gh_verify_csrf($csrf)) {
        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Invalid or expired CSRF token. Please refresh the page.']);
        exit;
    }
}

// =============================================================================
// ACTION: CHANGE PASSWORD
// =============================================================================
if ($action === 'change_password') {
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    $current = $input['current_password'] ?? '';
    $new = $input['new_password'] ?? '';

    if (strlen($new) < 6) {
        echo json_encode(['success' => false, 'error' => 'New password must be at least 6 characters.']);
        exit;
    }

    $hash = gh_get_password_hash();
    if (!password_verify($current, $hash)) {
        echo json_encode(['success' => false, 'error' => 'Current password is incorrect.']);
        exit;
    }

    $new_hash = password_hash($new, PASSWORD_BCRYPT);
    file_put_contents(GH_AUTH_FILE, json_encode([
        'password_hash' => $new_hash,
        'updated_at' => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT));

    echo json_encode(['success' => true, 'message' => 'Password changed successfully.']);
    exit;
}

// =============================================================================
// ACTION: GET CONTENT FILE
// =============================================================================
if ($action === 'get_content') {
    $file = basename($_GET['file'] ?? '');
    $allowed = ['home', 'about', 'results', 'contact', 'news', 'partners', 'activities', 'stories', 'gallery', 'site-settings'];

    if (!in_array($file, $allowed)) {
        echo json_encode(['success' => false, 'error' => 'Invalid content file requested.']);
        exit;
    }

    $path = GH_ROOT_DIR . "/assets/data/content/{$file}.json";
    if (!file_exists($path)) {
        echo json_encode(['success' => false, 'error' => "File {$file}.json not found."]);
        exit;
    }

    $content = json_decode(file_get_contents($path), true);
    echo json_encode(['success' => true, 'file' => $file, 'data' => $content]);
    exit;
}

// =============================================================================
// ACTION: SAVE CONTENT FILE
// =============================================================================
if ($action === 'save_content') {
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    $file = basename($input['file'] ?? '');
    $data = $input['data'] ?? null;

    $allowed = ['home', 'about', 'results', 'contact', 'news', 'partners', 'activities', 'stories', 'gallery', 'site-settings'];
    if (!in_array($file, $allowed) || $data === null) {
        echo json_encode(['success' => false, 'error' => 'Invalid file or data payload.']);
        exit;
    }

    $contentDir = GH_ROOT_DIR . '/assets/data/content';
    if (!is_dir($contentDir)) {
        mkdir($contentDir, 0755, true);
    }

    $contentPath = "{$contentDir}/{$file}.json";
    $jsonString = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
    file_put_contents($contentPath, $jsonString);

    // Sync to assets/data/{file}.json (unwrapping collections for client-side JS)
    $runtimePath = GH_ROOT_DIR . "/assets/data/{$file}.json";
    if ($file === 'news') {
        $list = isset($data['articles']) && is_array($data['articles']) ? $data['articles'] : $data;
        file_put_contents($runtimePath, json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    } elseif ($file === 'activities') {
        $list = isset($data['milestones']) && is_array($data['milestones']) ? $data['milestones'] : $data;
        file_put_contents($runtimePath, json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    } elseif ($file === 'partners') {
        $list = isset($data['partners']) && is_array($data['partners']) ? $data['partners'] : $data;
        file_put_contents($runtimePath, json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    } elseif ($file === 'stories') {
        $list = isset($data['stories']) && is_array($data['stories']) ? $data['stories'] : $data;
        file_put_contents($runtimePath, json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    } elseif ($file === 'gallery') {
        $list = isset($data['photos']) && is_array($data['photos']) ? $data['photos'] : $data;
        file_put_contents($runtimePath, json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    }

    // Recompile static HTML injections
    gh_recompile_html();

    echo json_encode(['success' => true, 'message' => "Successfully saved {$file}.json"]);
    exit;
}

// =============================================================================
// ACTION: LIST PHOTO ALBUMS
// =============================================================================
if ($action === 'list_albums') {
    $albums = [
        ['id' => 'a1-kickoff', 'title' => 'A1 Kick-Off Meeting (Bonn, Germany)', 'path' => 'assets/activities/a1-kickoff'],
        ['id' => 'a2-training-course', 'title' => 'A2 Youth Training Course (Brașov, Romania)', 'path' => 'assets/activities/a2-training-course'],
        ['id' => 'a4-de', 'title' => 'A4 Local Workshops (Germany)', 'path' => 'assets/activities/a4-local-workshops/de'],
        ['id' => 'a4-ro', 'title' => 'A4 Local Workshops (Romania)', 'path' => 'assets/activities/a4-local-workshops/ro'],
        ['id' => 'a4-tr', 'title' => 'A4 Local Workshops (Türkiye)', 'path' => 'assets/activities/a4-local-workshops/tr'],
        ['id' => 'a5-films-exhibition', 'title' => 'A5 Campaign Films & VR Exhibition', 'path' => 'assets/activities/a5-films-exhibition'],
        ['id' => 'a7-ro', 'title' => 'A7 Dissemination (Romania)', 'path' => 'assets/activities/a7-dissemination-final-meeting/ro'],
        ['id' => 'a7-tr', 'title' => 'A7 Dissemination (Türkiye)', 'path' => 'assets/activities/a7-dissemination-final-meeting/tr'],
        ['id' => 'a7-de', 'title' => 'A7 Dissemination (Germany)', 'path' => 'assets/activities/a7-dissemination-final-meeting/de'],
        ['id' => 'a7-final', 'title' => 'A7 Final Transnational Meeting', 'path' => 'assets/activities/a7-dissemination-final-meeting/final-meeting'],
        ['id' => 'gallery', 'title' => 'Main Website Photo Gallery', 'path' => 'assets/data/content/gallery.json', 'is_gallery' => true]
    ];

    echo json_encode(['success' => true, 'albums' => $albums]);
    exit;
}

// =============================================================================
// ACTION: GET ALBUM PHOTOS
// =============================================================================
if ($action === 'get_album_photos') {
    $albumId = $_GET['album'] ?? '';
    $res = gh_get_album_info($albumId);

    if (!$res) {
        echo json_encode(['success' => false, 'error' => 'Album not found.']);
        exit;
    }

    echo json_encode(['success' => true, 'album' => $res['album'], 'photos' => $res['photos']]);
    exit;
}

// =============================================================================
// ACTION: SAVE ALBUM PHOTOS (Captions & Order)
// =============================================================================
if ($action === 'save_album_photos') {
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    $albumId = $input['album'] ?? '';
    $photos = $input['photos'] ?? [];

    $res = gh_get_album_info($albumId);
    if (!$res) {
        echo json_encode(['success' => false, 'error' => 'Album not found.']);
        exit;
    }

    if (!empty($res['is_gallery'])) {
        // Save to gallery.json
        $path = GH_ROOT_DIR . '/assets/data/content/gallery.json';
        file_put_contents($path, json_encode(['photos' => $photos], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
        file_put_contents(GH_ROOT_DIR . '/assets/data/gallery.json', json_encode($photos, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    } else {
        $jsonPath = $res['dir'] . '/photos.json';
        file_put_contents($jsonPath, json_encode(['photos' => $photos], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    }

    echo json_encode(['success' => true, 'message' => 'Album saved successfully.']);
    exit;
}

// =============================================================================
// ACTION: UPLOAD PHOTO TO ALBUM
// =============================================================================
if ($action === 'upload_photo') {
    $albumId = $_POST['album'] ?? '';
    $res = gh_get_album_info($albumId);
    if (!$res) {
        echo json_encode(['success' => false, 'error' => 'Album not found.']);
        exit;
    }

    if (empty($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'error' => 'Upload failed or no file selected.']);
        exit;
    }

    $file = $_FILES['photo'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    if (!in_array($ext, $allowedExts)) {
        echo json_encode(['success' => false, 'error' => 'Invalid file format. Only JPG, PNG, WEBP allowed.']);
        exit;
    }

    // Clean filename
    $rawName = pathinfo($file['name'], PATHINFO_FILENAME);
    $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '_', strtolower($rawName));
    $filename = $cleanName . '-' . time() . '.' . $ext;

    $targetDir = $res['is_gallery'] ? (GH_ROOT_DIR . '/assets/images/uploads') : $res['dir'];
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $targetPath = $targetDir . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        echo json_encode(['success' => false, 'error' => 'Failed to save uploaded file. Check directory permissions.']);
        exit;
    }

    // Register in album photos.json
    $newEntry = [
        'file' => $res['is_gallery'] ? ("assets/images/uploads/" . $filename) : $filename,
        'caption_en' => $_POST['caption_en'] ?? ucwords(str_replace(['_', '-'], ' ', $rawName)),
        'caption_de' => $_POST['caption_de'] ?? '',
        'caption_tr' => $_POST['caption_tr'] ?? '',
        'caption_ro' => $_POST['caption_ro'] ?? '',
        'credit' => $_POST['credit'] ?? 'Green Horizon Consortium'
    ];

    if ($res['is_gallery']) {
        $newEntry['id'] = 'gal-' . time();
        $newEntry['title'] = $_POST['title'] ?? ucwords(str_replace(['_', '-'], ' ', $rawName));
        $newEntry['caption'] = $newEntry['caption_en'];
        $newEntry['category'] = $_POST['category'] ?? 'Events';
        $newEntry['date'] = date('F Y');
        $newEntry['place'] = $_POST['place'] ?? 'Transnational';
    }

    $currentPhotos = $res['photos'];
    array_unshift($currentPhotos, $newEntry);

    if ($res['is_gallery']) {
        file_put_contents(GH_ROOT_DIR . '/assets/data/content/gallery.json', json_encode(['photos' => $currentPhotos], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
        file_put_contents(GH_ROOT_DIR . '/assets/data/gallery.json', json_encode($currentPhotos, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    } else {
        file_put_contents($res['dir'] . '/photos.json', json_encode(['photos' => $currentPhotos], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    }

    echo json_encode(['success' => true, 'message' => 'Photo uploaded successfully!', 'entry' => $newEntry]);
    exit;
}

// =============================================================================
// ACTION: DELETE PHOTO FROM ALBUM
// =============================================================================
if ($action === 'delete_photo') {
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    $albumId = $input['album'] ?? '';
    $filename = $input['filename'] ?? '';

    $res = gh_get_album_info($albumId);
    if (!$res) {
        echo json_encode(['success' => false, 'error' => 'Album not found.']);
        exit;
    }

    $filtered = [];
    $found = false;
    foreach ($res['photos'] as $p) {
        $itemFile = $p['file'] ?? '';
        if ($itemFile === $filename || basename($itemFile) === basename($filename)) {
            $found = true;
            // Optionally delete file from disk
            $filePath = $res['is_gallery'] ? (GH_ROOT_DIR . '/' . ltrim($itemFile, '/')) : ($res['dir'] . '/' . basename($filename));
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        } else {
            $filtered[] = $p;
        }
    }

    if ($res['is_gallery']) {
        file_put_contents(GH_ROOT_DIR . '/assets/data/content/gallery.json', json_encode(['photos' => $filtered], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
        file_put_contents(GH_ROOT_DIR . '/assets/data/gallery.json', json_encode($filtered, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    } else {
        file_put_contents($res['dir'] . '/photos.json', json_encode(['photos' => $filtered], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    }

    echo json_encode(['success' => true, 'message' => 'Photo deleted successfully.']);
    exit;
}

// =============================================================================
// ACTION: GET VIDEOS LIST & METADATA
// =============================================================================
if ($action === 'get_videos') {
    $resultsPath = GH_ROOT_DIR . '/assets/data/content/results.json';
    $homePath = GH_ROOT_DIR . '/assets/data/content/home.json';

    $resultsData = file_exists($resultsPath) ? json_decode(file_get_contents($resultsPath), true) : [];
    $homeData = file_exists($homePath) ? json_decode(file_get_contents($homePath), true) : [];

    $films = $resultsData['result_2_documentaries']['films'] ?? [];
    $promo = $homeData['promo_video'] ?? [];

    $videoList = [];

    // 1. Promotional Video
    $promoFile = GH_ROOT_DIR . '/' . ($promo['video_src_mp4'] ?? 'assets/video/campaign-1-footage.mp4');
    $promoPoster = GH_ROOT_DIR . '/' . ($promo['poster'] ?? 'assets/video/poster-promo.jpg');
    $videoList[] = [
        'id' => 'promo',
        'type' => 'promotional',
        'title' => $promo['title'] ?? 'Green Horizon: Official Promotional Video',
        'country' => 'Transnational (DE, RO, TR)',
        'duration' => '3m 15s',
        'description' => $promo['description'] ?? '',
        'video_src' => $promo['video_src_mp4'] ?? 'assets/video/campaign-1-footage.mp4',
        'poster' => $promo['poster'] ?? 'assets/video/poster-promo.jpg',
        'file_exists' => file_exists($promoFile),
        'file_size' => file_exists($promoFile) ? round(filesize($promoFile) / (1024 * 1024), 1) . ' MB' : 'Missing'
    ];

    // 2. Result 2 Films (Germany, Romania, Türkiye)
    foreach ($films as $f) {
        $vFile = GH_ROOT_DIR . '/' . ($f['video_src'] ?? '');
        $videoList[] = [
            'id' => $f['id'] ?? ('film-' . count($videoList)),
            'type' => 'campaign',
            'title' => $f['title'] ?? '',
            'country' => $f['country'] ?? '',
            'duration' => $f['duration'] ?? '',
            'description' => $f['description'] ?? '',
            'video_src' => $f['video_src'] ?? '',
            'poster' => $f['poster'] ?? '',
            'file_exists' => file_exists($vFile),
            'file_size' => file_exists($vFile) ? round(filesize($vFile) / (1024 * 1024), 1) . ' MB' : 'Missing'
        ];
    }

    echo json_encode(['success' => true, 'videos' => $videoList]);
    exit;
}

// =============================================================================
// ACTION: SAVE VIDEO METADATA
// =============================================================================
if ($action === 'save_video_meta') {
    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    $id = $input['id'] ?? '';

    $resultsPath = GH_ROOT_DIR . '/assets/data/content/results.json';
    $homePath = GH_ROOT_DIR . '/assets/data/content/home.json';

    $resultsData = file_exists($resultsPath) ? json_decode(file_get_contents($resultsPath), true) : [];
    $homeData = file_exists($homePath) ? json_decode(file_get_contents($homePath), true) : [];

    if ($id === 'promo') {
        $homeData['promo_video']['title'] = $input['title'] ?? $homeData['promo_video']['title'];
        $homeData['promo_video']['description'] = $input['description'] ?? $homeData['promo_video']['description'];
        file_put_contents($homePath, json_encode($homeData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
    } else {
        if (!empty($resultsData['result_2_documentaries']['films'])) {
            foreach ($resultsData['result_2_documentaries']['films'] as &$film) {
                if ($film['id'] === $id) {
                    $film['title'] = $input['title'] ?? $film['title'];
                    $film['country'] = $input['country'] ?? $film['country'];
                    $film['duration'] = $input['duration'] ?? $film['duration'];
                    $film['description'] = $input['description'] ?? $film['description'];
                    break;
                }
            }
            file_put_contents($resultsPath, json_encode($resultsData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
        }
    }

    gh_recompile_html();
    echo json_encode(['success' => true, 'message' => 'Video details updated successfully.']);
    exit;
}

// =============================================================================
// ACTION: UPLOAD VIDEO OR POSTER FILE
// =============================================================================
if ($action === 'upload_video_file') {
    $id = $_POST['id'] ?? '';
    $type = $_POST['file_type'] ?? 'video'; // 'video' or 'poster'

    if (empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'error' => 'No file received or upload limit exceeded.']);
        exit;
    }

    $uploadFile = $_FILES['file'];
    $ext = strtolower(pathinfo($uploadFile['name'], PATHINFO_EXTENSION));

    if ($type === 'video') {
        if ($ext !== 'mp4') {
            echo json_encode(['success' => false, 'error' => 'Videos must be in MP4 format.']);
            exit;
        }
    } else {
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            echo json_encode(['success' => false, 'error' => 'Poster must be a JPG, PNG, or WEBP image.']);
            exit;
        }
    }

    $targetFilename = '';
    if ($id === 'promo') {
        $targetFilename = $type === 'video' ? 'campaign-1-footage.mp4' : 'poster-promo.jpg';
    } elseif ($id === 'film-1') {
        $targetFilename = $type === 'video' ? 'campaign-germany.mp4' : 'poster-germany.jpg';
    } elseif ($id === 'film-2') {
        $targetFilename = $type === 'video' ? 'campaign-romania.mp4' : 'poster-romania.jpg';
    } elseif ($id === 'film-3') {
        $targetFilename = $type === 'video' ? 'campaign-turkiye.mp4' : 'poster-turkiye.jpg';
    } else {
        $targetFilename = ($type === 'video' ? 'video-' : 'poster-') . time() . '.' . $ext;
    }

    $targetDir = GH_ROOT_DIR . '/assets/video';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $destPath = $targetDir . '/' . $targetFilename;
    if (!move_uploaded_file($uploadFile['tmp_name'], $destPath)) {
        echo json_encode(['success' => false, 'error' => 'Failed to save uploaded media file. Check folder permissions.']);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Media file updated successfully!',
        'path' => 'assets/video/' . $targetFilename,
        'size' => round(filesize($destPath) / (1024 * 1024), 1) . ' MB'
    ]);
    exit;
}

// =============================================================================
// ACTION: SYSTEM STATUS & GIT
// =============================================================================
if ($action === 'system_status') {
    $gitBranch = 'main';
    $gitCommit = 'Unknown';
    $hasUncommittedChanges = false;
    $uncommittedList = [];

    if (function_exists('exec')) {
        @exec('cd ' . escapeshellarg(GH_ROOT_DIR) . ' && git rev-parse --abbrev-ref HEAD 2>&1', $bOut);
        if (!empty($bOut[0])) $gitBranch = trim($bOut[0]);
        @exec('cd ' . escapeshellarg(GH_ROOT_DIR) . ' && git log -1 --format="%h - %s (%ci)" 2>&1', $cOut);
        if (!empty($cOut[0])) $gitCommit = trim($cOut[0]);
        @exec('cd ' . escapeshellarg(GH_ROOT_DIR) . ' && git status --porcelain 2>&1', $sOut);
        if (!empty($sOut)) {
            $hasUncommittedChanges = true;
            $uncommittedList = array_slice($sOut, 0, 10);
        }
    }

    echo json_encode([
        'success' => true,
        'php_version' => PHP_VERSION,
        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Standard Apache / cPanel',
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'git_branch' => $gitBranch,
        'git_commit' => $gitCommit,
        'has_uncommitted' => $hasUncommittedChanges,
        'uncommitted_files' => $uncommittedList,
        'root_dir' => GH_ROOT_DIR
    ]);
    exit;
}

// =============================================================================
// ACTION: GIT COMMIT & PUSH TO GITHUB
// =============================================================================
if ($action === 'git_sync') {
    if (!function_exists('exec')) {
        echo json_encode(['success' => false, 'error' => 'exec() function is disabled on this server.']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
    $customMsg = trim($input['message'] ?? '');
    $commitMsg = $customMsg ?: ('chore(cms): update website content from admin panel [' . date('Y-m-d H:i') . ']');

    $output = [];
    $ret = 0;

    // Stage content changes
    $cmd = 'cd ' . escapeshellarg(GH_ROOT_DIR) . ' && git add assets/data/ assets/activities/ assets/video/ *.html 2>&1';
    exec($cmd, $output, $ret);

    // Check if there is anything to commit
    $statusCheck = [];
    exec('cd ' . escapeshellarg(GH_ROOT_DIR) . ' && git status --porcelain 2>&1', $statusCheck);
    if (empty($statusCheck)) {
        echo json_encode(['success' => true, 'message' => 'Everything is already up-to-date. No changes to commit.']);
        exit;
    }

    // Commit
    $cmd = 'cd ' . escapeshellarg(GH_ROOT_DIR) . ' && git commit -m ' . escapeshellarg($commitMsg) . ' 2>&1';
    exec($cmd, $output, $ret);

    // Push to GitHub
    $pushOut = [];
    $pushRet = 0;
    exec('cd ' . escapeshellarg(GH_ROOT_DIR) . ' && git push origin main 2>&1', $pushOut, $pushRet);

    $allLog = implode("\n", array_merge($output, $pushOut));

    if ($pushRet === 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Successfully committed and pushed all changes to GitHub!',
            'log' => $allLog
        ]);
    } else {
        // Committed locally, push may need credentials or is offline
        echo json_encode([
            'success' => true,
            'partial' => true,
            'message' => 'Changes committed locally. Push to remote responded: ' . substr($allLog, 0, 150),
            'log' => $allLog
        ]);
    }
    exit;
}

// =============================================================================
// HELPER FUNCTIONS
// =============================================================================
function gh_get_album_info($albumId) {
    $albums = [
        'a1-kickoff' => ['title' => 'A1 Kick-Off Meeting (Bonn, Germany)', 'dir' => GH_ROOT_DIR . '/assets/activities/a1-kickoff', 'folder' => 'assets/activities/a1-kickoff'],
        'a2-training-course' => ['title' => 'A2 Youth Training Course (Brașov, Romania)', 'dir' => GH_ROOT_DIR . '/assets/activities/a2-training-course', 'folder' => 'assets/activities/a2-training-course'],
        'a4-de' => ['title' => 'A4 Local Workshops (Germany)', 'dir' => GH_ROOT_DIR . '/assets/activities/a4-local-workshops/de', 'folder' => 'assets/activities/a4-local-workshops/de'],
        'a4-ro' => ['title' => 'A4 Local Workshops (Romania)', 'dir' => GH_ROOT_DIR . '/assets/activities/a4-local-workshops/ro', 'folder' => 'assets/activities/a4-local-workshops/ro'],
        'a4-tr' => ['title' => 'A4 Local Workshops (Türkiye)', 'dir' => GH_ROOT_DIR . '/assets/activities/a4-local-workshops/tr', 'folder' => 'assets/activities/a4-local-workshops/tr'],
        'a5-films-exhibition' => ['title' => 'A5 Campaign Films & VR Exhibition', 'dir' => GH_ROOT_DIR . '/assets/activities/a5-films-exhibition', 'folder' => 'assets/activities/a5-films-exhibition'],
        'a7-ro' => ['title' => 'A7 Dissemination (Romania)', 'dir' => GH_ROOT_DIR . '/assets/activities/a7-dissemination-final-meeting/ro', 'folder' => 'assets/activities/a7-dissemination-final-meeting/ro'],
        'a7-tr' => ['title' => 'A7 Dissemination (Türkiye)', 'dir' => GH_ROOT_DIR . '/assets/activities/a7-dissemination-final-meeting/tr', 'folder' => 'assets/activities/a7-dissemination-final-meeting/tr'],
        'a7-de' => ['title' => 'A7 Dissemination (Germany)', 'dir' => GH_ROOT_DIR . '/assets/activities/a7-dissemination-final-meeting/de', 'folder' => 'assets/activities/a7-dissemination-final-meeting/de'],
        'a7-final' => ['title' => 'A7 Final Transnational Meeting', 'dir' => GH_ROOT_DIR . '/assets/activities/a7-dissemination-final-meeting/final-meeting', 'folder' => 'assets/activities/a7-dissemination-final-meeting/final-meeting'],
        'gallery' => ['title' => 'Main Website Photo Gallery', 'dir' => GH_ROOT_DIR . '/assets/data/content', 'is_gallery' => true]
    ];

    if (!isset($albums[$albumId])) return null;

    $info = $albums[$albumId];
    $photos = [];

    if (!empty($info['is_gallery'])) {
        $galleryPath = GH_ROOT_DIR . '/assets/data/content/gallery.json';
        if (file_exists($galleryPath)) {
            $raw = json_decode(file_get_contents($galleryPath), true);
            $photos = isset($raw['photos']) ? $raw['photos'] : (is_array($raw) ? $raw : []);
        }
    } else {
        $jsonPath = $info['dir'] . '/photos.json';
        if (file_exists($jsonPath)) {
            $raw = json_decode(file_get_contents($jsonPath), true);
            $photos = isset($raw['photos']) ? $raw['photos'] : (is_array($raw) ? $raw : []);
        }
    }

    // Attach full URL and file size to each photo for thumbnail display
    foreach ($photos as &$p) {
        $filename = $p['file'] ?? '';
        $fullPath = !empty($info['is_gallery']) ? (GH_ROOT_DIR . '/' . ltrim($filename, '/')) : ($info['dir'] . '/' . $filename);
        $p['file_url'] = !empty($info['is_gallery']) ? ('../' . ltrim($filename, '/')) : ('../' . $info['folder'] . '/' . $filename);
        $p['file_exists'] = file_exists($fullPath);
        $p['file_size'] = file_exists($fullPath) ? round(filesize($fullPath) / 1024, 0) . ' KB' : 'Missing';
    }

    $info['album'] = $albumId;
    $info['photos'] = $photos;
    return $info;
}

function gh_recompile_html() {
    $settingsPath = GH_ROOT_DIR . '/assets/data/content/site-settings.json';
    $homePath = GH_ROOT_DIR . '/assets/data/content/home.json';
    $resultsPath = GH_ROOT_DIR . '/assets/data/content/results.json';
    $storiesPath = GH_ROOT_DIR . '/assets/data/content/stories.json';
    $aboutPath = GH_ROOT_DIR . '/assets/data/content/about.json';
    $contactPath = GH_ROOT_DIR . '/assets/data/content/contact.json';

    $settings = file_exists($settingsPath) ? json_decode(file_get_contents($settingsPath), true) : null;
    $home = file_exists($homePath) ? json_decode(file_get_contents($homePath), true) : null;
    $results = file_exists($resultsPath) ? json_decode(file_get_contents($resultsPath), true) : null;
    $stories = file_exists($storiesPath) ? json_decode(file_get_contents($storiesPath), true) : null;
    $about = file_exists($aboutPath) ? json_decode(file_get_contents($aboutPath), true) : null;
    $contact = file_exists($contactPath) ? json_decode(file_get_contents($contactPath), true) : null;

    $hasDist = is_dir(GH_ROOT_DIR . '/dist');

    // 1. Update index.html
    $indexPath = GH_ROOT_DIR . '/index.html';
    if ($home && file_exists($indexPath)) {
        $html = file_get_contents($indexPath);
        if (!empty($home['hero']['title'])) {
            $html = preg_replace('/(<h1 class="section-title"[^>]*>)([\s\S]*?)(<\/h1>)/', '$1' . "\n            " . htmlspecialchars($home['hero']['title']) . "\n          $3", $html, 1);
        }
        if (!empty($home['hero']['subtitle'])) {
            $html = preg_replace('/(<p class="section-subtitle"[^>]*>)([\s\S]*?)(<\/p>)/', '$1' . "\n            " . htmlspecialchars($home['hero']['subtitle']) . "\n          $3", $html, 1);
        }
        if (!empty($home['promo_video']['title'])) {
            $html = preg_replace('/(<h3 class="drone-video-title">)([\s\S]*?)(<\/h3>)/', '$1' . htmlspecialchars($home['promo_video']['title']) . '$3', $html, 1);
        }
        if (!empty($home['promo_video']['description'])) {
            $html = preg_replace('/(<p class="drone-video-description">)([\s\S]*?)(<\/p>)/', '$1' . "\n              " . htmlspecialchars($home['promo_video']['description']) . "\n            $3", $html, 1);
        }
        if (!empty($home['promo_video']['poster'])) {
            $html = preg_replace('/(<video id="drone-mp4-player"[^>]*poster=")([^"]*)(")/', '$1' . $home['promo_video']['poster'] . '$3', $html, 1);
        }
        if (!empty($home['promo_video']['video_src_mp4'])) {
            $html = preg_replace('/(<video id="drone-mp4-player"[\s\S]*?<source src=")([^"]*)(")/', '$1' . $home['promo_video']['video_src_mp4'] . '$3', $html, 1);
        }
        file_put_contents($indexPath, $html);
        if ($hasDist) @copy($indexPath, GH_ROOT_DIR . '/dist/index.html');
    }

    // 2. Update resources.html & results.html (Campaign Films & Results)
    if ($results && !empty($results['result_2_documentaries']['films'])) {
        $films = $results['result_2_documentaries']['films'];
        $resPages = ['resources.html', 'results.html'];

        foreach ($resPages as $resPage) {
            $pPath = GH_ROOT_DIR . '/' . $resPage;
            if (!file_exists($pPath)) continue;
            $rHtml = file_get_contents($pPath);

            foreach ($films as $idx => $film) {
                $filmSlotId = 'film-' . ($idx + 1);
                // Replace in slot
                $slotPattern = '/(<div class="media-embed-slot" id="' . $filmSlotId . '">)([\s\S]*?)(<\/div>\s*<\/div>)/';
                if (preg_match($slotPattern, $rHtml, $match)) {
                    $slotContent = $match[2];

                    if (!empty($film['title'])) {
                        $slotContent = preg_replace('/(<h3[^>]*>)([\s\S]*?)(<\/h3>)/', '$1' . htmlspecialchars($film['title']) . '$3', $slotContent, 1);
                    }
                    if (!empty($film['duration'])) {
                        $slotContent = preg_replace('/(<span style="font-size: 0.82rem; font-weight: 700; color: var\(--text-light\);">)([\s\S]*?)(<\/span>)/', '$1' . htmlspecialchars($film['duration']) . '$3', $slotContent, 1);
                    }
                    if (!empty($film['description'])) {
                        $slotContent = preg_replace('/(<p style="font-size: 0.9rem; color: var\(--text-muted\); line-height: 1.55; margin-bottom: 0; flex: 1;">)([\s\S]*?)(<\/p>)/', '$1' . htmlspecialchars($film['description']) . '$3', $slotContent, 1);
                    }
                    if (!empty($film['poster'])) {
                        $slotContent = preg_replace('/(poster=")([^"]*)(")/', '$1' . $film['poster'] . '$3', $slotContent, 1);
                    }
                    if (!empty($film['video_src'])) {
                        $slotContent = preg_replace('/(<source src=")([^"]*)(")/', '$1' . $film['video_src'] . '$3', $slotContent, 1);
                    }

                    $rHtml = str_replace($match[0], $match[1] . $slotContent . $match[3], $rHtml);
                }
            }

            file_put_contents($pPath, $rHtml);
            if ($hasDist) @copy($pPath, GH_ROOT_DIR . '/dist/' . $resPage);
        }
    }

    // 3. Update stories.html
    if ($stories && file_exists(GH_ROOT_DIR . '/stories.html')) {
        $stList = isset($stories['stories']) ? $stories['stories'] : (is_array($stories) ? $stories : []);
        $stPath = GH_ROOT_DIR . '/stories.html';
        $sHtml = file_get_contents($stPath);

        foreach ($stList as $idx => $st) {
            $stSlotId = 'film-0' . ($idx + 1);
            $stPattern = '/(<article class="media-embed-slot" id="' . $stSlotId . '">)([\s\S]*?)(<\/article>)/';
            if (preg_match($stPattern, $sHtml, $match)) {
                $stContent = $match[2];
                if (!empty($st['title'])) {
                    $stContent = preg_replace('/(<h3[^>]*>)([\s\S]*?)(<\/h3>)/', '$1' . "\n                " . htmlspecialchars($st['title']) . "\n              $3", $stContent, 1);
                }
                if (!empty($st['summary'])) {
                    $stContent = preg_replace('/(<p style="font-size: 0.92rem; color: var\(--text-muted\); line-height: 1.6; margin-bottom: 1rem;">)([\s\S]*?)(<\/p>)/', '$1' . "\n                " . htmlspecialchars($st['summary']) . "\n              $3", $stContent, 1);
                }
                if (!empty($st['poster'])) {
                    $stContent = preg_replace('/(poster=")([^"]*)(")/', '$1' . $st['poster'] . '$3', $stContent, 1);
                }
                if (!empty($st['video_file'])) {
                    $stContent = preg_replace('/(<source src=")([^"]*)(")/', '$1' . $st['video_file'] . '$3', $stContent, 1);
                }
                $sHtml = str_replace($match[0], $match[1] . $stContent . $match[3], $sHtml);
            }
        }

        file_put_contents($stPath, $sHtml);
        if ($hasDist) @copy($stPath, GH_ROOT_DIR . '/dist/stories.html');
    }

    // 4. Update about.html Header
    if ($about && file_exists(GH_ROOT_DIR . '/about.html')) {
        $abPath = GH_ROOT_DIR . '/about.html';
        $abHtml = file_get_contents($abPath);
        if (!empty($about['header']['title'])) {
            $abHtml = preg_replace('/(<h1 class="section-title">)([\s\S]*?)(<\/h1>)/', '$1' . htmlspecialchars($about['header']['title']) . '$3', $abHtml, 1);
        }
        if (!empty($about['header']['subtitle'])) {
            $abHtml = preg_replace('/(<p class="section-subtitle"[^>]*>)([\s\S]*?)(<\/p>)/', '$1' . "\n          " . htmlspecialchars($about['header']['subtitle']) . "\n        $3", $abHtml, 1);
        }
        file_put_contents($abPath, $abHtml);
        if ($hasDist) @copy($abPath, GH_ROOT_DIR . '/dist/about.html');
    }

    // 5. Update contact.html Header
    if ($contact && file_exists(GH_ROOT_DIR . '/contact.html')) {
        $cPath = GH_ROOT_DIR . '/contact.html';
        $cHtml = file_get_contents($cPath);
        if (!empty($contact['header']['title'])) {
            $cHtml = preg_replace('/(<h1 class="section-title">)([\s\S]*?)(<\/h1>)/', '$1' . htmlspecialchars($contact['header']['title']) . '$3', $cHtml, 1);
        }
        file_put_contents($cPath, $cHtml);
        if ($hasDist) @copy($cPath, GH_ROOT_DIR . '/dist/contact.html');
    }

    // 6. Synchronize EU disclaimer & Project Number across all HTML files
    if ($settings && !empty($settings['eu_disclaimer'])) {
        $htmlFiles = glob(GH_ROOT_DIR . '/*.html');
        foreach ($htmlFiles as $hPath) {
            $pageHtml = file_get_contents($hPath);
            $pageHtml = preg_replace(
                '/(<p class="footer-disclaimer-text">)([\s\S]*?)(<\/p>)/',
                '$1' . "\n          " . htmlspecialchars($settings['eu_disclaimer']) . "\n        $3",
                $pageHtml
            );
            if (!empty($settings['project_number'])) {
                $pageHtml = preg_replace(
                    '/(<p class="footer-project-number">Project number: <strong>)([\s\S]*?)(<\/strong><\/p>)/',
                    '$1' . htmlspecialchars($settings['project_number']) . '$3',
                    $pageHtml
                );
            }
            file_put_contents($hPath, $pageHtml);
            if ($hasDist) {
                @copy($hPath, GH_ROOT_DIR . '/dist/' . basename($hPath));
            }
        }
    }

    // 7. Synchronize runtime data directories
    if ($hasDist) {
        $sourceData = GH_ROOT_DIR . '/assets/data';
        $destData = GH_ROOT_DIR . '/dist/assets/data';
        if (is_dir($sourceData) && is_dir($destData)) {
            $files = glob($sourceData . '/*.json');
            foreach ($files as $f) {
                @copy($f, $destData . '/' . basename($f));
            }
        }
    }
}
