<?php
session_start();

// Simulación de datos de productos y cursos (puedes reemplazar con una base de datos)
$productos = [
    1 => ['nombre' => 'Casco de Seguridad', 'precio' => 45, 'tipo' => 'producto'],
    2 => ['nombre' => 'Guantes Industriales', 'precio' => 30, 'tipo' => 'producto'],
    3 => ['nombre' => 'Gafas de Protección', 'precio' => 25, 'tipo' => 'producto'],
    4 => ['nombre' => 'Arnés de Seguridad', 'precio' => 80, 'tipo' => 'producto'],
];

$cursos = [
    1 => ['nombre' => 'Trabajo en Alturas', 'precio' => 120, 'tipo' => 'curso'],
    2 => ['nombre' => 'Primeros Auxilios', 'precio' => 80, 'tipo' => 'curso'],
    3 => ['nombre' => 'Manejo de Sustancias Peligrosas', 'precio' => 150, 'tipo' => 'curso'],
    4 => ['nombre' => 'Uso de EPP', 'precio' => 50, 'tipo' => 'curso'],
];

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar al carrito desde producto.php o cursos.php
if (isset($_GET['action']) && $_GET['action'] === 'add') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

    if ($tipo === 'producto' && isset($productos[$id])) {
        $_SESSION['carrito'][] = ['id' => $id, 'tipo' => 'producto', 'nombre' => $productos[$id]['nombre'], 'precio' => $productos[$id]['precio']];
    } elseif ($tipo === 'curso' && isset($cursos[$id])) {
        $_SESSION['carrito'][] = ['id' => $id, 'tipo' => 'curso', 'nombre' => $cursos[$id]['nombre'], 'precio' => $cursos[$id]['precio']];
    }

    header("Location: carrito.php");
    exit;
}

// Eliminar del carrito
if (isset($_GET['action']) && $_GET['action'] === 'remove') {
    $index = isset($_GET['index']) ? (int)$_GET['index'] : -1;
    if (isset($_SESSION['carrito'][$index])) {
        unset($_SESSION['carrito'][$index]);
        $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el array
    }
    header("Location: carrito.php");
    exit;
}

// Procesar la compra
$compra_confirmada = false;
$email_notificacion = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_compra'])) {
    $metodo_pago = isset($_POST['metodo_pago']) ? $_POST['metodo_pago'] : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';

    if ($metodo_pago && $email && !empty($_SESSION['carrito'])) {
        $compra_confirmada = true;

        // Simulación de envío de email (en un entorno real, usarías mail() o una librería como PHPMailer)
        $total = array_sum(array_column($_SESSION['carrito'], 'precio'));
        $detalle_compra = "Resumen de tu compra:\n\n";
        foreach ($_SESSION['carrito'] as $item) {
            $detalle_compra .= "- {$item['nombre']} ({$item['tipo']}): \${$item['precio']}\n";
        }
        $detalle_compra .= "\nTotal: \${$total}\nMétodo de Pago: {$metodo_pago}\n\nGracias por tu compra!";

        // Simulación: Guardamos el mensaje que se enviaría por email
        $email_notificacion = "Notificación enviada a {$email}:\n\n{$detalle_compra}";

        // Limpiar el carrito después de la compra
        $_SESSION['carrito'] = [];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/App.css">
    <title>Carrito - Productos de Seguridad</title>
</head>
<body>
    <div id="contenedor">
        <header>
            <div class="logo">Productos de Seguridad</div>
            <nav>
                <div class="nav-01">
                    <a href="index.php">Inicio</a>
                    <a href="index.php#catalog">Productos</a>
                    <a href="cursos.php">Cursos</a>
                    <a href="#">Contacto</a>
                </div>
            </nav>
        </header>
        <section class="cart">
            <div class="section-content">
                <h1>Carrito de Compras</h1>
                <?php if (!$compra_confirmada): ?>
                    <?php if (empty($_SESSION['carrito'])): ?>
                        <p>Tu carrito está vacío. <a href="index.php#catalog" class="btn-secondary">Explora nuestros productos</a></p>
                    <?php else: ?>
                        <div class="cart-items">
                            <?php
                            $total = 0;
                            foreach ($_SESSION['carrito'] as $index => $item):
                                $total += $item['precio'];
                            ?>
                                <div class="cart-item">
                                    <h3><?php echo htmlspecialchars($item['nombre']); ?> (<?php echo htmlspecialchars($item['tipo']); ?>)</h3>
                                    <p>Precio: $<?php echo number_format($item['precio'], 2); ?></p>
                                    <a href="carrito.php?action=remove&index=<?php echo $index; ?>" class="btn-remove">Eliminar</a>
                                </div>
                            <?php endforeach; ?>
                            <div class="cart-total">
                                <h3>Total: $<?php echo number_format($total, 2); ?></h3>
                            </div>
                        </div>
                        <div class="checkout">
                            <h2>Finalizar Compra</h2>
                            <form method="POST" action="carrito.php">
                                <div class="form-group">
                                    <label for="email">Correo Electrónico:</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="metodo_pago">Método de Pago:</label>
                                    <select id="metodo_pago" name="metodo_pago" required>
                                        <option value="">Selecciona un método</option>
                                        <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                                        <option value="transferencia">Transferencia Bancaria</option>
                                        <!-- Espacio para futuras formas de pago -->
                                        <option value="otro">Otro (especificar en comentarios)</option>
                                    </select>
                                </div>
                                <button type="submit" name="confirmar_compra" class="btn-add-to-cart">Confirmar Compra</button>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="confirmation">
                        <h2>¡Compra Confirmada!</h2>
                        <p>Gracias por tu compra. Hemos enviado una confirmación a tu correo electrónico.</p>
                        <pre><?php echo htmlspecialchars($email_notificacion); ?></pre>
                        <a href="index.php" class="btn-secondary">Volver al Inicio</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <footer>
            <div class="footer-content">
                <h3>Productos de Seguridad</h3>
                <p>© 2025 Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
</body>
</html>