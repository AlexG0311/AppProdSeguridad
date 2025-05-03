<?php
session_start();

// Simulación de datos de productos (puedes reemplazar con una base de datos)
$productos = [
    1 => [
        'nombre' => 'Casco de Seguridad',
        'descripcion' => 'Casco de alta resistencia con certificación ANSI para trabajos en altura. Incluye ajuste ergonómico y ventilación.',
        'precio' => 45,
        'marca' => 'Marca 1',
        'categoria' => 'Casco',
        'imagenes' => [
            'https://via.placeholder.com/400x400?text=Casco+Frente',
            'https://via.placeholder.com/400x400?text=Casco+Lado',
        ],
    ],
    2 => [
        'nombre' => 'Guantes Industriales',
        'descripcion' => 'Guantes resistentes a cortes y productos químicos, ideales para trabajos pesados. Material transpirable.',
        'precio' => 30,
        'marca' => 'Marca 2',
        'categoria' => 'Guantes',
        'imagenes' => [
            'https://via.placeholder.com/400x400?text=Guantes+Frente',
            'https://via.placeholder.com/400x400?text=Guantes+Dorso',
        ],
    ],
    3 => [
        'nombre' => 'Gafas de Protección',
        'descripcion' => 'Gafas con lentes anti-rayaduras y protección UV. Diseño cómodo para uso prolongado.',
        'precio' => 25,
        'marca' => 'Marca 1',
        'categoria' => 'Gafas',
        'imagenes' => [
            'https://via.placeholder.com/400x400?text=Gafas+Frente',
            'https://via.placeholder.com/400x400?text=Gafas+Lado',
        ],
    ],
    4 => [
        'nombre' => 'Arnés de Seguridad',
        'descripcion' => 'Arnés de cuerpo completo con puntos de anclaje múltiples. Certificado para trabajos en altura.',
        'precio' => 80,
        'marca' => 'Marca 3',
        'categoria' => 'Arnés',
        'imagenes' => [
            'https://via.placeholder.com/400x400?text=Arnés+Frente',
            'https://via.placeholder.com/400x400?text=Arnés+Espalda',
        ],
    ],
];

// Obtener el ID del producto desde la URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$producto = isset($productos[$id]) ? $productos[$id] : null;

if (!$producto) {
    echo "<h1>Producto no encontrado</h1>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/App.css">
    <title><?php echo htmlspecialchars($producto['nombre']); ?> - Productos de Seguridad</title>
</head>
<body>
    <div id="contenedor">
        <header>
            <div class="logo">Productos de Seguridad</div>
            <nav>
                <div class="nav-01">
                    <a href="../index.php">Inicio</a>
                    <a href="catalogo.php#catalogo">Productos</a>
                    <a href="cursos.php">Cursos</a>
                    <a href="carrito.php">Carrito</a>
                    <a href="#">Contacto</a>
                </div>
            </nav>
        </header>
        <section class="product-detail">
            <div class="section-content">
                <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
                <div class="product-detail-container">
                    <div class="product-images">
                        <?php foreach ($producto['imagenes'] as $imagen): ?>
                            <img src="<?php echo htmlspecialchars($imagen); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <?php endforeach; ?>
                    </div>
                    <div class="product-info">
                        <p class="category"><?php echo htmlspecialchars($producto['categoria']); ?> - <?php echo htmlspecialchars($producto['marca']); ?></p>
                        <p class="description"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <p class="price">$<?php echo number_format($producto['precio'], 2); ?></p>
                        <a href="carrito.php?action=add&tipo=producto&id=<?php echo $id; ?>" class="btn-add-to-cart">Agregar al Carrito</a>
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