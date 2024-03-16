<?php
session_start();

// Verificar si el usuario no está autenticado, si es así, redirigirlo a la página de inicio de sesión
if(!isset($_SESSION['usuario'])) {
    header("Location: Sesion.php");
    exit;
}

// Bienvenida al usuario
echo "Bienvenido, ".$_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Dashboard</h2>
    <!-- Contenido del dashboard -->
</body>
</html>
