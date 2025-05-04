<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Vistas/css/App.css">
    <link rel="stylesheet" href="style.css">
    <title>Productos de Seguridad</title>
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
            <a href="index.php">Inicio</a>
            <a href="./Vistas/catalogo.php">Productos</a>
            <a href="./Vistas/cursos.php">Cursos</a>
            <a href="./Vistas/carrito.php">Carrito</a>
            <?php if (!isset($_SESSION['isAuthenticated']) || !$_SESSION['isAuthenticated']): ?>
                <a href="./Vistas/register.php">Registrarse</a>
                <a href="./Vistas/login.php">Login</a>
            <?php else: ?>
                <a href="./Vistas/logout.php">Cerrar Sesión</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
      
        <section class="hero">
            <div class="hero-content">
                <h1 class = "neon">Equipos de Seguridad Industrial</h1>
                <p  class = "tex-inicio-header">Protección confiable para tu equipo. Encuentra los mejores productos y cursos de seguridad.</p>
                <a href="catalog.php" class="btn-hero">Explorar Ahora</a>
            </div>
        </section>
        <section class="products">
            <div class="section-content">
                <h2>Nuestros Productos de Seguridad</h2>
                <p>Descubre una amplia gama de equipos diseñados para garantizar la seguridad en entornos industriales.</p>
                <div class="product-grid">
                    <div class="product-item">
                        <img src="https://www.imposeg.com/cdn/shop/products/1_f82bd455-6045-4ef3-ab17-5d1175b42189_1024x1024@2x.png?v=1602889372" alt="Producto 1">
                        <h3>Casco de Seguridad</h3>
                        <p>Protección certificada para trabajos en altura.</p>
                        <a href="./Vistas/producto.php?id=1" class="btn-secondary">Ver Más</a>
                    </div>
                    <div class="product-item">
                        <img src="https://casaferretera.vtexassets.com/arquivos/ids/169516-1200-1200?v=638161484394300000&width=1200&height=1200&aspect=true" alt="Producto 2">
                        <h3>Guantes Industriales</h3>
                        <p>Resistentes a cortes y productos químicos.</p>
                        <a href="./Vistas/producto.php?id=2" class="btn-secondary">Ver Más</a>
                    </div>
                    <div class="product-item">
                        <img src="https://www.provesi.com.co/5741-large_default/bota-seguridad-saga-micropiel-negro-pu-2021e.jpg" alt="Producto 3">
                        <h3>Botas de Seguridad</h3>
                        <p>Con punta de acero para máxima protección.</p>
                        <a href="./Vistas/producto.php?id=3" class="btn-secondary">Ver Más</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="courses">
            <div class="section-content">
                <h2>Cursos de Seguridad Disponibles</h2>
                <p>Capacítate con nuestros programas especializados en seguridad industrial.</p>
                <div class="course-grid">
                    <div class="course-item">
                        <img src="https://industrialseguridad.com/wp-content/uploads/2023/09/Los-13-consejos-para-los-trabajos-en-altura.webp" alt="Curso 1">
                        <div class="course-info">
                            <h3>Curso de Trabajo en Alturas</h3>
                            <p>Aprende las mejores prácticas para trabajos en altura de forma segura.</p>
                            <a href="cursos.php" class="btn-secondary">Inscribirse</a>
                        </div>
                    </div>
                    <div class="course-item">
                        <img src="https://www.oformacio.com/wp-content/uploads/2021/03/Primeros-auxilios-en-grupo-1536x1025.jpg" alt="Curso 2">
                        <div class="course-info">
                            <h3>Capacitación en Primeros Auxilios</h3>
                            <p>Prepárate para responder ante emergencias médicas en el trabajo.</p>
                            <a href="cursos.php" class="btn-secondary">Inscribirse</a>
                        </div>
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