<?php
require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Verificar si el correo ya existe
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $message = 'Este correo ya está registrado.';
        $message_color = 'red';
    } else {
        // Encriptar contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "ss", $email, $hashed_password);
        if (mysqli_stmt_execute($stmt)) {
            $message = 'Registro exitoso. Redirigiendo al login...';
            $message_color = 'green';
            header("Refresh: 2; url=login.php");
        } else {
            $message = 'Error al registrar: ' . mysqli_error($conexion);
            $message_color = 'red';
        }
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
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="../style.css">
    <title>Registro - Productos de Seguridad</title>
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
        <section class="register">
            <div class="section-content">
                <h1>Registro</h1>
                <p>Crea una cuenta para acceder a nuestros cursos y productos.</p>
                <form method="POST" action="index.php">
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn-primary">Registrarse</button>
                    <?php if (isset($message)): ?>
                        <p style="color: <?php echo $message_color; ?>;"><?php echo $message; ?></p>
                    <?php endif; ?>
                </form>
                <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
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