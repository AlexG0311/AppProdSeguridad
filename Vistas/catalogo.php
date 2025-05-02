<?php
session_start();

// Simulación de datos de productos (puedes reemplazar con base de datos)
$products = [
    [
        'id' => 1,
        'nombre' => 'Casco de Seguridad',
        'categoria' => 'casco',
        'marca' => 'marca1',
        'precio' => 45,
        'imagen' => 'https://via.placeholder.com/200x200?text=Casco',
    ],
    [
        'id' => 2,
        'nombre' => 'Guantes Industriales',
        'categoria' => 'guantes',
        'marca' => 'marca2',
        'precio' => 30,
        'imagen' => 'https://via.placeholder.com/200x200?text=Guantes',
    ],
    [
        'id' => 3,
        'nombre' => 'Gafas de Protección',
        'categoria' => 'gafas',
        'marca' => 'marca1',
        'precio' => 25,
        'imagen' => 'https://via.placeholder.com/200x200?text=Gafas',
    ],
    [
        'id' => 4,
        'nombre' => 'Arnés de Seguridad',
        'categoria' => 'arnes',
        'marca' => 'marca3',
        'precio' => 80,
        'imagen' => 'https://via.placeholder.com/200x200?text=Arnés',
    ],
];

// Obtener los valores de los filtros desde GET
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';
$brand_filter = isset($_GET['brand']) ? $_GET['brand'] : '';
$price_filter = isset($_GET['price']) ? $_GET['price'] : '';

// Filtrar los productos
$filtered_products = array_filter($products, function($product) use ($category_filter, $brand_filter, $price_filter) {
    $category_match = empty($category_filter) || $product['categoria'] === $category_filter;
    $brand_match = empty($brand_filter) || $product['marca'] === $brand_filter;
    $price_match = true;

    if (!empty($price_filter)) {
        if ($price_filter === '0-50') {
            $price_match = $product['precio'] >= 0 && $product['precio'] <= 50;
        } elseif ($price_filter === '50-100') {
            $price_match = $product['precio'] > 50 && $product['precio'] <= 100;
        } elseif ($price_filter === '100+') {
            $price_match = $product['precio'] > 100;
        }
    }

    return $category_match && $brand_match && $price_match;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/App.css">
    <title>Catálogo - Productos de Seguridad</title>
</head>
<body>
    <div id="contenedor">
        <header>
            <div class="logo">Productos de Seguridad</div>
            <nav>
                <div class="nav-01">
                    <a href="inicio.php">Inicio</a>
                    <a href="catalogo.php">Productos</a>
                    <a href="cursos.php">Cursos</a>
                    <a href="carrito.php">Carrito</a>
                    <a href="index.php">Registrarse</a>
                    <a href="login.php">Login</a>
                </div>
            </nav>
        </header>
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
                                    <img src="<?php echo htmlspecialchars($product['imagen']); ?>" alt="<?php echo htmlspecialchars($product['nombre']); ?>">
                                    <h3><?php echo htmlspecialchars($product['nombre']); ?></h3>
                                    <p><?php echo htmlspecialchars($product['marca']); ?> - $<?php echo htmlspecialchars($product['precio']); ?></p>
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