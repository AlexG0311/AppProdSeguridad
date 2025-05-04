<?php
session_start();


// Incluir la conexión
require_once 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['isAuthenticated']) || !$_SESSION['isAuthenticated'] || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];

// Función para cargar los ítems del carrito desde la base de datos
function loadCartItems($conexion, $user_id) {
    $items = [];
    
    // Obtener ítems del carrito desde la tabla cart
    $query = "SELECT * FROM cart WHERE user_id = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    while ($cart_item = mysqli_fetch_assoc($result)) {
        $item_type = $cart_item['item_type'];
        $item_id = $cart_item['item_id'];
        
        // Consultar los detalles del ítem (producto o curso)
        if ($item_type === 'product') {
            $query_item = "SELECT name, price FROM products WHERE id = ?";
            $stmt_item = mysqli_prepare($conexion, $query_item);
            mysqli_stmt_bind_param($stmt_item, "i", $item_id);
            mysqli_stmt_execute($stmt_item);
            $result_item = mysqli_stmt_get_result($stmt_item);
            $item = mysqli_fetch_assoc($result_item);
            mysqli_stmt_close($stmt_item);

            if ($item) {
                $items[] = [
                    'id' => $cart_item['id'], // ID del registro en la tabla cart
                    'tipo' => 'product',
                    'item_id' => $item_id,
                    'nombre' => $item['name'],
                    'precio' => $item['price']
                ];
            }
        } elseif ($item_type === 'course') {
            $query_item = "SELECT name, cost FROM courses WHERE id = ?";
            $stmt_item = mysqli_prepare($conexion, $query_item);
            mysqli_stmt_bind_param($stmt_item, "i", $item_id);
            mysqli_stmt_execute($stmt_item);
            $result_item = mysqli_stmt_get_result($stmt_item);
            $item = mysqli_fetch_assoc($result_item);
            mysqli_stmt_close($stmt_item);

            if ($item) {
                $items[] = [
                    'id' => $cart_item['id'], // ID del registro en la tabla cart
                    'tipo' => 'course',
                    'item_id' => $item_id,
                    'nombre' => $item['name'],
                    'precio' => $item['cost']
                ];
            }
        }
    }
    
    mysqli_stmt_close($stmt);
    return $items;
}

// Agregar al carrito desde producto.php o cursos.php
if (isset($_GET['action']) && $_GET['action'] === 'add') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';

    // Mapear el tipo recibido (producto/curso) al tipo esperado por la base de datos (product/course)
    $item_type = ($tipo === 'producto') ? 'product' : (($tipo === 'curso') ? 'course' : '');

    if ($item_type === 'product') {
        // Verificar si el producto existe
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $producto = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($producto) {
            // Agregar el ítem a la tabla cart
            $query_insert = "INSERT INTO cart (user_id, item_type, item_id) VALUES (?, 'product', ?)";
            $stmt_insert = mysqli_prepare($conexion, $query_insert);
            mysqli_stmt_bind_param($stmt_insert, "ii", $user_id, $id);
            mysqli_stmt_execute($stmt_insert);
            mysqli_stmt_close($stmt_insert);
        }
    } elseif ($item_type === 'course') {
        // Verificar si el curso existe
        $query = "SELECT * FROM courses WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $curso = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($curso) {
            // Agregar el ítem a la tabla cart
            $query_insert = "INSERT INTO cart (user_id, item_type, item_id) VALUES (?, 'course', ?)";
            $stmt_insert = mysqli_prepare($conexion, $query_insert);
            mysqli_stmt_bind_param($stmt_insert, "ii", $user_id, $id);
            mysqli_stmt_execute($stmt_insert);
            mysqli_stmt_close($stmt_insert);
        }
    }

    // Redirigir al carrito después de agregar
    header("Location: carrito.php");
    exit;
}

