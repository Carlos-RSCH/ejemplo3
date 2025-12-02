<?php // /api/lib/auth.php
require_once __DIR__.'/jwt.php';

function require_bearer() {
  $hdr = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
  if (stripos($hdr, 'Bearer ') !== 0) {
    http_response_code(401);
    echo json_encode(['error' => 'Authorization requerido']);
    exit;
  }
  $token = trim(substr($hdr, 7));
  $secret = 'cambia_este_secret_fuerte';
  [$ok, $data] = jwt_verify($token, $secret);
  if (!$ok) {
    http_response_code(401);
    echo json_encode(['error' => $data]);
    exit;
  }
  return $data; // contiene: user_id, username, iat, exp...
}