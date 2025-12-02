<?php // /api/auth/registrar.php
header('Content-Type: application/json');
require_once __DIR__.'/../lib/db.php';

$input = json_decode(file_get_contents('php://input'), true);
$username = trim($input['username'] ?? '');
$password = $input['password'] ?? '';

if ($username === '' || $password === '') {
  http_response_code(400);
  echo json_encode(['error' => 'username y password son obligatorios']);
  exit;
}

$pdo = db();
$stmt = $pdo->prepare('SELECT id FROM usuarios WHERE nombre_de_usuario = ?');
$stmt->execute([$username]);
if ($stmt->fetch()) {
  http_response_code(409);
  echo json_encode(['error' => 'Usuario ya existe']);
  exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$pdo->prepare('INSERT INTO usuarios (nombre_de_usuario, password) VALUES (?, ?)')->execute([$username, $hash]);

echo json_encode(['message' => 'Usuario registrado']);