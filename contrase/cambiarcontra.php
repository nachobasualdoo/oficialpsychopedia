<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="CAMBIARCONTRA.css">
</head>
<body>
    <div class="content-wrapper">
        <header class="header">
            <a href="../index.php">
                <img src="../recursos/titulo.png">
            </a>
        </header>

        <form action="procesarcambio.php" method="post">
            <section class="formulario-cambiar">
                <b>SOLICITUD DE CAMBIO DE CONTRASEÑA</b>
                <p>Ingresa tu correo electrónico para enviar un enlace de restablecimiento.</p>
                <input class="labels" type="email" name="correo" placeholder="Correo Electrónico" required>
                <br>
                <hr>
                <br>
                <input class="botones" type="submit" value="Enviar Enlace">
            </section>
        </form>

        <footer>
            <div class="footer-left">
                <a href="https://www.instagram.com" target="ig">
                    <img src="../recursos/instagram.png" alt="Instagram">
                </a>
            </div>
            <div class="footer-center">
                <a href="https://www.twitter.com" target="x">
                    <img src="../recursos/x.jpg" alt="Twitter">
                </a>
            </div>
            <div class="footer-right">
                <a href="mailto:psychopediaproject@gmail.com" target="gmail">
                    <img src="../recursos/contacto.png" alt="contacto">
                </a>
            </div>
        </footer>
    </div>
</body>
</html>
