<<?php  
session_start();
if (!isset($_SESSION['ndesarrollador'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psychopedia</title>
    <link rel="stylesheet" href="../estilosINDEX.css">
</head>
<body>
    <header>
        <div class="titulo">
            <img src="../recursos/titulo.png" alt="titulo">
        </div>
        <div class="logo">
            <img src="../recursos/logo.png" alt="Logo">
        </div>
        <div class="hcontacto">
            <a href="https://mail.google.com"><img src="../recursos/contacto.png" alt="Gmail"></a>
            <a href="https://twitter.com"><img src="../recursos/x.jpg" alt="Twitter"></a>
            <a href="https://instagram.com"><img src="../recursos/instagram.png" alt="Instagram"></a>
        </div>
    </header>
    <main>
        <h1>¡Bienvenidos Desarrolladores!</h1>
        <p>Este es el Index perteneciente a los desarrolladores, abajo encontraran dos botones, uno los redirigira hacia la seccion
        para agregar documentos (desarrolladoresA.php), y, el otro, los redirigira hacia la seccion para editar o eliminar los documentos previamente agregados(desarrolladoresME.php).</p>
        <div class="buttons">
            <button class=""><a href="desarrolladoresa.php">Agregar</a></button>
            <button class=""><a href="desarrolladoresme.php">Editar/Eliminar</a></button>
        </div>
    </main>

    <footer>
        <a href="../terminos/tycondiciones.html">Términos y Condiciones</a>
        <a href="../terminos/pprivacidad.html">Políticas de Privacidad</a>
        <a href="../iniciosesion/iniciosesion.php">Psychopedia Plus+</a>
        <a href="../index.php">Index</a>
    </footer>
</body>
</html>
