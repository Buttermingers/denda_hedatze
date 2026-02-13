<?php
require_once 'api_config.php';

function is_authenticated($db)
{
    $authHeader = null;
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    } elseif (function_exists('getallheaders')) {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
        }
    }
    if (!$authHeader) {
        return false;
    }
    $parts = explode(' ', $authHeader);
    $token = isset($parts[1]) ? $parts[1] : '';
    if (empty($token)) {
        return false;
    }
    $stmt = $db->prepare("SELECT user_id FROM sessions WHERE token = :token");
    $stmt->execute([':token' => $token]);
    $result = $stmt->fetch();
    return $result !== false;
}
?>