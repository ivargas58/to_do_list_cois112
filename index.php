<?php
// Configuración de la base de datos PostgreSQL
$host = "localhost";
$dbname = "proyecto";
$user = "postgres";  // Cambia esto por tu usuario de PostgreSQL
$password = "";  // Cambia esto por tu contraseña

// Conexión a PostgreSQL
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("Error de conexión a PostgreSQL.");
}

// Crear tabla si no existe
pg_query($conn, "CREATE TABLE IF NOT EXISTS tasks (
    id SERIAL PRIMARY KEY,
    task TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Agregar tarea
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task"])) {
    $task = pg_escape_string($conn, $_POST["task"]);
    pg_query($conn, "INSERT INTO tasks (task) VALUES ('$task')");
    header("Location: index.php");
    exit();
}

// Eliminar tarea
if (isset($_GET["delete"])) {
    $id = intval($_GET["delete"]);
    pg_query($conn, "DELETE FROM tasks WHERE id = $id");
    header("Location: index.php");
    exit();
}

// Obtener tareas
$result = pg_query($conn, "SELECT * FROM tasks ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; text-align: center; padding: 20px; }
        h2 { color: #333; }
        form { margin-bottom: 20px; }
        input[type="text"] { padding: 10px; width: 300px; border: 1px solid #ccc; border-radius: 5px; }
        button { padding: 10px 15px; border: none; background: #28a745; color: white; cursor: pointer; }
        button:hover { background: #218838; }
        ul { list-style: none; padding: 0; }
        li { background: white; margin: 10px auto; padding: 10px; width: 320px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; }
        a { text-decoration: none; color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Lista de Tareas</h2>
    
    <form method="POST">
        <input type="text" name="task" placeholder="Nueva tarea..." required>
        <button type="submit">Agregar</button>
    </form>

    <ul>
        <?php while ($row = pg_fetch_assoc($result)): ?>
            <li>
                <?php echo htmlspecialchars($row["task"]); ?>
                <a href="?delete=<?php echo $row["id"]; ?>" onclick="return confirm('¿Eliminar tarea?')">✖</a>
            </li>
        <?php endwhile; ?>
    </ul>

</body>
</html>
