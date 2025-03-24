<?php
include 'conexion_be.php';

$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$contrasena = hash('sha512', $contrasena);
$isAdmin = isset($_POST['admin_check']);
$adminPin = isset($_POST['admin_pin']) ? $_POST['admin_pin'] : null;

if ($isAdmin) {
    if ($adminPin !== '858513') {
        echo '
            <script>
                alert("PIN de seguridad incorrecto. No puedes registrarte como administrador.");
                window.location = "login_registro_global.php";
            </script>
        ';
        exit();
    } else {
        $es_admin = 1;
    }
} else {
    $es_admin = 0;
}
// Verificar que el correo no se repita
$verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo'");
if (mysqli_num_rows($verificar_correo) > 0) {
    echo '
        <script>
            alert("El correo ya se encuentra registrado, intenta con otro.");
            window.location = "login_registro_global.php";
        </script>
    ';
    exit();
}
// Verificar que el usuario no se repita
$verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario'");
if (mysqli_num_rows($verificar_usuario) > 0) {
    echo '
        <script>
            alert("El usuario ya se encuentra registrado, intenta con otro.");
            window.location = "login_registro_global.php";
        </script>
    ';
    exit();
}

$query = "INSERT INTO usuarios (nombre_completo, correo, usuario, contrasena, es_admin) VALUES ('$nombre_completo', '$correo', '$usuario', '$contrasena', '$es_admin')";
$ejecutar = mysqli_query($conexion, $query);

if ($ejecutar) {
    session_start();
    $_SESSION['usuario'] = $usuario;
    $_SESSION['es_admin'] = $es_admin;
    $_SESSION['usuario_id'] = mysqli_insert_id($conexion);
    echo '
        <script>
            alert("Usuario registrado exitosamente.");
            window.location = "../../index.php"; // Redirigir al index.php
        </script>
    ';
} else {
    echo '
        <script>
            alert("Error al registrar el usuario.");
            window.location = "login_registro_global.php";
        </script>
    ';
}
?>