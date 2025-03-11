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