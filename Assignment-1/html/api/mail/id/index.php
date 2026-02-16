<?php
require '../../../vendor/autoload.php';

use Application\Mail;
use Application\Page;

$dsn = "pgsql:host=" . getenv('DB_PROD_HOST') . ";dbname=" . getenv('DB_PROD_NAME');

try {
    $pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

$mail = new Mail($pdo);
$page = new Page();

// extract id from URL
$uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', trim($uri, '/'));
$id = (int)end($parts);

if ($id <= 0) {
    $page->badRequest();
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $row = $mail->getById($id);
    if (!$row) {
        $page->notFound();
        exit;
    }
    $page->item($row);
    exit;
}

if ($method === 'DELETE') {
    $deleted = $mail->deleteById($id);
    if (!$deleted) {
        $page->notFound();
        exit;
    }
    $page->item(["deleted" => true]);
    exit;
}

$page->badRequest();
