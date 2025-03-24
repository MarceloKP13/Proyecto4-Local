<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAVCANA - Sobre Nosotros</title>
    <link rel="icon" href="../anexos/imagenes/logominiatura.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../anexos/css/header.css">
    <link rel="stylesheet" href="../anexos/css/boton.css">
    <link rel="stylesheet" href="../anexos/css/info.css">
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

    <main class=info-contenedor">
        <section class="caja2-section">
            <div class="caja2-content">
                <h1>Nuestra Historia</h1>
                <p>Conoce más sobre HAVCANA y nuestra historia.</p>
            </div>
        </section>

        <section class="historia-section">
            <div class="historia-content">
                <h2>Cómo Comenzó Todo</h2>
                <p>El fundador comenzó creando artesanías con bambú, elaborando esferos, impulsado por su pasión por las manualidades y la artesanía. De ahí nació la idea de desarrollar un proyecto que aproveche ramas, hojas, semillas y otros recursos naturales de la Amazonía ecuatoriana.</p>
                <p>HAVCANA es una empresa artesanal dedicada a la creación de diversos productos elaborados con materiales autóctonos de la Amazonía. Sin embargo, esta página web se enfoca principalmente en el contenido sobre vinos, ya que es el producto más estandarizado y cuenta con ventas consolidadas.</p>
                <p>Con el paso del tiempo, el fundador ha adquirido conocimientos sobre distintos procesos de elaboración para ampliar la variedad de productos derivados de los recursos amazónicos. Estos conocimientos fueron adquiridos antes, durante y después de obtener una formación tecnológica en Procesamiento de Alimentos.</p>
            </div>
            <div class="historia-image">
                <img src="../anexos/imagenes/havcanalogobotella.png" alt="Logo HAVCANA">
            </div>
        </section>

        <section class="proceso-section">
            <h2>Nuestro Proceso Artesanal</h2>
            <div class="proceso-steps">
                <div class="proceso-step">
                    <div class="step-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3>Selección</h3>
                    <p>Seleccionamos cuidadosamente productos autóctonos de la Amazonía ecuatoriana, garantizando la mejor calidad en nuestros productos.</p>
                </div>
                <div class="proceso-step">
                    <div class="step-icon">
                        <i class="fas fa-mortar-pestle"></i>
                    </div>
                    <h3>Preparación</h3>
                    <p>Procesamos los ingredientes de manera artesanal, preservando los métodos tradicionales y el respeto por los recursos naturales.</p>
                </div>
                <div class="proceso-step">
                    <div class="step-icon">
                        <i class="fas fa-wine-bottle"></i>
                    </div>
                    <h3>Fermentación</h3>
                    <p>Aplicamos técnicas artesanales de fermentación, monitoreando cada etapa para obtener productos de calidad excepcional.</p>
                </div>
                <div class="proceso-step">
                    <div class="step-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Control de Calidad</h3>
                    <p>Verificamos minuciosamente cada producto para asegurar que cumpla con nuestros estándares de calidad artesanal.</p>
                </div>
            </div>
        </section>

        <section class="valor-section">
            <h2>Nuestros Valores</h2>
            <div class="valor-grid">
                <div class="value-item">
                    <img src="../anexos/imagenes/humildad.png" alt="Humildad" class="valor-icon">
                    <h3>Humildad</h3>
                    <p>Mantenemos una actitud humilde en nuestro trabajo y relaciones.</p>
                </div>
                <div class="valor-item">
                    <img src="../anexos/imagenes/amabilidad.png" alt="Amabilidad" class="valor-icon">
                    <h3>Amabilidad</h3>
                    <p>Tratamos a todos con respeto y cordialidad.</p>
                </div>
                <div class="valor-item">
                    <img src="../anexos/imagenes/vida.png" alt="Vida" class="valor-icon">
                    <h3>Vida</h3>
                    <p>Celebramos y respetamos la vida en todas sus formas.</p>
                </div>
                <div class="valor-item">
                    <img src="../anexos/imagenes/cultura.png" alt="Cultura" class="valor-icon">
                    <h3>Cultura</h3>
                    <p>Preservamos y promovemos nuestra herencia cultural.</p>
                </div>
                <div class="valor-item">
                    <img src="../anexos/imagenes/ayuda.png" alt="Ayuda" class="valor-icon">
                    <h3>Ayuda</h3>
                    <p>Nos comprometemos a ayudar a nuestra comunidad.</p>
                </div>
                <div class="valor-item">
                    <img src="../anexos/imagenes/naturaleza.png" alt="Naturaleza" class="valor-icon">
                    <h3>Naturaleza</h3>
                    <p>Respetamos y protegemos nuestro entorno natural.</p>
                </div>
                <div class="valor-item">
                    <img src="../anexos/imagenes/avance.png" alt="Avance" class="valor-icon">
                    <h3>Avance</h3>
                    <p>Buscamos constantemente mejorar y crecer.</p>
                </div>
            </div>
        </section>

        <section class="futuro-section">
            <h2>Nuestra Visión de Futuro</h2>
            <p>En HAVCANA, miramos hacia el futuro con optimismo y grandes planes. Estamos constantemente investigando nuevos sabores y técnicas para ampliar nuestra colección de vinos. Nuestra meta es expandir nuestra presencia y llevar la experiencia HAVCANA a más personas, sin perder nunca la esencia artesanal que nos caracteriza.</p>
            <p>Actualmente contamos con cinco variedades excepcionales, pero estamos trabajando para desarrollar nuevos productos que sorprendan y deleiten a nuestros clientes. Cada nuevo sabor es una aventura que emprendemos con pasión y dedicación.</p>
            <p>Te invitamos a ser parte de nuestro viaje y crecer junto a nosotros en esta fascinante travesía del mundo de los vinos artesanales.</p>
        </section>
    </main>

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
                <a href="https://www.facebook.com/havcana8" target="_blank"><img src="../anexos/imagenes/facebook.png" alt="Facebook"></a>
                <a href="https://www.instagram.com/havcana8" target="_blank"><img src="../anexos/imagenes/instagram.png" alt="Instagram"></a>
                <a href="https://www.x.com/havcana8" target="_blank"><img src="../anexos/imagenes/x.png" alt="Twitter"></a>
            </div>
        </div>
        <div class="whatsapp-boton">
            <a href="https://wa.me/+593939339269" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
                <span class="contactod">Contacto Directo</span>
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </footer>

    <script src="../anexos/js/menu.js"></script>
</body>
</html>