<?php
try {
    require_once 'api_config.php';
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data['username']) || !isset($data['password'])) {
        throw new Exception('Faltan datos (username o password)', 400);
    }

    $stmt = $db->prepare("SELECT id, password FROM users WHERE username = :username");
    $stmt->execute([':username' => $data['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($data['password'], $user['password'])) {
        $token = bin2hex(random_bytes(32));
        $ins = $db->prepare("INSERT INTO sessions (token, user_id) VALUES (:token, :user_id)");
        $ins->execute([
            ':token' => $token,
            ':user_id' => $user['id']
        ]);

        http_response_code(200);
        echo json_encode(['token' => $token, 'username' => $data['username']]);
    } else {
        throw new Exception('Credenciales incorrectas', 401);
    }
} catch (Throwable $e) {
    $code = ($e->getCode() >= 100 && $e->getCode() <= 599) ? $e->getCode() : 500;
    http_response_code($code);
    echo json_encode(['error' => $e->getMessage()]);
}
?>