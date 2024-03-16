<?php
session_start(); // Iniciar sesión

if(isset($_SESSION['usuario'])){
    // Si ya hay una sesión iniciada, redirigir al usuario a otra página
    header("Location: PanelTareas.html");
    exit;
}

$host = "localhost";
$port = "5555";
$dbname = "Task";
$user = "postgres";
$password = "admin";

$mensaje = ""; // Inicializar variable para mensaje de inicio de sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el formulario de inicio de sesión fue enviado
    if(isset($_POST["email"]) && isset($_POST["contraseña"])){
        $email = $_POST["email"];
        $contraseña = $_POST["contraseña"];

        try {
            $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta para verificar las credenciales del usuario
            $sql = "SELECT nombre, contraseña FROM usuarios WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            // Verificar si se encontró algún registro
            if($stmt->rowCount() > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $hash_guardado = $row['contraseña'];
                if(password_verify($contraseña, $hash_guardado)){
                    // Contraseña correcta
                    $_SESSION['usuario'] = $row['nombre'];
                    $mensaje = "Inicio de sesión correctamente. Redirigiendo...";
                    header("refresh:2;url=PanelTareas.html"); // Redireccionar después de 2 segundos
                    exit;
                } else {
                    // Contraseña incorrecta
                    $mensaje = "Email o contraseña incorrectos. Por favor, inténtalo de nuevo.";
                }
            } else {
                // No se encontró ningún usuario con ese email
                $mensaje = "Email o contraseña incorrectos. Por favor, inténtalo de nuevo.";
            }
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #4e54c8, #8f94fb);
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container form label {
            display: block;
            margin-bottom: 5px;
        }

        .form-container form input[type="text"],
        .form-container form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container form .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .form-container form input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .form-container form input[type="submit"]:hover {
            background-color: #45a049;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
            left: 0;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Iniciar Sesión</h2>
            <?php if(!empty($mensaje)): ?>
                <p class="error"><?php echo $mensaje; ?></p>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label>Email:</label>
                <input type="text" name="email">
                <br>
                <label>Contraseña:</label>
                <input type="password" name="contraseña">
                <br>
                <input type="submit" value="Iniciar Sesión">
            </form>
        </div>
    </div>
    <footer>
        <p>Realizado por CodeMakers</p>
    </footer>
</body>
</html>
