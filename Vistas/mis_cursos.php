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
    <title>Mis Cursos - Productos de Seguridad</title>
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
                    <a href="mis_cursos.php">Mis Cursos</a>
                    <a href="#" id="auth-link"></a>
                </div>
            </nav>
        </header>
        <section class="my-courses">
            <div class="section-content">
                <h1>Mis Cursos</h1>
                <p>Aquí puedes ver los cursos que has comprado, tu progreso y descargar certificados.</p>
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

    <script>
        // Verificar autenticación
        const isAuthenticated = localStorage.getItem('isAuthenticated') === 'true';
        const userId = localStorage.getItem('user_id');
        const authLink = document.getElementById('auth-link');

        if (!isAuthenticated) {
            window.location.href = 'login.php';
        } else {
            authLink.textContent = 'Cerrar Sesión';
            authLink.addEventListener('click', (e) => {
                e.preventDefault();
                localStorage.removeItem('isAuthenticated');
                localStorage.removeItem('user_id');
                window.location.href = 'login.php';
            });

            // Filtrar cursos comprados por el usuario
            const purchases = <?php echo json_encode($purchases); ?>;
            const progress = <?php echo json_encode($progress); ?>;
            const courses = <?php echo json_encode($courses); ?>;
            const userCourses = [];

            purchases.forEach(purchase => {
                if (parseInt(purchase.user_id) === parseInt(userId)) {
                    const course_id = purchase.course_id;
                    let progreso = 0;

                    progress.forEach(prog => {
                        if (prog.user_id == userId && prog.course_id == course_id) {
                            progreso = prog.progreso;
                        }
                    });

                    userCourses.push({
                        id: course_id,
                        nombre: courses[course_id].nombre,
                        descripcion: courses[course_id].descripcion,
                        progreso: progreso,
                    });
                }
            });

            // Mostrar los cursos
            const coursesContent = document.getElementById('courses-content');
            if (userCourses.length === 0) {
                coursesContent.innerHTML = `
                    <p>No has comprado ningún curso aún. <a href="cursos.php" class="btn-secondary">Explora nuestros cursos</a></p>
                `;
            } else {
                let html = '<div class="courses-grid">';
                userCourses.forEach(course => {
                    html += `
                        <div class="course-item">
                            <h3>${course.nombre}</h3>
                            <p>${course.descripcion}</p>
                            <div class="progress-bar">
                                <div class="progress" style="width: ${course.progreso}%;"></div>
                            </div>
                            <p>Progreso: ${course.progreso}%</p>
                            <div class="course-actions">
                                <a href="curso_detalle.php?course_id=${course.id}" class="btn-secondary">Continuar</a>
                                ${course.progreso == 100 ? `<a href="download.php?type=certificate&course_id=${course.id}" class="btn-info">Descargar Certificado</a>` : ''}
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                coursesContent.innerHTML = html;
            }
        }
    </script>
</body>
</html>