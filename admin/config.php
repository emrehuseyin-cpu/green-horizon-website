<?php
/**
 * GREEN HORIZON — Admin Configuration & Authentication
 * Self-Hosted, 100% Free, Zero Third-Party Dependencies
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuration file path (stores password hash)
define('GH_AUTH_FILE', __DIR__ . '/.auth.json');
define('GH_ROOT_DIR', dirname(__DIR__));

// Initialize default password if not set (Default: greenhorizon2026)
function gh_get_password_hash() {
    if (file_exists(GH_AUTH_FILE)) {
        $data = json_decode(file_get_contents(GH_AUTH_FILE), true);
        if (!empty($data['password_hash'])) {
            return $data['password_hash'];
        }
    }
    // Default password: greenhorizon2026
    $default_hash = password_hash('greenhorizon2026', PASSWORD_BCRYPT);
    file_put_contents(GH_AUTH_FILE, json_encode([
        'password_hash' => $default_hash,
        'updated_at' => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT));
    return $default_hash;
}

// Check if admin is currently authenticated
function gh_is_logged_in() {
    return !empty($_SESSION['gh_admin_logged_in']) && $_SESSION['gh_admin_logged_in'] === true;
}

// Require authentication for protected actions
function gh_require_auth() {
    if (!gh_is_logged_in()) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Unauthorized. Please log in.']);
        exit;
    }
}

// CSRF Token Management
function gh_get_csrf_token() {
    if (empty($_SESSION['gh_csrf_token'])) {
        $_SESSION['gh_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['gh_csrf_token'];
}

function gh_verify_csrf($token) {
    return !empty($token) && hash_equals($_SESSION['gh_csrf_token'] ?? '', $token);
}
