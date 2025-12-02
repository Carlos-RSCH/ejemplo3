<?php // /api/contactos/actualizar.php (PUT ?id=)
header('Content-Type: application/json');
require_once __DIR__.'/../lib/db.php';
require_once __DIR__.'/../lib/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') { http_response_code(405); echo json_encode(['error'=>'Método no permitido']); exit; }

$claims = require_bearer();
$id = (int)($_GET['id'] ?? 0);
$input = json_decode(file_get_contents('php://input'), true);

$pdo = db();
$own = $pdo->prepare('SELECT id FROM contactos WHERE id = ? AND usuario_id = ?');
$own->execute([$id, $claims['user_id']]);
if (!$own->fetch()) { http_response_code(404); echo json_encode(['error'=>'Contacto no encontrado']); exit; }

$upd = $pdo->prepare('UPDATE contactos SET nombre=?, apellido=?, telefono=?, email=?, direccion=?, notas=? WHERE id=?');
$upd->execute([
  trim($input['nombre'] ?? ''),
  $input['apellido'] ?? null,
  trim($input['telefono'] ?? ''),
  $input['email'] ?? null,
  $input['direccion'] ?? null,
  $input['notas'] ?? null,
  $id
]);
echo json_encode(['message'=>'Contacto actualizado']);