<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear tu cuenta de Psychopedia</title>
    <link rel="stylesheet" href="estilosREGISTRO.css">
</head>
<body>
    <div class="scale-container">
        <header>
            <a href="../home/home.php">
                <img src="../recursos/titulo.png" alt="Título" class="logo">
            </a>
        </header>
        <form action="registroback.php" id="formulario" method="post" enctype="multipart/form-data">
            <section class="formulario-registro">
                <img src="../recursos/logo.png" alt="Logo" class="formulario-img"> 
                <b> SECCION DE REGISTRO</b>

                <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                    <p class="registroerror">El correo ya está registrado. Por favor, usa otro correo o <a href="../iniciosesion/iniciosesion.php">inicia sesión</a>.</p>
                <?php endif; ?>
                
                <input class="registrolabels" type="email" name="email" id="email" placeholder="Correo Electrónico" required>
                <input class="registrolabels" type="text" name="nombre" id="nombre" placeholder="Nombre" >
                <input class="registrolabels" type="text" name="apellido" id="apellido" placeholder="Apellido" >
                <input class="registrolabels" type="date" name="fnac" id="fnac" placeholder="Fecha de Nacimiento" required>
                <select class="registrolabels" id="sex" name="sex" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                </select>
                <input class="registrolabels" type="password" name="contrap" id="contrap" placeholder="Contraseña" required>
                <input class="registrolabels" type="password" name="ccontra" id="ccontra" placeholder="Confirmar Contraseña" required>
                <hr>
                <p>Al confirmar, estoy de acuerdo con los <a href="#">Términos y Condiciones</a> y las <a href="#">Políticas de Privacidad</a></p>
                <hr>
                <input class="botones" type="submit" value="Confirmar">
                <p>¿Ya tienes una cuenta? Entonces puedes <a href="../iniciosesion/iniciosesion.php">Iniciar Sesión</a>.</p>
            </section>
        </form>

        <footer>
            <div class="footer-left">
                <a href="https://www.instagram.com" target="_blank">
                    <img src="../recursos/instagram.png" alt="Instagram">
                </a>
            </div>
            <div class="footer-center">
                <a href="https://www.twitter.com" target="_blank">
                    <img src="../recursos/x.jpg" alt="Twitter">
                </a>
            </div>
            <div class="footer-right">
                <a href="mailto:psychopediaproject@gmail.com" target="_blank">
                    <img src="../recursos/contacto.png" alt="contacto">
                </a>
            </div>
        </footer>
    </div>
    <script>
        document.getElementById('formulario').addEventListener('submit', function(event) {
            var contra = document.getElementById('contrap').value;
            var ccontra = document.getElementById('ccontra').value;

            if (contra !== ccontra) {
                event.preventDefault(); // Evita que el formulario se envíe
                alert('Las contraseñas no coinciden. Por favor, verifícalas.');
            }
        });
    </script>
</body>
</html>
