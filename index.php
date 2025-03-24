<?php
    session_start();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAVCANA - Vinos Artesanales</title>
    <link rel="icon" href="anexos/imagenes/logominiatura.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="anexos/css/header.css">
    <link rel="stylesheet" href="anexos/css/boton.css">
    <link rel="stylesheet" href="anexos/css/inicio.css">
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <img src="anexos/imagenes/havcanalogo.png" alt="HAVCANA Logo">
                <a href="php/info.php" class="brand-name">HAVCANA</a>
            </div>

            <button class="hambur">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="php/catalogo.php">Catálogo</a></li>
                    <li><a href="php/carrito.php">Carrito</a></li>
                    <li><a href="php/auth_pro/pedido.php">Pedidos</a></li>
                    <li><a href="php/info.php">Sobre Nosotros</a></li>
                    <li><a href="php/contactos.php">Contacto</a></li>
                    <?php if(isset($_SESSION['usuario'])): ?>
                        <li class="usuario-info">
                            <a href="php/auth_pro/pedido.php"><span>Hola, <?php echo $_SESSION['usuario']; ?></span></a>
                            <?php if(isset($_SESSION['es_admin']) && $_SESSION['es_admin']): ?>
                                <span class="admin-color">Admin</span>
                            <?php endif; ?>
                            <a href="php/auth/salir.php">|  |   Cerrar Sesión</a>
                        </li>
                    <?php else: ?>
                        <li><a href="php/auth/login_registro_global.php">Iniciar Sesión</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <main class="caja1">
        <div class="caja1-cont">
            <h1>Descubre HAVCANA</h1>
            <p class="tagline">Vinos artesanales con sabores únicos</p>
            <p class="description">Nuestra pasión por los vinos artesanales nos lleva a crear sabores excepcionales que deleitarán tus sentidos. Elaborados con los mejores ingredientes y un proceso cuidadoso.</p>
            <a href="php/catalogo.php" class="cta-button">Explorar Catálogo</a>
        </div>
    </main>
    
    <section class="productos">
        <h2>Nuestros Vinos</h2>
        <div class="productos-tarjetas">
            <?php
            include 'php/auth/conexion_be.php';
            $result = mysqli_query($conexion, "SELECT nombre, descripcion, imagen FROM productos");
            while ($producto = mysqli_fetch_assoc($result)) {
                $imagen = str_replace('../', '', $producto['imagen']); // Ajustar la ruta para index.php
                echo '<div class="productos-cartas">';
                echo '<img src="' . $imagen . '" alt="' . $producto['nombre'] . '">';
                echo '<h3>' . $producto['nombre'] . '</h3>';
                echo '<p>' . $producto['descripcion'] . '</p>';
                echo '</div>';
            }
            mysqli_close($conexion);
            ?>
        </div>
    </section>
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
                    <li><a href="../php/catalogo.php">Catálogo</a></li>
                    <li><a href="../php/carrito.php">Carrito</a></li>
                    <li><a href="../php/auth_pro/pedido.php">Pedidos</a></li>
                    <li><a href="../php/info.php">Sobre Nosotros</a></li>
                    <li><a href="../php/contactos.php">Contacto</a></li>
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
                <a href="https://www.facebook.com/havcana8" target="_blank"><img src="anexos/imagenes/facebook.png" alt="Facebook"></a>
                <a href="https://www.instagram.com/havcana8" target="_blank"><img src="anexos/imagenes/instagram.png" alt="Instagram"></a>
                <a href="https://www.x.com/havcana8" target="_blank"><img src="anexos/imagenes/x.png" alt="Twitter"></a>
            </div>
        </div>
        <div class="whatsapp-boton">
            <a href="https://wa.me/+593939339269?text=Hola, necesito información sobre sus productos." target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
                <span class="contactod">Contacto Directo</span>
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </footer>
    <script src="anexos/js/menu.js"></script>
</body>
</html>