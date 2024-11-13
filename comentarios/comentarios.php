<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seccion de Comentarios/Sugerencias</title>
    <link rel="stylesheet" href="comentarios.css">
</head>
<body>

    <header>
        <a href="../home/home.php">
            <img src="../recursos/titulo.png" alt="Título" class="logo">
        </a>
    </header>

    <main>
        <h1>Enviar Comentarios</h1>
        <br>
        <form action="guardar_comentario.php" method="POST">
            <input type="text" name="nombre" placeholder="Ingresa tu Nombre:" required><br><br>
            <textarea name="comentario" placeholder="Escribe tu comentario aquí:" required></textarea><br><br>
            <input type="submit" value="Enviar Comentario">
        </form>
        <br>
        <hr>
        <br>
        <h2>Comentarios</h2>
        <br>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Nombre</th>
                <th>Comentario</th>
            </tr>

            <?php
            session_start();
            if (!isset($_SESSION['usuario'])) {
                header("Location: ../index.php");
                exit();
            }
            include '../conexion.php';
 
            if ($cnx->connect_error) {
                die("Conexión fallida: " . $cnx->connect_error);
            }

            // Consulta para obtener los comentarios
            $sql = "SELECT id, nombre, comentario FROM comentarios";
            $result = $cnx->query($sql);

            if ($result->num_rows > 0) {
                // Mostrar cada comentario en la tabla
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['comentario'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No hay comentarios aún</td></tr>";
            }

            $cnx->close();
            ?>

        </table>
    </main>

    <footer>
        <div class="footer">
            <p>© 2024 Psychopedia. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>
