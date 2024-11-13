<?php
$servername = "localhost";
$user = "root";
$contra = "";
$base = "psychopedia";

// Crear la conexión
$conexion = new mysqli($servername, $user, $contra, $base);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta SQL para obtener los datos
$sql = "SELECT * FROM usuarios";
$resultado = $conexion->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    echo '<style>
        .table-container {
            text-align: center;
            padding: 30px;
        }
        .table-container img {
            margin-bottom: 10px;
        }
        table {
            width: 75%;
            margin: 0 auto;
            border-collapse: collapse;
            padding: 10px;
        }
        body {
            background-color: #e5b3fe;
        }
        td, th {
            padding: 10px;
            text-align: center;
            border: 3px solid #E8B343;
        }
        th {
            background-color: #962F5A; 
            color: #E8B343;
        }
        h1 {
            text-align: center;
            color: #962F5A;
        }
        tr:nth-child(1n) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: skyblue;
        }
        .boton-container {
            text-align: center;
            margin-top: 20px;
        }
        .boton {
            background: #962F5A;
            border: none;
            padding: 12px;
            color: #E8B343;
            margin: 0 10px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
            transition: background-color 0.3s, transform 0.3s;
            text-decoration: none;
        }
        .boton:hover {
            background-color: #C9678E;
            transform: scale(1.07);
        }
    </style>';

    echo '<div class="table-container">';
    echo '<img src="recursos/titulo.png" alt="logo">';
    echo "<br><h1>SECCION DE DESARROLLADORES</h1><h2>Tabla de USUARIOS REGISTRADOS</h2>";
    echo "<table> <tr> <th>Apellido</th>
    <th>Nombre</th> <th>Sexo</th> <th>Fecha de Nacimiento</th>
    <th>Correo Electrónico</th> <th>Contraseña</th> <th>Edad</th> <th>ID Usuario</th>
    </tr>";

    while($row = $resultado->fetch_assoc()) {
        $fecha_nacimiento = new Datetime($row["fnacimiento"]);
        $fecha_actual = new DateTime();
        $diferencia = $fecha_actual->diff($fecha_nacimiento);
        $edad = $diferencia->y;
        
        echo "<tr>
                <td>" . $row["apellido"]. "</td>
                <td>" . $row["nombre"]. "</td>
                <td>" . $row["sexo"]. "</td>
                <td>" . $row["fnacimiento"]. "</td>
                <td>" . $row["mail"]. "</td>
                <td>" . $row["contrase"]. "</td>
                <td>" . $edad. "</td>
                <td>" . $row["id"]. "</td>
              </tr>";
    }
    echo "</table>";
    echo '</div>';
    echo '<div class="boton-container">
            <a href="../iniciosesion/iniciosesion.php" class="boton">Volver al Inicio de Sesión</a>
            <a href="../registro/registro.php" class="boton">Volver al Registro</a>
          </div>';
} else {
    echo "Sin registros encontrados";
}

// Cerrar la conexión
$conexion->close();
?>
