<?php
session_start();

// Incluir la conexión a la base de datos
require_once 'conexion.php';

// Obtener los valores de los filtros desde GET
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$brand_filter = isset($_GET['brand']) ? $_GET['brand'] : '';
$price_filter = isset($_GET['price']) ? $_GET['price'] : '';

// Consultar todos los productos desde la base de datos
$query = "SELECT * FROM products";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Filtrar los productos
$filtered_products = array_filter($products, function($product)
     use ($category_filter, $brand_filter, $price_filter) {
    $category_match = empty($category_filter) || strtolower($product['category']) === strtolower($category_filter);
    $brand_match = empty($brand_filter) || strtolower($product['brand']) === strtolower($brand_filter);
    $price_match = true;

    if (!empty($price_filter)) {
        if ($price_filter === '0-50') {
            $price_match = $product['price'] >= 0 && $product['price'] <= 50;
        } elseif ($price_filter === '50-100') {
            $price_match = $product['price'] > 50 && $product['price'] <= 100;
        } elseif ($price_filter === '100+') {
            $price_match = $product['price'] > 100;
        }
    }

    return $category_match && $brand_match && $price_match;
});

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
    <title>Catálogo - Productos de Seguridad</title>
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
        <section class="catalog">
            <div class="section-content">
                <h1>Catálogo de Equipos de Seguridad</h1>
                <div class="catalog-container">
                    <!-- Filtros -->
                    <aside class="filters">
                        <h3>Filtros</h3>
                        <form method="GET" action="catalogo.php">
                            <div class="filter-group">
                                <label for="category">Categoría:</label>
                                <select id="category" name="category" onchange="this.form.submit()">
                                    <option value="">Todas</option>
                                    <option value="casco" <?php echo $category_filter === 'casco' ? 'selected' : ''; ?>>Casco</option>
                                    <option value="guantes" <?php echo $category_filter === 'guantes' ? 'selected' : ''; ?>>Guantes</option>
                                    <option value="gafas" <?php echo $category_filter === 'gafas' ? 'selected' : ''; ?>>Gafas</option>
                                    <option value="arnes" <?php echo $category_filter === 'arnes' ? 'selected' : ''; ?>>Arnés</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="brand">Marca:</label>
                                <select id="brand" name="brand" onchange="this.form.submit()">
                                    <option value="">Todas</option>
                                    <option value="marca1" <?php echo $brand_filter === 'marca1' ? 'selected' : ''; ?>>Marca 1</option>
                                    <option value="marca2" <?php echo $brand_filter === 'marca2' ? 'selected' : ''; ?>>Marca 2</option>
                                    <option value="marca3" <?php echo $brand_filter === 'marca3' ? 'selected' : ''; ?>>Marca 3</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="price">Precio:</label>
                                <select id="price" name="price" onchange="this.form.submit()">
                                    <option value="">Cualquiera</option>
                                    <option value="0-50" <?php echo $price_filter === '0-50' ? 'selected' : ''; ?>>$0 - $50</option>
                                    <option value="50-100" <?php echo $price_filter === '50-100' ? 'selected' : ''; ?>>$50 - $100</option>
                                    <option value="100+" <?php echo $price_filter === '100+' ? 'selected' : ''; ?>>$100+</option>
                                </select>
                            </div>
                        </form>
                    </aside>
                    <!-- Catálogo -->
                    <div class="catalog-grid">
                        <?php if (empty($filtered_products)): ?>
                            <p>No se encontraron productos con los filtros seleccionados.</p>
                        <?php else: ?>
                            <?php foreach ($filtered_products as $product): ?>
                                <div class="catalog-item">
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <p><?php echo htmlspecialchars($product['brand']); ?> - $<?php echo htmlspecialchars($product['price']); ?></p>
                                    <a href="producto.php?id=<?php echo $product['id']; ?>" class="btn-secondary">Ver Detalles</a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
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