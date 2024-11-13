
<?php

session_start();    
include('../conexion.php');

if (isset($_POST['correo']) && isset($_POST['contrap'])) 
{
    function verificacion($datos)
    {
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos);
        return $datos;
    }
    
    $correo = verificacion($_POST['correo']);
    $contrap = verificacion($_POST['contrap']);
    $correo = mysqli_real_escape_string($cnx, $correo);
    $sql = "SELECT * FROM `usuarios` WHERE `mail` = '$correo'";
    $resultado = mysqli_query($cnx, $sql);

    if (!$resultado) 
    {
        die("Error en la consulta SQL: " . mysqli_error($cnx));
    }

    if (mysqli_num_rows($resultado) === 1) 
    {
        $row = mysqli_fetch_assoc($resultado);
        
        // Verificar la contraseña en texto plano
        if ($contrap === $row['contrase'])
        {
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellido'] = $row['apellido'];
            $_SESSION['usuario'] = $row['id'];  // Se guarda el correo o el ID como identificador

            // Redirigir al home
            header("Location: ../home/home.php");
            exit();
        }
        else
        {
            header("Location: iniciosesion.php?error=Correo Electrónico/Contraseña incorrectos.");
            exit();
        }
    } 
    else 
    {
        header("Location: iniciosesion.php?error=Correo Electrónico/Contraseña incorrectos.");
        exit();
    }
} 
else 
{
    header("Location: iniciosesion.php?error=Por favor complete todos los campos.");
    exit();
}
?>