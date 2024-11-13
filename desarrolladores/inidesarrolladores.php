<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DESARROLLADORES - Iniciar Sesion</title>
    <link rel="stylesheet" href="../iniciosesion/estilosINI.css">
</head>
<header>
    <a href="../index.php">
        <img src="../recursos/titulo.png" alt="Título" class="logo">
    </a>
</header>
<body>
    <form action="inidesarrolladoresback.php" id="formulario" method="post" enctype="multipart/form-data">
        <section class="formulario-registro">
            <img src="../recursos/logo.png" alt="Logo" class="formulario-img">
            <hr>
            <br>
            <?php
                if (isset($_GET['error'])) {
                    ?>
                    <p class="error">
                        <?php
                        echo $_GET['error'];
                        ?>
                    </p>
            <?php
                }
            ?>
            </hr>


            <input class="registrolabels" type="text" name="nde" id="nde" placeholder="Desarrollador" required>
            <input class="registrolabels" type="password" name="cde" id="cde" placeholder="Contraseña" required>
            <hr>
            <input class="botones" type="submit" value="Iniciar Sesion">
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
</body>
</html>
