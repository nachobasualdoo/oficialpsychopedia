<?php
include '../conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $nombre = $_POST['nombre'];
    $relevancia = $_POST['relevancia'];
    $categoria = $_POST['categoria'];
    $autor = $_POST['autor'];
    $restringido = $_POST['restringido'];
    $descripcion = $_POST['descripcion'];  // Captura la descripción
    $archivo_pdf = $_FILES['archivo_pdf']['name'];
    $imagen_previsualizacion = $_FILES['imagen_previsualizacion']['name'];
    $destino_pdf = '../uploads/pdf/' . $archivo_pdf;
    $destino_imagen = '../uploads/imagenes/' . $imagen_previsualizacion;

    // Mover archivos subidos
    move_uploaded_file($_FILES['archivo_pdf']['tmp_name'], $destino_pdf);
    move_uploaded_file($_FILES['imagen_previsualizacion']['tmp_name'], $destino_imagen);

    // Modificar consulta SQL para incluir la descripción
    $sql = "INSERT INTO documentos (nombre, relevancia, categoria, imagen_previsualizacion, archivo_pdf, restringido, descripcion, autor)
            VALUES ('$nombre', '$relevancia', '$categoria', '$imagen_previsualizacion', '$archivo_pdf', '$restringido', '$descripcion', '$autor')";

    if (mysqli_query($cnx, $sql)) {
        $mensaje = "Documento cargado exitosamente.";
    } 
    else 
    {
        $mensaje = "Error al cargar el documento: " . mysqli_error($cnx);
    }

    mysqli_close($cnx);
    header("Location: desarrolladoresA.php?mensaje=" . urlencode($mensaje));
    exit();
}

?>
