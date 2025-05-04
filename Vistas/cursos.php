<?php
session_start();

// Incluir la conexión a la base de datos
require_once 'conexion.php';

// Consultar todos los cursos desde la base de datos
$query = "SELECT * FROM courses";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$cursos = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
    <title>Cursos de Seguridad - Productos de Seguridad</title>
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
        <section class="training-programs">
            <div class="section-content">
                <h1>Programas de Capacitación</h1>
                <p>Explora nuestros cursos y certificaciones diseñados para mejorar la seguridad en tu entorno laboral.</p>
                <div class="training-grid">
                    <?php foreach ($cursos as $curso): ?>
                        <div class="training-item">
                            <h3><?php echo htmlspecialchars($curso['name']); ?></h3>
                            <p class="description"><?php echo htmlspecialchars($curso['description']); ?></p>
                            <ul class="course-details">
                                <li><strong>Duración:</strong> <?php echo htmlspecialchars($curso['duration']); ?></li>
                                <li><strong>Nivel:</strong> <?php echo htmlspecialchars($curso['level']); ?></li>
                                <li><strong>Costo:</strong> $<?php echo number_format($curso['cost'], 2); ?></li>
                            </ul>
                            <div class="training-actions">
                                <a href="carrito.php?action=add&tipo=curso&id=<?php echo $curso['id']; ?>" class="btn-secondary">Inscribirse</a>
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