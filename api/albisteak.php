<?php
try {
    require_once 'api_config.php';
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require_once 'auth_helper.php';

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        if (isset($_GET['id'])) {
            $stmt = $db->prepare("SELECT * FROM albisteak WHERE id = :id");
            $stmt->execute([':id' => $_GET['id']]);
            $result = $stmt->fetch();
            if ($result) {
                echo json_encode($result);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Not found']);
            }
        } else {
            $stmt = $db->query("SELECT * FROM albisteak ORDER BY id DESC");
            echo json_encode($stmt->fetchAll());
        }
    } elseif ($method === 'POST') {
        if (!is_authenticated($db)) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['izenburua']) || !isset($data['xehetasunak']) || !isset($data['autorea'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing fields']);
            exit;
        }

        try {
            $stmt = $db->prepare("INSERT INTO albisteak (izenburua, xehetasunak, autorea) VALUES (:izenburua, :xehetasunak, :autorea)");
            $stmt->execute([
                ':izenburua' => $data['izenburua'],
                ':xehetasunak' => $data['xehetasunak'],
                ':autorea' => $data['autorea']
            ]);

            echo json_encode(['id' => $db->lastInsertId(), 'message' => 'Created successfully', 'izenburua' => $data['izenburua'], 'xehetasunak' => $data['xehetasunak'], 'autorea' => $data['autorea']]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'DB error', 'message' => $e->getMessage()]);
            exit;
        }
    } elseif ($method === 'PUT') {
        if (!is_authenticated($db)) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $id = isset($data['id']) ? $data['id'] : (isset($_GET['id']) ? $_GET['id'] : null);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id']);
            exit;
        }

        $fields = [];
        $params = [];
        if (isset($data['izenburua'])) {
            $fields[] = "izenburua = :izenburua";
            $params[':izenburua'] = $data['izenburua'];
        }
        if (isset($data['xehetasunak'])) {
            $fields[] = "xehetasunak = :xehetasunak";
            $params[':xehetasunak'] = $data['xehetasunak'];
        }
        if (isset($data['autorea'])) {
            $fields[] = "autorea = :autorea";
            $params[':autorea'] = $data['autorea'];
        }

        if (empty($fields)) {
            http_response_code(400);
            echo json_encode(['error' => 'No fields to update']);
            exit;
        }

        $params[':id'] = $id;
        $sql = "UPDATE albisteak SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        echo json_encode(['message' => 'Updated successfully']);
    } elseif ($method === 'DELETE') {
        if (!is_authenticated($db)) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } elseif (isset($data['id'])) {
            $id = $data['id'];
        } else {
            $id = null;
        }

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing id']);
            exit;
        }

        $stmt = $db->prepare("DELETE FROM albisteak WHERE id = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['message' => 'Deleted successfully']);
    }
} catch (Throwable $e) {
    $code = ($e->getCode() >= 100 && $e->getCode() <= 599) ? $e->getCode() : 500;
    http_response_code($code);
    echo json_encode(['error' => $e->getMessage()]);
}
?>