<?php
session_start();
include '../auth/conexion_be.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login_registro_global.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener información del usuario
$query_usuario = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($query_usuario);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();


// Obtener todos los pedidos del usuario actual que no estén eliminados
$query_pedidos = "SELECT * FROM pedidos WHERE usuario_id = ? AND estado != 'eliminado' ORDER BY fecha_pedido DESC";
$stmt = $conexion->prepare($query_pedidos);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$pedidos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAVCANA - Pedido Generado</title>
    <link rel="icon" href="../../anexos/imagenes/logominiatura.png">
    <link rel="stylesheet" href="../../anexos/css/header.css">
    <link rel="stylesheet" href="../../anexos/css/pedido.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <img src="../../anexos/imagenes/havcanalogo.png" alt="HAVCANA Logo">
                <a href="../info.php" class="brand-name">HAVCANA</a>
                <button class="hambur">
                <span></span>
                <span></span>
                <span></span>
            </button>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="../../index.php">Inicio</a></li>
                    <li><a href="../catalogo.php">Catálogo</a></li>
                    <li><a href="../carrito.php">Carrito</a></li>                    
                    <li><a href="pedido.php">Pedidos</a></li>
                    <li><a href="../info.php">Sobre Nosotros</a></li>
                    <li><a href="../contactos.php">Contacto</a></li>
                    <?php if(isset($_SESSION['usuario'])): ?>
                        <li class="usuario-info">
                            <a href="pedido.php"><span>Hola, <?php echo $_SESSION['usuario']; ?></span></a>
                            <?php if(isset($_SESSION['es_admin']) && $_SESSION['es_admin']): ?>
                                <span class="admin-color">Admin</span>
                            <?php endif; ?>
                            <a href="../auth/salir.php">|  |   Cerrar Sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="pedido-contenedor">
    <h1>Mis Pedidos</h1>
    <div class="buscar-contenedor">
        <input type="text" id="searchPedidos" placeholder="Buscar pedido..." class="buscar-input">
    </div>

    <?php if ($pedidos->num_rows > 0): ?>
        <?php while ($pedido = $pedidos->fetch_assoc()): ?>
            <div class="pedido-card">
                <div class="pedido-header">
                    <h2>Pedido <?php echo $pedido['numero_pedido']; ?></h2>
                    <div class="<?php echo $pedido['estado'] == 1 ? 'estado-pendiente' : 'estado-realizado'; ?>" 
                         onclick="cambiarEstado(<?php echo $pedido['id']; ?>, <?php echo $pedido['estado']; ?>)">
                        Estado: <?php echo $pedido['estado'] == 1 ? 'Pendiente' : 'Realizado'; ?>
                    </div>
                    <script>
                    function cambiarEstado(id, estadoActual) {
                        const nuevoEstado = estadoActual == 1 ? 0 : 1;
                        fetch('actualizar_estado.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `pedido_id=${id}&estado=${nuevoEstado}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                location.reload();
                            }
                        });
                    }
                    </script>
                </div>
                <div class="detalles-pedido">
                    <p><strong>Nombre completo:</strong> <?php echo $usuario['nombre_completo']; ?></p>
                    <p><strong>Correo:</strong> <?php echo $usuario['correo']; ?></p>
                    <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?></p>
                    <p><strong>Total:</strong> $<?php echo number_format($pedido['total'], 2); ?></p>
                </div>
                <div class="productos-pedido">
                    <h3>Productos</h3>
                    <?php
                    $query_detalles = "SELECT dp.*, p.nombre, p.precio FROM detalles_pedido dp 
                                     JOIN productos p ON dp.producto_id = p.id 
                                     WHERE dp.pedido_id = ?";
                    $stmt_detalles = $conexion->prepare($query_detalles);
                    $stmt_detalles->bind_param("i", $pedido['id']);
                    $stmt_detalles->execute();
                    $detalles = $stmt_detalles->get_result();

                    while($detalle = $detalles->fetch_assoc()): ?>
                        <div class="producto-item">
                            <span class="producto-nombre"><?php echo $detalle['nombre']; ?></span>
                            <span class="producto-cantidad">x<?php echo $detalle['cantidad']; ?></span>
                            <span class="producto-precio">$<?php echo number_format($detalle['precio_unitario'], 2); ?></span>
                            <span class="producto-subtotal">$<?php echo number_format($detalle['precio_unitario'] * $detalle['cantidad'], 2); ?></span>
                        </div>
                    <?php endwhile; ?>
                    <div class="resumen-total">
                        <p><strong>Subtotal:</strong> $<?php echo number_format($pedido['subtotal'], 2); ?></p>
                        <p><strong>Envío:</strong> $<?php echo number_format($pedido['envio'], 2); ?></p>
                        <p class="total-final"><strong>Total:</strong> $<?php echo number_format($pedido['total'], 2); ?></p>
                    </div>
                </div>  


                    <div class="mensaje-privacidad">
                        <p>Para proteger su información personal y financiera, por favor contacte directamente con nuestro distribuidor para coordinar el pago y la entrega de su pedido.</p>
                        <a href="https://wa.me/+593939339269?text=Hola, quisiera consultar sobre mi pedido <?php echo urlencode($pedido['numero_pedido']); ?>" 
                           class="whatsapp-boton" 
                           target="_blank">
                            <i class="fab fa-whatsapp"></i> Contactar por WhatsApp
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="sin-pedidos">
                <p>No tienes pedidos por el momento.</p>
            </div>
        <?php endif; ?>
    </div>
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>HAVCANA</h3>
                <p>Vinos artesanales con sabores únicos elaborados con pasión y tradición.</p>
            </div>
            <div class="footer-section">
                <h3>Enlaces</h3>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="../../php/catalogo.php">Catálogo</a></li>
                    <li><a href="../../php/carrito.php">Carrito</a></li>
                    <li><a href="../../php/auth_pro/pedido.php">Mis Compras</a></li>
                    <li><a href="../../php/info.php">Sobre Nosotros</a></li>
                    <li><a href="../../php/contactos.php">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contacto</h3>
                <p><i class="fas fa-map-marker-alt"></i> Nueva Loja, Sucumbios, Ecuador</p>
                <p><i class="fas fa-phone"></i> +593 93 933 9269</p>
                <p><i class="fas fa-envelope"></i> info@havcana.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 HAVCANA. Todos los derechos reservados.</p>
            <div class="fredes-sociales">
                <a href="https://www.facebook.com/havcana8" target="_blank"><img src="../../anexos/imagenes/facebook.png" alt="Facebook"></a>
                <a href="https://www.instagram.com/havcana8" target="_blank"><img src="../../anexos/imagenes/instagram.png" alt="Instagram"></a>
                <a href="https://www.x.com/havcana8" target="_blank"><img src="../../anexos/imagenes/x.png" alt="Twitter"></a>
            </div>
        
    </footer>

    <script src="../../anexos/js/menu.js"></script>
    <script src="../../anexos/js/pedido.js"></script>
</body>
</html>