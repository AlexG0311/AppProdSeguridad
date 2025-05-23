<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Consulta para obtener el usuario
    $query = "SELECT id, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['isAuthenticated'] = true;
        $message = 'Inicio de sesión exitoso. Redirigiendo...';
        $message_color = 'green';
        header("Refresh: 2; url=mis_cursos.php");
    } else {
        $message = 'Correo o contraseña incorrectos.';
        $message_color = 'red';
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="../style.css">
    <title>Iniciar Sesión - Productos de Seguridad</title>
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
        <section class="login">
            <div class="section-content">
                <h1>Iniciar Sesión</h1>
                <p>Accede a tu cuenta para continuar aprendiendo.</p>
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn-primary">Iniciar Sesión</button>
                    <?php if (isset($message)): ?>
                        <p style="color: <?php echo $message_color; ?>;"><?php echo $message; ?></p>
                    <?php endif; ?>
                </form>
                <p>¿No tienes una cuenta? <a href="index.php">Regístrate aquí</a></p>
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