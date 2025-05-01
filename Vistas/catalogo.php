<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/App.css">
    <title>Catálogo - Productos de Seguridad</title>
</head>
<body>
    <div id="contenedor">
        <header>
            <div class="logo">Productos de Seguridad</div>
            <nav>
                <div class="nav-01">
                    <a href="index.php">Inicio</a>
                    <a href="catalog.php">Productos</a>
                    <a href="cursos.php">Cursos</a>
                    <a href="carrito.php">Carrito</a>
                    <a href="#">Contacto</a>
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
                        <div class="filter-group">
                            <label for="category">Categoría:</label>
                            <select id="category" name="category">
                                <option value="">Todas</option>
                                <option value="casco">Casco</option>
                                <option value="guantes">Guantes</option>
                                <option value="gafas">Gafas</option>
                                <option value="arnes">Arnés</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="brand">Marca:</label>
                            <select id="brand" name="brand">
                                <option value="">Todas</option>
                                <option value="marca1">Marca 1</option>
                                <option value="marca2">Marca 2</option>
                                <option value="marca3">Marca 3</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="price">Precio:</label>
                            <select id="price" name="price">
                                <option value="">Cualquiera</option>
                                <option value="0-50">$0 - $50</option>
                                <option value="50-100">$50 - $100</option>
                                <option value="100+">$100+</option>
                            </select>
                        </div>
                    </aside>
                    <!-- Catálogo -->
                    <div class="catalog-grid">
                        <div class="catalog-item">
                            <img src="https://via.placeholder.com/200x200" alt="Casco">
                            <h3>Casco de Seguridad</h3>
                            <p>Marca 1 - $45</p>
                            <a href="producto.php?id=1" class="btn-secondary">Ver Detalles</a>
                        </div>
                        <div class="catalog-item">
                            <img src="https://via.placeholder.com/200x200" alt="Guantes">
                            <h3>Guantes Industriales</h3>
                            <p>Marca 2 - $30</p>
                            <a href="producto.php?id=2" class="btn-secondary">Ver Detalles</a>
                        </div>
                        <div class="catalog-item">
                            <img src="https://via.placeholder.com/200x200" alt="Gafas">
                            <h3>Gafas de Protección</h3>
                            <p>Marca 1 - $25</p>
                            <a href="producto.php?id=3" class="btn-secondary">Ver Detalles</a>
                        </div>
                        <div class="catalog-item">
                            <img src="https://via.placeholder.com/200x200" alt="Arnés">
                            <h3>Arnés de Seguridad</h3>
                            <p>Marca 3 - $80</p>
                            <a href="producto.php?id=4" class="btn-secondary">Ver Detalles</a>
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