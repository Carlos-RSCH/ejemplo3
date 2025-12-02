<?php // /api/auth/perfil.php (GET)
header('Content-Type: application/json');
require_once __DIR__.'/../lib/db.php';
require_once __DIR__.'/../lib/auth.php';

$claims = require_bearer();
$pdo = db();
$stmt = $pdo->prepare('SELECT id, nombre_de_usuario, fecha_registro FROM usuarios WHERE id = ?');
$stmt->execute([$claims['user_id']]);
echo json_encode($stmt->fetch() ?: []);