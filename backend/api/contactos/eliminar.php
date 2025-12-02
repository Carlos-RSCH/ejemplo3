<?php // /api/contactos/eliminar.php (DELETE ?id=)
header('Content-Type: application/json');
require_once __DIR__.'/../lib/db.php';
require_once __DIR__.'/../lib/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') { http_response_code(405); echo json_encode(['error'=>'Método no permitido']); exit; }

$claims = require_bearer();
$id = (int)($_GET['id'] ?? 0);

$pdo = db();
$own = $pdo->prepare('SELECT id FROM contactos WHERE id = ? AND usuario_id = ?');
$own->execute([$id, $claims['user_id']]);
if (!$own->fetch()) { http_response_code(404); echo json_encode(['error'=>'Contacto no encontrado']); exit; }

$pdo->prepare('DELETE FROM contactos WHERE id = ?')->execute([$id]);
echo json_encode(['message'=>'Contacto eliminado']);