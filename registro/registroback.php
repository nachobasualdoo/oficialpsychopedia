<?php
    // Obtención de los datos del formulario
    $correo = $_REQUEST['email'];
    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];
    $fechanacimiento = $_REQUEST['fnac'];
    $sexo = $_REQUEST['sex'];
    $contrase = $_REQUEST['contrap'];
    $redireccionar_exito = "../iniciosesion/iniciosesion.php";
    $redireccionar_registro = "registro.php"; // Redirigir a la página de registro

    include '../conexion.php'; // Conexión a la base de datos

    // Verificación si ya existe un usuario con el correo proporcionado
    $verificacion_sql = "SELECT * FROM `usuarios` WHERE `mail` = '$correo'";
    $resultado = mysqli_query($cnx, $verificacion_sql);

    if (mysqli_num_rows($resultado) > 0) {
        // Si el correo ya está registrado, redirigir a la página de registro con mensaje de error
        mysqli_close($cnx);
        header("Location: $redireccionar_registro?error=1"); // El parámetro 'error=1' indica que hubo un problema
        exit();
    } 

    // Si no existe un usuario con ese correo, se procede a registrar
    $sql = "INSERT INTO `usuarios`(`nombre`, `apellido`, `sexo`, `fnacimiento`, `mail`, `contrase`, `id`) 
            VALUES ('$nombre','$apellido','$sexo','$fechanacimiento','$correo','$contrase','')";

    if (mysqli_query($cnx, $sql)) {
        echo "El usuario se registró correctamente.";
        header("Location: $redireccionar_exito"); // Redirigir a la página de inicio de sesión
    } else {
        echo "Error al registrar usuario: " . mysqli_error($cnx);
    }

    // Cierre de la conexión
    mysqli_close($cnx);
?>