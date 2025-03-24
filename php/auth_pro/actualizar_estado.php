<?php
include '../auth/conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pedido_id = $_POST['pedido_id'];
    $nuevo_estado = $_POST['estado'];
    
    $query = "UPDATE pedidos SET estado = ? WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ii", $nuevo_estado, $pedido_id);
    
    $success = mysqli_stmt_execute($stmt);
    
    echo json_encode(['success' => $success]);
    mysqli_stmt_close($stmt);
}
?>