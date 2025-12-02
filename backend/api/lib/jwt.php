<?php // /api/lib/jwt.php
function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
function base64url_decode($data) {
  return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', (4 - strlen($data) % 4) % 4));
}
function jwt_sign(array $payload, string $secret, int $ttlSeconds = 3600) {
  $header = ['alg' => 'HS256', 'typ' => 'JWT'];
  $now = time();
  $payload['iat'] = $now;
  $payload['exp'] = $now + $ttlSeconds;

  $h = base64url_encode(json_encode($header));
  $p = base64url_encode(json_encode($payload));
  $sig = base64url_encode(hash_hmac('sha256', "$h.$p", $secret, true));
  return "$h.$p.$sig";
}
function jwt_verify(string $token, string $secret) {
  $parts = explode('.', $token);
  if (count($parts) !== 3) return [false, 'Formato inválido'];
  [$h, $p, $s] = $parts;
  $expected = base64url_encode(hash_hmac('sha256', "$h.$p", $secret, true));
  if (!hash_equals($expected, $s)) return [false, 'Firma inválida'];

  $payload = json_decode(base64url_decode($p), true);
  if (!$payload) return [false, 'Payload inválido'];
  if (!isset($payload['exp']) || time() >= $payload['exp']) return [false, 'Token expirado'];
  return [true, $payload];
}