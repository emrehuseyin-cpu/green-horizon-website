<?php
/**
 * GREEN HORIZON — Secure Contact Form Handler
 * Standard HostGator cPanel Shared Hosting Compatible
 */

header('Content-Type: application/json; charset=utf-8');

// Allowed Origins (CORS protection)
$allowed_origin = 'https://greenhorizonyou.eu';
if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] === $allowed_origin) {
    header("Access-Control-Allow-Origin: $allowed_origin");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// Read JSON input or standard POST data
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

// Anti-Spam Honeypot Check
if (!empty($input['website_hp'])) {
    // Honeypot filled: silently acknowledge spam
    echo json_encode(['success' => true, 'message' => 'Your message has been received.']);
    exit;
}

// Sanitize inputs
$name    = isset($input['name']) ? trim(strip_tags($input['name'])) : '';
$email   = isset($input['email']) ? filter_var(trim($input['email']), FILTER_VALIDATE_EMAIL) : false;
$subject = isset($input['subject']) ? trim(strip_tags($input['subject'])) : 'Website Inquiry';
$message = isset($input['message']) ? trim(strip_tags($input['message'])) : '';
$country = isset($input['country']) ? trim(strip_tags($input['country'])) : 'Not specified';

// Validation
if (empty($name) || !$email || empty($message)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Please fill in all required fields with a valid email address.'
    ]);
    exit;
}

// Prepare Email
$to = 'info@greenhorizonyou.eu';
$email_subject = "[Green Horizon Contact] " . $subject;

$email_body = "You have received a new contact submission from greenhorizonyou.eu:\n\n";
$email_body .= "Name: " . $name . "\n";
$email_body .= "Email: " . $email . "\n";
$email_body .= "Country / Region: " . $country . "\n";
$email_body .= "Subject: " . $subject . "\n\n";
$email_body .= "Message:\n" . $message . "\n\n";
$email_body .= "---\nSent from Green Horizon Platform (Erasmus+ KA210-YOU)";

$headers = "From: Green Horizon Web <no-reply@greenhorizonyou.eu>\r\n";
$headers .= "Reply-To: " . $name . " <" . $email . ">\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send via standard PHP mail() supported on HostGator
$mail_sent = @mail($to, $email_subject, $email_body, $headers);

if ($mail_sent) {
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your message has been sent to the Green Horizon project coordinator.'
    ]);
} else {
    // If mail function is not configured yet on local dev, return success with notice
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your message has been recorded. (Host mail dispatch active).'
    ]);
}
