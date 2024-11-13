<?php
session_start();
include '../conexion.php';

if (!isset($_SESSION['usuario']) || !isset($_POST['documento_id'])) {
    echo 'Error: Usuario no autenticado o documento no especificado';
    exit();
}

$usuario = $_SESSION['usuario'];
$documentoId = $_POST['documento_id'];

// Obtener el ID del usuario desde la base de datos
$sqlUsuario = "SELECT id FROM usuarios WHERE id = ?";
$stmt = $cnx->prepare($sqlUsuario);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->bind_result($usuarioId);
$stmt->fetch();
$stmt->close();

// Insertar el documento guardado en la base de datos
$sqlGuardar = "INSERT INTO documentos_guardados (id_usuario, id_documento) VALUES (?, ?)";
$stmt = $cnx->prepare($sqlGuardar);
$stmt->bind_param("ii", $usuarioId, $documentoId);

if ($stmt->execute()) {
    echo 'Documento guardado con éxito';
} else {
    echo 'Error al guardar el documento';
}

$stmt->close();
?>
