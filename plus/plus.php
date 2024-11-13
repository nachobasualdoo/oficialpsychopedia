<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../conexion.php';

if ($cnx->connect_error) {
    die('Error de conexión: ' . $cnx->connect_error);
}

$usuario = $_SESSION['usuario'];
$sql = "SELECT plan FROM usuarios WHERE id = ?";
$stmt = $cnx->prepare($sql);
$stmt->bind_param("i", $usuario);
$stmt->execute();
$stmt->bind_result($planActual);
$stmt->fetch();
$stmt->close();
$cnx->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Psychopedia Plus+</title>
    <link rel="stylesheet" href="estilosplus.css">
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <header>
        <a href="../home/home.php">
            <img src="../recursos/titulo.png" alt="Título" class="logo">
        </a>
    </header>
    <main id="main-content">
        <h1>PSYCHOPEDIA PLUS+</h1>
        <section class="suscripcion">
            <div class="planes">
                <div class="plan-contenedor">
                    <div class="plan">
                        <h2>Sin plan</h2>
                        <li><b>Acceso a documentos básicos</b></li>
                        <?php if ($planActual === 'ninguno'): ?>
                            <p>Plan actual</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="plan-contenedor">
                    <div class="plan">
                        <h2>Plan Basic</h2>
                        <p>Acceso a documentos de categoría PREMIUM.</p>
                        <p><strong>Precio:</strong> $999ARS/mes</p>
                        <ul>
                            <li>Documentos PREMIUM</li>
                            <li>Actualizaciones mensuales</li>
                        </ul>
                        <?php if ($planActual === 'basic'): ?>
                            <p>Plan actual</p>
                        <?php else: ?>
                            <button class='btn-pago' id="checkout-button">Pagar</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <p>© 2024 Psychopedia. Todos los derechos reservados.</p>
            <nav class="footer-nav">
                <a href="/terminos/tycondiciones.html">Términos y Condiciones</a>
                <a href="/terminos/pprivacidad.html">Políticas de Privacidad</a>
                <a href="/desarrolladores/inidesarrolladores.php">Desarrolladores</a>
            </nav>
        </div>
    </footer>
    <div id="notificacion" style="display:none; position:fixed; bottom:10px; right:10px; background-color:green; color:white; padding:10px; border-radius:5px;"></div>
</body>

<script>
    const stripe = Stripe('pk_test_51QGh9HJU8LuuJkEez2B86ql15aB7RLzOcFaoVoxLE648MYjXAf68rNZYDM5iqPpcoknD0rniPRGHSqQsHIn1Og8p00qgIbWoyP'); // Reemplaza con tu clave pública

    document.getElementById("checkout-button").addEventListener("click", async (e) => {
        e.preventDefault();
        try {
            const response = await fetch("procesarsusc.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
            });

            if (!response.ok) {
                const errorMessage = await response.text();
                throw new Error(`Error en la solicitud: ${errorMessage}`);
            }

            const { sessionId } = await response.json();

            if (!sessionId) {
                throw new Error("sessionId no encontrado en la respuesta");
            }

            const result = await stripe.redirectToCheckout({ sessionId: sessionId });
            if (result.error) {
                console.error(result.error.message);
                document.getElementById('notificacion').innerText = result.error.message;
                document.getElementById('notificacion').style.display = 'block';
            }
        } catch (error) {
            console.error("Error en el proceso de suscripción:", error);
            document.getElementById('notificacion').innerText = error.message;
            document.getElementById('notificacion').style.display = 'block';
        }
    });
</script>

</html>
