<?php
$conexion = new PDO("mysql:host=localhost;dbname=havcana_db", "root", "");

try {
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

