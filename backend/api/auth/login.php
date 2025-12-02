<?php // /api/auth/login.php
header('Content-Type: application/json');
require_once __DIR__.'/../lib/db.php';
require_once __DIR__.'/../lib/jwt.php';

$input = json_decode(file_get_contents('php://input'), true);
$username = trim($input['username'] ?? '');
$password = $input['password'] ?? '';

$pdo = db();
$stmt = $pdo->prepare('SELECT id, password FROM usuarios WHERE nombre_de_usuario = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
  http_response_code(401);
  echo json_encode(['error' => 'Credenciales inválidas']);
  exit;
}

$secret = 'cambia_este_secret_fuerte';
$token = jwt_sign(['user_id' => (int)$user['id'], 'username' => $username], $secret, 3600); // 1h

// opcional: guardar última emisión
$pdo->prepare('UPDATE usuarios SET token = ? WHERE id = ?')->execute([$token, $user['id']]);

echo json_encode(['token' => $token]);