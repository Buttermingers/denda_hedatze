<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

$dbFile = 'albisteak.db';

try {
    $db = new PDO("sqlite:$dbFile");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("CREATE TABLE IF NOT EXISTS albisteak (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        izenburua TEXT NOT NULL,
        xehetasunak TEXT NOT NULL,
        autorea TEXT NOT NULL
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS sessions (
        token TEXT PRIMARY KEY,
        user_id INTEGER,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $hashedPassword = password_hash('admin', PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES ('admin', :password)");
        $stmt->execute([':password' => $hashedPassword]);
    }

    $stmt = $db->query("SELECT COUNT(*) FROM albisteak");
    if ($stmt->fetchColumn() == 0) {
        $albisteakData = [
            [
                'izenburua' => 'Vue 3.0 kaleratu da',
                'xehetasunak' => 'Vue.js framework-aren bertsio berria eskuragarri dago funtzionalitate berriekin.',
                'autorea' => 'Mikel'
            ],
            [
                'izenburua' => 'Teknologia berriak 2024',
                'xehetasunak' => 'Adimen artifiziala eta konputazio kuantikoa gero eta garrantzitsuagoak dira.',
                'autorea' => 'Ane'
            ],
            [
                'izenburua' => 'Programazio ikastaroa',
                'xehetasunak' => 'Datorren astean hasiko da Python eta JavaScript ikastaroa.',
                'autorea' => 'Jon'
            ],
            [
                'izenburua' => 'Hackathon-a Bilbon',
                'xehetasunak' => 'Asteburu honetan hackathon erraldoia ospatuko da Euskalduna jauregian.',
                'autorea' => 'Maite'
            ]
        ];

        $insert = $db->prepare("INSERT INTO albisteak (izenburua, xehetasunak, autorea) VALUES (:izenburua, :xehetasunak, :autorea)");
        foreach ($albisteakData as $albiste) {
            $insert->execute($albiste);
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Database initialized']);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>