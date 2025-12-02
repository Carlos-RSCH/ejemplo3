<?php // /api/contactos/crear.php (POST)
header('Content-Type: application/json');
require_once __DIR__.'/../lib/db.php';
require_once __DIR__.'/../lib/auth.php';

$claims = require_bearer();
$input = json_decode(file_get_contents('php://input'), true);

$nombre = trim($input['nombre'] ?? '');
$telefono = trim($input['telefono'] ?? '');
if ($nombre === '' || $telefono === '') { http_response_code(400); echo json_encode(['error'=>'nombre y telefono obligatorios']); exit; }

$pdo = db();
$stmt = $pdo->prepare('INSERT INTO contactos (usuario_id, nombre, apellido, telefono, email, direccion, notas)
                       VALUES (?, ?, ?, ?, ?, ?, ?)');
$stmt->execute([
  $claims['user_id'],
  $nombre,
  $input['apellido'] ?? null,
  $telefono,
  $input['email'] ?? null,
  $input['direccion'] ?? null,
  $input['notas'] ?? null
]);
echo json_encode(['message'=>'Contacto creado', 'id' => $pdo->lastInsertId()]);