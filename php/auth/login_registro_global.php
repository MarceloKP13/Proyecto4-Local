<?php
    session_start();
    include 'conexion_be.php';

    if(isset($_SESSION['usuario'])){
        header("location: ../../index.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../anexos/imagenes/logominiatura.png">
    <link rel="stylesheet" href="../../anexos/css/login.css">
    <title>HAVCANA - Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>

    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Registrarse</button>
                </div>
            </div>

            <div class="contenedor__login-register">
                <form action="login_usuario_be.php" method="POST" class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" placeholder="Correo electrónico" name="correo" required>
                    <div class="contenedor_contrasena">
                        <input type="password" placeholder="Contraseña" name="contrasena" id="contrasena_login" required>
                        <span class="eye_icon" id="eye_icon_login">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <button>Entrar</button>
                </form>

                <form action="registro_usuario_be.php" method="POST" class="formulario__register">
    <h2>Regístrate</h2>
    <input type="text" placeholder="Nombre Completo" name="nombre_completo" required>
    <input type="email" placeholder="Correo electrónico" name="correo" required>
    <input type="text" placeholder="Usuario" name="usuario" required>
    <div class="contenedor_contrasena">
        <input type="password" placeholder="Contraseña" name="contrasena" id="contrasena_register" required>
        <span class="eye_icon" id="eye_icon_register">
            <i class="fas fa-eye"></i>
        </span>
    </div>
    <div class="admin_check_container">
    <input type="checkbox" id="admin_check" name="admin_check">
        <label for="admin_check">¿Eres administrador?</label>
    </div>
    <div id="admin_pin_div" style="display: none;">
        <input type="text" placeholder="PIN de administrador" name="admin_pin">
    </div>
    <button>Registrarse</button>
</form>
            </div>
        </div>
    </main>
    <script src="../../anexos/js/login.js"></script>
</body>
</html>