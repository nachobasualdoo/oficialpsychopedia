<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

include '../conexion.php';

$usuario = $_SESSION['usuario'];

// Obtener el ID del usuario
$sqlUsuario = "SELECT id FROM usuarios WHERE id = ?";
$stmt = $cnx->prepare($sqlUsuario);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->bind_result($usuarioId);
$stmt->fetch();
$stmt->close();

// Obtener los documentos guardados por el usuario
$sql = "SELECT documentos.*, documentos_guardados.id_documento FROM documentos
        JOIN documentos_guardados ON documentos.id = documentos_guardados.id_documento
        WHERE documentos_guardados.id_usuario = ?";
$stmt = $cnx->prepare($sql);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();

// Verifica si se ha enviado la solicitud para eliminar un documento
if (isset($_POST['eliminar'])) {
    $documentoId = $_POST['documento_id'];

    // Eliminar el documento de la tabla documentos_guardados
    $sqlEliminar = "DELETE FROM documentos_guardados WHERE id_usuario = ? AND id_documento = ?";
    $stmtEliminar = $cnx->prepare($sqlEliminar);
    $stmtEliminar->bind_param("ii", $usuarioId, $documentoId);
    $stmtEliminar->execute();
    $stmtEliminar->close();

    // Redirecciona a la misma página para ver los cambios
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Documentos Guardados</title>
    <link rel="stylesheet" href="misdocumentos.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    <header>
        <a href="home.php">
            <img src="../recursos/titulo.png" alt="Título" class="logo">
        </a>
    </header>
    <main>
        <h1>MIS DOCUMENTOS </h1>
        <div class="documentos-grid">
        <?php
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $esPremium = $fila['restringido'];
                $claseDocumento = $esPremium ? 'documento-item restringido' : 'documento-item';
                $clasePremiumUsuario = ($esPremium && $_SESSION['plan'] !== 'premium') ? ' no-descargar-premium' : '';
                $docId = $fila['id'];

                // Renderiza la tarjeta del documento
                echo '<div class="' . $claseDocumento . $clasePremiumUsuario . '" data-title="' . htmlspecialchars($fila["nombre"]) . '" data-description="' . htmlspecialchars($fila["descripcion"]) . '" data-image="' . htmlspecialchars($fila["archivo_pdf"]) . '">';

                echo '<img src="../uploads/imagenes/' . $fila['imagen_previsualizacion'] . '" alt="Imagen del Documento">';
                echo '<h3>' . htmlspecialchars($fila["nombre"]) . '</h3>';
                
                echo '<p>Categoría: ' . htmlspecialchars($fila["categoria"]) . '</p>';

                if ($esPremium) {
                    echo '<p><span class="estrella-premium">★★★</span><br> Documento Premium</p>';
                }
                // Dentro del bucle que renderiza cada documento
                echo '<form method="POST" action="">';
                echo '<input type="hidden" name="documento_id" value="' . $docId . '">';
                echo '<button type="submit" name="eliminar" class="btn-eliminar">-</button>';
                echo '</form>';

            }
        } else {
            echo '<p class="nodocumentos">No tienes documentos guardados.</p>';
        }
        ?>
        </div>
    </main>

    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-title">Título del Documento</h2>
                <span class="close-button">&times;</span>
            </div>
            <p id="modal-description">Descripción del documento...</p>
            <div class="button-group">
                <a id="modal-download" class="btn-descargarMODAL" style="display: none;" download>Descargar PDF</a>
                <a id="modal-share" class="btn-descargarMODAL" href="#">Compartir Documento</a>
                <p id="modal-nopremium" class="p-nopremium">¡Adquiere Psychopedia+ para descargar y compartir el documento!</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('modal');
            var closeButton = document.querySelector('.close-button');
            var body = document.body;
            var documentoItems = document.querySelectorAll('.documento-item');

            documentoItems.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    // Evita abrir el modal si el clic se hizo en el botón de eliminar
                    if (event.target.classList.contains('btn-eliminar')) {
                        return;
                    }

                    var title = item.getAttribute('data-title');
                    var description = item.getAttribute('data-description');
                    var image = item.getAttribute('data-image');
                    var file = item.getAttribute('data-file');
                    var isPremium = item.classList.contains('restringido');
                    var userPlan = "<?php echo $_SESSION['plan']; ?>";

                    document.getElementById('modal-title').textContent = title;
                    document.getElementById('modal-description').textContent = description;

                    var downloadLink = document.getElementById('modal-download');
                    var shareLink = document.getElementById('modal-share');
                    var pPremium = document.getElementById('modal-nopremium');

                    if (isPremium && userPlan !== 'premium') {
                        downloadLink.style.display = 'none';
                        shareLink.style.display = 'none';
                        pPremium.style.display = 'block';
                    } else {
                        downloadLink.href = file;
                        downloadLink.style.display = 'inline-block';
                        shareLink.style.display = 'inline-block';
                        pPremium.style.display = 'none';
                        shareLink.href = "#";
                        shareLink.setAttribute('data-file-url', window.location.origin + "/" + file);
                    }

                    modal.style.display = 'block';
                    body.classList.add('modal-open');
                });
            });

            closeButton.addEventListener('click', function() {
                modal.style.display = 'none';
                body.classList.remove('modal-open');
            });

            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                    body.classList.remove('modal-open');
                }
            });
        });


    </script>

    <footer>
        <div class="footer">
            <p>© 2024 Psychopedia. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
