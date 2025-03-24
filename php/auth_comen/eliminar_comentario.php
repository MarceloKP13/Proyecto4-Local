<?php
session_start();
include 'conexion_com.php';

header('Content-Type: application/json');

if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conexion, $_POST['id']);
    
    $sql = "DELETE FROM comentarios WHERE id = '$id'";
    
    if (mysqli_query($conexion, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el comentario']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
}

mysqli_close($conexion);
?>