<?php
$host = 'localhost';
$dbname = 'havcana_db';
$username = 'root';
$password = '';

try {
    $conexion = mysqli_connect($host, $username, $password, $dbname);
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
} catch(Exception $e) {
    die("Error de conexión: " . $e->getMessage());
}