// Eliminar del carrito
if (isset($_GET['action']) && $_GET['action'] === 'remove') {
    $cart_id = isset($_GET['cart_id']) ? (int)$_GET['cart_id'] : 0;

    if ($cart_id > 0) {
        // Eliminar el ítem de la tabla cart
        $query_delete = "DELETE FROM cart WHERE id = ? AND user_id = ?";
        $stmt_delete = mysqli_prepare($conexion, $query_delete);
        mysqli_stmt_bind_param($stmt_delete, "ii", $cart_id, $user_id);
        mysqli_stmt_execute($stmt_delete);
        mysqli_stmt_close($stmt_delete);
    }

    header("Location: carrito.php");
    exit;
}

// Cargar los ítems del carrito
$carrito = loadCartItems($conexion, $user_id);

// Procesar la compra
$compra_confirmada = false;
$email_notificacion = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_compra'])) {
    $metodo_pago = isset($_POST['metodo_pago']) ? $_POST['metodo_pago'] : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';

    if ($metodo_pago && $email && !empty($carrito)) {
        $compra_confirmada = true;

        // Simulación de envío de email (en un entorno real, usarías mail() o una librería como PHPMailer)
        $total = array_sum(array_column($carrito, 'precio'));
        $detalle_compra = "Resumen de tu compra:\n\n";
        foreach ($carrito as $item) {
            $detalle_compra .= "- {$item['nombre']} ({$item['tipo']}): \${$item['precio']}\n";
        }
        $detalle_compra .= "\nTotal: \${$total}\nMétodo de Pago: {$metodo_pago}\n\nGracias por tu compra!";

        // Simulación: Guardamos el mensaje que se enviaría por email
        $email_notificacion = "Notificación enviada a {$email}:\n\n{$detalle_compra}";

        // Limpiar el carrito del usuario en la base de datos
        $query_clear = "DELETE FROM cart WHERE user_id = ?";
        $stmt_clear = mysqli_prepare($conexion, $query_clear);
        mysqli_stmt_bind_param($stmt_clear, "i", $user_id);
        mysqli_stmt_execute($stmt_clear);
        mysqli_stmt_close($stmt_clear);
    }
}

// Cerrar la conexión
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/App.css">
    <link rel="stylesheet" href="../style.css">
    <title>Carrito - Productos de Seguridad</title>
</head>
<body>
    <div id="contenedor">
        <nav>
            <div class="nav-01">
                <input type="checkbox" id="sidebar-active">
                <label for="sidebar-active" class="open-sidebar-button">
                    <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
                </label>
                <label id="overlay" for="sidebar-active"></label>
                <div class="links-container">
                    <label for="sidebar-active" class="close-sidebar-button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg>
                    </label>
                    <a href="../index.php">Inicio</a>
                    <a href="catalogo.php">Productos</a>
                    <a href="cursos.php">Cursos</a>
                    <a href="carrito.php">Carrito</a>
                    <?php if (!isset($_SESSION['isAuthenticated']) || !$_SESSION['isAuthenticated']): ?>
                        <a href="register.php">Registrarse</a>
                        <a href="login.php">Login</a>
                    <?php else: ?>
                        <a href="logout.php">Cerrar Sesión</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
        <section class="cart">
            <div class="section-content">
                <h1>Carrito de Compras</h1>
                <?php if (!$compra_confirmada): ?>
                    <?php if (empty($carrito)): ?>
                        <p>Tu carrito está vacío. <a href="catalogo.php#catalogo" class="btn-secondary">Explora nuestros productos</a></p>
                    <?php else: ?>
                        <div class="cart-items">
                            <?php
                            $total = 0;
                            foreach ($carrito as $index => $item):
                                $total += $item['precio'];
                            ?>
                                <div class="cart-item">
                                    <h3><?php echo htmlspecialchars($item['nombre']); ?> (<?php echo htmlspecialchars($item['tipo']); ?>)</h3>
                                    <p>Precio: $<?php echo number_format($item['precio'], 2); ?></p>
                                    <a href="carrito.php?action=remove&cart_id=<?php echo $item['id']; ?>" class="btn-remove">Eliminar</a>
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
                        <a href="../index.php" class="btn-secondary">Volver al Inicio</a>
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