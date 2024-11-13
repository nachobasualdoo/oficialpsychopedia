<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../conexion.php';

// Verifica que la conexión sea exitosa
if ($cnx->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Error de conexión: ' . $cnx->connect_error]);
    exit();
}

require '../vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51QGh9HJU8LuuJkEexeNycoPjdWjTM5LIHFjXkPPTh4O6WzCn6pKWTSEcOQMWoSyZ4v9PQGdeO2irOlNVqzP73fYQ00JeM4H0kl'); // Reemplaza 
header('Content-Type: application/json');

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'ars',
                'product_data' => [
                    'name' => 'Plan Basic',
                ],
                'unit_amount' => 50000,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'pagoexitoso.php',
        'cancel_url' => 'pagofallido.php',
        'metadata' => [
            'user_id' => $_SESSION['usuario']
        ]
    ]);


    echo json_encode(['sessionId' => $session->id]);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
