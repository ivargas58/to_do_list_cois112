/* Archivo: index.php */
<?php
include 'db.php';
$result = pg_query($dbconn, "SELECT * FROM tasks ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Tareas</h1>
        <form action="add_task.php" method="POST">
            <input type="text" name="task_name" placeholder="Nueva tarea" required>
            <textarea name="task_description" placeholder="Descripción"></textarea>
            <button type="submit">Agregar</button>
        </form>
        <ul>
            <?php while ($row = pg_fetch_assoc($result)) { ?>
                <li><?php echo $row['task_name']; ?> - <?php echo $row['task_description']; ?></li>
            <?php } ?>
        </ul>
    </div>
</body>
</html>
