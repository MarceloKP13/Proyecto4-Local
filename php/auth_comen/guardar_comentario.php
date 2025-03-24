mysqli_close($conexion);
?>
<?php
require_once 'conexion_com.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = !empty($_POST['nombre_comentario']) ? $_POST['nombre_comentario'] : 'Anónimo';
    $tipo = $_POST['tipo_comentario'];
    $comentario = $_POST['comentario'];

    try {
        $stmt = $conexion->prepare("INSERT INTO comentarios (nombre, tipo_comentario, comentario) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $tipo, $comentario]);

        header('Location: ../contactos.php?comentario_enviado=true');
        exit();
    } catch(PDOException $e) {
        echo "<script>alert('Error al guardar el comentario: " . $e->getMessage() . "'); window.location.href='../contactos.php';</script>";
        exit();
    }
}
?>

