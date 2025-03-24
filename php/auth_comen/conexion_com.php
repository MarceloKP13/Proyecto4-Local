<?php
$conexion = new PDO("mysql:host=sql305.infinityfree.com;dbname=if0_38584302_havcana_db", "if0_38584302", "u5x0DWHfc6l");

try {
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
