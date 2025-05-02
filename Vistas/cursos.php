<?php
session_start();

// Simulación de datos de cursos (puedes reemplazar con una base de datos)
$cursos = [
    1 => [
        'nombre' => 'Trabajo en Alturas',
        'duracion' => '16 horas',
        'nivel' => 'Intermedio',
        'costo' => 120,
        'descripcion' => 'Aprende las mejores prácticas para trabajos en altura de forma segura.',
    ],
    2 => [
        'nombre' => 'Primeros Auxilios',
        'duracion' => '8 horas',
        'nivel' => 'Básico',
        'costo' => 80,
        'descripcion' => 'Prepárate para responder ante emergencias médicas en el trabajo.',
    ],
    3 => [
        'nombre' => 'Manejo de Sustancias Peligrosas',
        'duracion' => '12 horas',
        'nivel' => 'Avanzado',
        'costo' => 150,
        'descripcion' => 'Capacitación para el manejo seguro de sustancias químicas peligrosas.',
    ],
    4 => [
        'nombre' => 'Uso de EPP',
        'duracion' => '4 horas',
        'nivel' => 'Básico',
        'costo' => 50,
        'descripcion' => 'Entrenamiento en el uso correcto de Equipos de Protección Personal.',
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/App.css">
    <title>Cursos de Seguridad - Productos de Seguridad</title>
</head>
<body>
    <div id="contenedor">
        <header>
            <div class="logo">Productos de Seguridad</div>
            <nav>
                <div class="nav-01">
                    <a href="index.php">Inicio</a>
                    <a href="index.php#catalog">Productos</a>
                    <a href="mis_cursos.php">Mis Cursos</a>
                    <a href="carrito.php">Carrito</a>
                    <a href="#">Contacto</a>
                </div>
            </nav>
        </header>
        <section class="training-programs">
            <div class="section-content">
                <h1>Programas de Capacitación</h1>
                <p>Explora nuestros cursos y certificaciones diseñados para mejorar la seguridad en tu entorno laboral.</p>
                <div class="training-grid">
                    <?php foreach ($cursos as $id => $curso): ?>
                        <div class="training-item">
                            <h3><?php echo htmlspecialchars($curso['nombre']); ?></h3>
                            <p class="description"><?php echo htmlspecialchars($curso['descripcion']); ?></p>
                            <ul class="course-details">
                                <li><strong>Duración:</strong> <?php echo htmlspecialchars($curso['duracion']); ?></li>
                                <li><strong>Nivel:</strong> <?php echo htmlspecialchars($curso['nivel']); ?></li>
                                <li><strong>Costo:</strong> $<?php echo number_format($curso['costo'], 2); ?></li>
                            </ul>
                            <div class="training-actions">
                                <a href="carrito.php?action=add&tipo=curso&id=<?php echo $id; ?>" class="btn-secondary">Inscribirse</a>
                                <a href="#" class="btn-info">Más Información</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
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