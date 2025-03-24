<?php
session_start();
include 'auth/conexion_be.php';

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Procesar acciones del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if ($accion === 'agregar' && isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
        $producto_id = (int)$_POST['producto_id'];
        $cantidad = (int)$_POST['cantidad'];

        // Obtener información del producto de la base de datos
        $query = "SELECT * FROM productos WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($producto = $result->fetch_assoc()) {
            // Calcular precio según cantidad (precio especial por docena)
            $precio_unitario = $producto['precio'];
            if ($cantidad >= 12) {
                // Aplicar descuento por docena
                $precio_unitario = strpos(strtolower($producto['nombre']), 'manzana') !== false ? 3.85 : 7.75;
            }

            // Verificar si ya existe en el carrito
            $existe = false;
            foreach ($_SESSION['carrito'] as $index => $item) {
                if ($item['id'] === $producto_id) {
                    // Actualizar cantidad y recalcular precio si es necesario
                    $nueva_cantidad = $item['cantidad'] + $cantidad;
                    $nuevo_precio = ($nueva_cantidad >= 12) ? 
                        (strpos(strtolower($producto['nombre']), 'manzana') !== false ? 3.85 : 7.75) :
                        $producto['precio'];

                    $_SESSION['carrito'][$index]['cantidad'] = $nueva_cantidad;
                    $_SESSION['carrito'][$index]['precio'] = $nuevo_precio;
                    $existe = true;
                    break;
                }
            }

            if (!$existe) {
                $_SESSION['carrito'][] = [
                    'id' => $producto_id,
                    'nombre' => $producto['nombre'],
                    'precio' => $precio_unitario,
                    'cantidad' => $cantidad
                ];
            }
        }
    } elseif ($accion === 'actualizar' && isset($_POST['item_index']) && isset($_POST['cantidad'])) {
        $index = (int)$_POST['item_index'];
        $cantidad = (int)$_POST['cantidad'];

        if (isset($_SESSION['carrito'][$index])) {
            if ($cantidad > 0) {
                // Recalcular precio según nueva cantidad
                $producto_id = $_SESSION['carrito'][$index]['id'];
                $query = "SELECT * FROM productos WHERE id = ?";
                $stmt = $conexion->prepare($query);
                $stmt->bind_param("i", $producto_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $producto = $result->fetch_assoc();

                $nuevo_precio = $producto['precio'];
                if ($cantidad >= 12) {
                    $nuevo_precio = strpos(strtolower($producto['nombre']), 'manzana') !== false ? 3.85 : 7.75;
                }

                $_SESSION['carrito'][$index]['cantidad'] = $cantidad;
                $_SESSION['carrito'][$index]['precio'] = $nuevo_precio;
            } else {
                array_splice($_SESSION['carrito'], $index, 1);
            }
        }
    } elseif ($accion === 'eliminar' && isset($_POST['item_index'])) {
        $index = (int)$_POST['item_index'];
        if (isset($_SESSION['carrito'][$index])) {
            array_splice($_SESSION['carrito'], $index, 1);
        }
    } elseif ($accion === 'vaciar') {
        $_SESSION['carrito'] = [];
    }

    header('Location: carrito.php');
    exit;
}

// Calcular totales
$subtotal = 0;
$envio = 5.00;
$total = 0;

foreach ($_SESSION['carrito'] as $item) {
    $subtotal += $item['precio'] * $item['cantidad'];
}

