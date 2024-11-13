<?php
include '../conexion.php';

// Consulta para obtener los productos desde la tabla 'merchandising'
$sql = "SELECT id, nombrep, descripcion, precio, stock, categoria, rutaimg FROM merchandising";
$resultado = $cnx->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchandising - Psychopedia</title>
    <link rel="stylesheet" href="estilosmerch.css">
</head>
<body>
    <header>
        <div class="titulo">
            <a href="../home/home.php">
                <img src="../recursos/titulo.png" alt="Título" class="logo">
            </a>
        </div>
        <nav class="secciones">
            <a href="../home/home.php">Inicio</a>
            <a href="../historia/historiapsychopedia.php">Nuestra Historia</a>
            <a href="../plus/plus.php">Psychopedia Plus+</a>
        </nav>
    </header>
    <br>
    <main>
        <div class="banner">
            Stock Limitado!
        </div>
        <div class="productos-grid">
            <?php
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo '<div class="producto-item">';
                    echo '<img src="' . $fila["rutaimg"] . '" alt="' . $fila["nombrep"] . '">';
                    echo '<h3>' . $fila["nombrep"] . '</h3>';
                    echo '<p>Categoria: ' . $fila["categoria"] . '</p>';
                    echo '<p>Stock: ' . $fila["stock"] . '</p>';
                    echo '<p>Precio: $' . $fila["precio"] . '</p>';

                    echo '<label for="talla">Talla:</label><br>';
                    echo '<select name="talla" class="select-talla">';
                    echo '<option value="S">S</option>';
                    echo '<option value="M">M</option>';
                    echo '<option value="L">L</option>';
                    echo '<option value="XL">XL</option>';
                    echo '</select><br>';
                    echo '<label for="cantidad">Cantidad:</label><br>';
                    echo '<input type="number" name="cantidad" class="input-cantidad" min="1" max="' . $fila["stock"] . '" value="1"><br>';
                    echo '<button class="add-to-cart" data-id="' . $fila["id"] . '" data-nombre="' . $fila["nombrep"] . '" data-precio="' . $fila["precio"] . '" data-stock="' . $fila["stock"] . '">Añadir al carrito </button>';
                    echo '</div>';
                }
            } else {
                echo '<p class="no-products">No hay productos disponibles.</p>';
            }
            ?>
        </div>
    </main>


    <footer>
        <button class="carrito-btn">Ver carrito</button>
        <div class="carrito-container" id="carrito" style="display: none;">
            <h2><b>CARRITO DE COMPRAS</b></h2>

            <div class="containerinfo">
                <button class="info-button">
                    i
                    <span class="tooltip">Tener en cuenta antes de realizar la compra, <br>que los envíos de nuestro Merchandising<br> solo se encuentran en funcionamiento <br>dentro de la provincia de Córdoba, Argentina.</span>
                </button>
            </div>



            <hr class="barra-separadora">
            <div id="productos-carrito"></div>
            <button id="checkout-btn" class="add-to-cart">Realizar Pedido</button>
        </div>
        <div class="footer-content">
            <p>© 2024 Psychopedia. Todos los derechos reservados.</p>
            <nav class="footer-nav">
                <a href="../terminos/tycondiciones.html">Términos y Condiciones</a>
                <a href="../terminos/pprivacidad.html">Políticas de Privacidad</a>
                <a href="../desarrolladores/inidesarrolladores.php">Desarrolladores</a>
            </nav>
        </div>
    </footer>

    <div id="notificacion" style="display:none; position:fixed; bottom:10px; right:10px; background-color:green; color:white; padding:10px; border-radius:5px;"></div>

<script type="text/javascript">
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    // Mostrar/ocultar el carrito y actualizar su vista
    document.querySelector('.carrito-btn').addEventListener('click', function() {
        const carritoEl = document.getElementById('carrito');
        carritoEl.style.display = carritoEl.style.display === 'none' ? 'block' : 'none';
        actualizarCarritoVista();
    });

    // Función para mostrar una notificación
    function mostrarNotificacion(mensaje) {
        const notificacion = document.getElementById('notificacion');
        notificacion.textContent = mensaje;
        notificacion.style.display = 'block';
        setTimeout(() => {
            notificacion.style.display = 'none';
        }, 3000);
    }

    // Función para actualizar la vista del carrito
    function actualizarCarritoVista() {
        const productosContainer = document.getElementById('productos-carrito');
        productosContainer.innerHTML = '';

        if (carrito.length === 0) {
            productosContainer.innerHTML = '<p>No hay productos en el carrito.</p>';
        } else {
            carrito.forEach((producto, index) => {
                productosContainer.innerHTML += `
                    <p>
                        ${producto.nombre} - Talla: ${producto.talla} - Cantidad: ${producto.cantidad} - $${producto.total}
                       | <button class="remove-from-cart" data-index="${index}">X</button>
                    </p>`;
            });

            document.querySelectorAll('.remove-from-cart').forEach(button => {
                button.addEventListener('click', function() {
                    eliminarProductoDelCarrito(this.dataset.index);
                });
            });
        }
    }


    // Función para eliminar un producto del carrito
    function eliminarProductoDelCarrito(index) {
        carrito.splice(index, 1);
        localStorage.setItem('carrito', JSON.stringify(carrito));
        mostrarNotificacion('Producto eliminado del carrito');
        actualizarCarritoVista();
    }

    // Función para procesar el pedido
    document.getElementById('checkout-btn').addEventListener('click', function() {
        if (carrito.length === 0) {
            mostrarNotificacion('El carrito está vacío');
            return;
        }

        fetch('procesar_pedido.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(carrito)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarNotificacion('Pedido realizado con éxito');
                carrito = [];
                localStorage.removeItem('carrito');
                actualizarCarritoVista();
            } else {
                mostrarNotificacion('Error al realizar el pedido');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('Hubo un problema al procesar el pedido');
        });
    });

    // Agregar productos al carrito
    // Función para añadir producto al carrito
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const precio = parseFloat(this.dataset.precio);
            const stock = parseInt(this.dataset.stock);

            const talla = this.closest('.producto-item').querySelector('.select-talla').value;
            const cantidad = parseInt(this.closest('.producto-item').querySelector('.input-cantidad').value);

            // Validación de stock
            if (cantidad > stock) {
                mostrarNotificacion('La cantidad seleccionada excede el stock disponible.');
                return;
            }

            const total = precio * cantidad;
            const producto = { id, nombre, talla, cantidad, precio, total };

            carrito.push(producto);
            localStorage.setItem('carrito', JSON.stringify(carrito));
            mostrarNotificacion('Producto añadido al carrito');
            actualizarCarritoVista();
        });
    });
    actualizarCarritoVista();
</script>

</body>
</html>

<?php
$cnx->close();
?>
