    <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}
include '../conexion.php';

$usuario = $_SESSION['usuario'];
$sql = "SELECT nombre, apellido, foto_perfil, plan FROM usuarios WHERE id = ?";
$stmt = $cnx->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->bind_result($nombre, $apellido, $foto_perfil, $plan);
$stmt->fetch();
$stmt->close();
$_SESSION['nombre'] = $nombre;
$_SESSION['apellido'] = $apellido;
$_SESSION['foto_perfil'] = $foto_perfil;
$_SESSION['plan'] = $plan;

$filtro = isset($_GET['criterio']) ? $_GET['criterio'] : 'nombre';
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'ASC';
$categoriaFiltro = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$relevanciaFiltro = isset($_GET['relevancia']) ? $_GET['relevancia'] : '';
$premiumFiltro = isset($_GET['premium']) ? $_GET['premium'] : '';
$busquedaTitulo = isset($_GET['busqueda_titulo']) ? $_GET['busqueda_titulo'] : '';

// Consulta para obtener las categorías únicas
$sqlCategorias = "SELECT DISTINCT categoria FROM documentos";
$resultCategorias = $cnx->query($sqlCategorias);

// Consulta para obtener la relevancia única
$sqlRelevancia = "SELECT DISTINCT relevancia FROM documentos";
$resultRelevancia = $cnx->query($sqlRelevancia);

$sql = "SELECT d.*, COUNT(rd.reaccion) AS total_likes
        FROM documentos d
        LEFT JOIN reacciones_documentos rd ON d.id = rd.documento_id AND rd.reaccion = 'me_gusta'
        WHERE 1=1";

// Agregar los filtros de búsqueda, categorías, etc.
$params = [];
$types = '';

if ($busquedaTitulo) {
    $sql .= " AND nombre LIKE ?";
    $params[] = "%" . $busquedaTitulo . "%";
    $types .= 's';
}

if ($categoriaFiltro) {
    $sql .= " AND categoria = ?";
    $params[] = $categoriaFiltro;
    $types .= 's';
}

if ($relevanciaFiltro) {
    $sql .= " AND relevancia = ?";
    $params[] = $relevanciaFiltro;
    $types .= 'i';
}

if ($premiumFiltro === '1') {
    $sql .= " AND restringido = 1"; // Solo documentos premium
} elseif ($premiumFiltro === '0') {
    $sql .= " AND restringido = 0"; // Solo documentos no premium
}

if ($filtro == 'likes') {
    $sql .= " GROUP BY d.id ORDER BY total_likes $orden";
} elseif ($filtro == 'fecha_creacion') {
    $sql .= " GROUP BY d.id ORDER BY d.fecha_creacion $orden";
} else {
    $sql .= " GROUP BY d.id ORDER BY d.$filtro $orden";
}

$stmt = $cnx->prepare($sql);

if ($params) {
    $stmt->bind_param($types, ...$params);
}

$sqlCountLikes = "SELECT COUNT(*) FROM reacciones_documentos WHERE documento_id = ? AND reaccion = 'me_gusta'";
$sqlCountDislikes = "SELECT COUNT(*) FROM reacciones_documentos WHERE documento_id = ? AND reaccion = 'no_me_gusta'";

$stmtCountLikes = $cnx->prepare($sqlCountLikes);
$stmtCountLikes->bind_param("i", $docId);
$stmtCountLikes->execute();
$stmtCountLikes->bind_result($countLikes);
$stmtCountLikes->fetch();
$stmtCountLikes->close();

$stmtCountDislikes = $cnx->prepare($sqlCountDislikes);
$stmtCountDislikes->bind_param("i", $docId);
$stmtCountDislikes->execute();
$stmtCountDislikes->bind_result($countDislikes);
$stmtCountDislikes->fetch();
$stmtCountDislikes->close();


$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();


$documentosGuardados = [];
$sqlGuardados = "SELECT id_documento FROM documentos_guardados WHERE id_usuario = ?";
$stmtGuardados = $cnx->prepare($sqlGuardados);
$stmtGuardados->bind_param("i", $_SESSION['usuario']);
$stmtGuardados->execute();
$resultGuardados = $stmtGuardados->get_result();

if ($resultGuardados->num_rows === 0) 
{
    echo '';
}
else 
{
    while ($fila = $resultGuardados->fetch_assoc()) 
    {
        $documentosGuardados[] = $fila['id_documento'];
    }
}



