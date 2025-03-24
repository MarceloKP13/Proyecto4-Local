<?php
session_start();
include '../auth/conexion_be.php';

if (!isset($_SESSION['usuario_id']) || empty($_SESSION['carrito'])) {
    header('Location: ../carrito.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$fecha = date('dmY');
$sql = "SELECT COUNT(*) as total FROM pedidos WHERE DATE(fecha_pedido) = CURDATE()";
$result = mysqli_query($conexion, $sql);
$row = mysqli_fetch_assoc($result);
$secuencial = str_pad($row['total'] + 1, 3, '0', STR_PAD_LEFT);
$numero_pedido = 'PED-' . $fecha . $secuencial . '-' . $usuario_id;
$subtotal = 0;
$envio = 5.00;

foreach ($_SESSION['carrito'] as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}

$total = $subtotal + $envio;

try {
    mysqli_begin_transaction($conexion);

    // Insertar pedido
    $sql_pedido = "INSERT INTO pedidos (numero_pedido, usuario_id, subtotal, envio, total) 
                   VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql_pedido);
    mysqli_stmt_bind_param($stmt, "siddd", $numero_pedido, $usuario_id, $subtotal, $envio, $total);
    mysqli_stmt_execute($stmt);
    $pedido_id = mysqli_insert_id($conexion);

    // Insertar detalles del pedido
    foreach ($_SESSION['carrito'] as $item) {
        $sql_detalle = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario) 
                        VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql_detalle);
        mysqli_stmt_bind_param($stmt, "iiid", $pedido_id, $item['id'], $item['cantidad'], $item['precio']);
        mysqli_stmt_execute($stmt);
    }

    mysqli_commit($conexion);
    $_SESSION['carrito'] = array();
    
    echo "<script>
            alert('Pedido generado exitosamente. Número de pedido: $numero_pedido');
            window.location.href = 'pedido.php';
          </script>";
} catch (Exception $e) {
    mysqli_rollback($conexion);
    echo "<script>
            alert('Error al procesar el pedido. Por favor, intente nuevamente.');
            window.location.href = '../carrito.php';
          </script>";
}

mysqli_close($conexion);
?>