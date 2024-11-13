<?php 
// Incluir las clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar los archivos de PHPMailer
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

include('../conexion.php');

if (isset($_POST['correo'])) {
    $correo = $_POST['correo'];

    // Buscar el correo en la base de datos
    $sql = "SELECT * FROM `usuarios` WHERE `mail` = '$correo'";
    $resultado = mysqli_query($cnx, $sql);

    if (mysqli_num_rows($resultado) === 1) {
        // Generar un token de restablecimiento único
        $token = bin2hex(random_bytes(50));

        // Definir el tiempo de expiración (1 hora)
        $expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Insertar el token en la base de datos
        $sqlToken = "INSERT INTO reset_tokens (email, token, expires_at) VALUES ('$correo', '$token', '$expires_at')";
        mysqli_query($cnx, $sqlToken);

        // Enviar el correo electrónico con PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP(); 
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'psychopediaproject@gmail.com'; 
            $mail->Password = 'bbzm cche dati izin'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('psychopediaproject@gmail.com', 'Psychopedia'); 
            $mail->addAddress($correo);

            // Contenido del correo
            $mail->isHTML(true); 
            $mail->Subject = 'Restablecer Clave'; 
            $enlaceRestablecimiento = "https://751d-190-105-223-179.ngrok-free.app/oficialpsychopedia/contrase/restablecer.php?token=$token";
            $mail->Body = "<b>¡Hola!</b>, hemos recibido una solicitud de <b>cambio de contraseña</b>. <br> Por favor, sigue el siguiente enlace para continuar con el <b>restablecimiento de tu contraseña</b>: <a href='$enlaceRestablecimiento'>$enlaceRestablecimiento</a> <br>. En caso de no haber solicitado <b> restablecer tu contraseña</b> en Psychopedia,<b> ignora este correo.</b><br> Atte: <b>Equipo de Desarrollo de Psychopedia</b>.
            <b>Cualquier consulta a</b>: psychopediaproject@gmail.com"; 
            $mail->AltBody = 'Haz clic en el siguiente enlace para restablecer tu contraseña: ' . $enlaceRestablecimiento;

            // Enviar el correo
            $mail->send();

            // Mostrar mensaje de éxito
            echo '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Correo Enviado</title>
                <link rel="stylesheet" href="estilosproceso.css">
            </head>
            <body>
                <div class="container">
                    <div class="message-box">
                        <h1><b>¡Correo Enviado!</b></h1>
                        <p>Hemos enviado instrucciones a tu correo electrónico para restablecer tu contraseña. Por favor, <b>revisa tu bandeja de entrada.</b></p>
                        <a href="../iniciosesion/iniciosesion.php" class="btn">Volver a Inicio de Sesión</a>
                    </div>
                </div>
            </body>
            </html>';
        } catch (Exception $e) {
            // Error al enviar el correo
            header("Location: cambiarcontra.php?error=No se pudo enviar el mensaje. Error de PHPMailer: {$mail->ErrorInfo}");
        }
    } else {
        // Redirigir si el correo no está registrado
        header("Location: cambiarcontra.php?error=El correo electrónico no está registrado.");
    }
}
?>