$stmtGuardados->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psychopedia</title>
    <link rel="stylesheet" href="estilospp.css">
</head>
<body>
    <header>
        <div class="titulo">
            <img src="../recursos/titulo.png" alt="titulo">
        </div>
        <nav class="secciones">
            <a href="../historia/historiapsychopedia.php">Acerca de Nosotros</a>
            <a href="../plus/plus.php">Plus+</a>
            <a href="../merch/merch.php">Merchandising</a>
            <a href="../donaciones/donaciones.php">Donaciones</a>
        </nav>
        <div class="nuestras-redes">
            <button class="redes-btn">Nuestras Redes</button><br>
            <div class="redes-menu">
                <a href="https://x.com" target="_blank">
                    <img src="../recursos/x.jpg" alt="Twitter">
                </a>
                <a href="https://instagram.com" target="_blank">
                    <img src="../recursos/instagram.png" alt="Instagram">
                </a>
                <a href="https://mail.google.com" target="_blank">
                    <img src="../recursos/contacto.png" alt="Mail">
                </a>
            </div>
        </div>
        <div class="usuario" id="usuario-icono">
            <img src="<?php echo isset($_SESSION['foto_perfil']) ? $_SESSION['foto_perfil'] : '../recursos/usuario.png'; ?>" >
            <div class="usuario-menu" id="usuario-menu">
                <h2><b>MI CUENTA</b></h2>
                <p><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></p><hr class="barra-menu">

                <a href="../cuenta/cuenta.php">Datos Personales</a><br>
                <a href="mis_documentos.php">Documentos Guardados</a><br>
                <a href="../cerrarsesion.php">Cerrar Sesión</a><br>
            </div>
        </div>

    </header>
    <main>
        <h1 class="documentos-heading">DOCUMENTOS DISPONIBLES</h1>
        <hr class="barra-separadora">
        <h2 class="subdocumentos-heading">ORDENAR</h2>
        <div class="filtro-barra">
            <form action="home.php" method="get">
                <div class="filtros">
                    <div class="filtro-item">
                        <label for="criterio">Por</label>
                        <select name="criterio" id="criterio">
                            <option value="nombre" <?php if($filtro == 'nombre') echo 'selected'; ?>>Nombre</option>
                            <option value="categoria" <?php if($filtro == 'categoria') echo 'selected'; ?>>Categoría</option>
                            <option value="fecha_creacion" <?php if($filtro == 'fecha_creacion') echo 'selected'; ?>>Fecha de Creación</option>
                            <option value="likes" <?php if($filtro == 'likes') echo 'selected'; ?>>Cantidad de Likes</option>
                        </select>
                    </div>
                    <div class="filtro-item">
                        <label for="orden">Forma</label>
                        <select name="orden" id="orden">
                            <option value="ASC" <?php if($orden == 'ASC') echo 'selected'; ?>>Ascendente</option>
                            <option value="DESC" <?php if($orden == 'DESC') echo 'selected'; ?>>Descendente</option>
                        </select>
                    </div>
                    <br>
                </div>
                <button type="submit" class="btn-ordenar">Ordenar</button>
                <hr class="barra-separadora">
                <h2 class="subdocumentos-heading">FILTRAR</h2>
                <div class="filtros">
                    <div class="filtro-item">
                        <label for="categoria">Categoría</label>
                        <select name="categoria" id="categoria">
                            <option value="">Todas</option>
                            <?php

                            if ($resultCategorias->num_rows > 0) {
                                while ($categoria = $resultCategorias->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($categoria['categoria']) . '"';
                                    if ($categoriaFiltro == $categoria['categoria']) echo ' selected';
                                    echo '>' . htmlspecialchars($categoria['categoria']) . '</option>';
                                }
                            }

                            ?>
                        </select>
                    </div>

                    <div class="filtro-item">
                        <label for="premium">Premium</label>
                        <select name="premium" id="premium">
                            <option value="">Todos</option>
                            <option value="1" <?php if($premiumFiltro == '1') echo 'selected'; ?>>SI</option>
                            <option value="0" <?php if($premiumFiltro == '0') echo 'selected'; ?>>NO</option>
                        </select>
                    </div>
                    
                    <br>
                </div>
                <button type="submit" name="filtrar" class="btn-filtrar">Filtrar</button>
                <hr class="barra-separadora">
            </form>
            <h2 class="subdocumentos-heading">BUSCAR DOCUMENTO</h2>

            <div class="container">
                <form action="home.php" method="get">
                    <input type="text" name="busqueda_titulo" id="busqueda_titulo" placeholder="Buscar" value="<?php echo isset($_GET['busqueda_titulo']) ? htmlspecialchars($_GET['busqueda_titulo']) : ''; ?>">
                    <button type="submit" name="filtrar" class="btn"><img src="../recursos/lupa.png" class="lupa"></button><BR>
                </form>
            </div>
            <hr class="barra-separadora">

        
        <h1 class="documentos-heading">DOCUMENTOS</h1>
        </div>
        <div class="documentos-grid">

        <?php
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $esPremium = $fila['restringido'];
                $claseDocumento = $esPremium ? 'documento-item restringido' : 'documento-item';
                $clasePremiumUsuario = ($esPremium && $_SESSION['plan'] !== 'premium') ? ' no-descargar-premium' : '';
                $docId = $fila['id'];

                $isGuardado = in_array($docId, $documentosGuardados) ? true : false;
                
                $sqlCountLikes = "SELECT COUNT(*) FROM reacciones_documentos WHERE documento_id = ? AND reaccion = 'me_gusta'";
                $sqlCountDislikes = "SELECT COUNT(*) FROM reacciones_documentos WHERE documento_id = ? AND reaccion = 'no_me_gusta'";
                $stmtCountLikes = $cnx->prepare($sqlCountLikes);
                $stmtCountLikes->bind_param("i", $docId);
                $stmtCountLikes->execute();
                $stmtCountLikes->bind_result($countLikes);
                $stmtCountLikes->fetch();
                $stmtCountLikes->close();
                $stmtCountDislikes = $cnx->prepare($sqlCountDislikes);
                $stmtCountDislikes->bind_param("i", $docId);
                $stmtCountDislikes->execute();
                $stmtCountDislikes->bind_result($countDislikes);
                $stmtCountDislikes->fetch();
                $stmtCountDislikes->close();
                echo '<div class="' . $claseDocumento . $clasePremiumUsuario . '" data-title="' . htmlspecialchars($fila["nombre"]) . '" data-description="' . htmlspecialchars($fila["descripcion"]) . '" data-image="' . htmlspecialchars($fila["imagen_previsualizacion"]) . '" data-file="../uploads/pdf/' . htmlspecialchars($fila["archivo_pdf"]) . '">';
                
                echo '<img src="../uploads/imagenes/' . $fila['imagen_previsualizacion'] . '" alt="Imagen del Documento">';
                echo '<h3>' . $fila["nombre"] . '</h3>';
                echo '<p><b>Autor: ' . $fila["autor"] . '</b></p>';
                echo '<p>Categoría: ' . $fila["categoria"] . '</p>';

                if ($esPremium) 
                {
                    echo '<p><b><span class="estrella-premium">★★★</span><br> Documento Premium</b></p>';
                }


                
                if ($isGuardado) 
                {
                     echo '<button disabled class="btn-guardar" data-id="' . $fila["id"] . '">' . '♥' . '</button>';
                }
                else  
                {
                    echo '<button class="btn-guardar" data-id="' . $fila["id"] . '">' . '♡' . '</button>';
                }
                



                echo '<p> ¿Qué te ha parecido este documento? </p>';
                echo '
                <div class="botones-reacciones" data-id="' . $fila["id"] .'">
                    <button type="submit" name="reaccion" value="me_gusta" class="btn-like">👍 ' . $countLikes . '</button>
                    <button type="submit" name="reaccion" value="no_me_gusta" class="btn-dislike">👎 ' . $countDislikes . '</button>
                </div>';
                echo '</div>';
            }
        } else {
            echo '<div class="no-documentos"><p>Sin resultados</p></div>';
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

    // GUARDAR GUARDAR GUARDAR GUARDAR GUARDAR GUARDAR GUARDAR GUARDAR GUARDAR     


    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('modal');
        var closeButton = document.querySelector('.close-button');
        var body = document.body;
        var documentoItems = document.querySelectorAll('.documento-item');
        var botonGuardar = document.querySelectorAll('.btn-guardar');
        var botonesReacciones = document.querySelectorAll('.botones-reacciones');


        botonGuardar.forEach(function(boton) {
            boton.addEventListener('click', function(event) {
                event.stopPropagation(); // Evitar que el click en el botón abra el modal
                var documentoId = boton.getAttribute('data-id');

                // Hacer la solicitud AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'guardardocumento.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); // Refresca la página
                    }
                };
                xhr.send('documento_id=' + documentoId);
            });
        });



        // LIKE DISLIKE LIKE DISLIKE LIKE DISLIKE LIKE DISLIKE LIKE DISLIKE LIKE DISLIKE

        botonesReacciones.forEach(function(container) {
            container.querySelector('.btn-like').addEventListener('click', function() {
                event.stopPropagation();
                var documentoId = container.getAttribute('data-id');
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'reacciones.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); // Refresca la página
                    }
                };
                xhr.send('documento_id=' + documentoId + '&reaccion=me_gusta');
            });

            container.querySelector('.btn-dislike').addEventListener('click', function() {
                event.stopPropagation();
                var documentoId = container.getAttribute('data-id');
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'reacciones.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload(); // Refresca la página
                    }
                };
                xhr.send('documento_id=' + documentoId + '&reaccion=no_me_gusta');
            });
        });
        


        // OCULTAR DESCARGA PREMIUM OCULTAR DESCARGA PREMIUM OCULTAR DESCARGA PREMIUM OCULTAR DESCARGA PREMIUM 


        documentoItems.forEach(function(item) {
            item.addEventListener('click', function(event) {
                if (event.target.tagName.toLowerCase() === 'a') {
                    return;
                }

                var title = item.getAttribute('data-title');
                var description = item.getAttribute('data-description');
                var file = item.getAttribute('data-file');
                var isPremium = item.classList.contains('no-descargar-premium');
                var userPlan = "<?php echo $_SESSION['plan']; ?>";

                document.getElementById('modal-title').textContent = title;
                document.getElementById('modal-description').textContent = description;
                

                var downloadLink = document.getElementById('modal-download');
                var shareLink = document.getElementById('modal-share');
                var pPremium = document.getElementById('modal-nopremium');

                if (isPremium && userPlan !== 'premium') {
                    downloadLink.style.display = 'none'; // Ocultar si es premium y no tiene plan
                    shareLink.style.display = 'none'; // Ocultar compartir también
                    pPremium.style.display = 'block';

                } else {
                    downloadLink.href = file; // Asignar href si no es premium o tiene plan premium
                    downloadLink.style.display = 'inline-block'; // Mostrar botón de descarga
                    shareLink.style.display = 'inline-block'; // Mostrar botón de compartir
                    pPremium.style.display = 'none';
                    shareLink.href = "#";
                    shareLink.setAttribute('data-file-url', window.location.origin + "/" + file);
                }

                var shareLink = document.getElementById('modal-share');
                shareLink.href = "#";  // Inicialmente el link no tiene destino
                shareLink.setAttribute('data-file-url', window.location.origin + "/" + file);
                modal.style.display = 'block';
                body.classList.add('modal-open');
            });
        });
        document.getElementById('modal-share').addEventListener('click', function(event) {
            event.preventDefault();
            var fileUrl = this.getAttribute('data-file-url');
            
            // Copiar el enlace al portapapeles
            navigator.clipboard.writeText(fileUrl).then(function() {
                alert('Enlace copiado al portapapeles: ' + fileUrl);
            }, function() {
                alert('Hubo un error al copiar el enlace.');
            });
        });

        document.getElementById("usuario-icono").addEventListener("click", function () {
            const menu = document.getElementById("usuario-menu");
            if (menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }
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
        <div class="footer-content">
            <p>© 2024 Psychopedia. Todos los derechos reservados.</p>
            <nav class="footer-nav">
                <a href="../politicasyterminos/tycondiciones.html">Términos y Condiciones</a>
                <a href="../politicasyterminos/ppvacidad.html">Políticas de Privacidad</a>
                <a href="../desarrolladores/inidesarrolladores.php">Desarrolladores</a>
            </nav>
            <br>
            <p>¿Tienes alguna sugerencia para mejorar la pagina?, puedes enviarla <a href="../comentarios/comentarios.php">aqui</a> </p>
        </div>
    </footer>
</body>
</html>
