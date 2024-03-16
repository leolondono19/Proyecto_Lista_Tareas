<?php
$host = "localhost";
$port = "5555"; 
$dbname = "Task";
$user = "postgres";
$password = "admin";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Agregar esta línea para asegurarnos de que la conexión esté disponible para otros scripts
    return $pdo;
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

