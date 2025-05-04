<?php
session_start();

// Incluir la conexión a la base de datos
require_once 'conexion.php';

// Obtener el ID del producto desde la URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Consultar el producto desde la base de datos
$query = "SELECT * FROM products WHERE id = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$producto = mysqli_fetch_assoc($result);

// Verificar si el producto existe
if (!$producto) {
    echo "<h1>Producto no encontrado</h1>";
    exit;
}

// Cerrar el statement y la conexión
mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/App.css">
    <link rel="stylesheet" href="../style.css">
    <title><?php echo htmlspecialchars($producto['name']); ?> - Productos de Seguridad</title>
    <style>
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            max-width: 400px;
            width: 80%;
        }
        .modal-content h2 {
            margin-top: 0;
        }
        .modal-content p {
            margin: 15px 0;
        }
        .modal-content a {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            border-radius: 3px;
        }
        .modal-content a:hover {
            background-color: #0056b3;
        }
        .modal-content .close-btn {
            background-color: #6c757d;
        }
        .modal-content .close-btn:hover {
            background-color: #5a6268;
        }
    </style>
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
        <section class="product-detail">
            <div class="section-content">
                <h1><?php echo htmlspecialchars($producto['name']); ?></h1>
                <div class="product-detail-container">
                    <div class="product-images">
                        <img src="<?php echo htmlspecialchars($producto['image']); ?>" alt="<?php echo htmlspecialchars($producto['name']); ?>">
                    </div>
                    <div class="product-info">
                        <p class="category"><?php echo htmlspecialchars($producto['category']); ?> - <?php echo htmlspecialchars($producto['brand']); ?></p>
                        <p class="price">$<?php echo number_format($producto['price'], 2); ?></p>
                        <a href="#" class="btn-add-to-cart" onclick="handleAddToCart(<?php echo $id; ?>, '<?php echo isset($_SESSION['isAuthenticated']) && $_SESSION['isAuthenticated'] ? 'true' : 'false'; ?>'); return false;">Agregar al Carrito</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal para usuarios no autenticados -->
        <div id="loginModal" class="modal">
            <div class="modal-content">
                <h2>Iniciar Sesión Requerido</h2>
                <p>Debes iniciar sesión o registrarte para agregar productos al carrito.</p>
                <a href="login.php">Iniciar Sesión</a>
                <a href="register.php">Registrarse</a>
                <a href="#" class="close-btn" onclick="closeModal(); return false;">Cerrar</a>
            </div>
        </div>

        <footer>
            <div class="footer-content">
                <h3>Productos de Seguridad</h3>
                <p>© 2025 Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>

    <script>
        // Función para manejar el clic en "Agregar al Carrito"
        function handleAddToCart(productId, isAuthenticated) {
            if (isAuthenticated === 'true') {
                // Si el usuario está autenticado, redirigir a carrito.php
                window.location.href = 'carrito.php?action=add&tipo=producto&id=' + productId;
            } else {
                // Si no está autenticado, mostrar el modal
                document.getElementById('loginModal').style.display = 'flex';
            }
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('loginModal').style.display = 'none';
        }

        // Cerrar el modal si se hace clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('loginModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    </script>
</body>
</html>