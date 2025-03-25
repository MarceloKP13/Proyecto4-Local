<?php
require_once 'conexion_com.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = !empty($_POST['nombre_comentario']) ? $_POST['nombre_comentario'] : 'Anónimo';
    $tipo = $_POST['tipo_comentario'];
    $comentario = $_POST['comentario'];

    $sql = "INSERT INTO comentarios (nombre, tipo_comentario, comentario) VALUES (:nombre, :tipo, :comentario)";
    $stmt = $conexion->prepare($sql);
    
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':comentario', $comentario);
    
    if ($stmt->execute()) {
        header('Location: ../contactos.php?comentario_enviado=true');
        exit();
    } else {
        echo "<script>alert('Error al guardar el comentario'); window.location.href='../contactos.php';</script>";
        exit();
    }
}
?>