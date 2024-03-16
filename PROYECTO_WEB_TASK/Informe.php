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

    // Consultar las tareas completadas
    $stmt_completadas = $pdo->query("SELECT * FROM tareas WHERE estado = 'Completada'");
    $tareas_completadas = $stmt_completadas->fetchAll(PDO::FETCH_ASSOC);

    // Consultar las tareas pendientes
    $stmt_pendientes = $pdo->query("SELECT * FROM tareas WHERE estado = 'Pendiente'");
    $tareas_pendientes = $stmt_pendientes->fetchAll(PDO::FETCH_ASSOC);

    // Consultar las tareas en curso
    $stmt_en_curso = $pdo->query("SELECT * FROM tareas WHERE estado = 'En Curso'");
    $tareas_en_curso = $stmt_en_curso->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Manejar cualquier error de la base de datos
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informes de Tareas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            color: white;
        }

        .container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            padding: 20px;
        }

        .section {
            width: 30%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .section h2 {
            text-align: center;
        }

        .task {
            margin-bottom: 10px;
            padding: 5px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }

        .task p {
            margin: 0;
        }

        .btn-container {
            margin-top: 20px;
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .timer {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="section">
            <h2>Tareas Completadas</h2>
            <?php foreach ($tareas_completadas as $tarea): ?>
                <div class="task">
                    <p><strong>Título:</strong> <?php echo $tarea['titulo']; ?></p>
                    <p><strong>Descripción:</strong> <?php echo $tarea['descripcion']; ?></p>
                    <p><strong>Fecha Límite:</strong> <?php echo $tarea['fecha_limite']; ?></p>
                    <p><strong>Prioridad:</strong> <?php echo $tarea['prioridad']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section">
            <h2>Tareas Pendientes</h2>
            <?php foreach ($tareas_pendientes as $tarea): ?>
                <div class="task">
                    <p><strong>Título:</strong> <?php echo $tarea['titulo']; ?></p>
                    <p><strong>Descripción:</strong> <?php echo $tarea['descripcion']; ?></p>
                    <p><strong>Fecha Límite:</strong> <?php echo $tarea['fecha_limite']; ?></p>
                    <p><strong>Prioridad:</strong> <?php echo $tarea['prioridad']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section">
            <h2>Tareas en Curso</h2>
            <?php foreach ($tareas_en_curso as $tarea): ?>
                <div class="task">
                    <p><strong>Título:</strong> <?php echo $tarea['titulo']; ?></p>
                    <p><strong>Descripción:</strong> <?php echo $tarea['descripcion']; ?></p>
                    <p><strong>Fecha Límite:</strong> <?php echo $tarea['fecha_limite']; ?></p>
                    <p><strong>Prioridad:</strong> <?php echo $tarea['prioridad']; ?></p>
                    <div class="timer" id="timer_<?php echo $tarea['id']; ?>">Tiempo transcurrido: </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="btn-container">
        <a href="PanelTareas.html" class="btn">Volver a la Página Principal</a>
    </div>

    <script>
        // Función para actualizar el cronómetro cada segundo
        setInterval(function() {
            <?php foreach ($tareas_en_curso as $tarea): ?>
                // Obtener la fecha de inicio de la tarea
                var startTime_<?php echo $tarea['id']; ?> = new Date('<?php echo $tarea['fecha_creacion']; ?>');
                var currentTime_<?php echo $tarea['id']; ?> = new Date();

                // Calcular el tiempo transcurrido en milisegundos
                var elapsedTime_<?php echo $tarea['id']; ?> = currentTime_<?php echo $tarea['id']; ?> - startTime_<?php echo $tarea['id']; ?>;

                // Convertir el tiempo transcurrido a horas, minutos y segundos
                var hours_<?php echo $tarea['id']; ?> = Math.floor((elapsedTime_<?php echo $tarea['id']; ?> / (1000 * 60 * 60)) % 24);
                var minutes_<?php echo $tarea['id']; ?> = Math.floor((elapsedTime_<?php echo $tarea['id']; ?> / (1000 * 60)) % 60);
                var seconds_<?php echo $tarea['id']; ?> = Math.floor((elapsedTime_<?php echo $tarea['id']; ?> / 1000) % 60);

                // Mostrar el tiempo transcurrido en el elemento HTML correspondiente
                document.getElementById('timer_<?php echo $tarea['id']; ?>').textContent = 'Tiempo transcurrido: ' + hours_<?php echo $tarea['id']; ?> + ' horas, ' + minutes_<?php echo $tarea['id']; ?> + ' minutos, ' + seconds_<?php echo $tarea['id']; ?> + ' segundos';
            <?php endforeach; ?>
        }, 1000);
    </script>
</body>
</html>
