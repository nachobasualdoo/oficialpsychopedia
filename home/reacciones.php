<?php
session_start();
include '../conexion.php';

if (!isset($_SESSION['usuario']) || !isset($_POST['documento_id']) || !isset($_POST['reaccion'])) {
    header("Location: home.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$documento_id = $_POST['documento_id'];
$reaccion = $_POST['reaccion'];

// Verificar si el usuario ya ha reaccionado al documento
$sqlCheck = "SELECT * FROM reacciones_documentos WHERE documento_id = ? AND id_usuario = ?";
$stmtCheck = $cnx->prepare($sqlCheck);
$stmtCheck->bind_param("is", $documento_id, $usuario);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    // El usuario ya reaccionó, actualizamos la reacción
    $sqlUpdate = "UPDATE reacciones_documentos SET reaccion = ? WHERE documento_id = ? AND id_usuario = ?";
    $stmtUpdate = $cnx->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sis", $reaccion, $documento_id, $usuario);
    $stmtUpdate->execute();
    $stmtUpdate->close();
} else {
    // El usuario no ha reaccionado, insertamos una nueva reacción
    $sqlInsert = "INSERT INTO reacciones_documentos (documento_id, id_usuario, reaccion) VALUES (?, ?, ?)";
    $stmtInsert = $cnx->prepare($sqlInsert);
    $stmtInsert->bind_param("iss", $documento_id, $usuario, $reaccion);
    $stmtInsert->execute();
    $stmtInsert->close();
}
exit();
?>
