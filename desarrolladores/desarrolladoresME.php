    <?php
    session_start();

    // Conectar a la base de datos
    include '../conexion.php';
    if ($cnx->connect_error) {
        die('Error de conexión: ' . $cnx->connect_error);
    }

    // Manejar eliminación de documentos
    if (isset($_POST['eliminar'])) {
        $idDocumento = $_POST['idDocumento'];
        $sqlEliminar = "DELETE FROM documentos WHERE id = ?";
        $stmtEliminar = $cnx->prepare($sqlEliminar);
        if ($stmtEliminar) {
            $stmtEliminar->bind_param("i", $idDocumento);
            if ($stmtEliminar->execute()) {
                echo "Documento eliminado correctamente.";
            } else {
                echo "Error al eliminar el documento: " . $stmtEliminar->error;
            }
            $stmtEliminar->close();
        } else {
            echo "Error en la preparación de la consulta: " . $cnx->error;
        }
        exit();
    }

    // Manejar modificación de documentos
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) 
    {
        $idDocumento = $_POST['idDocumento'];
        $nombre = $_POST['nombre'];
        $relevancia = $_POST['relevancia'];
        $categoria = $_POST['categoria'];
        $descripcion = $_POST['descripcion'];
        $autor = $_POST['autor'];

        // Construcción dinámica de la consulta de actualización
        $camposActualizados = [];
        $parametros = [];
        $tipos = '';

        if (!empty($nombre)) {
            $camposActualizados[] = 'nombre = ?';
            $parametros[] = $nombre;
            $tipos .= 's';
        }
        if (!empty($relevancia)) {
            $camposActualizados[] = 'relevancia = ?';
            $parametros[] = $relevancia;
            $tipos .= 's';
        }
        if (!empty($categoria)) {
            $camposActualizados[] = 'categoria = ?';
            $parametros[] = $categoria;
            $tipos .= 's';
        }
        if (!empty($descripcion)) {
            $camposActualizados[] = 'descripcion = ?';
            $parametros[] = $descripcion;
            $tipos .= 's';
        }
        if (!empty($autor)) {
            $camposActualizados[] = 'autor = ?';
            $parametros[] = $autor;
            $tipos .= 's';
        }

        // Manejar la subida de la imagen de previsualización
        if (!empty($_FILES['imagen_previsualizacion']['name'])) {
            $imagen_previsualizacion = $_FILES['imagen_previsualizacion']['name'];
            $ruta_imagen = 'uploads/imagenes/' . basename($imagen_previsualizacion);
            // Mover la imagen al directorio de destino
            if (move_uploaded_file($_FILES['imagen_previsualizacion']['tmp_name'], $ruta_imagen)) {
                $camposActualizados[] = 'imagen_previsualizacion = ?';
                $parametros[] = $imagen_previsualizacion; // Solo se guarda el nombre del archivo
                $tipos .= 's';
            } else {
                echo "Error al subir la imagen.";
                exit();
            }
        }

        // Solo proceder si hay cambios
        if (!empty($camposActualizados)) {
            $sqlActualizar = "UPDATE documentos SET " . implode(', ', $camposActualizados) . " WHERE id = ?";
            $parametros[] = $idDocumento; // El ID siempre es el último parámetro
            $tipos .= 'i'; // El ID es entero

            $stmtActualizar = $cnx->prepare($sqlActualizar);
            if ($stmtActualizar) {
                $stmtActualizar->bind_param($tipos, ...$parametros);
                if ($stmtActualizar->execute()) {
                    echo "Documento actualizado correctamente.";
                } else {
                    echo "Error al actualizar el documento: " . $stmtActualizar->error;
                }
                $stmtActualizar->close();
            } else {
                echo "Error en la preparación de la consulta: " . $cnx->error;
                exit();
            }
        }

        // Redireccionar después de guardar
        header("Location: desarrolladoresME.php");
        exit();
    }

// Obtener documentos
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'nombre';
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'ASC';
$sql = "SELECT * FROM documentos ORDER BY $filtro $orden";
$resultado = $cnx->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Desarrolladores - Psychopedia</title>
    <link rel="stylesheet" href="estilosfd3.css">
</head>
<body>
    <header>
        <a href="../index.php">
            <img src="../recursos/titulo.png" alt="Título" class="logo">
        </a>
    </header>
    <main>
        <h1>GESTION DE DOCUMENTOS</h1>
        <div class="documentos-grid">
            <?php
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo '<div class="documento-item">';
                    echo '<form method="post" action="desarrollador.php" enctype="multipart/form-data">';
                    echo '<input type="hidden" name="idDocumento" value="' . $fila["id"] . '">';
                    echo '<img src="../uploads/imagenes/'.$fila["imagen_previsualizacion"].'" alt="Previsualización">';
                    echo '<label>Nombre del documento:</label>';
                    echo '<input type="text" name="nombre" value="' . $fila["nombre"] . '">';
                    echo '<label>Autor del documento:</label>';
                    echo '<input type="text" name="autor" value="' . $fila["autor"] . '">';
                    echo '<label>Relevancia:</label>';
                    echo '<select name="relevancia">';
                    echo '<option value="1"' . ($fila["relevancia"] == 1 ? ' selected' : '') . '>1 (Alta)</option>';
                    echo '<option value="2"' . ($fila["relevancia"] == 2 ? ' selected' : '') . '>2 (Media)</option>';
                    echo '<option value="3"' . ($fila["relevancia"] == 3 ? ' selected' : '') . '>3 (Baja)</option>';
                    echo '</select>';
                    echo '<label>Categoría:</label>';
                    echo '<input type="text" name="categoria" value="' . $fila["categoria"] . '">';
                    echo '<label>Cambiar Imagen:</label>';
                    echo '<input type="file" id="imagen_previsualizacion" name="imagen_previsualizacion" accept="image/*">';
                    echo '<div class="botones">';
                    echo '<label>Descripción:</label>';
                    echo '<textarea name="descripcion" id="descripcion" rows="4" cols="50">' . $fila["descripcion"] . '</textarea>';
                    echo '<button type="submit" name="guardar" class="boton-verde">Guardar Cambios</button>';
                    echo '<button type="submit" name="eliminar" class="boton-rojo">Eliminar</button>';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<div class="no-documentos"><p>No se encontraron documentos</p></div>';
            }
            ?>
        </div>
    </main>
</body>
</html>
