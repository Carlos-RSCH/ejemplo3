<?php // /api/contactos/index.php (GET)
header('Content-Type: application/json');
require_once __DIR__.'/../lib/db.php';
require_once __DIR__.'/../lib/auth.php';

$claims = require_bearer();
$pdo = db();

$q = trim($_GET['q'] ?? '');
if ($q !== '') {
  $stmt = $pdo->prepare(
    'SELECT * FROM contactos WHERE usuario_id = ? AND (nombre LIKE ? OR apellido LIKE ?) ORDER BY fecha_creacion DESC'
  );
  $like = "%$q%";
  $stmt->execute([$claims['user_id'], $like, $like]);
} else {
  $stmt = $pdo->prepare('SELECT * FROM contactos WHERE usuario_id = ? ORDER BY fecha_creacion DESC');
  $stmt->execute([$claims['user_id']]);
}
echo json_encode($stmt->fetchAll());