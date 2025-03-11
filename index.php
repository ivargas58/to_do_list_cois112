/* Archivo: db.php */
<?php
$host = 'localhost';
$dbname = 'proyecto';
$user = 'postgres';
$password = '';

$dbconn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$dbconn) {
    die("Error: No se pudo conectar a la base de datos.");
}
?>

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

/* Archivo: add_task.php */
<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $query = "INSERT INTO tasks (task_name, task_description) VALUES ('$task_name', '$task_description')";
    pg_query($dbconn, $query);
    header("Location: index.php");
}
?>

/* Archivo: style.css */
.container {
    width: 50%;
    margin: 50px auto;
    text-align: center;
}
form {
    margin-bottom: 20px;
}
input, textarea {
    display: block;
    width: 100%;
    margin: 10px 0;
    padding: 10px;
}
button {
    background: #28a745;
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
}
ul {
    list-style: none;
    padding: 0;
}
li {
    background: #f8f9fa;
    margin: 5px 0;
    padding: 10px;
}
