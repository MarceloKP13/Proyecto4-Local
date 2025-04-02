<?php
session_start();
include 'conexion_com.php';
header('Content-Type: application/json');

if (!isset($_SESSION['es_admin']) || !$_SESSION['es_admin']) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $stmt = $conexion->prepare("DELETE FROM comentarios WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró el comentario']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el comentario']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
}
?>