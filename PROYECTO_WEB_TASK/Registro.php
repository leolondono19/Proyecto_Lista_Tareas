<?php
$host = "localhost";
$port = "5555";
$dbname = "Task";
$user = "postgres";
$password = "admin";

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Inicializar variables para los mensajes de error y texto de ejemplo
$nombre_error = $email_error = $contraseña_error = "";
$nombre = $email = $contraseña = "";
$nombre_ejemplo = "Ejemplo: Juan Pérez";
$email_ejemplo = "Ejemplo: juan@example.com";
$contraseña_ejemplo = "Ejemplo: contraseña123";

// Mensaje de éxito al registrar
$registro_exitoso = "";

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar nombre
    if (empty(trim($_POST["nombre"]))) {
        $nombre_error = "Por favor ingresa tu nombre.";
    } else {
        $nombre = trim($_POST["nombre"]);
    }

    // Validar email
    if (empty(trim($_POST["email"]))) {
        $email_error = "Por favor ingresa tu email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validar contraseña
    if (empty(trim($_POST["contraseña"]))) {
        $contraseña_error = "Por favor ingresa tu contraseña.";
    } else {
        $contraseña = trim($_POST["contraseña"]);
    }

    // Insertar datos en la base de datos si no hay errores
    if (empty($nombre_error) && empty($email_error) && empty($contraseña_error)) {
        $sql = "INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Enlazar variables a la declaración preparada como parámetros
            $stmt->bindParam(1, $nombre);
            $stmt->bindParam(2, $email);

            // Almacenar el valor en una variable antes de pasarla por referencia
            $hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);
            $stmt->bindParam(3, $hashed_password);

            // Ejecutar la declaración preparada
            if ($stmt->execute()) {
                // Mensaje de éxito
                $registro_exitoso = "¡Registro exitoso!";

                // Limpiar los campos después de registrar
                $nombre = $email = $contraseña = "";
            } else {
                echo "Error al ejecutar la consulta.";
            }

            // Cerrar la declaración
            $stmt = null;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
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
            width: 400px;
            animation: zoomIn 1s ease-out;
        }

        @keyframes zoomIn {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
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

        .mensaje-exito {
            text-align: center;
            color: green;
            margin-bottom: 10px;
        }

        .volver-inicio {
            text-align: center;
            margin-top: 10px;
        }

        .volver-inicio a {
            color: blue;
            text-decoration: none;
        }

        .volver-inicio a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Registro de Usuario</h2>
            <div class="mensaje-exito"><?php echo $registro_exitoso; ?></div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <label>Nombre:</label>
                    <input type="text" name="nombre" value="<?php echo $nombre; ?>" placeholder="<?php echo $nombre_ejemplo; ?>">
                    <span class="error"><?php echo $nombre_error; ?></span>
                </div>
                <div>
                    <label>Email:</label>
                    <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $email_ejemplo; ?>">
                    <span class="error"><?php echo $email_error; ?></span>
                </div>
                <div>
                    <label>Contraseña:</label>
                    <input type="password" name="contraseña" placeholder="<?php echo $contraseña_ejemplo; ?>">
                    <span class="error"><?php echo $contraseña_error; ?></span>
                </div>
                <div>
                    <input type="submit" value="Registrarse">
                </div>
            </form>
            <div class="volver-inicio">
                <a href="index.php">Volver a la página de inicio</a>
            </div>
        </div>
    </div>
    <footer>
        <p>Realizado por CodeMakers</p>
    </footer>
</body>
</html>
