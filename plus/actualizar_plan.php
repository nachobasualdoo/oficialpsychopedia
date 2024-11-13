<?php
require '../vendor/autoload.php';
require '../conexion.php';
\Stripe\Stripe::setApiKey('sk_test_51QGh9HJU8LuuJkEexeNycoPjdWjTM5LIHFjXkPPTh4O6WzCn6pKWTSEcOQMWoSyZ4v9PQGdeO2irOlNVqzP73fYQ00JeM4H0kl');

// Captura el evento enviado por Stripe
$input = @file_get_contents("php://input");
$event = json_decode($input);

if ($event->type == 'payment_intent.succeeded') {
    $paymentIntent = $event->data->object;

    // Obtén el user_id de los metadatos del pago
    $userId = $paymentIntent->metadata->user_id;

    // Actualiza el plan del usuario en la base de datos
    $stmt = $cnx->prepare("UPDATE usuarios SET plan = 'basic' WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();

    http_response_code(200);
} else {
    http_response_code(400);
}
