<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    $host = "localhost";
    $port = "5555"; 
    $dbname = "Task";
    $user = "postgres";
    $password = "admin";

    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Recuperar los datos del formulario
        $titulo = $_POST["titulo"];
        $descripcion = $_POST["descripcion"];
        $fecha_limite = $_POST["fecha_limite"];
        $prioridad = $_POST["prioridad"];
        
        // Insertar la tarea en la base de datos
        $stmt = $pdo->prepare("INSERT INTO tareas (titulo, descripcion, fecha_limite, prioridad) VALUES (:titulo, :descripcion, :fecha_limite, :prioridad)");

        // Enlazar los parámetros
        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":fecha_limite", $fecha_limite);
        $stmt->bindParam(":prioridad", $prioridad);

        // Ejecutar la consulta
        $stmt->execute();

        // Redireccionar a la página de éxito
        header("Location: PanelTareas.html?success=true");
        exit();
    } catch (PDOException $e) {
        // Manejar cualquier error de la base de datos
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Tareas</title>
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
            width: 400px;
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
        .form-container form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-container form select {
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
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Registro de Tarea</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo" id="titulo" placeholder="Ejemplo: Completar informe mensual">
                </div>
                <div>
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" placeholder="Ejemplo: Descripción detallada de la tarea"></textarea>
                </div>
                <div>
                    <label for="fecha_limite">Fecha límite:</label>
                    <input type="text" name="fecha_limite" id="fecha_limite" placeholder="Ejemplo: AAAA-MM-DD">
                </div>
                <div>
                    <label for="prioridad">Prioridad:</label>
                    <select name="prioridad" id="prioridad">
                        <option value="Normal">Normal</option>
                        <option value="Super Importante">Super Importante</option>
                        <option value="Importante">Importante</option>
                        <option value="No relevante">No relevante</option>
                    </select>
                </div>
                <div>
                    <input type="submit" value="Registrar Tarea">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
