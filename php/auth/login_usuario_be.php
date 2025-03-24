<?php
session_start();
include 'conexion_be.php';

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$contrasena = hash('sha512', $contrasena);

$validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo' AND contrasena = '$contrasena'");
if (mysqli_num_rows($validar_login) > 0) {
    $usuario = mysqli_fetch_assoc($validar_login);
    $_SESSION['usuario'] = $usuario['usuario'];
    $_SESSION['es_admin'] = $usuario['es_admin'];
    $_SESSION['usuario_id'] = $usuario['id']; // Corrected to access 'id' from $usuario

    if ($usuario['es_admin'] == 1) {
        header("location: ../../index.php");
    } else {
        header("location: ../../index.php"); 
    }
    exit;
} else {
    echo '
        <script>
            alert("Datos incorrectos, verificar registro.");
            window.location = "login_registro_global.php";
        </script>
    ';
    exit;
}
?>