<?php
// Forzar a PHP a mostrar cualquier error en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = '127.0.0.1'; 
$db   = 'refugio_mascotas';
$user = 'root';
$pass = 'root'; 
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
     die("Error de conexión crítico: " . $e->getMessage());
}
?>