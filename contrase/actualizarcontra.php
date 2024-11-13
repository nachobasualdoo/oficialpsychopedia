<?php
include('../conexion.php');

if (isset($_POST['token']) && isset($_POST['nuevacontrasena']) && isset($_POST['confirmarcontrasena'])) {
    $token = $_POST['token'];
    $nueva_contrasena = $_POST['nuevacontrasena'];
    $confirmar_contrasena = $_POST['confirmarcontrasena'];

    if ($nueva_contrasena === $confirmar_contrasena) {
        // Buscar el token en la base de datos
        $sql = "SELECT * FROM reset_tokens WHERE token = '$token'";
        $resultado = mysqli_query($cnx, $sql);

        if (mysqli_num_rows($resultado) === 1) {
            $row = mysqli_fetch_assoc($resultado);
            $email = $row['email'];

            // Actualizar la contraseña del usuario
            $sqlUpdate = "UPDATE usuarios SET contrase = '$nueva_contrasena' WHERE mail = '$email'";
            mysqli_query($cnx, $sqlUpdate);

            // Eliminar el token de restablecimiento después de usarlo
            $sqlDeleteToken = "DELETE FROM reset_tokens WHERE token = '$token'";
            mysqli_query($cnx, $sqlDeleteToken);

            // Redirigir a la página de inicio de sesión con mensaje de éxito
            header("Location: ../iniciosesion/iniciosesion.php?success=Tu%20contraseña%20ha%20sido%20restablecida%20correctamente.");
            exit(); // Asegúrate de detener el script después de la redirección
        } else {
            echo "Token inválido.";
        }
    } else {
        echo "Las contraseñas no coinciden.";
    }
}
?>
