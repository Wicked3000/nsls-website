<?php
// ============================================================
//  NSLS — Downloads Tracker
//  Endpoint: GET /backend/download.php?id=<download_id>
//  Increments the download count and redirects to the file.
// ============================================================

header('Content-Type: application/json');

require_once __DIR__ . '/db.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid download ID.']);
    exit;
}

try {
    $pdo = getDB();

    // Fetch file path
    $stmt = $pdo->prepare("SELECT file_path, title FROM downloads WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $file = $stmt->fetch();

    if (!$file) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Download not found.']);
        exit;
    }

    // Increment download count
    $pdo->prepare("UPDATE downloads SET download_count = download_count + 1 WHERE id = :id")
        ->execute([':id' => $id]);

    // Redirect to actual file
    header('Location: ' . $file['file_path']);
    exit;

}
catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error.']);
}
