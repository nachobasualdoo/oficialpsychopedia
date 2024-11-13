<?php
include '../conexion.php';

// Obtén los datos enviados desde el JSON y decodifícalos
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
    $exito = true;  // Variable para controlar el éxito del proceso

    foreach ($data as $producto) {
        $id_producto = $cnx->real_escape_string($producto['id']);
        $nombre_producto = $cnx->real_escape_string($producto['nombre']);
        $talla = $cnx->real_escape_string($producto['talla']);
        $cantidad = $cnx->real_escape_string($producto['cantidad']);
        $precio = $cnx->real_escape_string($producto['precio']);
        $total = $cnx->real_escape_string($producto['total']);

        // Inserta los datos en la tabla 'pedidos'
        $sql = "INSERT INTO pedidos (id_producto, nombre_producto, talla, cantidad, precio, total)
                VALUES ('$id_producto', '$nombre_producto', '$talla', '$cantidad', '$precio', '$total')";

        // Ejecuta la consulta y verifica si ocurre un error
        if (!$cnx->query($sql)) {
            $exito = false;
            error_log("Error al insertar producto $id_producto: " . $cnx->error); // Log del error
            break; // Sale del bucle si falla una inserción
        }
    }

    // Responde en función del éxito de las operaciones de inserción
    echo json_encode(['success' => $exito]);
} else {
    echo json_encode(['success' => false, 'error' => 'No data received']);
}

$cnx->close();
?>
