<?php
include '../conexion.php';
if (isset($_POST['eliminar'])) {
    $idDocumento = $_POST['idDocumento'];
    $sqlEliminar = "DELETE FROM documentos WHERE id = ?";
    $stmtEliminar = $cnx->prepare($sqlEliminar);
    $stmtEliminar->bind_param("i", $idDocumento);
    $stmtEliminar->execute();
    $stmtEliminar->close();
    header("Location: ../home/home.php");
    exit();
}
if (isset($_POST['guardar'])) {
    $idDocumento = $_POST['idDocumento'];
    $nombre = $_POST['nombre'];
    $relevancia = $_POST['relevancia'];
    $categoria = $_POST['categoria'];
    if (isset($_FILES['imagen_previsualizacion']) && $_FILES['imagen_previsualizacion']['error'] == UPLOAD_ERR_OK) {
        $imagenTmp = $_FILES['imagen_previsualizacion']['tmp_name'];
        $imagenNombre = basename($_FILES['imagen_previsualizacion']['name']);
        $imagenRuta = $imagenNombre;
        move_uploaded_file($imagenTmp, $imagenRuta);
    } else {
        $imagenRuta = $_POST['imagen_previsualizacion_actual'];
    }

    $sqlActualizar = "UPDATE documentos SET nombre = ?, relevancia = ?, categoria = ?, imagen_previsualizacion = ? WHERE id = ?";
    $stmtActualizar = $cnx->prepare($sqlActualizar);
    $stmtActualizar->bind_param("ssssi", $nombre, $relevancia, $categoria, $imagenRuta, $idDocumento);
    $stmtActualizar->execute();
    $stmtActualizar->close();
    header("Location: ../home/home.php");
    exit();
}

