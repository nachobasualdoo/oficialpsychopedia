<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.html");
    exit();
}

// Conectar a la base de datos
include '../conexion.php';

// Obtener datos actuales del usuario
$usuario = $_SESSION['usuario'];
$sql = "SELECT nombre, apellido, fnacimiento, sexo, contrase, foto_perfil FROM usuarios WHERE id = ?";
$stmt = $cnx->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->bind_result($nombre, $apellido, $fnacimiento, $sexo, $contrase, $foto_perfil);
$stmt->fetch();
$stmt->close();

// Actualizar los datos del usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_datos'])) {
    $nuevoNombre = $_POST['nombre'];
    $nuevoApellido = $_POST['apellido'];
    $nuevaFechaNacimiento = $_POST['fnacimiento'];
    $nuevoSexo = $_POST['sexo'];
    $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, fnacimiento = ?, sexo = ?, contrase = ? WHERE id = ?";
    $stmt = $cnx->prepare($sql);
    $stmt->bind_param("ssssss", $nuevoNombre, $nuevoApellido, $nuevaFechaNacimiento, $nuevoSexo, $contrase, $usuario);
    $stmt->execute();
    $stmt->close();

    // Actualizar los datos de la sesión
    $_SESSION['nombre'] = $nuevoNombre;
    $_SESSION['apellido'] = $nuevoApellido;

    // Redirigir a la misma página para evitar reenvío de formulario
    header("Location: cuenta.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cambiar_contrasena'])) 
{
    
    $nuevaContrasena = $_POST['nueva_contrasena'];
    $confirmarContrasena = $_POST['confirmar_contrasena'];

        if ($nuevaContrasena === $confirmarContrasena)
        {
            if (strlen($nuevaContrasena) >= 8) 
            {
            
                $sql = "UPDATE usuarios SET contrase = ? WHERE id = ?";
                $stmt = $cnx->prepare($sql);
                $stmt->bind_param("ss", $nuevaContrasena, $usuario);
                $stmt->execute();
                $stmt->close();
                echo "Contraseña actualizada correctamente.";
            } 
            else 
            {
                echo "La nueva contraseña debe tener al menos 8 caracteres.";
            }
        } 
        else 
        {
            echo "Las contraseñas no coinciden.";
        }
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_foto'])) {
    if ($_FILES['foto_perfil']['name']) {
        $directorio = "../uploads/usuarios/fotosperfil/"; 
        $nombreArchivo = basename($_FILES["foto_perfil"]["name"]);
        $rutaCompleta = $directorio . $nombreArchivo;
        
        // Mover la imagen cargada a la carpeta especificada
        if (move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $rutaCompleta)) {
            // Actualizar la base de datos con la nueva ruta de la imagen
            $sql = "UPDATE usuarios SET foto_perfil = ? WHERE id = ?";
            $stmt = $cnx->prepare($sql);
            $stmt->bind_param("ss", $rutaCompleta, $usuario);
            $stmt->execute();
            $stmt->close();
        } else {
            // Manejo de errores en caso de que la imagen no se haya cargado correctamente
            echo "Error al subir la imagen.";
        }
    }

    // Redirigir a la misma página
    header("Location: cuenta.php");
    exit();
}


// Eliminar cuenta
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_cuenta'])) {
    if (isset($_POST['confirmacion1']) && isset($_POST['confirmacion2'])) {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $cnx->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->close();

        session_destroy();
        header("Location: ../index.html?mensaje=Cuenta eliminada exitosamente.");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta</title>
    <link rel="stylesheet" href="estilosCuenta.css">
</head>
<body>
<header>
    <a href="../home/home.php">
        <img src="../recursos/titulo.png" alt="Título" class="logo">
    </a>
</header>
    <h1>MI CUENTA</h1>
    <main>
        <!-- Formulario para actualizar datos -->
        <form action="cuenta.php" method="post">
            <h2>Actualizar Datos</h2>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" required><br>

            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="<?php echo $apellido; ?>" required><br>

            <label for="fnacimiento">Fecha de Nacimiento</label>
            <input type="date" name="fnacimiento" id="fnacimiento" value="<?php echo $fnacimiento; ?>" required><br>

            <label for="sexo">Sexo </label>
            <select name="sexo" id="sexo">
                <option value="Masculino" <?php if($sexo == 'Masculino') echo 'selected'; ?>>Masculino</option>
                <option value="Femenino" <?php if($sexo == 'Femenino') echo 'selected'; ?>>Femenino</option>
                <option value="Prefiero no decirlo" <?php if($sexo == 'Prefiero no decirlo') echo 'selected'; ?>>Prefiero no decirlo</option>
            </select><br>

            <button type="submit" name="actualizar_datos" class="botonescss">Guardar Cambios</button>
        </form>

        <form action="cuenta.php" method="post">
                <h2>Cambiar Contraseña</h2>
                <label for="nueva_contrasena">Nueva contraseña:</label>
                <input type="text" name="nueva_contrasena" id="nueva_contrasena" required><br>
                <label for="confirmar_contrasena">Confirmar nueva contraseña:</label>
                <input type="password" name="confirmar_contrasena" id="botonescss" required><br>
                <button type="submit" name="cambiar_contrasena" class="botonescss">Cambiar Contraseña</button>
        </form>



        <form action="cuenta.php" method="post" enctype="multipart/form-data">
            <h2>Actualizar Foto de Perfil</h2>
            <label for="foto_perfil">Foto de Perfil actual:</label><br>
            <img src="<?php echo $foto_perfil; ?>" alt="Foto de Perfil Actual" class="fotoPerfilImg"><br>
            <input type="file" name="foto_perfil" id="foto_perfil"><br>
            <button type="submit" name="actualizar_foto" class="botonescss">Actualizar Foto</button>
        </form>







        <!-- Botón para cerrar sesión -->
        <form action="../cerrarsesion.php" method="post">
            <button type="submit" name="cerrar_sesion" class="botonescss">Cerrar Sesión</button>
        </form>

        <!-- Botón para eliminar cuenta con confirmación -->
        <form action="cuenta.php" method="post" class="" onsubmit="return confirmarEliminacion();">
            <h2>Eliminar Cuenta</h2>
            <p>Dentro de esta seccion, puedes eliminar tu cuenta. En caso de estar seguro de esta accion, doy mi consentimiento y soy consciente de que:.</p>
            <label for="confirmacion1">Estoy seguro de eliminar mi cuenta</label>
            <input type="checkbox" name="confirmacion2" id="confirmacion2" required>
            <label for="confirmacion2">Entiendo que esta acción es irreversible</label>
            <input type="checkbox" name="confirmacion1" id="confirmacion1" required>
            <button type="submit" name="eliminar_cuenta" class="botonescss">Eliminar Cuenta</button>
        </form>
    </main>

    <script>
        function confirmarEliminacion() {
            return confirm("¿Estás absolutamente seguro de que deseas eliminar tu cuenta? Esta acción no puede deshacerse.");
        }
    </script>
    <footer>
        <div class="footer-content">
            <p>© 2024 Psychopedia. Todos los derechos reservados.</p>
            <nav class="footer-nav">
                <a href="../terminos/tycondiciones.html">Términos y Condiciones</a>
                <a href="../terminos/pprivacidad.html">Políticas de Privacidad</a>
                <a href="../plus/plus.php">Psychopedia Plus+</a>
                <a href="../desarrolladores/inidesarrolladores.php">Desarrolladores</a>

            </nav>
        </div>
    </footer>
</body>
</html>
