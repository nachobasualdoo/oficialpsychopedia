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

// Insertar comentario si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $comentario = $_POST['comentario'];

    $sql = "INSERT INTO comentarios (nombre, comentario) VALUES ('$nombre', '$comentario')";

    if ($cnx->query($sql) === TRUE) {
        echo "Comentario enviado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $cnx->error;
    }
}

$cnx->close();
?>
