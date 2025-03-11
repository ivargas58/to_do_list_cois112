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