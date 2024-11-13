<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Documento</title>
    <link rel="stylesheet" href="estilosdesar.css">
    <link rel="stylesheet" href="estilosfd.css"> 
</head>
<body>
    <header>
        <a href="../home/home.php">
            <img src="../recursos/titulo.png" alt="Título" class="logo">
        </a>
    </header>
        <main>
        <h1>SECCIÓN DESARROLLADORES</h1>
        <h2>Cargar Documento</h2>

        <?php if (isset($mensaje)): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <form action="desarrolladoresINSERCION.php" method="post" enctype="multipart/form-data" class="formulario">
            <label for="nombre">Nombre del Documento:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="autor">Autor del Documento:</label>
            <input type="text" id="autor" name="autor" required>

            <label for="relevancia">Relevancia:</label>
            <select id="relevancia" name="relevancia" required>
                <option value="1">1 (Baja)</option>
                <option value="2">2 (Media)</option>
                <option value="3">3 (Alta)</option>
            </select>

            <label for="categoria">Categoría:</label>
            <input type="text" id="categoria" name="categoria" required>
        
            <label for="archivo_pdf">Archivo PDF:</label>
            <input type="file" id="archivo_pdf" name="archivo_pdf" accept="application/pdf" required>

            <label for="imagen_previsualizacion">Imagen de Previsualización:</label>
            <input type="file" id="imagen_previsualizacion" name="imagen_previsualizacion" accept="image/*" required>

            <label for="restringido">¿Es un documento premium?</label>
            <select id="restringido" name="restringido" required>
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>

            <!-- Caja de texto para la descripción -->
            <label for="descripcion">Descripción del Documento:</label>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50" required></textarea>

            <button type="submit">Subir Documento</button>
        </form>
        <button type="submit"><a href="../home/home.php">Volver al Home</a></button>

    </main>
</body>
</html>