$total = $subtotal + $envio;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAVCANA - Carrito de Compras</title>
    <link rel="icon" href="../anexos/imagenes/logominiatura.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../anexos/css/header.css">
    <link rel="stylesheet" href="../anexos/css/boton.css">
    <link rel="stylesheet" href="../anexos/css/carrito.css">
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <img src="../anexos/imagenes/havcanalogo.png" alt="HAVCANA Logo">
                <a href="info.php" class="brand-name">HAVCANA</a>
            </div>

            <button class="hambur">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav>
                <ul class="nav-menu">
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="catalogo.php">Catálogo</a></li>
                    <li><a href="carrito.php">Carrito</a></li>
                    <li><a href="auth_pro/pedido.php">Pedidos</a></li>
                    <li><a href="info.php">Sobre Nosotros</a></li>
                    <li><a href="contactos.php">Contacto</a></li>
                    <?php if(isset($_SESSION['usuario'])): ?>
                        <li class="usuario-info">
                            <a href="auth_pro/pedido.php"><span>Hola, <?php echo $_SESSION['usuario']; ?></span></a>
                            <?php if(isset($_SESSION['es_admin']) && $_SESSION['es_admin']): ?>
                                <span class="admin-color">Admin</span>
                            <?php endif; ?>
                            <a href="auth/salir.php">|  |   Cerrar Sesión</a>
                        </li>
                    <?php else: ?>
                        <li><a href="auth/login_registro_global.php">Iniciar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="carro-contenedor">
        <h1>Tu Carrito de Compras</h1>

        <?php if (empty($_SESSION['carrito'])): ?>
        <div class="vacio-carro">
            <i class="fas fa-shopping-cart"></i>
            <p>Tu carrito está vacío</p>
            <a href="catalogo.php" class="continuar">Ir al catálogo</a>
        </div>
        <?php else: ?>
        <div class="carro-grid">
            <div class="carro-items">
                <table class="carro-tabla">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['carrito'] as $index => $item): ?>
                        <tr>
                            <td class="producto-nombre">
                                <?php echo $item['nombre']; ?>
                                <?php if ($item['cantidad'] >= 12): ?>
                                    <span class="descuento">¡Precio especial por docena!</span>
                                <?php endif; ?>
                            </td>
                            <td class="producto-precio">$<?php echo number_format($item['precio'], 2); ?></td>
                            <td class="producto-cualidad">
                                <form action="carrito.php" method="POST" class="cualdiad-form">
                                    <input type="hidden" name="accion" value="actualizar">
                                    <input type="hidden" name="item_index" value="<?php echo $index; ?>">
                                    <select name="cantidad" onchange="this.form.submit()">
                                        <?php for($i = 1; $i <= 24; $i++): ?>
                                            <option value="<?php echo $i; ?>" <?php echo ($i == $item['cantidad']) ? 'selected' : ''; ?>>
                                                <?php echo $i; ?>
                                                <?php if($i == 12): ?> (Docena)<?php endif; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </form>
                            </td>
                            <td class="producto-subtotal">$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                            <td class="producto-acciones">
                                <form action="carrito.php" method="POST">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="item_index" value="<?php echo $index; ?>">
                                    <button type="submit" class="eliminar-boton">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="carro-acciones">
                    <a href="catalogo.php" class="continuar">
                        <i class="fas fa-arrow-left"></i> Seguir comprando
                    </a>
                    <form action="carrito.php" method="POST">
                        <input type="hidden" name="accion" value="vaciar">
                        <button type="submit" class="vacio-carro-btn">
                            <i class="fas fa-trash"></i> Vaciar carrito
                        </button>
                    </form>
                </div>
            </div>

            <div class="carro-resumen">
                <h2>Resumen del pedido</h2>
                <div class="resumen-row">
                    <span>Subtotal</span>
                    <span>$<?php echo number_format($subtotal, 2); ?></span>
                </div>
                <div class="resumen-row">
                    <span>Envío</span>
                    <span>$<?php echo number_format($envio, 2); ?></span>
                </div>
                <div class="resumen-row total">
                    <span>Total</span>
                    <span>$<?php echo number_format($total, 2); ?></span>
                </div>
                <button class="generar-boton" onclick="generarPedido()">
                    Generar Pedido <i class="fas fa-arrow-right"></i>
                </button>
                <script>
                function generarPedido() {
                    <?php if(!isset($_SESSION['usuario'])): ?>
                        if(confirm('Debe iniciar sesión para generar un pedido. ¿Desea ir a la página de inicio de sesión?')) {
                            window.location.href = 'auth/login_registro_global.php';
                        }
                    <?php else: ?>
                        window.location.href = 'auth_pro/procesar_pedido.php';
                    <?php endif; ?>
                }
                </script>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <footer>
        <div class="whatsapp-boton">
            <a href="https://wa.me/+593939339269?text=Hola, necesito información sobre sus productos." target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
                <span class="contactod">Contacto Directo</span>
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </footer>

    <script src="../anexos/js/menu.js"></script>
</body>
</html>