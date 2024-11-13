<?php
session_start();    
include('../conexion.php');

if (isset($_POST['nde']) && isset($_POST['cde'])) {
    
    function limpiarDatos($datos) {
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos);
        return $datos;
    }
    
    $ndesarrollador = limpiarDatos($_POST['nde']);
    $cdesarrollador = limpiarDatos($_POST['cde']);

    // Consulta para obtener el desarrollador
    $sql = "SELECT * FROM `desarrolladores` WHERE `ndesarrollador` = ?";
    $stmt = mysqli_prepare($cnx, $sql);
    mysqli_stmt_bind_param($stmt, "s", $ndesarrollador);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) === 1) {
        $row = mysqli_fetch_assoc($resultado);
        
        // Verificación de contraseña en texto plano
        if ($cdesarrollador === $row['cdesarrollador']) {
            $_SESSION['ndesarrollador'] = $row['ndesarrollador'];
            $_SESSION['idesarrollador'] = $row['idesarrollador'];

            // Redirigir al home de desarrolladores
            header("Location: desarrolladores.php");
            exit();
        } else {
            header("Location: inidesarrolladores.php?error=Datos incorrectos.");
            exit();
        }
    } else {
        header("Location: inidesarrolladores.php?error=Datos incorrectos.");
        exit();
    }
} else {
    header("Location: inidesarrolladores.php?error=Por favor complete todos los campos.");
    exit();
}
?>
