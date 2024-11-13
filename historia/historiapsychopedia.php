<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
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
    <link rel="stylesheet" href="historia.css">
</head>
<body>
    <header>
        <a href="../home/home.php">
            <img src="../recursos/titulo.png" alt="Título" class="logo">
        </a>
    </header>
    <main>
        <h1>Historia de la Web</h1>
        <p> 
            Psychopedia Project nace como un proyecto final de curso. Mencionaremos anteriores ideas y la manera en la que fue evolucionando este proyecto.<br><br>
            
            Desde un primer momento, en proyecto iba a estar enfocado en el Desarrollo Personal, teniendo un enfoque completamente distinto, iba a ser una aplicación para dispositivos moviles. Sin embargo, luego de debatir entre el equipo de Desarrollo, nos decantamos por una biblioteca virtual en formato de aplicación móvil.<br><br>
           
            Nos satisfacía la funcionalidad que habíamos pensado para nuestro proyecto, sin embargo, el hecho de que sea para dispositivos móviles no nos terminaba de convencer.<br><br>

            Como habíamos recibido educacion previa de programación en lenguaje HTML, PHP y una noción básica de CSS, por lo cual,
            pensamos que sería una buena idea realizar una Biblioteca Virtual, pero en formato de página Web.<br><br>

            Para codificar, utilizamos los lenguajes de los cuales teníamos conocimientos previos, HTML y PHP, también integramos scripts con JSON para poder hacer que funcionen algunas cosas.

            Desde Abril de 2024 nos dedicamos a crear esta Web enfocada en el cuidado de la salud mental, apta para absolutamente todas las personas, basandonos en documentos de profesionales de la salud. <br><br>

            <h2><b>Hoy en dia este proyecto es una realidad.</b></h2><br>


        </p>
        <br>
        <h1>Desarrolladores</h1>
        <br>
        <div class="imagenes-contenedor">
            <div class="imagen-item">
                <h2 class="epigrafe"><b>Ignacio Basualdo</b></h2>
                <p class="epigrafe2">Desarrollador Principal</p>
            </div>
            <div class="imagen-item">
                <h2 class="epigrafe"><b>Juan Ignacio Farias</b></h2>
                <p class="epigrafe2">Búsqueda y Carga de Documentos</p>
            </div>
            <div class="imagen-item">
                <h2 class="epigrafe"><b>Luciano Reartes</b></h2>
                <p class="epigrafe2">Diseño y Desarrollo de <br> la Seccion <a href='../merch/merch.php'>Merchandising</a></p>
            </div>
        </div>
        <div class="buttons">
            <button class="home"><a href="../home/home.php">Pagina Principal</a></button>
            <button class="index"><a href="../index.php">Inicio</a></button>
        </div>
    </main>
    <footer>
        <a href="../terminos/tycondiciones.html">Términos y Condiciones</a>
        <a href="../terminos/pprivacidad.html">Políticas de Privacidad</a>
        <a href="../plus/plus.php">Psychopedia Plus+</a>
    </footer>
</body>
</html>
