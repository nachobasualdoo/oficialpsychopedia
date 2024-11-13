<?php
include '../conexion.php'; // Conexión a la base de datos

if (isset($_GET['token']) && isset($_GET['usuario'])) {
    $token = $_GET['token'];
    $usuario = $_GET['usuario'];

    // Verificar si el token es válido
    $sql = "SELECT token_eliminacion FROM usuarios WHERE mail = ? AND token_eliminacion = ?";
    $stmt = $cnx->prepare($sql);
    $stmt->bind_param("ss", $usuario, $token);
    $stmt->execute();
    $stmt->bind_result($tokenEliminacion);
    $stmt->fetch();
    $stmt->close();

    if ($tokenEliminacion) {
        // Eliminar la cuenta
        $sql = "DELETE FROM usuarios WHERE mail = ?";
        $stmt = $cnx->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->close();

        // Destruir la sesión y redirigir
        session_destroy();
        header("Location: ../index.php?mensaje=Cuenta eliminada exitosamente.");
        exit();
    } else {
        echo "Token inválido o ya usado.";
    }
} else {
    echo "Acceso no autorizado.";
}
?>
