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

// Verificar si se ha enviado el formulario de modificación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar_tarea'])) {
    try {
        // Obtener los datos del formulario de modificación
        $id_tarea = $_POST["id_tarea"];
        $titulo = $_POST["titulo"];
        $descripcion = $_POST["descripcion"];
        $fecha_limite = $_POST["fecha_limite"];
        $prioridad = $_POST["prioridad"];
        $estado = $_POST["estado"];

        // Preparar la consulta de actualización
        $stmt = $pdo->prepare("UPDATE tareas SET titulo = :titulo, descripcion = :descripcion, fecha_limite = :fecha_limite, prioridad = :prioridad, estado = :estado WHERE id = :id_tarea");

        // Enlazar los parámetros
        $stmt->bindParam(":id_tarea", $id_tarea);
        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":descripcion", $descripcion);
        $stmt->bindParam(":fecha_limite", $fecha_limite);
        $stmt->bindParam(":prioridad", $prioridad);
        $stmt->bindParam(":estado", $estado);

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Tarea</title>
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
            <h2>Modificar Tarea</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div>
                    <label for="id_tarea">Seleccionar Tarea:</label>
                    <select name="id_tarea" id="id_tarea">
                        <?php foreach ($tareas as $tarea): ?>
                            <option value="<?php echo $tarea['id']; ?>"><?php echo $tarea['titulo']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <input type="submit" name="seleccionar_tarea" value="Seleccionar">
                </div>
            </form>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['seleccionar_tarea'])): ?>
                <?php
                // Obtener el ID de la tarea seleccionada
                $id_tarea_seleccionada = $_POST["id_tarea"];

                // Consultar los detalles de la tarea seleccionada
                $stmt = $pdo->prepare("SELECT * FROM tareas WHERE id = :id_tarea");
                $stmt->bindParam(":id_tarea", $id_tarea_seleccionada);
                $stmt->execute();
                $tarea = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <h2>Datos de la Tarea Seleccionada</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="id_tarea" value="<?php echo $tarea['id']; ?>">
                    <div>
                        <label for="titulo">Título:</label>
                        <input type="text" name="titulo" id="titulo" value="<?php echo $tarea['titulo']; ?>">
                    </div>
                    <div>
                        <label for="descripcion">Descripción:</label>
                        <textarea name="descripcion" id="descripcion"><?php echo $tarea['descripcion']; ?></textarea>
                    </div>
                    <div>
                        <label for="fecha_limite">Fecha límite:</label>
                        <input type="text" name="fecha_limite" id="fecha_limite" value="<?php echo $tarea['fecha_limite']; ?>">
                    </div>
                    <div>
                        <label for="prioridad">Prioridad:</label>
                        <select name="prioridad" id="prioridad">
                            <option value="Normal" <?php echo ($tarea['prioridad'] == 'Normal') ? 'selected' : ''; ?>>Normal</option>
                            <option value="Super Importante" <?php echo ($tarea['prioridad'] == 'Super Importante') ? 'selected' : ''; ?>>Super Importante</option>
                            <option value="Importante" <?php echo ($tarea['prioridad'] == 'Importante') ? 'selected' : ''; ?>>Importante</option>
                            <option value="No relevante" <?php echo ($tarea['prioridad'] == 'No relevante') ? 'selected' : ''; ?>>No relevante</option>
                        </select>
                    </div>
                    <div>
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado">
                            <option value="Pendiente" <?php echo ($tarea['estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                            <option value="En Curso" <?php echo ($tarea['estado'] == 'En Curso') ? 'selected' : ''; ?>>En Curso</option>
                            <option value="Completada" <?php echo ($tarea['estado'] == 'Completada') ? 'selected' : ''; ?>>Completada</option>
                        </select>
                    </div>
                    <div>
                        <input type="submit" name="modificar_tarea" value="Modificar Tarea">
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
