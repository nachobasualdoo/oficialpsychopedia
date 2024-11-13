<?php
include('../conexion.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Buscar el token en la base de datos y verificar su validez
    $sql = "SELECT * FROM reset_tokens WHERE token = '$token' AND expires_at > NOW()";
    $resultado = mysqli_query($cnx, $sql);

    if (mysqli_num_rows($resultado) === 1) {
        // Mostrar el formulario de cambio de contraseña
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Restablecer Contraseña</title>
            <link rel="stylesheet" href="https://751d-190-105-223-179.ngrok-free.app/oficialpsychopedia/contrase/CAMBIARCONTRA.css">
        </head>
        <body>
            <div class="content-wrapper">
                <header class="header">
                    <img src="https://751d-190-105-223-179.ngrok-free.app/oficialpsychopedia/recursos/titulo.png" alt="Título">
                </header>

                <form action="https://751d-190-105-223-179.ngrok-free.app/oficialpsychopedia/contrase/actualizarcontra.php" method="post">
                    <section class="formulario-cambiar">
                        <img src="https://751d-190-105-223-179.ngrok-free.app/oficialpsychopedia/recursos/logo.png" alt="Logo" class="formulario-img">
                        <b>RESTABLECER CONTRASEÑA</b>
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <input class="labels" type="password" name="nuevacontrasena" placeholder="Nueva Contraseña" required>
                        <input class="labels" type="password" name="confirmarcontrasena" placeholder="Confirmar Contraseña" required>
                        <hr>
                        <input class="botones" type="submit" value="Restablecer Contraseña">
                    </section>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Este enlace de restablecimiento de contraseña es inválido o ha expirado.";
    }
}
?>
