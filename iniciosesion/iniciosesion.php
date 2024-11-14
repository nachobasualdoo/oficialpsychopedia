<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="estilosINI.css">
</head>
<body>
    <div class="content-wrapper"> 
        <header>
            <a href="../index.php">
                <img src="../recursos/titulo.png" alt="Título" class="logo">
            </a>
        </header>

        <form action="iniciosesionback.php" id="formulario" method="post" enctype="multipart/form-data">
            <section class="formulario-registro">
                <img src="../recursos/logo.png" alt="Logo" class="formulario-img">
                <b> INICIO DE SESION</b>

                <hr>
                <br>
                <?php
                    if (isset($_GET['error'])) {
                        ?>
                        <p class="error">
                            <?php echo $_GET['error']; ?>
                        </p>
                <?php
                    }

                    // Mostrar el mensaje de éxito si existe
                    if (isset($_GET['success'])) {
                        ?>
                        <p class="success">
                            <?php echo $_GET['success']; ?>
                        </p>
                <?php
                    }
                ?>
                <input class="registrolabels" type="email" name="correo" id="correo" placeholder="Correo Electrónico" required>
                <input class="registrolabels" type="password" name="contrap" id="contrap" placeholder="Contraseña" required>
                <hr>
                <input class="botones" type="submit" value="Iniciar Sesion">
                
                <!-- Enlace para cambiar la contraseña -->
                <p><a href="../contrase/cambiarcontra.php">¿Olvidaste tu contraseña?</a></p>

                <p>¿No tienes una cuenta en Psychopedia? Entonces, puedes <a href="../registro/registro.php">Registrarte</a>.</p>
            </section>
        </form>
    </div>
    <footer>
        <div class="footer-left">
            <a href="https://www.instagram.com/psychopediaproject/" target="ig">
                <img src="../recursos/instagram.png" alt="Instagram">
            </a>
        </div>
        <div class="footer-center">
            <a href="https://x.com/PsychopediaNLJ" target="x">
                <img src="../recursos/x.jpg" alt="Twitter">
            </a>
        </div>
    </footer>
</body>
</html>
