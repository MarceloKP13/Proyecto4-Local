<?php
session_start();
include '../auth/conexion_be.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    header("Location: ../catalogo.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $maridaje = $_POST['maridaje'];

    // Actualizar información básica
    $query = "UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, maridaje = ? WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sdssi", $nombre, $precio, $descripcion, $maridaje, $producto_id);
    $stmt->execute();

    // Procesar nueva imagen si se subió una
    if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] === 0) {
        $imagen = $_FILES['nueva_imagen'];
        $nombre_archivo = basename($imagen['name']);
        $ruta_destino = "../../anexos/imagenes/" . $nombre_archivo;
        
        if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
            $ruta_bd = "../anexos/imagenes/" . $nombre_archivo;
            
            // Actualizar imagen en productos
            $query = "UPDATE productos SET imagen = ? WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("si", $ruta_bd, $producto_id);
            $stmt->execute();
        }
    }

    header("Location: ../catalogo.php");
    exit();
}
?>