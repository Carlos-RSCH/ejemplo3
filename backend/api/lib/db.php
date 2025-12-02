<?php // /api/lib/db.php
function db() {
  $host = 'localhost';
  $db   = 'agenda_db';
  $user = 'root';
  $pass = '1604';
  $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
  $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];
  return new PDO($dsn, $user, $pass, $opt);
}