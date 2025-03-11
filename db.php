/* Archivo: db.php */
<?php
$host = 'localhost';
$dbname = 'nombre_basedatos';
$user = 'usuario';
$password = 'contraseña';

$dbconn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$dbconn) {
    die("Error: No se pudo conectar a la base de datos.");
}
?>