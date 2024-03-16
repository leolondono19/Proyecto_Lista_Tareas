<?php
// Incluir el archivo de conexión a la base de datos
$host = "localhost";
$port = "5555"; 
$dbname = "Task";
$user = "postgres";
$password = "admin";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar todas las tareas disponibles
    $stmt = $pdo->query("SELECT id, titulo FROM tareas");
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Manejar cualquier error de la base de datos
    echo "Error: " . $e->getMessage();
}

// Función para eliminar una tarea
function eliminarTarea($id_tarea) {
    global $pdo;
    try {
        // Preparar la consulta SQL para eliminar la tarea
        $stmt = $pdo->prepare("DELETE FROM tareas WHERE id = :id_tarea");

        // Enlazar el parámetro
        $stmt->bindParam(":id_tarea", $id_tarea);

        // Ejecutar la consulta
        $stmt->execute();

        // Redireccionar a alguna página de éxito
        header("Location: PanelTareas.html");
        exit();
    } catch (PDOException $e) {
        // Manejar cualquier error de la base de datos
        echo "Error: " . $e->getMessage();
    }
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la tarea a eliminar
    $id_tarea_eliminar = $_POST["id_tarea_eliminar"];
    // Llamar a la función para eliminar la tarea
    eliminarTarea($id_tarea_eliminar);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar Tarea</title>
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
            background-color: #FF6347;
            color: white;
            cursor: pointer;
        }

        .form-container form input[type="submit"]:hover {
            background-color: #FF4500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Borrar Tarea</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <label for="id_tarea_eliminar">Seleccionar Tarea a Eliminar:</label>
                    <select name="id_tarea_eliminar" id="id_tarea_eliminar">
                        <?php foreach ($tareas as $tarea): ?>
                            <option value="<?php echo $tarea['id']; ?>"><?php echo $tarea['titulo']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <input type="submit" value="Borrar Tarea">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
