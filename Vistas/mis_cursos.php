<?php
session_start();

// Simulación de datos (puedes reemplazar con base de datos)
$courses = [
    1 => ['nombre' => 'Trabajo en Alturas', 'descripcion' => 'Aprende a trabajar en altura de forma segura.'],
    2 => ['nombre' => 'Primeros Auxilios', 'descripcion' => 'Prepárate para emergencias médicas.'],
    3 => ['nombre' => 'Manejo de Sustancias Peligrosas', 'descripcion' => 'Capacitación en manejo de químicos.'],
    4 => ['nombre' => 'Uso de EPP', 'descripcion' => 'Entrenamiento en equipos de protección personal.'],
];

// Simulación de compras y progreso (puedes reemplazar con base de datos)
$purchases = [
    1 => ['user_id' => 1, 'course_id' => 1, 'fecha' => '2025-04-01'],
    2 => ['user_id' => 1, 'course_id' => 2, 'fecha' => '2025-04-02'],
    3 => ['user_id' => 2, 'course_id' => 3, 'fecha' => '2025-04-03'],
];

$progress = [
    1 => ['user_id' => 1, 'course_id' => 1, 'progreso' => 50],
    2 => ['user_id' => 1, 'course_id' => 2, 'progreso' => 100],
    3 => ['user_id' => 2, 'course_id' => 3, 'progreso' => 30],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/mis_cursos.css">
    <link rel="stylesheet" href="../style.css">
    <title>Mis Cursos - Productos de Seguridad</title>
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
            <a href="mis_cursos.php">Mis Cursos</a>
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
        <section class="my-courses">
            <div class="section-content">
                <h1>Mis Cursos</h1>
                <p>Estamos desarrollando esta parte, disfruta de nuestros productos :D.</p>
                <div id="courses-content"></div>
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