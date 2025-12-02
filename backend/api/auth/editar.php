<?php // /api/auth/editar.php (PUT)
header('Content-Type: application/json');
require_once __DIR__.'/../lib/db.php';
require_once __DIR__.'/../lib/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
  http_response_code(405); echo json_encode(['error' => 'Método no permitido']); exit;
}

$claims = require_bearer();
$input = json_decode(file_get_contents('php://input'), true);
$newUsername = trim($input['username'] ?? '');

if ($newUsername === '') { http_response_code(400); echo json_encode(['error'=>'username requerido']); exit; }

$pdo = db();
$exists = $pdo->prepare('SELECT id FROM usuarios WHERE nombre_de_usuario = ? AND id <> ?');
$exists->execute([$newUsername, $claims['user_id']]);
if ($exists->fetch()) { http_response_code(409); echo json_encode(['error'=>'username en uso']); exit; }

$upd = $pdo->prepare('UPDATE usuarios SET nombre_de_usuario = ? WHERE id = ?');
$upd->execute([$newUsername, $claims['user_id']]);
echo json_encode(['message'=>'Perfil actualizado']);